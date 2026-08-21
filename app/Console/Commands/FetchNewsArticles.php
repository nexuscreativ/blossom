<?php

namespace App\Console\Commands;

use App\Models\NewsSource;
use App\Services\NewsAggregator\AggregatorService;
use Illuminate\Console\Command;

class FetchNewsArticles extends Command
{
    protected $signature = 'news:fetch {--source= : Only fetch from a specific source name} {--sync-categories : Sync category definitions first}';

    protected $description = 'Fetch latest news articles from all active news sources';

    public function handle(): int
    {
        if (! config('news.enabled', true)) {
            $this->warn('News fetching is disabled in config.');

            return static::SUCCESS;
        }

        $aggregator = new AggregatorService();

        if ($this->option('sync-categories')) {
            $aggregator->syncCategories();
            $this->info('Categories synced.');
        }

        $sourceName = $this->option('source');

        if ($sourceName) {
            $source = NewsSource::where('name', $sourceName)->active()->first();

            if (! $source) {
                $this->error("Source '{$sourceName}' not found or inactive.");

                return static::FAILURE;
            }

            $this->info("Fetching from {$source->name}...");
            $count = $aggregator->fetchFromSource($source);
            $this->info("Fetched {$count} new articles from {$source->name}.");

            return static::SUCCESS;
        }

        $this->info('Fetching from all active sources...');
        $results = $aggregator->fetchAll();

        foreach ($results as $name => $count) {
            $this->line("  <info>{$name}</info>: {$count} new articles");
        }

        $total = array_sum($results);
        $this->info("Done. Total new articles: {$total}");

        return static::SUCCESS;
    }
}
