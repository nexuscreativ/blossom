<?php

namespace App\Services\Email;

use App\Services\ServiceRegistry;
use Illuminate\Support\Facades\Log;

/**
 * Dispatches transactional emails through the primary email service
 * configured in the Service Manager (services table).
 */
class EmailSender
{
    public function __construct(protected ServiceRegistry $registry)
    {
    }

    /**
     * Send an email via the primary email service.
     *
     * Returns ['success' => bool, 'message' => string, 'skipped' => bool].
     * When no email service is configured, sending is skipped (demo mode)
     * and the outcome is logged.
     */
    public function send(string $to, string $subject, string $html, ?string $text = null): array
    {
        $service = $this->registry->getPrimary('email');

        if (! $service) {
            Log::info('EmailSender: no primary email service configured; skipped.', ['to' => $to, 'subject' => $subject]);

            return ['success' => true, 'message' => 'Email skipped (no email service configured).', 'skipped' => true];
        }

        if (! $service->isEnabled()) {
            Log::info('EmailSender: primary email service is disabled; skipped.', ['service' => $service->getName(), 'to' => $to]);

            return ['success' => true, 'message' => 'Email skipped (email service disabled).', 'skipped' => true];
        }

        if (! method_exists($service, 'send')) {
            Log::warning('EmailSender: email service has no send() support.', ['service' => $service->getName()]);

            return ['success' => false, 'message' => 'Email service does not support sending.', 'skipped' => true];
        }

        $result = $service->send($to, $subject, $html);

        if (! $result['success']) {
            Log::warning('EmailSender: send failed.', ['service' => $service->getName(), 'to' => $to, 'error' => $result['message']]);
        }

        return array_merge($result, ['skipped' => false]);
    }
}