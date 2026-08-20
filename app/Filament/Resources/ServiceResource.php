<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Models\Service;
use Filament\Actions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-server-stack';

    protected static string | \UnitEnum | null $navigationGroup = 'Settings';

    protected static ?int $navigationSort = 2;

    protected static ?string $label = 'Service';

    protected static ?string $pluralLabel = 'Services';

    protected static array $categories = [
        'payment' => 'Payment',
        'email' => 'Email',
        'sms' => 'SMS',
        'storage' => 'Storage',
        'analytics' => 'Analytics',
        'oauth' => 'OAuth',
    ];

    public static function form(Schema $schema): Schema
    {
        $baseSection = \Filament\Schemas\Components\Section::make()
            ->columns(2)
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(50),
                Forms\Components\TextInput::make('display_name')
                    ->required()
                    ->maxLength(100),
                Forms\Components\Select::make('category')
                    ->options(static::$categories)
                    ->required(),
                Forms\Components\Select::make('sandbox_mode')
                    ->options([
                        'sandbox' => 'Sandbox',
                        'production' => 'Production',
                    ])
                    ->default('sandbox')
                    ->required(),
                Forms\Components\Toggle::make('is_enabled')
                    ->default(false),
                Forms\Components\Toggle::make('is_primary')
                    ->default(false),
                Forms\Components\TextInput::make('priority')
                    ->numeric()
                    ->default(0),
            ]);

        $schemaFields = static::resolveSchemaFields($schema);

        $sections = [$baseSection];

        if ($schemaFields !== null) {
            $configFields = array_values(array_filter(
                $schemaFields,
                fn ($field) => str_starts_with((string) $field->getName(), 'config.')
            ));
            $credentialFields = array_values(array_filter(
                $schemaFields,
                fn ($field) => str_starts_with((string) $field->getName(), 'credentials.')
            ));

            if ($configFields) {
                $sections[] = \Filament\Schemas\Components\Section::make('Configuration')
                    ->schema($configFields);
            }

            if ($credentialFields) {
                $sections[] = \Filament\Schemas\Components\Section::make('Credentials')
                    ->description('Stored encrypted in the database.')
                    ->schema($credentialFields);
            }
        }

        if ($schemaFields === null || count($sections) === 1) {
            $sections[] = \Filament\Schemas\Components\Section::make('Configuration')
                ->schema([
                    Forms\Components\KeyValue::make('config')
                        ->keyLabel('Key')
                        ->valueLabel('Value')
                        ->addActionLabel('Add configuration'),
                ]);

            $sections[] = \Filament\Schemas\Components\Section::make('Credentials')
                ->description('Stored encrypted in the database.')
                ->schema([
                    Forms\Components\KeyValue::make('credentials')
                        ->keyLabel('Key')
                        ->valueLabel('Secret value')
                        ->addActionLabel('Add credential'),
                ]);
        }

        return $schema->schema($sections);
    }

    /**
     * Resolve dynamic config fields from a registered implementation,
     * when editing an existing service record.
     *
     * @return \Filament\Forms\Components\Field[]|null
     */
    protected static function resolveSchemaFields(Schema $schema): ?array
    {
        try {
            $livewire = $schema->getLivewire();
        } catch (\Throwable $e) {
            $livewire = null;
        }

        if ($livewire === null || ! method_exists($livewire, 'getRecord')) {
            return null;
        }

        $record = $livewire->getRecord();

        if (! $record instanceof Service || blank($record->category) || blank($record->name)) {
            return null;
        }

        return app('services')->getConfigSchema($record->category, $record->name);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('display_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'payment' => 'success',
                        'email' => 'info',
                        'sms' => 'warning',
                        'storage' => 'gray',
                        'analytics' => 'primary',
                        'oauth' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\IconColumn::make('is_enabled')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_primary')
                    ->boolean(),
                Tables\Columns\TextColumn::make('sandbox_mode')
                    ->badge()
                    ->color(fn (string $state): string => $state === 'production' ? 'danger' : 'info'),
                Tables\Columns\TextColumn::make('last_test_result.success')
                    ->label('Last Test')
                    ->formatStateUsing(fn ($state): string => match ($state) {
                        true => 'Passed',
                        false => 'Failed',
                        null => 'Never tested',
                        default => 'Never tested',
                    })
                    ->badge()
                    ->color(fn ($state): string => match ($state) {
                        true => 'success',
                        false => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('last_tested_at')
                    ->dateTime()
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->options(static::$categories),
                Tables\Filters\TernaryFilter::make('is_enabled'),
                Tables\Filters\TernaryFilter::make('is_primary'),
            ])
            ->actions([
                Actions\EditAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}