<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ListingResource\Pages;
use App\Models\Listing;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions;

class ListingResource extends Resource
{
    protected static ?string $model = Listing::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-map-pin';

    protected static string | \UnitEnum | null $navigationGroup = 'Content';

    protected static ?int $navigationSort = 3;

    protected static ?string $label = 'Listing';

    protected static ?string $pluralLabel = 'Listings';

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
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->dehydrated()
                            ->unique(Listing::class, 'slug', ignoreRecord: true),
                    ]),

                \Filament\Schemas\Components\Section::make()
                    ->schema([
                        Forms\Components\Textarea::make('description')
                            ->rows(4)
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('body')
                            ->rows(6)
                            ->columnSpanFull(),
                    ]),

                \Filament\Schemas\Components\Section::make('Contact & Location')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('website')
                            ->url()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('phone')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('address')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('city')
                            ->maxLength(255)
                            ->default('Jos'),
                        Forms\Components\TextInput::make('state')
                            ->maxLength(255)
                            ->default('Plateau'),
                    ]),

                \Filament\Schemas\Components\Section::make('Settings')
                    ->columns(3)
                    ->schema([
                        Forms\Components\Select::make('type')
                            ->options([
                                'business' => 'Business',
                                'personality' => 'Personality',
                                'institution' => 'Institution',
                            ])
                            ->default('business')
                            ->required(),
                        Forms\Components\Select::make('tier')
                            ->options([
                                'standard' => 'Standard',
                                'featured' => 'Featured',
                                'premium' => 'Premium',
                            ])
                            ->default('standard')
                            ->required(),
                        Forms\Components\Select::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'active' => 'Active',
                                'suspended' => 'Suspended',
                                'archived' => 'Archived',
                            ])
                            ->default('pending')
                            ->required(),
                    ]),

                \Filament\Schemas\Components\Section::make('Visibility')
                    ->columns(3)
                    ->schema([
                        Forms\Components\Toggle::make('is_verified')
                            ->default(false),
                        Forms\Components\TextInput::make('rating')
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(5),
                        Forms\Components\DateTimePicker::make('featured_until'),
                    ]),

                \Filament\Schemas\Components\Section::make('Media')
                    ->schema([
                        Forms\Components\FileUpload::make('featured_image')
                            ->image()
                            ->directory('listings')
                            ->maxSize(5120),
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
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'business' => 'success',
                        'personality' => 'info',
                        'institution' => 'warning',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('city')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tier')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'standard' => 'gray',
                        'featured' => 'info',
                        'premium' => 'warning',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'active' => 'success',
                        'suspended' => 'danger',
                        'archived' => 'gray',
                        default => 'gray',
                    }),
                Tables\Columns\IconColumn::make('is_verified')
                    ->boolean(),
                Tables\Columns\TextColumn::make('rating')
                    ->sortable(),
                Tables\Columns\TextColumn::make('views_count')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'active' => 'Active',
                        'suspended' => 'Suspended',
                        'archived' => 'Archived',
                    ]),
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'business' => 'Business',
                        'personality' => 'Personality',
                        'institution' => 'Institution',
                    ]),
                Tables\Filters\SelectFilter::make('tier')
                    ->options([
                        'standard' => 'Standard',
                        'featured' => 'Featured',
                        'premium' => 'Premium',
                    ]),
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
            'index' => Pages\ListListings::route('/'),
            'create' => Pages\CreateListing::route('/create'),
            'edit' => Pages\EditListing::route('/{record}/edit'),
        ];
    }
}
