<?php

namespace Database\Seeders;

use App\Models\NewsSource;
use Illuminate\Database\Seeder;

class NewsSourceSeeder extends Seeder
{
    public function run(): void
    {
        NewsSource::updateOrCreate(
            ['name' => 'NewsData.io'],
            [
                'driver' => 'newsdata',
                'api_key' => '',
                'api_url' => 'https://newsdata.io/api/1/latest',
                'categories' => ['business','technology','entertainment','health','sports','lifestyle','politics','culture'],
                'country' => 'ng',
                'language' => 'en',
                'is_active' => false,
                'is_auto_publish' => true,
                'fetch_interval' => 3600,
            ]
        );

        NewsSource::updateOrCreate(
            ['name' => 'The Guardian'],
            [
                'driver' => 'guardian',
                'api_key' => 'test',
                'api_url' => 'https://content.guardianapis.com',
                'categories' => ['business','technology','film','sport','lifeandstyle','politics','artanddesign','education'],
                'country' => 'gb',
                'language' => 'en',
                'is_active' => true,
                'is_auto_publish' => true,
                'fetch_interval' => 3600,
            ]
        );

        $this->command->info('News sources seeded: NewsData.io (inactive, needs API key), The Guardian (active).');
    }
}
