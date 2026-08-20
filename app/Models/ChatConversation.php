<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ChatConversation extends Model
{
    protected $fillable = [
        'channel', 'channel_identifier', 'visitor_name', 'visitor_email',
        'subject', 'status', 'is_hitl', 'is_ai', 'assigned_to_id',
        'escalated_at', 'resolved_at', 'metadata', 'last_message_at',
    ];

    protected $casts = [
        'is_hitl' => 'boolean',
        'is_ai' => 'boolean',
        'escalated_at' => 'datetime',
        'resolved_at' => 'datetime',
        'last_message_at' => 'datetime',
        'metadata' => 'array',
    ];

    public const STATUS_OPEN = 'open';
    public const STATUS_WAITING = 'waiting';
    public const STATUS_ESCALATED = 'escalated';
    public const STATUS_RESOLVED = 'resolved';
    public const STATUS_CLOSED = 'closed';

    public function messages(): HasMany
    {
        return $this->hasMany(ChatMessage::class, 'conversation_id')->orderBy('created_at');
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to_id');
    }

    public function isOpen(): bool
    {
        return in_array($this->status, [self::STATUS_OPEN, self::STATUS_WAITING]);
    }

    public function markLastMessage(): void
    {
        $this->update(['last_message_at' => now()]);
    }
}