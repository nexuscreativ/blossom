@extends('layouts.app')
@section('title', 'News')
@section('metaDescription', 'Latest news curated from global sources — powered by BLOSSOM, your global magazine with Nigerian soul.')

@section('content')

{{-- Page Header --}}
<section class="relative pt-32 pb-12 bg-ink overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-orange/15 via-transparent to-sean/10 pointer-events-none"></div>
    <div class="container-blossom relative z-10">
        <div class="max-w-2xl">
            <span class="font-ui text-xs font-semibold tracking-[0.15em] uppercase text-orange block mb-3">The Wire</span>
            <h1 class="font-display text-4xl md:text-5xl font-bold text-white leading-tight mb-4">
                Latest <span class="text-gradient-orange">News</span>
            </h1>
            <p class="font-body text-lg text-white/60">
                Curated stories from the world's best sources, delivered fresh to BLOSSOM.
            </p>
        </div>
    </div>
</section>

{{-- Category Filter --}}
<section class="sticky top-[72px] z-[150] bg-white/95 backdrop-blur-xl border-b border-silver">
    <div class="container-blossom">
        <div class="flex gap-1 overflow-x-auto py-3 scrollbar-hide">
            <a href="{{ route('news.index') }}"
               class="px-4 py-2 rounded-full font-ui text-sm font-medium whitespace-nowrap transition-all duration-300 {{ !request('category') ? 'bg-onion text-white' : 'text-graphite hover:text-onion hover:bg-onion/5' }}">
                All
            </a>
            @foreach($categories as $category)
                <a href="{{ route('news.index', ['category' => $category]) }}"
                   class="px-4 py-2 rounded-full font-ui text-sm font-medium whitespace-nowrap transition-all duration-300 {{ request('category') === $category ? 'bg-onion text-white' : 'text-graphite hover:text-onion hover:bg-onion/5' }}">
                    {{ $category }}
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- Articles Grid --}}
<section class="py-12 lg:py-16">
    <div class="container-blossom">
        @if($articles->count())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 stagger-children">
                @foreach($articles as $article)
                    <a href="{{ route('news.show', $article->slug) }}" class="article-card group">
                        <div class="article-card-image">
                            @if($article->source_image)
                                <img src="{{ $article->source_image }}" alt="{{ $article->title }}" loading="lazy">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-onion/20 to-orange/10 flex items-center justify-center">
                                    <span class="font-display text-4xl text-white/20">B</span>
                                </div>
                            @endif
                            <div class="absolute top-4 left-4 z-10">
                                <span class="category-pill category-pill--purple">{{ $article->category }}</span>
                            </div>
                            <div class="absolute top-4 right-4 z-10">
                                <span class="px-2.5 py-1 rounded-full bg-black/60 text-white/80 font-ui text-[10px] font-medium backdrop-blur-sm">
                                    {{ $article->source_name }}
                                </span>
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="font-display text-lg font-bold text-onion leading-snug mb-2 group-hover:text-orange transition-colors duration-300 line-clamp-2">
                                {{ $article->title }}
                            </h3>
                            <p class="font-body text-secondary text-sm leading-relaxed mb-4 line-clamp-2">{{ $article->excerpt }}</p>
                            <div class="flex items-center justify-between font-ui text-xs text-muted">
                                <span>{{ $article->author_name ?? $article->source_name }}</span>
                                <span>{{ $article->published_at?->diffForHumans() ?? '' }}</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-12">
                {{ $articles->links() }}
            </div>
        @else
            <div class="text-center py-20">
                <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-onion/5 flex items-center justify-center">
                    <svg class="w-10 h-10 text-onion/30" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5"/>
                    </svg>
                </div>
                <h3 class="font-display text-xl font-bold text-ink mb-2">No news yet</h3>
                <p class="font-body text-secondary text-sm">News articles will appear here once fetched from our sources.</p>
            </div>
        @endif
    </div>
</section>

@endsection
