<?php

namespace App\Services\Payment\Gateways;

use App\Services\BaseService;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Http;

class NombaService extends BaseService
{
    protected string $name = 'nomba';
    protected string $category = 'payment';

    public static function getConfigSchema(): array
    {
        return [
            TextInput::make('credentials.api_key')
                ->label('API Key')
                ->password()
                ->revealable()
                ->required(),
            TextInput::make('credentials.secret_key')
                ->label('Secret Key')
                ->password()
                ->revealable(),
            TextInput::make('config.base_url')
                ->label('API Base URL')
                ->default('https://api.nomba.com'),
            TextInput::make('config.merchant_id')
                ->label('Merchant ID'),
        ];
    }

    public function validate(): bool
    {
        return filled($this->getCredential('api_key'));
    }

    public function test(): array
    {
        if (! $this->validate()) {
            return ['success' => false, 'message' => 'Missing Nomba API key.'];
        }

        try {
            $baseUrl = rtrim((string) $this->getConfig('base_url', 'https://api.nomba.com'), '/');
            $response = Http::withToken($this->getCredential('api_key'))
                ->acceptJson()
                ->timeout(15)
                ->get($baseUrl . '/v1/transactions');

            if ($response->ok()) {
                return ['success' => true, 'message' => 'Connected to Nomba API successfully.'];
            }

            if ($response->status() === 401) {
                return ['success' => false, 'message' => 'Nomba rejected the API key (401 Unauthorized).'];
            }

            return ['success' => false, 'message' => 'Nomba API responded with status ' . $response->status()];
        } catch (\Throwable $e) {
            return ['success' => false, 'message' => 'Could not reach Nomba: ' . $e->getMessage()];
        }
    }
}