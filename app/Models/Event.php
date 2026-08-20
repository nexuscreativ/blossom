<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'organizer_id', 'title', 'slug', 'description', 'body',
        'featured_image', 'venue', 'address', 'latitude', 'longitude',
        'starts_at', 'ends_at', 'status', 'ticket_type', 'ticket_price',
        'max_attendees', 'attendees_count', 'ticket_url', 'website',
        'contact_email', 'contact_phone',
        'type', 'duration', 'is_featured',
    ];

    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
            'ticket_price' => 'decimal:2',
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
            'is_featured' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::creating(fn (Event $e) => $e->slug ??= Str::slug($e->title));
    }

    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('status', 'published')->where('starts_at', '>=', now())->orderBy('starts_at');
    }

    public function isUpcoming(): bool
    {
        return $this->status === 'published' && $this->starts_at->isFuture();
    }
}
