<?php

namespace App\Filament\Resources\ServiceResource\Pages;

use App\Filament\Resources\ServiceResource;
use App\Services\ServiceRegistry;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditService extends EditRecord
{
    protected static string $resource = ServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('testConnection')
                ->label('Test Connection')
                ->icon('heroicon-o-signal')
                ->color('info')
                ->action(fn () => $this->testConnection()),
            Actions\DeleteAction::make(),
        ];
    }

    public function testConnection(): void
    {
        $registry = app(ServiceRegistry::class);
        $service = $registry->get($this->record->category, $this->record->name);

        if (! $service) {
            $this->record->recordTest(false, 'No implementation registered for this service yet.');

            Notification::make()
                ->title('Test Failed')
                ->body('No implementation registered for this service yet.')
                ->danger()
                ->send();

            return;
        }

        $result = $service->test();
        $this->record->recordTest($result['success'], $result['message']);

        Notification::make()
            ->title($result['success'] ? 'Connection OK' : 'Connection Failed')
            ->body($result['message'])
            ->{$result['success'] ? 'success' : 'danger'}()
            ->send();
    }
}