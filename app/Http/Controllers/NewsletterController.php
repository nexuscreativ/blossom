<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function unsubscribe(string $token)
    {
        $subscriber = NewsletterSubscriber::where('token', $token)->first();

        if (!$subscriber) {
            abort(404, 'Invalid unsubscribe link.');
        }

        $subscriber->update([
            'status' => 'unsubscribed',
            'unsubscribed_at' => now(),
        ]);

        return view('pages.newsletter.unsubscribed');
    }
}
