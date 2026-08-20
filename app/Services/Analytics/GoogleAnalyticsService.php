<?php

namespace App\Services\Analytics;

use App\Services\BaseService;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class GoogleAnalyticsService extends BaseService
{
    protected string $name = 'google_analytics';
    protected string $category = 'analytics';

    public static function getConfigSchema(): array
    {
        return [
            TextInput::make('config.property_id')
                ->label('GA4 Property ID')
                ->required()
                ->helperText('Numeric ID, e.g. 123456789'),
            TextInput::make('config.view_id')
                ->label('UA View ID (optional)'),
            Textarea::make('credentials.service_account_json')
                ->label('Service Account JSON')
                ->rows(8)
                ->helperText('Paste the contents of the Google service account key file to enable live queries.'),
        ];
    }

    public function validate(): bool
    {
        return filled($this->getConfig('property_id'));
    }

    public function test(): array
    {
        if (! $this->validate()) {
            return ['success' => false, 'message' => 'Missing Google Analytics property ID.'];
        }

        if (! filled($this->getCredential('service_account_json'))) {
            return ['success' => false, 'message' => 'Property ID is set, but a service account JSON is required to run a live connectivity test.'];
        }

        return ['success' => true, 'message' => 'Google Analytics configuration is complete and service account credentials are present.'];
    }
}