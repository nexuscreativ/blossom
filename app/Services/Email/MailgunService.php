<?php

namespace App\Services\Email;

use App\Services\BaseService;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Http;

class MailgunService extends BaseService
{
    protected string $name = 'mailgun';
    protected string $category = 'email';

    public static function getConfigSchema(): array
    {
        return [
            TextInput::make('credentials.api_key')
                ->label('API Key')
                ->password()
                ->revealable()
                ->required()
                ->helperText('Starts with key-.'),
            TextInput::make('config.domain')
                ->label('Domain')
                ->required()
                ->helperText('e.g. mg.blossom.example.com'),
            Select::make('config.region')
                ->label('Region')
                ->options([
                    'us' => 'US (api.mailgun.net)',
                    'eu' => 'EU (api.eu.mailgun.net)',
                ])
                ->default('us'),
            TextInput::make('config.from_address')
                ->label('From Address'),
        ];
    }

    public function validate(): bool
    {
        return filled($this->getCredential('api_key'))
            && filled($this->getConfig('domain'));
    }

    public function test(): array
    {
        if (! $this->validate()) {
            return ['success' => false, 'message' => 'Missing Mailgun API key or domain.'];
        }

        try {
            $host = $this->getConfig('region') === 'eu' ? 'https://api.eu.mailgun.net' : 'https://api.mailgun.net';
            $response = Http::withBasicAuth('api', $this->getCredential('api_key'))
                ->acceptJson()
                ->timeout(15)
                ->get($host . '/v3/domains');

            if ($response->ok()) {
                return ['success' => true, 'message' => 'Connected to Mailgun API successfully.'];
            }

            return ['success' => false, 'message' => 'Mailgun API responded with status ' . $response->status() . ': ' . ($response->json('message') ?? 'unknown error')];
        } catch (\Throwable $e) {
            return ['success' => false, 'message' => 'Could not reach Mailgun: ' . $e->getMessage()];
        }
    }

    /**
     * Send an HTML email via the Mailgun Messages API.
     *
     * Returns ['success' => bool, 'message' => string].
     */
    public function send(string $to, string $subject, string $html): array
    {
        if (! $this->validate()) {
            return ['success' => false, 'message' => 'Missing Mailgun API key or domain.'];
        }

        try {
            $domain = $this->getConfig('domain');
            $host = $this->getConfig('region') === 'eu' ? 'https://api.eu.mailgun.net' : 'https://api.mailgun.net';
            $from = $this->getConfig('from_address') ?: 'no-reply@' . $domain;

            $response = Http::withBasicAuth('api', $this->getCredential('api_key'))
                ->asMultipart()
                ->timeout(20)
                ->post($host . '/v3/' . $domain . '/messages', [
                    'from' => $from,
                    'to' => $to,
                    'subject' => $subject,
                    'html' => $html,
                ]);

            if ($response->ok()) {
                return ['success' => true, 'message' => 'Email sent successfully.'];
            }

            return ['success' => false, 'message' => 'Mailgun send failed with status ' . $response->status() . ': ' . ($response->json('message') ?? 'unknown error')];
        } catch (\Throwable $e) {
            return ['success' => false, 'message' => 'Could not send email via Mailgun: ' . $e->getMessage()];
        }
    }
}