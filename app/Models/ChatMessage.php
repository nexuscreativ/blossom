<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatMessage extends Model
{
    protected $fillable = [
        'conversation_id', 'role', 'body', 'attachments',
        'source', 'is_hitl', 'delivered_at', 'read_at',
    ];

    protected $casts = [
        'attachments' => 'array',
        'is_hitl' => 'boolean',
        'delivered_at' => 'datetime',
        'read_at' => 'datetime',
    ];

    public function conversation(): BelongsTo
    {
        return $this->belongsTo(ChatConversation::class, 'conversation_id');
    }
}