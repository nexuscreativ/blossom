<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AggregatedArticleResource\Pages;
use App\Models\AggregatedArticle;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions;

class AggregatedArticleResource extends Resource
{
    protected static ?string $model = AggregatedArticle::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-newspaper';

    protected static string | \UnitEnum | null $navigationGroup = 'News Aggregator';

    protected static ?int $navigationSort = 11;

    protected static ?string $label = 'Aggregated Article';

    protected static ?string $pluralLabel = 'Aggregated Articles';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                \Filament\Schemas\Components\Section::make()
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->dehydrated()
                            ->unique(AggregatedArticle::class, 'slug', ignoreRecord: true),
                    ]),

                \Filament\Schemas\Components\Section::make()
                    ->schema([
                        Forms\Components\Textarea::make('excerpt')
                            ->rows(3)
                            ->maxLength(500),
                        Forms\Components\RichEditor::make('body')
                            ->columnSpanFull(),
                    ]),

                \Filament\Schemas\Components\Section::make('Details')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('source_url')
                            ->label('Source URL')
                            ->url()
                            ->disabled()
                            ->dehydrated(false),
                        Forms\Components\TextInput::make('source_name')
                            ->disabled()
                            ->dehydrated(false),
                        Forms\Components\Select::make('category')
                            ->options([
                                'Business' => 'Business',
                                'Technology' => 'Technology',
                                'Entertainment' => 'Entertainment',
                                'Health & Wellness' => 'Health & Wellness',
                                'Sports' => 'Sports',
                                'Lifestyle' => 'Lifestyle',
                                'Politics & Governance' => 'Politics & Governance',
                                'Culture & Heritage' => 'Culture & Heritage',
                                'General' => 'General',
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('author_name')
                            ->nullable()
                            ->maxLength(255),
                    ]),

                \Filament\Schemas\Components\Section::make('Publishing')
                    ->columns(3)
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'published' => 'Published',
                                'rejected' => 'Rejected',
                            ])
                            ->default('pending')
                            ->required(),
                        Forms\Components\Toggle::make('is_auto_publish')
                            ->label('Auto-publish'),
                        Forms\Components\DateTimePicker::make('published_at_local')
                            ->label('Published At'),
                    ]),

                \Filament\Schemas\Components\Section::make('SEO')
                    ->schema([
                        Forms\Components\TextInput::make('seo_title')
                            ->maxLength(255)
                            ->nullable(),
                        Forms\Components\Textarea::make('seo_description')
                            ->rows(2)
                            ->nullable(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('source_name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('category')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Business' => 'info',
                        'Technology' => 'primary',
                        'Entertainment' => 'danger',
                        'Health & Wellness' => 'success',
                        'Sports' => 'warning',
                        'Lifestyle' => 'gray',
                        'Politics & Governance' => 'info',
                        'Culture & Heritage' => 'warning',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'published' => 'success',
                        'rejected' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('views_count')
                    ->sortable(),
                Tables\Columns\TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('fetched_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'published' => 'Published',
                        'rejected' => 'Rejected',
                    ]),
                Tables\Filters\SelectFilter::make('news_source_id')
                    ->relationship('newsSource', 'name')
                    ->label('Source'),
                Tables\Filters\SelectFilter::make('category')
                    ->options([
                        'Business' => 'Business',
                        'Technology' => 'Technology',
                        'Entertainment' => 'Entertainment',
                        'Health & Wellness' => 'Health & Wellness',
                        'Sports' => 'Sports',
                        'Lifestyle' => 'Lifestyle',
                        'Politics & Governance' => 'Politics & Governance',
                        'Culture & Heritage' => 'Culture & Heritage',
                    ]),
                Tables\Filters\TernaryFilter::make('is_auto_publish')
                    ->label('Auto-published'),
            ])
            ->actions([
                Actions\Action::make('publish')
                    ->label('Publish')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (AggregatedArticle $record): bool => $record->status !== 'published')
                    ->action(fn (AggregatedArticle $record) => $record->approve(auth()->id())),
                Actions\Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn (AggregatedArticle $record): bool => $record->status !== 'rejected')
                    ->action(fn (AggregatedArticle $record) => $record->reject()),
                Actions\Action::make('viewOriginal')
                    ->label('View Original')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->url(fn (AggregatedArticle $record): string => $record->source_url)
                    ->openUrlInNewTab(),
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\BulkAction::make('publishSelected')
                        ->label('Publish Selected')
                        ->icon('heroicon-o-check-circle')
                        ->action(fn ($records) => $records->each->approve(auth()->id())),
                    Actions\BulkAction::make('rejectSelected')
                        ->label('Reject Selected')
                        ->icon('heroicon-o-x-circle')
                        ->action(fn ($records) => $records->each->reject()),
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
            'index' => Pages\ListAggregatedArticles::route('/'),
            'edit' => Pages\EditAggregatedArticle::route('/{record}/edit'),
        ];
    }
}
