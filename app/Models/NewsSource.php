<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NewsSource extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'driver',
        'api_key',
        'api_url',
        'categories',
        'country',
        'language',
        'is_active',
        'is_auto_publish',
        'fetch_interval',
        'last_fetched_at',
        'settings',
    ];

    protected function casts(): array
    {
        return [
            'categories' => 'array',
            'settings' => 'array',
            'is_active' => 'boolean',
            'is_auto_publish' => 'boolean',
            'last_fetched_at' => 'datetime',
        ];
    }

    public function articles(): HasMany
    {
        return $this->hasMany(AggregatedArticle::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function shouldFetch(): bool
    {
        if (! $this->is_active) {
            return false;
        }

        if (! $this->last_fetched_at) {
            return true;
        }

        return $this->last_fetched_at->addSeconds($this->fetch_interval)->isPast();
    }
}
