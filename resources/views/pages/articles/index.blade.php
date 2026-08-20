@extends('layouts.app')
@section('title', 'Articles')
@section('metaDescription', 'Read the latest articles on lifestyle, culture, business, and community from Plateau State.')

@section('content')

{{-- Page Header --}}
<section class="pt-32 pb-12 bg-pearl">
    <div class="container-blossom">
        <div class="max-w-2xl">
            <span class="font-ui text-xs font-semibold tracking-[0.15em] uppercase text-onion block mb-3">Stories</span>
            <h1 class="font-display text-4xl md:text-5xl font-bold text-onion leading-tight mb-4">
                Latest Stories
            </h1>
            <p class="font-body text-secondary text-lg">
                In-depth reporting, compelling features, and inspiring stories from across Plateau State.
            </p>
        </div>
    </div>
</section>

{{-- Category Filter --}}
<section class="sticky top-[72px] z-[150] bg-white/95 backdrop-blur-xl border-b border-silver">
    <div class="container-blossom">
        <div class="flex gap-1 overflow-x-auto py-3 scrollbar-hide" x-data="{ active: 'all' }">
            @php
                $categories = ['all' => 'All', 'culture' => 'Culture', 'business' => 'Business', 'politics' => 'Politics', 'tourism' => 'Tourism', 'education' => 'Education', 'heritage' => 'Heritage'];
            @endphp
            @foreach($categories as $slug => $label)
                <button @click="active = '{{ $slug }}'"
                        class="px-4 py-2 rounded-full font-ui text-sm font-medium whitespace-nowrap transition-all duration-300"
                        :class="active === '{{ $slug }}' ? 'bg-onion text-white' : 'text-graphite hover:text-onion hover:bg-onion/5'">
                    {{ $label }}
                </button>
            @endforeach
        </div>
    </div>
</section>

{{-- Articles Grid --}}
<section class="py-12 lg:py-16">
    <div class="container-blossom">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 stagger-children">
            @foreach($articles as $article)
                <a href="{{ route('articles.show', $article['slug']) }}" class="article-card group">
                    <div class="article-card-image">
                        <img src="{{ $article['img'] }}" alt="{{ $article['title'] }}" loading="lazy">
                        <div class="absolute top-4 left-4 z-10">
                            <span class="category-pill category-pill--purple">{{ $article['cat'] }}</span>
                        </div>
                        @if($article['premium'])
                            <div class="absolute top-4 right-4 z-10">
                                <span class="badge-premium">Premium</span>
                            </div>
                        @endif
                    </div>
                    <div class="p-6">
                        <h3 class="font-display text-lg font-bold text-onion leading-snug mb-2 group-hover:text-orange transition-colors duration-300 line-clamp-2">
                            {{ $article['title'] }}
                        </h3>
                        <p class="font-body text-secondary text-sm leading-relaxed mb-4 line-clamp-2">{{ $article['excerpt'] }}</p>
                        <div class="flex items-center justify-between font-ui text-xs text-muted">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-full bg-onion/10 flex items-center justify-center text-onion text-[10px] font-semibold">{{ substr($article['author'], 0, 1) }}</div>
                                <span>{{ $article['author'] }}</span>
                            </div>
                            <span>{{ $article['time'] }} · {{ $article['date'] }}</span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        {{-- Load More --}}
        <div class="text-center mt-12">
            <button class="btn-secondary">Load More Stories</button>
        </div>
    </div>
</section>

@endsection
