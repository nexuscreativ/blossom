<?php

namespace App\Services\OAuth;

use App\Services\BaseService;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Http;

class GoogleOAuthService extends BaseService
{
    protected string $name = 'google';
    protected string $category = 'oauth';

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
            TextInput::make('config.redirect_uri')
                ->label('Redirect URI'),
            Select::make('config.scopes')
                ->label('Scopes')
                ->multiple()
                ->options([
                    'openid' => 'openid',
                    'email' => 'email',
                    'profile' => 'profile',
                ])
                ->default(['openid', 'email', 'profile']),
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
            return ['success' => false, 'message' => 'Missing Google OAuth client ID or client secret.'];
        }

        try {
            $response = Http::acceptJson()->timeout(15)
                ->get('https://accounts.google.com/.well-known/openid-configuration');

            if ($response->ok()) {
                return ['success' => true, 'message' => 'Google OAuth credentials are set and the discovery endpoint is reachable.'];
            }

            return ['success' => false, 'message' => 'Google discovery endpoint responded with status ' . $response->status()];
        } catch (\Throwable $e) {
            return ['success' => false, 'message' => 'Could not reach Google: ' . $e->getMessage()];
        }
    }
}