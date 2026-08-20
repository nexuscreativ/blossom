<?php

namespace App\Jobs;

use App\Mail\NewsletterBroadcastMail;
use App\Models\NewsletterBroadcast;
use App\Models\NewsletterSubscriber;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendNewsletterJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $backoff = 60;

    public function __construct(
        public NewsletterBroadcast $broadcast,
        public NewsletterSubscriber $subscriber,
    ) {}

    public function handle(): void
    {
        if ($this->batch()?->cancelled()) {
            return;
        }

        Mail::to($this->subscriber->email)
            ->send(new NewsletterBroadcastMail($this->broadcast, $this->subscriber));

        $this->broadcast->increment('sent_count');
    }

    public function failed(\Throwable $exception): void
    {
        \Log::error("Newsletter send failed for [{$this->subscriber->email}]: " . $exception->getMessage());
    }
}
