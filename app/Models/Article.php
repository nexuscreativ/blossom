<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'author_id',
        'category_id',
        'title',
        'slug',
        'excerpt',
        'body',
        'featured_image',
        'featured_image_caption',
        'pill_color',
        'status',
        'is_featured',
        'is_premium',
        'is_editor_pick',
        'reading_time',
        'views_count',
        'likes_count',
        'comments_count',
        'bookmarks_count',
        'published_at',
        'scheduled_at',
        'seo_title',
        'seo_description',
    ];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'is_premium' => 'boolean',
            'is_editor_pick' => 'boolean',
            'published_at' => 'datetime',
            'scheduled_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Article $article) {
            if (empty($article->slug)) {
                $article->slug = Str::slug($article->title);
            }
            $article->reading_time = max(1, (int) ceil(str_word_count(strip_tags($article->body)) / 200));
        });
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ArticleImage::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'commentable_id')
            ->where('commentable_type', Article::class);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                     ->whereNotNull('published_at')
                     ->where('published_at', '<=', now());
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopePremium($query)
    {
        return $query->where('is_premium', true);
    }

    public function scopeEditorsPicks($query)
    {
        return $query->where('is_editor_pick', true);
    }

    public function scopeTrending($query, int $days = 7)
    {
        return $query->published()
                     ->where('published_at', '>=', now()->subDays($days))
                     ->orderByDesc('views_count');
    }
}
