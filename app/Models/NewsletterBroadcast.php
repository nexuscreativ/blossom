<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsletterBroadcast extends Model
{
    protected $fillable = [
        'subject', 'preview_text', 'body', 'status',
        'recipients_count', 'sent_count', 'opened_count',
        'clicked_count', 'sent_at', 'sent_by',
    ];

    protected function casts(): array
    {
        return ['sent_at' => 'datetime'];
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sent_by');
    }

    public function scopeSent($query)
    {
        return $query->where('status', 'sent');
    }
}
