<?php

namespace App\Services\OAuth;

use App\Services\BaseService;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Http;

class FacebookOAuthService extends BaseService
{
    protected string $name = 'facebook';
    protected string $category = 'oauth';

    public static function getConfigSchema(): array
    {
        return [
            TextInput::make('credentials.client_id')
                ->label('App ID')
                ->required(),
            TextInput::make('credentials.client_secret')
                ->label('App Secret')
                ->password()
                ->revealable()
                ->required(),
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
            return ['success' => false, 'message' => 'Missing Facebook OAuth app ID or app secret.'];
        }

        try {
            $response = Http::acceptJson()->timeout(15)
                ->get('https://graph.facebook.com/v21.0/me', [
                    'access_token' => $this->getCredential('client_id') . '|' . $this->getCredential('client_secret'),
                    'fields' => 'id',
                ]);

            if ($response->ok() || $response->status() === 400) {
                return ['success' => true, 'message' => 'Facebook Graph API is reachable with the configured app credentials.'];
            }

            return ['success' => false, 'message' => 'Facebook Graph API responded with status ' . $response->status()];
        } catch (\Throwable $e) {
            return ['success' => false, 'message' => 'Could not reach Facebook: ' . $e->getMessage()];
        }
    }
}