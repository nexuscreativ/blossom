<?php

namespace App\Services\NewsAggregator;

use App\Models\AggregatedArticle;
use App\Models\Category;
use App\Models\NewsSource;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AggregatorService
{
    protected NewsDataService $newsDataService;
    protected GuardianService $guardianService;

    protected array $categoryMap = [
        'business' => ['name' => 'Business', 'color' => '#2563EB', 'icon' => 'heroicon-o-briefcase'],
        'technology' => ['name' => 'Technology', 'color' => '#7C3AED', 'icon' => 'heroicon-o-computer-desktop'],
        'entertainment' => ['name' => 'Entertainment', 'color' => '#EC4899', 'icon' => 'heroicon-o-musical-note'],
        'health' => ['name' => 'Health & Wellness', 'color' => '#059669', 'icon' => 'heroicon-o-heart'],
        'sports' => ['name' => 'Sports', 'color' => '#DC2626', 'icon' => 'heroicon-o-trophy'],
        'lifestyle' => ['name' => 'Lifestyle', 'color' => '#D97706', 'icon' => 'heroicon-o-sparkles'],
        'politics' => ['name' => 'Politics & Governance', 'color' => '#4338CA', 'icon' => 'heroicon-o-building-library'],
        'culture' => ['name' => 'Culture & Heritage', 'color' => '#B45309', 'icon' => 'heroicon-o-globe-alt'],
        'general' => ['name' => 'General', 'color' => '#6B7280', 'icon' => 'heroicon-o-newspaper'],
    ];

    public function __construct()
    {
        $this->newsDataService = new NewsDataService();
        $this->guardianService = new GuardianService();
    }

    public function fetchFromSource(NewsSource $source): int
    {
        if (! $source->shouldFetch()) {
            Log::info("Skipping {$source->name}: not due for fetch yet.");
            return 0;
        }

        $articles = match ($source->driver) {
            'newsdata' => $this->newsDataService->fetchMultiple($source->categories, [
                'country' => $source->country,
                'language' => $source->language,
            ]),
            'guardian' => $this->guardianService->fetchMultiple($source->categories, [
                'page_size' => 15,
                'tag' => $source->settings['tag'] ?? null,
                'q' => $source->settings['query'] ?? null,
            ]),
            default => collect(),
        };

        $newCount = $this->persist($articles, $source);

        $source->update(['last_fetched_at' => now()]);

        Log::info("Fetched {$newCount} new articles from {$source->name}.");

        return $newCount;
    }

    public function fetchAll(): array
    {
        $results = [];

        $sources = NewsSource::active()->get();

        foreach ($sources as $source) {
            $results[$source->name] = $this->fetchFromSource($source);
        }

        return $results;
    }

    public function persist(Collection $articles, NewsSource $source): int
    {
        $count = 0;

        foreach ($articles as $articleData) {
            if ($this->isDuplicate($articleData, $source)) {
                continue;
            }

            try {
                AggregatedArticle::create([
                    'news_source_id' => $source->id,
                    'external_id' => $articleData['external_id'],
                    'title' => $articleData['title'],
                    'slug' => $this->uniqueSlug($articleData['title']),
                    'excerpt' => $articleData['excerpt'] ?? Str::limit(strip_tags($articleData['title']), 200),
                    'body' => $articleData['body'],
                    'source_url' => $articleData['source_url'],
                    'source_name' => $articleData['source_name'],
                    'source_image' => $articleData['source_image'],
                    'category' => $this->mapCategory($articleData['category']),
                    'tags' => $articleData['tags'],
                    'author_name' => $articleData['author_name'],
                    'language' => $articleData['language'] ?? 'en',
                    'published_at' => $articleData['published_at'] ?? now(),
                    'fetched_at' => now(),
                    'status' => $source->is_auto_publish ? 'published' : 'pending',
                    'is_auto_publish' => $source->is_auto_publish,
                    'published_at_local' => $source->is_auto_publish ? now() : null,
                ]);

                $count++;
            } catch (\Exception $e) {
                Log::warning("Failed to persist article: {$articleData['title']} — {$e->getMessage()}");
            }
        }

        return $count;
    }

    protected function isDuplicate(array $articleData, NewsSource $source): bool
    {
        if (! empty($articleData['external_id'])) {
            $exists = AggregatedArticle::where('news_source_id', $source->id)
                ->where('external_id', $articleData['external_id'])
                ->exists();

            if ($exists) {
                return true;
            }
        }

        return AggregatedArticle::where('source_url', $articleData['source_url'])->exists();
    }

    protected function uniqueSlug(string $title): string
    {
        $slug = Str::slug($title);
        $original = $slug;
        $counter = 1;

        while (AggregatedArticle::where('slug', $slug)->exists()) {
            $slug = "{$original}-{$counter}";
            $counter++;
        }

        return $slug;
    }

    public function mapCategory(string $apiCategory): string
    {
        $normalized = strtolower(trim($apiCategory));

        foreach ($this->categoryMap as $key => $value) {
            if ($key === $normalized || $value['name'] === $normalized) {
                return $value['name'];
            }
        }

        if (str_contains($normalized, 'tech')) {
            return 'Technology';
        }
        if (str_contains($normalized, 'sport')) {
            return 'Sports';
        }
        if (str_contains($normalized, 'business') || str_contains($normalized, 'econom')) {
            return 'Business';
        }
        if (str_contains($normalized, 'entertain') || str_contains($normalized, 'celebr')) {
            return 'Entertainment';
        }
        if (str_contains($normalized, 'health') || str_contains($normalized, 'well')) {
            return 'Health & Wellness';
        }
        if (str_contains($normalized, 'life')) {
            return 'Lifestyle';
        }
        if (str_contains($normalized, 'politi') || str_contains($normalized, 'govern')) {
            return 'Politics & Governance';
        }
        if (str_contains($normalized, 'culture') || str_contains($normalized, 'herit')) {
            return 'Culture & Heritage';
        }

        return 'General';
    }

    public function syncCategories(): void
    {
        foreach ($this->categoryMap as $key => $config) {
            Category::updateOrCreate(
                ['slug' => Str::slug($config['name'])],
                [
                    'name' => $config['name'],
                    'color' => $config['color'],
                    'icon' => $config['icon'],
                    'sort_order' => array_search($key, array_keys($this->categoryMap)) * 10,
                    'is_active' => true,
                ]
            );
        }
    }
}
