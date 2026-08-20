<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CommentResource\Pages;
use App\Models\Comment;
use Filament\Actions;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CommentResource extends Resource
{
    protected static ?string $model = Comment::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-chat-bubble-oval-left';

    protected static string | \UnitEnum | null $navigationGroup = 'Management';

    protected static ?int $navigationSort = 5;

    protected static ?string $label = 'Comment';

    protected static ?string $pluralLabel = 'Comments';

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
                        Forms\Components\Textarea::make('body')
                            ->rows(4)
                            ->required(),
                        Forms\Components\TextInput::make('commentable_type')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('commentable_id')
                            ->numeric(),
                        Forms\Components\Select::make('parent_id')
                            ->relationship('parent', 'id')
                            ->searchable()
                            ->preload()
                            ->nullable()
                            ->label('Parent Comment'),
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
                Tables\Columns\TextColumn::make('commentable_type')
                    ->formatStateUsing(fn ($state) => class_basename((string) $state))
                    ->badge(),
                Tables\Columns\TextColumn::make('likes_count')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
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
            'index' => Pages\ListComments::route('/'),
            'create' => Pages\CreateComment::route('/create'),
            'edit' => Pages\EditComment::route('/{record}/edit'),
        ];
    }
}