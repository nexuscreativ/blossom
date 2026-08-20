<?php

namespace App\Filament\Resources;

use App\Enums\Payment\PaymentProvider;
use App\Enums\Payment\TransactionStatus;
use App\Enums\Payment\TransactionType;
use App\Filament\Resources\TransactionResource\Pages;
use App\Models\Transaction;
use App\ValueObjects\Money;
use Filament\Actions;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-banknotes';

    protected static string | \UnitEnum | null $navigationGroup = 'Management';

    protected static ?int $navigationSort = 2;

    protected static ?string $label = 'Transaction';

    protected static ?string $pluralLabel = 'Transactions';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                \Filament\Schemas\Components\Section::make()
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('reference')
                            ->required()
                            ->maxLength(100),
                        Forms\Components\Select::make('user_id')
                            ->relationship('user', 'email')
                            ->searchable()
                            ->preload()
                            ->nullable(),
                        Forms\Components\Select::make('provider')
                            ->options(collect(PaymentProvider::cases())->mapWithKeys(fn ($p) => [$p->value => $p->displayName()])->all())
                            ->required(),
                        Forms\Components\Select::make('type')
                            ->options(collect(TransactionType::cases())->mapWithKeys(fn ($t) => [$t->value => ucfirst(str_replace('_', ' ', $t->value))])->all())
                            ->required(),
                        Forms\Components\Select::make('status')
                            ->options(collect(TransactionStatus::cases())->mapWithKeys(fn ($s) => [$s->value => ucfirst($s->value)])->all())
                            ->default('pending')
                            ->required(),
                        Forms\Components\TextInput::make('amount')
                            ->numeric()
                            ->required()
                            ->helperText('Amount in kobo (minor units).'),
                        Forms\Components\TextInput::make('currency')
                            ->default('NGN')
                            ->maxLength(3),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->maxLength(255),
                        Forms\Components\DateTimePicker::make('paid_at'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('reference')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.email')
                    ->label('User')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('amount')
                    ->formatStateUsing(fn ($state) => '₦' . number_format(Money::fromKobo((int) $state)->toNaira(), 2))
                    ->sortable(),
                Tables\Columns\TextColumn::make('provider')
                    ->badge()
                    ->formatStateUsing(fn ($state) => ucfirst((string) $state)),
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->formatStateUsing(fn ($state) => ucfirst(str_replace('_', ' ', (string) $state))),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'success' => 'success',
                        'pending', 'processing' => 'warning',
                        'failed', 'cancelled', 'refunded' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('paid_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(collect(TransactionStatus::cases())->mapWithKeys(fn ($s) => [$s->value => ucfirst($s->value)])->all()),
                Tables\Filters\SelectFilter::make('provider')
                    ->options(collect(PaymentProvider::cases())->mapWithKeys(fn ($p) => [$p->value => $p->displayName()])->all()),
                Tables\Filters\SelectFilter::make('type')
                    ->options(collect(TransactionType::cases())->mapWithKeys(fn ($t) => [$t->value => ucfirst(str_replace('_', ' ', $t->value))])->all()),
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
            'index' => Pages\ListTransactions::route('/'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }
}