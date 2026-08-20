<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ChatConversationResource\Pages;
use App\Models\ChatConversation;
use App\Services\Chat\ChatManager;
use Filament\Actions;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ChatConversationResource extends Resource
{
    protected static ?string $model = ChatConversation::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static string | \UnitEnum | null $navigationGroup = 'Management';

    protected static ?int $navigationSort = 2;

    protected static ?string $label = 'Conversation';

    protected static ?string $pluralLabel = 'Chat Inbox';

    protected static string | \Illuminate\Contracts\Support\Htmlable | null $navigationBadgeTooltip = 'Open conversations';

    public static function getNavigationBadge(): ?string
    {
        $count = static::getModel()::whereIn('status', [
            ChatConversation::STATUS_OPEN,
            ChatConversation::STATUS_ESCALATED,
        ])->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                \Filament\Schemas\Components\View::make('filament.resources.chat-transcript'),
                \Filament\Schemas\Components\Section::make('Visitor')
                    ->schema([
                        TextInput::make('visitor_name'),
                        TextInput::make('visitor_email'),
                        TextInput::make('subject'),
                    ])->columns(3),
                \Filament\Schemas\Components\Section::make('Conversation')
                    ->schema([
                        Select::make('channel')
                            ->options([
                                'web' => 'Web Widget',
                                'whatsapp' => 'WhatsApp',
                                'telegram' => 'Telegram',
                                'voice' => 'Voice',
                            ])
                            ->disabled(),
                        Select::make('status')
                            ->options([
                                ChatConversation::STATUS_OPEN => 'Open',
                                ChatConversation::STATUS_WAITING => 'Waiting',
                                ChatConversation::STATUS_ESCALATED => 'Escalated',
                                ChatConversation::STATUS_RESOLVED => 'Resolved',
                                ChatConversation::STATUS_CLOSED => 'Closed',
                            ]),
                        Select::make('assigned_to_id')
                            ->relationship('assignedTo', 'email')
                            ->searchable()
                            ->preload()
                            ->nullable()
                            ->label('Assigned Agent'),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('last_message_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('visitor_name')
                    ->placeholder('Anonymous')
                    ->description(fn (ChatConversation $record) => $record->visitor_email ?? $record->channel_identifier ?? '')
                    ->searchable(),
                Tables\Columns\TextColumn::make('channel')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'whatsapp' => 'success',
                        'telegram' => 'info',
                        'voice' => 'warning',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('last_message')
                    ->state(fn (ChatConversation $record) => $record->messages()->latest()->value('body'))
                    ->limit(50),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        ChatConversation::STATUS_ESCALATED => 'warning',
                        ChatConversation::STATUS_RESOLVED => 'success',
                        ChatConversation::STATUS_CLOSED => 'gray',
                        default => 'info',
                    }),
                Tables\Columns\TextColumn::make('assignedTo.email')
                    ->placeholder('—')
                    ->label('Agent'),
                Tables\Columns\TextColumn::make('messages_count')
                    ->counts('messages')
                    ->label('Messages')
                    ->sortable(),
                Tables\Columns\TextColumn::make('last_message_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        ChatConversation::STATUS_OPEN => 'Open',
                        ChatConversation::STATUS_WAITING => 'Waiting',
                        ChatConversation::STATUS_ESCALATED => 'Escalated',
                        ChatConversation::STATUS_RESOLVED => 'Resolved',
                        ChatConversation::STATUS_CLOSED => 'Closed',
                    ]),
                Tables\Filters\SelectFilter::make('channel')
                    ->options([
                        'web' => 'Web Widget',
                        'whatsapp' => 'WhatsApp',
                        'telegram' => 'Telegram',
                        'voice' => 'Voice',
                    ]),
            ])
            ->actions([
                Actions\EditAction::make()->label('Open'),
                Actions\Action::make('reply')
                    ->label('Reply')
                    ->icon('heroicon-o-paper-airplane')
                    ->form([
                        Textarea::make('body')
                            ->required()
                            ->label('Reply Message'),
                    ])
                    ->action(function (ChatConversation $record, array $data): void {
                        $manager = app(ChatManager::class);
                        $agent = auth()->user();
                        $manager->agentReply($record, $data['body'], $agent);

                        Notification::make()
                            ->title('Reply sent to visitor.')
                            ->success()
                            ->send();
                    })
                    ->visible(fn (ChatConversation $record) => $record->is_hitl),
                Actions\Action::make('resolve')
                    ->label('Resolve')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->action(function (ChatConversation $record): void {
                        app(ChatManager::class)->resolve($record, auth()->user());
                        Notification::make()->title('Conversation resolved.')->success()->send();
                    })
                    ->visible(fn (ChatConversation $record) => $record->isOpen()),
                Actions\Action::make('reopen')
                    ->label('Reopen')
                    ->icon('heroicon-o-arrow-path')
                    ->color('warning')
                    ->action(function (ChatConversation $record): void {
                        $record->update([
                            'status' => ChatConversation::STATUS_OPEN,
                            'is_hitl' => false,
                            'is_ai' => true,
                            'resolved_at' => null,
                        ]);
                        Notification::make()->title('Conversation reopened.')->warning()->send();
                    })
                    ->visible(fn (ChatConversation $record) => in_array($record->status, [ChatConversation::STATUS_RESOLVED, ChatConversation::STATUS_CLOSED])),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\Action::make('bulk-resolve')
                        ->label('Resolve selected')
                        ->icon('heroicon-o-check-circle')
                        ->action(function ($records): void {
                            foreach ($records as $record) {
                                app(ChatManager::class)->resolve($record, auth()->user());
                            }
                            Notification::make()->title('Selected conversations resolved.')->success()->send();
                        }),
                    Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListChatConversations::route('/'),
            'edit' => Pages\EditChatConversation::route('/{record}/edit'),
        ];
    }
}