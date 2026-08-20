<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-users';

    protected static string | \UnitEnum | null $navigationGroup = 'Administration';

    protected static ?int $navigationSort = 10;

    protected static ?string $label = 'User';

    protected static ?string $pluralLabel = 'Users';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                \Filament\Schemas\Components\Section::make()
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('first_name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('last_name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->unique(User::class, 'email', ignoreRecord: true),
                        Forms\Components\Select::make('role')
                            ->options([
                                'user' => 'User',
                                'author' => 'Author',
                                'editor' => 'Editor',
                                'admin' => 'Admin',
                            ])
                            ->default('user')
                            ->required(),
                        Forms\Components\Toggle::make('is_active')
                            ->default(true),
                    ]),

                \Filament\Schemas\Components\Section::make('Profile')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('phone')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('location')
                            ->maxLength(255),
                        Forms\Components\Textarea::make('bio')
                            ->rows(3),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('first_name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('last_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('role')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'user' => 'gray',
                        'author' => 'info',
                        'editor' => 'warning',
                        'admin' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->options([
                        'user' => 'User',
                        'author' => 'Author',
                        'editor' => 'Editor',
                        'admin' => 'Admin',
                    ]),
                Tables\Filters\TernaryFilter::make('is_active'),
            ])
            ->actions([
                Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
