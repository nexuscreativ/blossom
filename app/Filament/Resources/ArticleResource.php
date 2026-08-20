<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticleResource\Pages;
use App\Models\Article;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-document-text';

    protected static string | \UnitEnum | null $navigationGroup = 'Content';

    protected static ?int $navigationSort = 1;

    protected static ?string $label = 'Article';

    protected static ?string $pluralLabel = 'Articles';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                \Filament\Schemas\Components\Section::make()
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($operation, $state, Forms\Set $set) =>
                                $operation === 'create' ? $set('slug', \Illuminate\Support\Str::slug($state)) : null
                            ),
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->dehydrated()
                            ->unique(Article::class, 'slug', ignoreRecord: true),
                    ]),

                \Filament\Schemas\Components\Section::make()
                    ->schema([
                        Forms\Components\Textarea::make('excerpt')
                            ->rows(3)
                            ->maxLength(500),
                        Forms\Components\RichEditor::make('body')
                            ->required()
                            ->columnSpanFull(),
                    ]),

                \Filament\Schemas\Components\Section::make('Settings')
                    ->columns(3)
                    ->schema([
                        Forms\Components\Select::make('category_id')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload(),
                        Forms\Components\Select::make('status')
                            ->options([
                                'draft' => 'Draft',
                                'review' => 'In Review',
                                'published' => 'Published',
                                'archived' => 'Archived',
                            ])
                            ->default('draft')
                            ->required(),
                        Forms\Components\TextInput::make('reading_time')
                            ->numeric()
                            ->default(5)
                            ->suffix('min'),
                    ]),

                \Filament\Schemas\Components\Section::make('Flags')
                    ->columns(3)
                    ->schema([
                        Forms\Components\Toggle::make('is_featured'),
                        Forms\Components\Toggle::make('is_premium'),
                        Forms\Components\Toggle::make('is_editor_pick'),
                        Forms\Components\Select::make('pill_color')
                            ->options([
                                'purple' => 'Purple',
                                'green' => 'Green',
                                'orange' => 'Orange',
                                'outline' => 'Outline',
                            ])
                            ->default('purple'),
                    ]),

                \Filament\Schemas\Components\Section::make('Media')
                    ->schema([
                        Forms\Components\FileUpload::make('featured_image')
                            ->image()
                            ->directory('articles')
                            ->maxSize(5120),
                        Forms\Components\TextInput::make('featured_image_caption')
                            ->maxLength(255),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'draft' => 'gray',
                        'review' => 'warning',
                        'published' => 'success',
                        'archived' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\IconColumn::make('is_featured')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_premium')
                    ->boolean(),
                Tables\Columns\TextColumn::make('views_count')
                    ->sortable(),
                Tables\Columns\TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'review' => 'In Review',
                        'published' => 'Published',
                        'archived' => 'Archived',
                    ]),
                Tables\Filters\SelectFilter::make('category_id')
                    ->relationship('category', 'name')
                    ->label('Category'),
                Tables\Filters\TernaryFilter::make('is_featured'),
                Tables\Filters\TernaryFilter::make('is_premium'),
            ])
            ->actions([
                Actions\EditAction::make(),
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
            'index' => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'edit' => Pages\EditArticle::route('/{record}/edit'),
        ];
    }
}
