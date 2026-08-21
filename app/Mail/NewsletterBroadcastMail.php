<?php

namespace App\Mail;

use App\Models\NewsletterBroadcast;
use App\Models\NewsletterSubscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewsletterBroadcastMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public NewsletterBroadcast $broadcast,
        public NewsletterSubscriber $subscriber,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->broadcast->subject,
            from: config('mail.from.address', 'hello@blossom.ng'),
        );
    }

    public function content(): Content
    {
        return new Content(
            htmlString: $this->buildHtml(),
        );
    }

    protected function buildHtml(): string
    {
        $unsubscribeUrl = route('newsletter.unsubscribe', $this->subscriber->token);
        $subscriberName = $this->subscriber->name ?? 'there';
        $preview = $this->broadcast->preview_text ?? '';
        $body = $this->broadcast->body ?? '';

        return <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$this->broadcast->subject}</title>
</head>
<body style="margin:0;padding:0;background-color:#FAFAFA;font-family:'Georgia','Times New Roman',serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#FAFAFA;padding:40px 20px;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color:#FFFFFF;border-radius:12px;overflow:hidden;box-shadow:0 4px 20px rgba(0,0,0,0.08);">
                    <!-- Header -->
                    <tr>
                        <td style="background:linear-gradient(135deg,#2A1433,#3D1E4A);padding:40px 48px;text-align:center;">
                            <h1 style="margin:0;color:#FFFFFF;font-size:28px;font-weight:700;letter-spacing:2px;">BLOSSOM</h1>
                            <p style="margin:8px 0 0;color:rgba(255,255,255,0.5);font-size:12px;letter-spacing:3px;text-transform:uppercase;">Global Stories, Nigerian Soul</p>
                        </td>
                    </tr>
                    <!-- Greeting -->
                    <tr>
                        <td style="padding:40px 48px 0;">
                            <p style="margin:0;color:#424242;font-size:16px;">Hi {$subscriberName},</p>
                            <?php if ($preview): ?>
                            <p style="margin:12px 0 0;color:#616161;font-size:15px;line-height:1.7;">{$preview}</p>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <!-- Body -->
                    <tr>
                        <td style="padding:24px 48px;">
                            <div style="color:#1A1A1A;font-size:15px;line-height:1.8;">{$body}</div>
                        </td>
                    </tr>
                    <!-- Footer -->
                    <tr>
                        <td style="padding:32px 48px;border-top:1px solid #E0E0E0;">
                            <p style="margin:0;font-size:12px;color:#9E9E9E;text-align:center;line-height:1.6;">
                                You're receiving this because you subscribed to the BLOSSOM newsletter.<br>
                                <a href="{$unsubscribeUrl}" style="color:#5B2C6F;text-decoration:underline;">Unsubscribe</a> ·
                                <a href="https://blossom.ng" style="color:#5B2C6F;text-decoration:underline;">Visit BLOSSOM</a>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
HTML;
    }
}
