<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use Filament\Actions;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static string | \UnitEnum | null $navigationGroup = 'Management';

    protected static ?int $navigationSort = 4;

    protected static ?string $label = 'Community Post';

    protected static ?string $pluralLabel = 'Community Posts';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                \Filament\Schemas\Components\Section::make()
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->relationship('user', 'email')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\Select::make('type')
                            ->options([
                                'text' => 'Text',
                                'image' => 'Image',
                                'link' => 'Link',
                            ])
                            ->default('text')
                            ->required(),
                        Forms\Components\Textarea::make('body')
                            ->rows(5)
                            ->required(),
                        Forms\Components\FileUpload::make('image')
                            ->image()
                            ->directory('community')
                            ->maxSize(5120),
                        Forms\Components\Toggle::make('is_pinned')
                            ->default(false),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.email')
                    ->label('User')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('body')
                    ->limit(60)
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->badge(),
                Tables\Columns\TextColumn::make('likes_count')
                    ->sortable(),
                Tables\Columns\TextColumn::make('comments_count')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_pinned')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'text' => 'Text',
                        'image' => 'Image',
                        'link' => 'Link',
                    ]),
                Tables\Filters\TernaryFilter::make('is_pinned'),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}