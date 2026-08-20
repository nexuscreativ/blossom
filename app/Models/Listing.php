<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Listing extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'owner_id', 'name', 'slug', 'type', 'description', 'body',
        'featured_image', 'website', 'email', 'phone', 'address',
        'city', 'state', 'latitude', 'longitude', 'tier', 'status',
        'is_verified', 'views_count', 'rating', 'featured_until',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
            'is_verified' => 'boolean',
            'rating' => 'integer',
            'featured_until' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::creating(fn (Listing $l) => $l->slug ??= Str::slug($l->name));
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function images()
    {
        return $this->hasMany(ListingImage::class);
    }

    public function reviews()
    {
        return $this->hasMany(ListingReview::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeFeatured($query)
    {
        return $query->active()->where('tier', 'featured');
    }

    public function scopePremium($query)
    {
        return $query->active()->where('tier', 'premium');
    }
}
