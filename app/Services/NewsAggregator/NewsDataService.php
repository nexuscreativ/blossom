<?php

namespace App\Services\NewsAggregator;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NewsDataService
{
    protected string $apiKey;
    protected string $baseUrl = 'https://newsdata.io/api/1';

    public function __construct(?string $apiKey = null)
    {
        $this->apiKey = $apiKey ?? config('services.newsdata.api_key', config('news.api_keys.newsdata', ''));
    }

    public function fetch(string $category, array $config = []): Collection
    {
        $country = $config['country'] ?? config('news.default_country', 'ng');
        $language = $config['language'] ?? 'en';

        try {
            $response = Http::timeout(30)
                ->get("{$this->baseUrl}/news", [
                    'apikey' => $this->apiKey,
                    'country' => $country,
                    'category' => $category,
                    'language' => $language,
                ]);

            if (! $response->successful()) {
                Log::warning("NewsData API error: {$response->status()} for category {$category}");
                return collect();
            }

            $data = $response->json();

            return $this->parseResponse($data);
        } catch (\Exception $e) {
            Log::error("NewsData fetch failed for category {$category}: {$e->getMessage()}");
            return collect();
        }
    }

    public function fetchMultiple(array $categories, array $config = []): Collection
    {
        $articles = collect();

        foreach ($categories as $category) {
            $articles = $articles->merge($this->fetch($category, $config));
            usleep(250000);
        }

        return $articles;
    }

    protected function parseResponse(array $data): Collection
    {
        $articles = $data['results'] ?? [];

        return collect($articles)->map(function ($article) {
            return [
                'external_id' => $article['article_id'] ?? null,
                'title' => $article['title'] ?? '',
                'excerpt' => $article['description'] ?? null,
                'body' => $this->cleanBody($article['content'] ?? $article['description'] ?? ''),
                'source_url' => $article['link'] ?? '',
                'source_name' => $article['source_name'] ?? $article['source_id'] ?? 'Unknown',
                'source_image' => $article['image_url'] ?? null,
                'category' => $article['category'][0] ?? 'general',
                'tags' => $article['keywords'] ?? null,
                'author_name' => $article['creator'][0] ?? null,
                'language' => $article['language'] ?? 'en',
                'published_at' => $this->parseDate($article['pubDate'] ?? null),
            ];
        })->filter(function ($article) {
            return ! empty($article['title']) && ! empty($article['source_url']);
        });
    }

    protected function cleanBody(?string $content): ?string
    {
        if (! $content) {
            return null;
        }

        $content = strip_tags($content);
        $content = html_entity_decode($content, ENT_QUOTES, 'UTF-8');

        return trim($content);
    }

    protected function parseDate(?string $date): ?string
    {
        if (! $date) {
            return now()->toDateTimeString();
        }

        try {
            return \Carbon\Carbon::parse($date)->toDateTimeString();
        } catch (\Exception $e) {
            return now()->toDateTimeString();
        }
    }
}
