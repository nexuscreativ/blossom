<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Models\Event;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-calendar-days';

    protected static string | \UnitEnum | null $navigationGroup = 'Content';

    protected static ?int $navigationSort = 2;

    protected static ?string $label = 'Event';

    protected static ?string $pluralLabel = 'Events';

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
                            ->unique(Event::class, 'slug', ignoreRecord: true),
                        Forms\Components\Select::make('type')
                            ->options([
                                'Festival' => 'Festival',
                                'Conference' => 'Conference',
                                'Exhibition' => 'Exhibition',
                                'Competition' => 'Competition',
                                'Concert' => 'Concert',
                                'Gala' => 'Gala',
                                'Workshop' => 'Workshop',
                                'Other' => 'Other',
                            ]),
                        Forms\Components\TextInput::make('duration')
                            ->placeholder('e.g. 3-Day Event')
                            ->maxLength(40),
                        Forms\Components\Toggle::make('is_featured')
                            ->label('Featured Event'),
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

                \Filament\Schemas\Components\Section::make('Details')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('venue')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('address')
                            ->maxLength(255),
                        Forms\Components\DateTimePicker::make('starts_at')
                            ->required(),
                        Forms\Components\DateTimePicker::make('ends_at')
                            ->required(),
                        Forms\Components\TextInput::make('max_attendees')
                            ->numeric()
                            ->label('Capacity'),
                        Forms\Components\TextInput::make('attendees_count')
                            ->numeric()
                            ->default(0)
                            ->disabled(),
                    ]),

                \Filament\Schemas\Components\Section::make('Ticketing')
                    ->columns(3)
                    ->schema([
                        Forms\Components\Select::make('ticket_type')
                            ->options([
                                'free' => 'Free',
                                'paid' => 'Paid',
                                'registration' => 'Registration Required',
                            ])
                            ->default('free')
                            ->required(),
                        Forms\Components\TextInput::make('ticket_price')
                            ->numeric()
                            ->prefix('₦')
                            ->default(0),
                        Forms\Components\TextInput::make('ticket_url')
                            ->url()
                            ->maxLength(255),
                    ]),

                \Filament\Schemas\Components\Section::make('Settings')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->options([
                                'draft' => 'Draft',
                                'published' => 'Published',
                                'cancelled' => 'Cancelled',
                                'completed' => 'Completed',
                            ])
                            ->default('draft')
                            ->required(),
                        Forms\Components\TextInput::make('organizer_id')
                            ->numeric(),
                    ]),

                \Filament\Schemas\Components\Section::make('Contact & Media')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('contact_email')
                            ->email()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('contact_phone')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('website')
                            ->url()
                            ->maxLength(255),
                        Forms\Components\FileUpload::make('featured_image')
                            ->image()
                            ->directory('events')
                            ->maxSize(5120),
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
                Tables\Columns\TextColumn::make('venue')
                    ->searchable(),
                Tables\Columns\TextColumn::make('starts_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ticket_type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'free' => 'success',
                        'paid' => 'warning',
                        'registration' => 'info',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'draft' => 'gray',
                        'published' => 'success',
                        'cancelled' => 'danger',
                        'completed' => 'info',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('attendees_count')
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
                        'published' => 'Published',
                        'cancelled' => 'Cancelled',
                        'completed' => 'Completed',
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
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }
}
