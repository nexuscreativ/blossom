@extends('layouts.app')
@section('title', $article['title'] ?? 'Article')
@section('metaDescription', $article['excerpt'] ?? 'Read this article on BLOSSOM — Plateau\'s Prestige Magazine.')

@section('content')

{{-- Article Hero --}}
<section class="relative h-[60vh] min-h-[400px] flex items-end overflow-hidden">
    <img src="{{ $article['img'] ?? 'https://images.unsplash.com/photo-1590845947376-2638caa89305?w=1920&q=80' }}"
         alt="{{ $article['title'] }}" class="absolute inset-0 w-full h-full object-cover parallax-slow">
    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/50 to-black/30"></div>

    <div class="relative z-10 container-blossom pb-12">
        <div class="max-w-3xl">
            <div class="flex items-center gap-3 mb-4">
                <span class="category-pill category-pill--{{ $article['catColor'] ?? 'purple' }}">{{ $article['cat'] }}</span>
                @if($article['premium'])
                    <span class="badge-premium">Premium</span>
                @endif
            </div>
            <h1 class="font-display text-3xl md:text-4xl lg:text-5xl font-bold text-white leading-tight mb-4">
                {{ $article['title'] }}
            </h1>
            <div class="flex flex-wrap items-center gap-4 text-white/60 font-ui text-sm">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-onion/40 border border-white/20 flex items-center justify-center text-white text-xs font-semibold">{{ $article['authorInitial'] ?? substr($article['author'], 0, 1) }}</div>
                    <span>{{ $article['author'] }}</span>
                </div>
                <span class="text-white/30">·</span>
                <span>{{ $article['date'] }}</span>
                <span class="text-white/30">·</span>
                <span>{{ $article['time'] }} read</span>
            </div>
        </div>
    </div>
</section>

{{-- Article Content --}}
<article class="py-12 lg:py-16">
    <div class="max-w-[800px] mx-auto px-6 lg:px-12">
        <div class="font-body text-lg text-primary leading-[1.8] space-y-6 mb-12">
            {!! $article['body'] ?? '' !!}
        </div>

        {{-- Tags --}}
        <div class="flex flex-wrap gap-2 mb-8">
            @foreach(['Technology', 'Startups', 'Plateau', 'Innovation', 'Entrepreneurship'] as $tag)
                <span class="px-3 py-1.5 rounded-full bg-pearl text-graphite font-ui text-xs font-medium hover:bg-onion hover:text-white transition-colors cursor-pointer">
                    {{ $tag }}
                </span>
            @endforeach
        </div>

        {{-- Share --}}
        <div class="flex items-center gap-4 py-6 border-t border-b border-silver">
            <span class="font-ui text-sm font-semibold text-ink">Share this story</span>
            <div class="flex items-center gap-2">
                @foreach(['Twitter', 'Facebook', 'LinkedIn', 'WhatsApp'] as $platform)
                    <button class="w-9 h-9 rounded-full bg-pearl flex items-center justify-center text-graphite hover:bg-onion hover:text-white transition-all duration-300">
                        <span class="sr-only">{{ $platform }}</span>
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="4"/></svg>
                    </button>
                @endforeach
            </div>
        </div>
    </div>
</article>

{{-- Related Stories --}}
<section class="py-16 bg-pearl">
    <div class="container-blossom">
        <div class="section-header reveal">
            <h2 class="section-title"><span class="section-title-accent">Related Stories</span></h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 stagger-children">
            @foreach([
                ['slug' => 'the-rise-of-agritech-in-plateau-state', 'img' => 'https://images.unsplash.com/photo-1574943320219-553eb213f72d?w=800&q=80', 'cat' => 'Business', 'title' => 'The Rise of Agritech in Plateau State', 'time' => '7 min'],
                ['slug' => 'how-plateaus-youth-are-redefining-nigerian-music', 'img' => 'https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?w=800&q=80', 'cat' => 'Culture', 'title' => 'How Plateau\'s Youth Are Redefining Nigerian Music', 'time' => '5 min'],
                ['slug' => 'jos-museum-a-journey-through-time', 'img' => 'https://images.unsplash.com/photo-1554907984-15263bfd63bd?w=800&q=80', 'cat' => 'Tourism', 'title' => 'Jos Museum: A Journey Through Time', 'time' => '4 min'],
            ] as $related)
                <a href="{{ route('articles.show', $related['slug']) }}" class="article-card group">
                    <div class="article-card-image">
                        <img src="{{ $related['img'] }}" alt="" loading="lazy">
                        <div class="absolute top-4 left-4 z-10">
                            <span class="category-pill category-pill--green">{{ $related['cat'] }}</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="font-display text-lg font-bold text-onion group-hover:text-orange transition-colors">{{ $related['title'] }}</h3>
                        <span class="font-ui text-xs text-muted mt-2 block">{{ $related['time'] }} read</span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

@endsection
