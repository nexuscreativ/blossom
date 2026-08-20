<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Event;
use App\Models\Listing;

class PageController extends Controller
{
    public function home()
    {
        return view('pages.home');
    }

    public function articlesIndex()
    {
        $articles = Article::published()
            ->with(['author', 'category'])
            ->orderByDesc('published_at')
            ->get()
            ->map(fn (Article $article) => $this->articleArray($article))
            ->all();

        return view('pages.articles.index', [
            'articles' => $articles,
            'categories' => ['all' => 'All', 'culture' => 'Culture', 'business' => 'Business', 'politics' => 'Politics', 'tourism' => 'Tourism', 'education' => 'Education', 'heritage' => 'Heritage'],
        ]);
    }

    public function articleShow(string $slug)
    {
        $article = Article::published()
            ->with(['author', 'category'])
            ->where('slug', $slug)
            ->first();

        abort_unless($article, 404);

        // Premium content gate (C4): redirect to pricing unless subscribed.
        if ($article->is_premium && ! (auth()->user()?->hasActiveSubscription())) {
            return redirect()->route('pricing')->with('error', 'This article is for BLOSSOM Premium subscribers.');
        }

        return view('pages.articles.show', [
            'article' => $this->articleArray($article),
        ]);
    }

    public function eventsIndex()
    {
        $events = Event::upcoming()
            ->get()
            ->map(fn (Event $event) => $this->eventArray($event))
            ->all();

        return view('pages.events.index', compact('events'));
    }

    public function eventShow(string $slug)
    {
        $event = Event::where('slug', $slug)->first();

        abort_unless($event, 404);

        $events = Event::upcoming()
            ->get()
            ->map(fn (Event $event) => $this->eventArray($event))
            ->all();

        return view('pages.events.show', [
            'event' => $this->eventArray($event),
            'events' => $events,
        ]);
    }

    public function listingsIndex()
    {
        $listings = Listing::active()
            ->get()
            ->map(fn (Listing $listing) => $this->listingArray($listing))
            ->sortByDesc(fn (array $l) => $l['featured'])
            ->values()
            ->all();

        return view('pages.listings.index', compact('listings'));
    }

    public function listingShow(string $slug)
    {
        $listing = Listing::active()->where('slug', $slug)->first();

        abort_unless($listing, 404);

        $listings = Listing::active()
            ->get()
            ->map(fn (Listing $listing) => $this->listingArray($listing))
            ->sortByDesc(fn (array $l) => $l['featured'])
            ->values()
            ->all();

        return view('pages.listings.show', [
            'listing' => $this->listingArray($listing),
            'listings' => $listings,
        ]);
    }

    public function terms()
    {
        return view('pages.legal.terms');
    }

    public function privacy()
    {
        return view('pages.legal.privacy');
    }

    public function about()
    {
        return view('pages.about.index');
    }

    public function cookies()
    {
        return view('pages.legal.cookies');
    }

    public function advertise()
    {
        return view('pages.advertise.index');
    }

    public function careers()
    {
        return view('pages.careers.index');
    }

    public function pressKit()
    {
        return view('pages.press-kit.index');
    }

    public function accessibility()
    {
        return view('pages.accessibility.index');
    }

    public function community()
    {
        return view('pages.community.index');
    }

    public function pricing()
    {
        return view('pages.subscription.index');
    }

    public function newsletter()
    {
        return view('pages.newsletter.index');
    }

    public function contact()
    {
        return view('pages.contact.index');
    }

    public function dashboard()
    {
        return view('pages.dashboard.index');
    }

    private function articleArray(Article $article): array
    {
        return [
            'slug' => $article->slug,
            'img' => $article->featured_image,
            'cat' => $article->category?->name ?? 'General',
            'catColor' => $article->pill_color ?? 'purple',
            'title' => $article->title,
            'excerpt' => $article->excerpt,
            'body' => $article->body,
            'author' => $article->author?->full_name ?? 'BLOSSOM Editorial',
            'authorInitial' => strtoupper(substr($article->author?->first_name ?? 'B', 0, 1)),
            'time' => ($article->reading_time ?? 5) . ' min',
            'date' => $article->published_at?->format('M d, Y'),
            'premium' => (bool) $article->is_premium,
            'featured' => (bool) $article->is_featured,
        ];
    }

    private function eventArray(Event $event): array
    {
        return [
            'slug' => $event->slug,
            'month' => strtoupper($event->starts_at->format('M')),
            'day' => $event->starts_at->format('d'),
            'title' => $event->title,
            'location' => $event->venue,
            'type' => $event->type ?? 'Event',
            'desc' => $event->description,
            'img' => $event->featured_image,
            'featured' => (bool) $event->is_featured,
            'duration' => $event->duration ?? '1-Day Event',
        ];
    }

    private function listingArray(Listing $listing): array
    {
        return [
            'slug' => $listing->slug,
            'name' => $listing->name,
            'type' => ucfirst($listing->type),
            'img' => $listing->featured_image,
            'featured' => in_array($listing->tier, ['featured', 'premium'], true),
            'desc' => $listing->description,
        ];
    }
}