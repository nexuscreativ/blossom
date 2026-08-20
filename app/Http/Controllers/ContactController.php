<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Services\Email\EmailSender;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function __construct(protected EmailSender $emailSender)
    {
    }

    public function send(Request $request): RedirectResponse
    {
        if (! Setting::get('page.page.contact.form_enabled', true)) {
            return back()->with('contact_error', 'The contact form is currently disabled. Please email us directly.');
        }

        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255'],
            'subject' => ['nullable', 'string', 'max:100'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        $topic = $validated['subject'] ?: 'General';
        $siteName = Setting::get('site.site.name', 'BLOSSOM');
        $recipient = Setting::get('site.site.contact_email', 'hello@blossom.ng');

        $subject = "[{$siteName}] Contact form: {$topic} from {$validated['first_name']} {$validated['last_name']}";

        $html = view('emails.contact-notification', [
            'siteName' => $siteName,
            'name' => "{$validated['first_name']} {$validated['last_name']}",
            'email' => $validated['email'],
            'topic' => $topic,
            'message' => $validated['message'],
        ])->render();

        $result = $this->emailSender->send($recipient, $subject, $html);

        if (! $result['success']) {
            logger()->warning('Contact form email failed.', [
                'email' => $validated['email'],
                'error' => $result['message'],
            ]);

            return back()->with('contact_error', 'Your message could not be sent right now. Please email us directly.');
        }

        return back()->with('contact_success', 'Thank you! Your message has been received. We will get back to you shortly.');
    }
}