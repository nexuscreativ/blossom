<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Models\Category;
use App\Models\Event;
use App\Models\Listing;
use App\Models\NewsletterSubscriber;
use App\Models\User;
use Illuminate\Console\Command;

class DbStatsCommand extends Command
{
    protected $signature = 'blossom:stats';
    protected $description = 'Show database record counts';

    public function handle(): int
    {
        $this->line("Users:                " . User::count());
        $this->line("Categories:           " . Category::count());
        $this->line("Articles:             " . Article::count());
        $this->line("Events:               " . Event::count());
        $this->line("Listings:             " . Listing::count());
        $this->line("Newsletter:           " . NewsletterSubscriber::count());
        return Command::SUCCESS;
    }
}
