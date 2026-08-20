<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookmarkResource\Pages;
use App\Models\Bookmark;
use Filament\Actions;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BookmarkResource extends Resource
{
    protected static ?string $model = Bookmark::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-bookmark';

    protected static string | \UnitEnum | null $navigationGroup = 'Management';

    protected static ?int $navigationSort = 6;

    protected static ?string $label = 'Bookmark';

    protected static ?string $pluralLabel = 'Bookmarks';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                \Filament\Schemas\Components\Section::make()
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->relationship('user', 'email')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\TextInput::make('bookmarkable_type')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('bookmarkable_id')
                            ->required()
                            ->numeric(),
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
                Tables\Columns\TextColumn::make('bookmarkable_type')
                    ->formatStateUsing(fn ($state) => class_basename((string) $state))
                    ->badge(),
                Tables\Columns\TextColumn::make('bookmarkable_id')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->actions([
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
            'index' => Pages\ListBookmarks::route('/'),
        ];
    }
}