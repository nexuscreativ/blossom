<?php

namespace App\Services\Sms;

use App\Services\BaseService;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Http;

class TermiiService extends BaseService
{
    protected string $name = 'termii';
    protected string $category = 'sms';

    public static function getConfigSchema(): array
    {
        return [
            TextInput::make('credentials.api_key')
                ->label('API Key')
                ->password()
                ->revealable()
                ->required(),
            TextInput::make('config.sender_id')
                ->label('Sender ID')
                ->maxLength(11),
            TextInput::make('config.base_url')
                ->label('API Base URL')
                ->default('https://api.ng.termii.com'),
        ];
    }

    public function validate(): bool
    {
        return filled($this->getCredential('api_key'));
    }

    public function test(): array
    {
        if (! $this->validate()) {
            return ['success' => false, 'message' => 'Missing Termii API key.'];
        }

        try {
            $baseUrl = rtrim((string) $this->getConfig('base_url', 'https://api.ng.termii.com'), '/');
            $response = Http::timeout(15)
                ->get($baseUrl . '/api/check/balance', [
                    'api_key' => $this->getCredential('api_key'),
                ]);

            if ($response->ok()) {
                return ['success' => true, 'message' => 'Connected to Termii API successfully.'];
            }

            return ['success' => false, 'message' => 'Termii API responded with status ' . $response->status() . ': ' . ($response->json('message') ?? 'unknown error')];
        } catch (\Throwable $e) {
            return ['success' => false, 'message' => 'Could not reach Termii: ' . $e->getMessage()];
        }
    }
}