<?php

namespace App\Services\Payment\Gateways;

use App\Services\BaseService;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Http;

class MonnifyService extends BaseService
{
    protected string $name = 'monnify';
    protected string $category = 'payment';

    public static function getConfigSchema(): array
    {
        return [
            TextInput::make('credentials.client_id')
                ->label('Client ID')
                ->required(),
            TextInput::make('credentials.client_secret')
                ->label('Client Secret')
                ->password()
                ->revealable()
                ->required(),
            TextInput::make('config.base_url')
                ->label('API Base URL')
                ->default('https://api.monnify.com'),
            TextInput::make('config.contract_code')
                ->label('Contract Code'),
        ];
    }

    public function validate(): bool
    {
        return filled($this->getCredential('client_id'))
            && filled($this->getCredential('client_secret'));
    }

    public function test(): array
    {
        if (! $this->validate()) {
            return ['success' => false, 'message' => 'Missing Monnify client ID or client secret.'];
        }

        try {
            $baseUrl = rtrim((string) $this->getConfig('base_url', 'https://api.monnify.com'), '/');
            $response = Http::withBasicAuth(
                $this->getCredential('client_id'),
                $this->getCredential('client_secret')
            )->acceptJson()
                ->timeout(15)
                ->post($baseUrl . '/api/v1/auth/login');

            if ($response->ok() && filled(data_get($response->json(), 'responseBody.accessToken'))) {
                return ['success' => true, 'message' => 'Connected to Monnify API successfully.'];
            }

            return ['success' => false, 'message' => 'Monnify API responded with status ' . $response->status() . ': ' . ($response->json('responseMessage') ?? 'unknown error')];
        } catch (\Throwable $e) {
            return ['success' => false, 'message' => 'Could not reach Monnify: ' . $e->getMessage()];
        }
    }
}