<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsletterSubscriberResource\Pages;
use App\Models\NewsletterSubscriber;
use Filament\Actions;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;

class NewsletterSubscriberResource extends Resource
{
    protected static ?string $model = NewsletterSubscriber::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-envelope';

    protected static string | \UnitEnum | null $navigationGroup = 'Management';

    protected static ?int $navigationSort = 1;

    protected static ?string $label = 'Newsletter Subscriber';

    protected static ?string $pluralLabel = 'Newsletter Subscribers';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                \Filament\Schemas\Components\Section::make()
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('name')
                            ->maxLength(255),
                        Forms\Components\Select::make('status')
                            ->options([
                                'active' => 'Active',
                                'unsubscribed' => 'Unsubscribed',
                                'bounced' => 'Bounced',
                            ])
                            ->default('active')
                            ->required(),
                        Forms\Components\TextInput::make('source')
                            ->maxLength(50),
                        Forms\Components\Select::make('user_id')
                            ->relationship('user', 'email')
                            ->searchable()
                            ->preload()
                            ->nullable(),
                        Forms\Components\DateTimePicker::make('subscribed_at'),
                        Forms\Components\DateTimePicker::make('unsubscribed_at'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'unsubscribed' => 'gray',
                        'bounced' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('source')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('subscribed_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'active' => 'Active',
                        'unsubscribed' => 'Unsubscribed',
                        'bounced' => 'Bounced',
                    ]),
            ])
            ->actions([
                Action::make('unsubscribe')
                    ->label('Unsubscribe')
                    ->icon('heroicon-o-x-circle')
                    ->color('warning')
                    ->visible(fn (NewsletterSubscriber $record) => $record->status === 'active')
                    ->requiresConfirmation()
                    ->action(fn (NewsletterSubscriber $record) => $record->unsubscribe()),
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
            'index' => Pages\ListNewsletterSubscribers::route('/'),
            'create' => Pages\CreateNewsletterSubscriber::route('/create'),
            'edit' => Pages\EditNewsletterSubscriber::route('/{record}/edit'),
        ];
    }
}