<?php

namespace App\Filament\Resources;

use App\Enums\Payment\PaymentProvider;
use App\Enums\Payment\SubscriptionStatus;
use App\Filament\Resources\SubscriptionResource\Pages;
use App\Models\Subscription;
use App\ValueObjects\Money;
use Filament\Actions;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SubscriptionResource extends Resource
{
    protected static ?string $model = Subscription::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-arrow-path';

    protected static string | \UnitEnum | null $navigationGroup = 'Management';

    protected static ?int $navigationSort = 3;

    protected static ?string $label = 'Subscription';

    protected static ?string $pluralLabel = 'Subscriptions';

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
                        Forms\Components\Select::make('plan')
                            ->options([
                                'monthly' => 'Monthly',
                                'yearly' => 'Yearly',
                            ])
                            ->default('monthly')
                            ->required(),
                        Forms\Components\Select::make('status')
                            ->options(collect(SubscriptionStatus::cases())->mapWithKeys(fn ($s) => [$s->value => ucfirst(str_replace('_', ' ', $s->value))])->all())
                            ->default('active')
                            ->required(),
                        Forms\Components\Select::make('provider')
                            ->options(collect(PaymentProvider::cases())->mapWithKeys(fn ($p) => [$p->value => $p->displayName()])->all())
                            ->nullable(),
                        Forms\Components\TextInput::make('amount')
                            ->numeric()
                            ->helperText('Amount in kobo (minor units).')
                            ->required(),
                        Forms\Components\TextInput::make('currency')
                            ->default('NGN')
                            ->maxLength(3),
                        Forms\Components\TextInput::make('provider_subscription_id')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('provider_plan_code')
                            ->maxLength(255),
                        Forms\Components\DateTimePicker::make('starts_at'),
                        Forms\Components\DateTimePicker::make('ends_at'),
                        Forms\Components\DateTimePicker::make('trial_ends_at'),
                        Forms\Components\DateTimePicker::make('cancelled_at'),
                        Forms\Components\DateTimePicker::make('last_payment_at'),
                        Forms\Components\DateTimePicker::make('next_payment_at'),
                        Forms\Components\TextInput::make('payments_count')
                            ->numeric()
                            ->default(0),
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
                Tables\Columns\TextColumn::make('plan')
                    ->badge()
                    ->color(fn (string $state): string => $state === 'yearly' ? 'info' : 'gray'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active', 'trial' => 'success',
                        'past_due', 'non_renewing' => 'warning',
                        'cancelled', 'expired', 'paused' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('amount')
                    ->formatStateUsing(fn ($state) => '₦' . number_format(Money::fromKobo((int) $state)->toNaira(), 2)),
                Tables\Columns\TextColumn::make('provider')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('ends_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('payments_count')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(collect(SubscriptionStatus::cases())->mapWithKeys(fn ($s) => [$s->value => ucfirst(str_replace('_', ' ', $s->value))])->all()),
                Tables\Filters\SelectFilter::make('plan')
                    ->options([
                        'monthly' => 'Monthly',
                        'yearly' => 'Yearly',
                    ]),
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
            'index' => Pages\ListSubscriptions::route('/'),
            'create' => Pages\CreateSubscription::route('/create'),
            'edit' => Pages\EditSubscription::route('/{record}/edit'),
        ];
    }
}