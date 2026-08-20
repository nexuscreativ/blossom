<?php

namespace App\Console\Commands;

use App\Jobs\SendNewsletterJob;
use App\Models\NewsletterBroadcast;
use App\Models\NewsletterSubscriber;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;

class SendNewsletterCommand extends Command
{
    protected $signature = 'newsletter:send {broadcast_id?}';
    protected $description = 'Send a newsletter broadcast to all active subscribers';

    public function handle(): int
    {
        $broadcastId = $this->argument('broadcast_id');

        if ($broadcastId) {
            $broadcast = NewsletterBroadcast::findOrFail($broadcastId);
        } else {
            $broadcast = NewsletterBroadcast::where('status', 'draft')->latest()->first();

            if (!$broadcast) {
                $this->error('No draft broadcasts found. Create one first.');
                return self::FAILURE;
            }
        }

        if ($broadcast->status === 'sent') {
            $this->warn("Broadcast #{$broadcast->id} was already sent.");
            return self::SUCCESS;
        }

        $subscribers = NewsletterSubscriber::where('status', 'active')->get();

        if ($subscribers->isEmpty()) {
            $this->error('No active subscribers found.');
            return self::FAILURE;
        }

        $this->info("Sending \"{$broadcast->subject}\" to {$subscribers->count()} subscribers...");

        $broadcast->update([
            'status' => 'sending',
            'recipients_count' => $subscribers->count(),
            'sent_at' => now(),
        ]);

        $batch = Bus::batch(
            $subscribers->map(fn ($sub) => new SendNewsletterJob($broadcast, $sub))
        )->then(function ($batch) use ($broadcast) {
            $broadcast->update(['status' => 'sent']);
        })->catch(function ($batch) use ($broadcast) {
            $broadcast->update(['status' => 'failed']);
        })->finally(function ($batch) use ($broadcast) {
            $broadcast->update(['sent_count' => $batch->processedJobs()]);
        })->dispatch();

        $this->info("Newsletter batch dispatched. Batch ID: {$batch->id}");
        return self::SUCCESS;
    }
}
