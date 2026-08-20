<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\Event;
use App\Models\Listing;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DemoContentSeeder extends Seeder
{
    public function run(): void
    {
        $this->clearExistingContent();

        $this->seedArticles();
        $this->seedEvents();
        $this->seedListings();
    }

    private function clearExistingContent(): void
    {
        DB::table('article_tags')->delete();
        DB::table('article_images')->delete();
        DB::table('listing_images')->delete();
        DB::table('listing_reviews')->delete();

        Article::withTrashed()->forceDelete();
        Event::withTrashed()->forceDelete();
        Listing::withTrashed()->forceDelete();
    }

    private function categoryByName(string $name): ?Category
    {
        return Category::query()
            ->whereRaw('LOWER(name) = ?', [strtolower($name)])
            ->orWhereRaw('LOWER(slug) = ?', [strtolower($name)])
            ->first();
    }

    private function authorByName(string $name): User
    {
        $parts = preg_split('/\s+/', trim($name));
        $first = $parts[0];
        $last = $parts[count($parts) - 1];

        $user = User::query()
            ->whereRaw('LOWER(first_name) = ? AND LOWER(last_name) = ?', [strtolower($first), strtolower($last)])
            ->first();

        if ($user) {
            return $user;
        }

        $email = Str::slug($first . ' ' . $last) . '@blossom.ng';

        return User::create([
            'first_name' => $first,
            'last_name' => $last,
            'email' => $email,
            'role' => 'author',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
    }

    private function seedArticles(): void
    {
        $articles = [
            [
                'slug' => 'how-plateau-entrepreneurs-are-building-africas-next-tech-hub',
                'img' => 'https://images.unsplash.com/photo-1590845947376-2638caa89305?w=800&q=80',
                'cat' => 'Business',
                'catColor' => 'purple',
                'title' => 'How Plateau Entrepreneurs Are Building Africa\'s Next Tech Hub',
                'excerpt' => 'From Jos to Lagos, Plateau founders are attracting millions in venture capital.',
                'author' => 'Emmanuel Dung',
                'time' => '6 min',
                'date' => 'Aug 15, 2026',
                'premium' => true,
            ],
            [
                'slug' => 'the-hidden-waterfalls-of-shere-hills',
                'img' => 'https://images.unsplash.com/photo-1504173010664-32509aeebb62?w=800&q=80',
                'cat' => 'Tourism',
                'catColor' => 'green',
                'title' => 'The Hidden Waterfalls of Shere Hills',
                'excerpt' => 'A visual journey through Plateau\'s best-kept natural secrets.',
                'author' => 'Grace Pam',
                'time' => '4 min',
                'date' => 'Aug 14, 2026',
                'premium' => false,
            ],
            [
                'slug' => 'the-berom-people-guardians-of-plateaus-ancient-traditions',
                'img' => 'https://images.unsplash.com/photo-1518611012118-696072aa579a?w=800&q=80',
                'cat' => 'Culture',
                'catColor' => 'orange',
                'title' => 'The Berom People: Guardians of Plateau\'s Ancient Traditions',
                'excerpt' => 'Centuries-old customs find new life in the hands of young custodians.',
                'author' => 'Ibrahim Musa',
                'time' => '10 min',
                'date' => 'Aug 13, 2026',
                'premium' => true,
            ],
            [
                'slug' => 'the-nzem-berom-festival-where-drums-speak-the-language-of-ancestors',
                'img' => 'https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?w=800&q=80',
                'cat' => 'Heritage',
                'catColor' => 'green',
                'title' => 'The Nzem Berom Festival: Where Drums Speak the Language of Ancestors',
                'excerpt' => 'Every year, the Berom people gather to celebrate centuries of tradition.',
                'author' => 'Amina Bello',
                'time' => '8 min',
                'date' => 'Aug 12, 2026',
                'premium' => true,
            ],
            [
                'slug' => 'how-plateaus-youth-are-redefining-nigerian-music',
                'img' => 'https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?w=800&q=80',
                'cat' => 'Culture',
                'catColor' => 'orange',
                'title' => 'How Plateau\'s Youth Are Redefining Nigerian Music',
                'excerpt' => 'A new generation of artists is putting Jos on the global music map.',
                'author' => 'Danladi Yusuf',
                'time' => '5 min',
                'date' => 'Aug 11, 2026',
                'premium' => false,
            ],
            [
                'slug' => 'the-rise-of-agritech-in-plateau-state',
                'img' => 'https://images.unsplash.com/photo-1574943320219-553eb213f72d?w=800&q=80',
                'cat' => 'Business',
                'catColor' => 'purple',
                'title' => 'The Rise of Agritech in Plateau State',
                'excerpt' => 'Smart farming solutions are transforming agriculture across the plateau.',
                'author' => 'Fatima Abubakar',
                'time' => '7 min',
                'date' => 'Aug 10, 2026',
                'premium' => false,
            ],
            [
                'slug' => 'jos-museum-a-journey-through-time',
                'img' => 'https://images.unsplash.com/photo-1554907984-15263bfd63bd?w=800&q=80',
                'cat' => 'Tourism',
                'catColor' => 'green',
                'title' => 'Jos Museum: A Journey Through Time',
                'excerpt' => 'Plateau\'s most treasured institution keeps 70,000 years of history alive.',
                'author' => 'Grace Pam',
                'time' => '4 min',
                'date' => 'Aug 9, 2026',
                'premium' => false,
            ],
        ];

        foreach ($articles as $data) {
            $category = $this->categoryByName($data['cat']);
            $author = $this->authorByName($data['author']);

            Article::create([
                'author_id' => $author->id,
                'category_id' => $category?->id,
                'title' => $data['title'],
                'slug' => $data['slug'],
                'excerpt' => $data['excerpt'],
                'body' => $this->articleBody($data['title'], $data['excerpt']),
                'featured_image' => $data['img'],
                'pill_color' => $data['catColor'],
                'status' => 'published',
                'is_premium' => $data['premium'],
                'reading_time' => (int) $data['time'],
                'published_at' => Carbon::parse($data['date']),
            ]);
        }
    }

    private function articleBody(string $title, string $excerpt): string
    {
        return '<p>' . e($excerpt) . '</p>'
            . '<p>' . e($title) . ' — a story from the heart of Plateau State, brought to you by the BLOSSOM editorial team.</p>'
            . '<p>From the rolling hills of Jos to the markets and communities across the plateau, these are the voices, places, and ideas shaping one of Nigeria\'s most vibrant regions.</p>';
    }

    private function seedEvents(): void
    {
        $events = [
            [
                'slug' => 'nzem-berom-cultural-festival-2026',
                'month' => 'SEP',
                'day' => '15',
                'title' => 'Nzem Berom Cultural Festival 2026',
                'location' => 'Ryom, Plateau State',
                'type' => 'Festival',
                'desc' => 'The annual celebration of Berom heritage featuring traditional music, dance, and cultural exhibitions.',
                'img' => 'https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?w=1200&q=80',
                'featured' => true,
                'duration' => '3-Day Event',
            ],
            [
                'slug' => 'plateau-tech-summit-2026',
                'month' => 'SEP',
                'day' => '22',
                'title' => 'Plateau Tech Summit 2026',
                'location' => 'Jos Business Hub',
                'type' => 'Conference',
                'desc' => 'Nigeria\'s premier tech conference outside Lagos.',
                'img' => 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=800&q=80',
                'featured' => false,
                'duration' => '1-Day Event',
            ],
            [
                'slug' => 'plateau-state-art-exhibition',
                'month' => 'OCT',
                'day' => '05',
                'title' => 'Plateau State Art Exhibition',
                'location' => 'Jos Museum',
                'type' => 'Exhibition',
                'desc' => 'Showcasing 200+ works from Plateau artists.',
                'img' => 'https://images.unsplash.com/photo-1513364776144-60967b0f800f?w=800&q=80',
                'featured' => false,
                'duration' => '7-Day Event',
            ],
            [
                'slug' => 'plateau-food-festival',
                'month' => 'OCT',
                'day' => '18',
                'title' => 'Plateau Food Festival',
                'location' => 'Rayfield Resort',
                'type' => 'Festival',
                'desc' => 'Celebrating the culinary heritage of Plateau.',
                'img' => 'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?w=800&q=80',
                'featured' => false,
                'duration' => '2-Day Event',
            ],
            [
                'slug' => 'youth-innovation-challenge',
                'month' => 'NOV',
                'day' => '02',
                'title' => 'Youth Innovation Challenge',
                'location' => 'University of Jos',
                'type' => 'Competition',
                'desc' => '₦10M prize pool for young innovators.',
                'img' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=800&q=80',
                'featured' => false,
                'duration' => '1-Day Event',
            ],
            [
                'slug' => 'heritage-music-concert',
                'month' => 'NOV',
                'day' => '15',
                'title' => 'Heritage Music Concert',
                'location' => 'Jos Cultural Centre',
                'type' => 'Concert',
                'desc' => 'Traditional and contemporary Plateau music.',
                'img' => 'https://images.unsplash.com/photo-1470225620780-dba8ba36b745?w=800&q=80',
                'featured' => false,
                'duration' => '1-Day Event',
            ],
            [
                'slug' => 'end-of-year-gala',
                'month' => 'DEC',
                'day' => '01',
                'title' => 'End-of-Year Gala',
                'location' => 'Hill Station Hotel',
                'type' => 'Gala',
                'desc' => 'BLOSSOM Magazine\'s annual celebration.',
                'img' => 'https://images.unsplash.com/photo-1511578314322-379afb476865?w=800&q=80',
                'featured' => false,
                'duration' => '1-Day Event',
            ],
        ];

        foreach ($events as $data) {
            $startsAt = Carbon::createFromFormat('M d Y', $data['month'] . ' ' . $data['day'] . ' 2026');
            $dayCount = max(1, (int) filter_var($data['duration'], FILTER_SANITIZE_NUMBER_INT) ?: 1);

            Event::create([
                'title' => $data['title'],
                'slug' => $data['slug'],
                'description' => $data['desc'],
                'featured_image' => $data['img'],
                'venue' => $data['location'],
                'address' => $data['location'],
                'starts_at' => $startsAt,
                'ends_at' => $startsAt->copy()->addDays($dayCount - 1)->endOfDay(),
                'status' => 'published',
                'type' => $data['type'],
                'duration' => $data['duration'],
                'is_featured' => $data['featured'],
                'ticket_type' => 'free',
                'ticket_price' => 0,
            ]);
        }
    }

    private function seedListings(): void
    {
        $admin = User::query()->where('email', 'admin@blossom.ng')->first();
        $owner = $admin ?? User::query()->first();

        $listings = [
            [
                'slug' => 'jos-business-hub',
                'name' => 'Jos Business Hub',
                'type' => 'Business',
                'img' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=600&q=80',
                'featured' => true,
                'desc' => 'The premier co-working and innovation space in Jos.',
            ],
            [
                'slug' => 'prof-david-danladi',
                'name' => 'Prof. David Danladi',
                'type' => 'Personality',
                'img' => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?w=600&q=80',
                'featured' => true,
                'desc' => 'Renowned academic and cultural advocate.',
            ],
            [
                'slug' => 'university-of-jos',
                'name' => 'University of Jos',
                'type' => 'Institution',
                'img' => 'https://images.unsplash.com/photo-1562774053-701939374585?w=600&q=80',
                'featured' => false,
                'desc' => 'Plateau State\'s premier university.',
            ],
            [
                'slug' => 'plateau-tourism-board',
                'name' => 'Plateau Tourism Board',
                'type' => 'Institution',
                'img' => 'https://images.unsplash.com/photo-1497366216548-37526070297c?w=600&q=80',
                'featured' => false,
                'desc' => 'Promoting tourism across the state.',
            ],
            [
                'slug' => 'rayfield-resort',
                'name' => 'Rayfield Resort',
                'type' => 'Business',
                'img' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=600&q=80',
                'featured' => true,
                'desc' => 'Plateau\'s premium hospitality destination.',
            ],
            [
                'slug' => 'dr-hauwa-ibrahim',
                'name' => 'Dr. Hauwa Ibrahim',
                'type' => 'Personality',
                'img' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=600&q=80',
                'featured' => false,
                'desc' => 'Leading healthcare innovator in Northern Nigeria.',
            ],
        ];

        foreach ($listings as $data) {
            Listing::create([
                'owner_id' => $owner->id,
                'name' => $data['name'],
                'slug' => $data['slug'],
                'type' => strtolower($data['type']),
                'description' => $data['desc'],
                'featured_image' => $data['img'],
                'tier' => $data['featured'] ? 'featured' : 'standard',
                'status' => 'active',
                'is_verified' => true,
                'city' => 'Jos',
                'state' => 'Plateau',
                'views_count' => 0,
                'rating' => 5,
            ]);
        }
    }
}