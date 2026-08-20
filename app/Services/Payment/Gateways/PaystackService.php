<?php

namespace App\Services\Payment\Gateways;

use App\Services\BaseService;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Http;

class PaystackService extends BaseService
{
    protected string $name = 'paystack';
    protected string $category = 'payment';

    public static function getConfigSchema(): array
    {
        return [
            TextInput::make('credentials.secret_key')
                ->label('Secret Key')
                ->password()
                ->revealable()
                ->required()
                ->helperText('Starts with sk_live_ or sk_test_.'),
            TextInput::make('credentials.public_key')
                ->label('Public Key')
                ->password()
                ->revealable()
                ->helperText('Starts with pk_live_ or pk_test_.'),
            TextInput::make('config.base_url')
                ->label('API Base URL')
                ->default('https://api.paystack.co'),
        ];
    }

    public function validate(): bool
    {
        return filled($this->getCredential('secret_key'));
    }

    public function test(): array
    {
        if (! $this->validate()) {
            return ['success' => false, 'message' => 'Missing Paystack secret key. Configure credentials first.'];
        }

        try {
            $baseUrl = rtrim((string) $this->getConfig('base_url', 'https://api.paystack.co'), '/');
            $response = Http::withToken($this->getCredential('secret_key'))
                ->acceptJson()
                ->timeout(15)
                ->get($baseUrl . '/balance');

            if ($response->ok() && data_get($response->json(), 'status') === true) {
                return ['success' => true, 'message' => 'Connected to Paystack API successfully.'];
            }

            return ['success' => false, 'message' => 'Paystack API responded with status ' . $response->status() . ': ' . ($response->json('message') ?? 'unknown error')];
        } catch (\Throwable $e) {
            return ['success' => false, 'message' => 'Could not reach Paystack: ' . $e->getMessage()];
        }
    }
}