<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class AggregatedArticle extends Model
{
    use HasFactory;

    protected $fillable = [
        'news_source_id',
        'external_id',
        'title',
        'slug',
        'excerpt',
        'body',
        'source_url',
        'source_name',
        'source_image',
        'category',
        'tags',
        'author_name',
        'language',
        'published_at',
        'fetched_at',
        'status',
        'is_auto_publish',
        'published_at_local',
        'approved_by',
        'approved_at',
        'views_count',
        'seo_title',
        'seo_description',
    ];

    protected function casts(): array
    {
        return [
            'tags' => 'array',
            'published_at' => 'datetime',
            'fetched_at' => 'datetime',
            'published_at_local' => 'datetime',
            'approved_at' => 'datetime',
            'is_auto_publish' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (AggregatedArticle $article) {
            if (empty($article->slug)) {
                $article->slug = Str::slug($article->title);
            }
        });
    }

    public function newsSource(): BelongsTo
    {
        return $this->belongsTo(NewsSource::class);
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                     ->whereNotNull('published_at_local');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    public function scopeBySource($query, int $sourceId)
    {
        return $query->where('news_source_id', $sourceId);
    }

    public function approve(?int $userId = null): void
    {
        $this->update([
            'status' => 'published',
            'published_at_local' => now(),
            'approved_by' => $userId,
            'approved_at' => now(),
        ]);
    }

    public function reject(): void
    {
        $this->update(['status' => 'rejected']);
    }

    public function getSeoTitleAttribute(): ?string
    {
        return $this->attributes['seo_title'] ?? $this->title;
    }

    public function getSeoDescriptionAttribute(): ?string
    {
        return $this->attributes['seo_description'] ?? $this->excerpt;
    }
}
