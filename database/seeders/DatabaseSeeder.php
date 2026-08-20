<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Article;
use App\Models\Event;
use App\Models\Listing;
use App\Models\NewsletterSubscriber;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Users
        $admin = User::updateOrCreate(
            ['email' => 'admin@blossom.ng'],
            [
                'first_name' => 'Dung',
                'last_name' => 'Gyang',
                'role' => 'admin',
                'password' => Hash::make('blossom2024'),
                'email_verified_at' => now(),
                'bio' => 'Editor-in-Chief of BLOSSOM Magazine. Passionate about telling the stories of the Plateau.',
                'location' => 'Jos, Plateau State',
            ]
        );

        $users = [];
        $userData = [
            ['Amina', 'Bello', 'amina@blossom.ng', 'author', 'Culture and lifestyle writer covering Jos nightlife and food scene.', 'Jos'],
            ['Ibrahim', 'Musa', 'ibrahim@blossom.ng', 'author', 'Tourism and heritage correspondent. Hiking enthusiast.', 'Barkin Ladi'],
            ['Grace', 'Pam', 'grace@blossom.ng', 'editor', 'Senior editor. Former lecturer at University of Jos.', 'Jos'],
            ['Fatima', 'Abubakar', 'fatima@blossom.ng', 'user', 'Plateau food blogger and restaurant critic.', 'Jos'],
            ['Emmanuel', 'Dung', 'emmanuel@blossom.ng', 'author', 'Business and tech reporter covering startups across Northern Nigeria.', 'Jos'],
            ['Sarah', 'Daniel', 'sarah@blossom.ng', 'author', 'Photographer and visual storyteller. Capturing Plateau one frame at a time.', 'Shendam'],
            ['Musa', 'Aliyu', 'musa.a@blossom.ng', 'author', 'Education correspondent. Advocate for girl-child education in the North.', 'Pankshin'],
        ];

        foreach ($userData as [$first, $last, $email, $role, $bio, $loc]) {
            $users[] = User::updateOrCreate(
                ['email' => $email],
                [
                    'first_name' => $first,
                    'last_name' => $last,
                    'role' => $role,
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                    'bio' => $bio,
                    'location' => $loc,
                ]
            );
        }

        // Categories
        $categories = [];
        $catData = [
            ['Culture', 'culture', '#5B2C6F', 'Traditions, festivals, and the vibrant cultural life of the Plateau'],
            ['Business', 'business', '#2E7D32', 'Entrepreneurship, startups, and economic development on the Plateau'],
            ['Tourism', 'tourism', '#1565C0', 'Discovering the natural beauty and tourist destinations of Plateau State'],
            ['Heritage', 'heritage', '#BF360C', 'Preserving the history and heritage of Plateau communities'],
            ['Food & Drink', 'food-drink', '#E65100', 'The rich culinary traditions and emerging food scene of Jos'],
            ['Lifestyle', 'lifestyle', '#6A1B9A', 'Fashion, wellness, entertainment, and modern living on the Plateau'],
            ['Education', 'education', '#00695C', 'Schools, universities, and the future of learning in Plateau State'],
            ['Technology', 'technology', '#283593', 'Innovation, tech hubs, and digital transformation across the Plateau'],
        ];

        foreach ($catData as [$name, $slug, $color, $desc]) {
            $categories[$slug] = Category::updateOrCreate(
                ['slug' => $slug],
                [
                    'name' => $name,
                    'color' => $color,
                    'description' => $desc,
                    'is_active' => true,
                    'sort_order' => array_search([$name, $slug, $color, $desc], $catData),
                ]
            );
        }

        // Tags
        $tags = [];
        foreach (['Technology', 'Startups', 'Music', 'Food', 'Festivals', 'Education', 'Innovation', 'Heritage', 'Nature', 'Youth', 'Fashion', 'Sports', 'Politics', 'Health', 'Photography', 'Architecture'] as $tagName) {
            $tags[] = Tag::firstOrCreate(['name' => $tagName]);
        }

        // Demo Content (Articles, Events, Listings)
        // Demo content lives in the DB (not a static class), seeded here.
        $this->call(DemoContentSeeder::class);

        // Newsletter Subscribers
        if (NewsletterSubscriber::count() === 0) {
        $subscribers = [
            ['info@josbusinesshub.ng', 'Jos Business Hub'],
            ['amina@example.com', 'Amina Reader'],
            ['ibrahim@example.com', 'Ibrahim Fan'],
            ['grace@example.com', 'Grace Plateau'],
            ['fatima@example.com', 'Fatima Foodie'],
            ['emmanuel@example.com', 'Emmanuel Tech'],
            ['sarah@example.com', 'Sarah Lens'],
            ['musa@example.com', 'Musa Heritage'],
            ['chidinma@example.com', 'Chidinma Lagos'],
            ['abdullahi@example.com', 'Abdullahi Kano'],
        ];

        foreach ($subscribers as [$email, $name]) {
            NewsletterSubscriber::create([
                'email' => $email,
                'name' => $name,
                'status' => 'active',
                'subscribed_at' => now()->subDays(rand(1, 60)),
                'source' => 'website',
            ]);
        }
        }

        // Settings & Services
        $this->call([
            SettingsSeeder::class,
            ServicesSeeder::class,
        ]);
    }
}
