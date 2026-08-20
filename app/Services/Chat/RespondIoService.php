<?php

namespace App\Services\Chat;

use App\Services\BaseService;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Http;

/**
 * respond.io channel adapter — powers WhatsApp, Telegram and Voice
 * conversations through the respond.io API. Activates when credentials
 * are configured in Admin → Services.
 */
class RespondIoService extends BaseService
{
    protected string $name = 'respondio';
    protected string $category = 'chat';

    public static function getConfigSchema(): array
    {
        return [
            TextInput::make('credentials.api_key')
                ->label('respond.io API Key')
                ->password()
                ->revealable()
                ->helperText('Found under Settings → API in your respond.io workspace.'),
            TextInput::make('config.workspace')
                ->label('Workspace ID')
                ->helperText('e.g. w-XXXXXX. Leave blank to auto-resolve.'),
            TextInput::make('config.webhook_secret')
                ->label('Webhook Secret')
                ->password()
                ->revealable()
                ->helperText('Used to verify incoming webhooks.'),
            TextInput::make('config.voice_number')
                ->label('Voice / WhatsApp Number')
                ->helperText('The connected number shown to visitors (optional).'),
        ];
    }

    public function validate(): bool
    {
        return filled($this->getCredential('api_key'));
    }

    public function test(): array
    {
        if (! $this->validate()) {
            return ['success' => false, 'message' => 'Missing respond.io API key.'];
        }

        try {
            $response = Http::withToken($this->getCredential('api_key'))
                ->acceptJson()
                ->timeout(15)
                ->get('https://api.respond.io/v2/contacts', ['limit' => 1]);

            if ($response->ok() || $response->status() === 200) {
                return ['success' => true, 'message' => 'Connected to respond.io API successfully.'];
            }

            return ['success' => false, 'message' => 'respond.io API responded with status ' . $response->status() . ': ' . ($response->body() ? substr($response->body(), 0, 200) : 'no body')];
        } catch (\Throwable $e) {
            return ['success' => false, 'message' => 'Could not reach respond.io: ' . $e->getMessage()];
        }
    }

    /**
     * The base API URL.
     */
    protected function baseUrl(): string
    {
        return 'https://api.respond.io/v2';
    }

    /**
     * Send a message to a visitor over their channel (WhatsApp/Telegram/Voice).
     *
     * @param  string  $to  recipient id in respond.io (e.g. a contact/room id)
     * @param  string  $body  message text
     */
    public function sendMessage(string $to, string $body): array
    {
        if (! $this->validate()) {
            return ['success' => false, 'message' => 'respond.io not configured.'];
        }

        try {
            $response = Http::withToken($this->getCredential('api_key'))
                ->acceptJson()
                ->timeout(20)
                ->post($this->baseUrl() . '/messages', [
                    'contactId' => $to,
                    'message' => [
                        'type' => 'text',
                        'text' => $body,
                    ],
                ]);

            if ($response->successful()) {
                return ['success' => true, 'message' => 'Message sent via respond.io.'];
            }

            return ['success' => false, 'message' => 'respond.io send failed with status ' . $response->status() . ': ' . substr($response->body(), 0, 200)];
        } catch (\Throwable $e) {
            return ['success' => false, 'message' => 'Could not send via respond.io: ' . $e->getMessage()];
        }
    }

    /**
     * Verify an incoming webhook signature.
     */
    public function verifyWebhook(string $signature, string $payload, ?string $secret = null): bool
    {
        $secret = $secret ?? $this->getConfig('webhook_secret');

        if (! filled($secret)) {
            return true; // no secret configured → accept (dev mode)
        }

        return hash_equals(hash_hmac('sha256', $payload, $secret), $signature);
    }
}