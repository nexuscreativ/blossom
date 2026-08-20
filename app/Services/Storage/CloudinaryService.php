<?php

namespace App\Services\Storage;

use App\Services\BaseService;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Http;

class CloudinaryService extends BaseService
{
    protected string $name = 'cloudinary';
    protected string $category = 'storage';

    public static function getConfigSchema(): array
    {
        return [
            TextInput::make('credentials.api_key')
                ->label('API Key')
                ->required(),
            TextInput::make('credentials.api_secret')
                ->label('API Secret')
                ->password()
                ->revealable()
                ->required(),
            TextInput::make('config.cloud_name')
                ->label('Cloud Name')
                ->required(),
            TextInput::make('config.folder')
                ->label('Upload Folder')
                ->default('blossom'),
        ];
    }

    public function validate(): bool
    {
        return filled($this->getConfig('cloud_name'))
            && filled($this->getCredential('api_key'))
            && filled($this->getCredential('api_secret'));
    }

    public function test(): array
    {
        if (! $this->validate()) {
            return ['success' => false, 'message' => 'Missing Cloudinary cloud name, API key, or API secret.'];
        }

        try {
            $cloud = $this->getConfig('cloud_name');
            $response = Http::withBasicAuth(
                $this->getCredential('api_key'),
                $this->getCredential('api_secret')
            )->acceptJson()
                ->timeout(15)
                ->get("https://{$cloud}.res.cloudinary.com/v1_1/{$cloud}/resources/image", [
                    'max_results' => 1,
                ]);

            if ($response->ok()) {
                return ['success' => true, 'message' => 'Connected to Cloudinary API successfully.'];
            }

            return ['success' => false, 'message' => 'Cloudinary API responded with status ' . $response->status() . ': ' . ($response->json('error.message') ?? 'unknown error')];
        } catch (\Throwable $e) {
            return ['success' => false, 'message' => 'Could not reach Cloudinary: ' . $e->getMessage()];
        }
    }
}