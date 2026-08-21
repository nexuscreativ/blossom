<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsSourceResource\Pages;
use App\Models\NewsSource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions;

class NewsSourceResource extends Resource
{
    protected static ?string $model = NewsSource::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-signal';

    protected static string | \UnitEnum | null $navigationGroup = 'News Aggregator';

    protected static ?int $navigationSort = 10;

    protected static ?string $label = 'News Source';

    protected static ?string $pluralLabel = 'News Sources';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                \Filament\Schemas\Components\Section::make()
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('driver')
                            ->options([
                                'newsdata' => 'NewsData.io',
                                'guardian' => 'The Guardian',
                            ])
                            ->required(),
                    ]),

                \Filament\Schemas\Components\Section::make('API Configuration')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('api_key')
                            ->label('API Key')
                            ->password()
                            ->revealable()
                            ->nullable(),
                        Forms\Components\TextInput::make('api_url')
                            ->label('API Base URL')
                            ->required()
                            ->maxLength(500)
                            ->default(fn (Forms\Get $get) => match ($get('driver')) {
                                'newsdata' => 'https://newsdata.io/api/1',
                                'guardian' => 'https://content.guardianapis.com',
                                default => '',
                            }),
                        Forms\Components\MultiSelect::make('categories')
                            ->options([
                                'business' => 'Business',
                                'technology' => 'Technology',
                                'entertainment' => 'Entertainment',
                                'health' => 'Health & Wellness',
                                'sports' => 'Sports',
                                'lifestyle' => 'Lifestyle',
                                'politics' => 'Politics & Governance',
                                'culture' => 'Culture & Heritage',
                            ])
                            ->default(['business', 'technology', 'entertainment', 'health', 'sports', 'lifestyle', 'politics', 'culture'])
                            ->required(),
                        Forms\Components\TextInput::make('country')
                            ->default('ng')
                            ->maxLength(10),
                        Forms\Components\TextInput::make('language')
                            ->default('en')
                            ->maxLength(10),
                    ]),

                \Filament\Schemas\Components\Section::make('Settings')
                    ->columns(3)
                    ->schema([
                        Forms\Components\Toggle::make('is_active')
                            ->default(true),
                        Forms\Components\Toggle::make('is_auto_publish')
                            ->default(true)
                            ->label('Auto-publish fetched articles'),
                        Forms\Components\TextInput::make('fetch_interval')
                            ->numeric()
                            ->default(3600)
                            ->suffix('seconds'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('driver')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'newsdata' => 'info',
                        'guardian' => 'success',
                        default => 'gray',
                    }),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_auto_publish')
                    ->boolean()
                    ->label('Auto-publish'),
                Tables\Columns\TextColumn::make('last_fetched_at')
                    ->dateTime()
                    ->sortable()
                    ->placeholder('Never'),
                Tables\Columns\TextColumn::make('articles_count')
                    ->counts('articles')
                    ->label('Articles')
                    ->sortable(),
            ])
            ->actions([
                Actions\EditAction::make(),
                Actions\Action::make('fetchNow')
                    ->label('Fetch Now')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Fetch News')
                    ->modalDescription('Fetch latest articles from this source now.')
                    ->action(function (NewsSource $record) {
                        $aggregator = new \App\Services\NewsAggregator\AggregatorService();
                        $count = $aggregator->fetchFromSource($record);

                        \Filament\Notifications\Notification::make()
                            ->title("Fetched {$count} new articles")
                            ->success()
                            ->send();
                    }),
                Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNewsSources::route('/'),
            'create' => Pages\CreateNewsSource::route('/create'),
            'edit' => Pages\EditNewsSource::route('/{record}/edit'),
        ];
    }
}
