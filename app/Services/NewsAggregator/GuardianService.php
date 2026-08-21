<?php

namespace App\Services\NewsAggregator;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GuardianService
{
    protected string $apiKey;
    protected string $baseUrl = 'https://content.guardianapis.com';

    public function __construct(?string $apiKey = null)
    {
        $this->apiKey = $apiKey ?? config('news.api_keys.guardian', 'test');
    }

    public function fetch(string $section, array $config = []): Collection
    {
        $pageSize = $config['page_size'] ?? 10;

        try {
            $response = Http::timeout(30)->get("{$this->baseUrl}/search", [
                'api-key' => $this->apiKey,
                'section' => $section,
                'show-fields' => 'all',
                'page-size' => $pageSize,
                'order-by' => 'newest',
            ]);

            if (! $response->successful()) {
                Log::warning("Guardian API error: {$response->status()} for section {$section}");
                return collect();
            }

            $data = $response->json();

            return $this->parseResponse($data);
        } catch (\Exception $e) {
            Log::error("Guardian fetch failed for section {$section}: {$e->getMessage()}");
            return collect();
        }
    }

    public function fetchMultiple(array $sections, array $config = []): Collection
    {
        $articles = collect();

        foreach ($sections as $section) {
            $articles = $articles->merge($this->fetch($section, $config));
            usleep(250000);
        }

        return $articles;
    }

    protected function parseResponse(array $data): Collection
    {
        $results = $data['response']['results'] ?? [];

        return collect($results)->map(function ($article) {
            $fields = $article['fields'] ?? [];

            return [
                'external_id' => $article['id'] ?? null,
                'title' => $article['webTitle'] ?? '',
                'excerpt' => $fields['trailText'] ?? $fields['standfirst'] ?? null,
                'body' => $this->cleanBody($fields['body'] ?? null),
                'source_url' => $article['webUrl'] ?? '',
                'source_name' => 'The Guardian',
                'source_image' => $fields['thumbnail'] ?? null,
                'category' => $this->mapSection($article['sectionName'] ?? ''),
                'tags' => $this->extractTags($article),
                'author_name' => $fields['byline'] ?? null,
                'language' => 'en',
                'published_at' => $this->parseDate($article['webPublicationDate'] ?? null),
            ];
        })->filter(function ($article) {
            return ! empty($article['title']) && ! empty($article['source_url']);
        });
    }

    protected function mapSection(string $section): string
    {
        return match (strtolower($section)) {
            'business' => 'business',
            'technology', 'science', 'environment' => 'technology',
            'culture', 'film', 'music', 'books', 'artanddesign', 'stage', 'tv-and-radio' => 'culture',
            'lifeandstyle' => 'lifestyle',
            'football', 'sport', 'cricket', 'tennis', 'rugby-union', 'formula-one', 'cycling', 'boxing', 'golf', 'athletics', 'swimming' => 'sports',
            'world', 'uk-news', 'us-news', 'australia-news', 'africa', 'asia-pacific', 'europe-news', 'latin-america', 'middle-east' => 'politics',
            'society', 'education', 'media', 'law', 'politics' => 'politics',
            default => 'general',
        };
    }

    protected function extractTags(array $article): ?array
    {
        $tags = [];

        foreach ($article['tags'] ?? [] as $tag) {
            if (! empty($tag['webTitle'])) {
                $tags[] = $tag['webTitle'];
            }
        }

        return ! empty($tags) ? $tags : null;
    }

    protected function cleanBody(?string $html): ?string
    {
        if (! $html) {
            return null;
        }

        $text = strip_tags($html);
        $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
        $text = preg_replace('/\s+/', ' ', $text);

        return trim($text);
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
