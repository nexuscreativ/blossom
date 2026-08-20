<?php

namespace App\Livewire;

use App\Models\NewsletterSubscriber;
use App\Services\Email\EmailSender;
use Livewire\Component;

class NewsletterSubscribe extends Component
{
    public string $email = '';
    public string $status = '';
    public bool $success = false;

    public function subscribe()
    {
        $this->validate(
            ['email' => 'required|email|max:255'],
            ['email.required' => 'Please enter your email address.', 'email.email' => 'Please enter a valid email address.']
        );

        $existing = NewsletterSubscriber::where('email', $this->email)->first();

        if ($existing && $existing->status === 'active') {
            $this->status = 'You are already subscribed!';
            $this->success = true;
            return;
        }

        if ($existing && $existing->status === 'unsubscribed') {
            $existing->update([
                'status' => 'active',
                'subscribed_at' => now(),
                'unsubscribed_at' => null,
            ]);
        } else {
            NewsletterSubscriber::create([
                'email' => $this->email,
                'status' => 'active',
                'subscribed_at' => now(),
                'source' => 'website',
            ]);
        }

        $this->sendConfirmation($existing->email ?? $this->email);

        $this->success = true;
        $this->status = 'Welcome aboard! Check your inbox for a confirmation.';
        $this->email = '';

        $this->dispatch('newsletter-subscribed');
    }

    protected function sendConfirmation(string $email): void
    {
        try {
            $siteName = setting('site.site.name', 'BLOSSOM');
            $html = view('emails.newsletter-confirmation', [
                'siteName' => $siteName,
                'email' => $email,
            ])->render();

            app(EmailSender::class)->send(
                $email,
                "Welcome to {$siteName} — Subscription Confirmed",
                $html
            );
        } catch (\Throwable $e) {
            logger()->warning('Newsletter confirmation email failed.', [
                'email' => $email,
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function render()
    {
        return view('livewire.newsletter-subscribe');
    }
}
