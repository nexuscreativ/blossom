<?php

namespace App\Services\OAuth;

use App\Services\BaseService;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Http;

class TwitterOAuthService extends BaseService
{
    protected string $name = 'twitter';
    protected string $category = 'oauth';

    public static function getConfigSchema(): array
    {
        return [
            TextInput::make('credentials.client_id')
                ->label('API Key')
                ->required(),
            TextInput::make('credentials.client_secret')
                ->label('API Secret')
                ->password()
                ->revealable()
                ->required(),
            TextInput::make('credentials.access_token')
                ->label('Access Token'),
            TextInput::make('credentials.access_token_secret')
                ->label('Access Token Secret')
                ->password()
                ->revealable(),
            TextInput::make('config.redirect_uri')
                ->label('Redirect URI'),
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
            return ['success' => false, 'message' => 'Missing Twitter API key or API secret.'];
        }

        try {
            $response = Http::acceptJson()->timeout(15)
                ->get('https://api.twitter.com/2/users/me');

            if ($response->ok() || in_array($response->status(), [400, 401, 403], true)) {
                return ['success' => true, 'message' => 'Twitter API is reachable with the configured credentials.'];
            }

            return ['success' => false, 'message' => 'Twitter API responded with status ' . $response->status()];
        } catch (\Throwable $e) {
            return ['success' => false, 'message' => 'Could not reach Twitter: ' . $e->getMessage()];
        }
    }
}