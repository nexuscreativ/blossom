<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class NewsletterSubscriber extends Model
{
    protected $fillable = [
        'user_id', 'email', 'name', 'status', 'token',
        'subscribed_at', 'unsubscribed_at', 'source',
    ];

    protected function casts(): array
    {
        return [
            'subscribed_at' => 'datetime',
            'unsubscribed_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (NewsletterSubscriber $subscriber) {
            if (empty($subscriber->token)) {
                $subscriber->token = Str::random(64);
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function unsubscribe(): void
    {
        $this->update(['status' => 'unsubscribed', 'unsubscribed_at' => now()]);
    }
}
