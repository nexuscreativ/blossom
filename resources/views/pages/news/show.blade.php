@extends('layouts.app')
@section('title', $article->title)
@section('metaDescription', $article->seo_description ?? $article->excerpt ?? 'Read this news on BLOSSOM — Global Stories, Nigerian Soul.')

@section('content')

{{-- Article Hero --}}
<section class="relative h-[50vh] min-h-[350px] flex items-end overflow-hidden">
    @if($article->source_image)
        <img src="{{ $article->source_image }}" alt="{{ $article->title }}" class="absolute inset-0 w-full h-full object-cover parallax-slow">
    @else
        <div class="absolute inset-0 bg-gradient-to-br from-onion to-ink"></div>
    @endif
    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/50 to-black/30"></div>

    <div class="relative z-10 container-blossom pb-12">
        <div class="max-w-3xl">
            <div class="flex items-center gap-3 mb-4">
                <span class="category-pill category-pill--purple">{{ $article->category }}</span>
                <span class="px-2.5 py-1 rounded-full bg-white/10 text-white/70 font-ui text-[10px] font-medium backdrop-blur-sm border border-white/10">
                    Via {{ $article->source_name }}
                </span>
            </div>
            <h1 class="font-display text-3xl md:text-4xl lg:text-5xl font-bold text-white leading-tight mb-4">
                {{ $article->title }}
            </h1>
            <div class="flex flex-wrap items-center gap-4 text-white/60 font-ui text-sm">
                @if($article->author_name)
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-full bg-onion/40 border border-white/20 flex items-center justify-center text-white text-xs font-semibold">
                            {{ substr($article->author_name, 0, 1) }}
                        </div>
                        <span>{{ $article->author_name }}</span>
                    </div>
                    <span class="text-white/30">&middot;</span>
                @endif
                <span>{{ $article->published_at?->format('M j, Y') ?? '' }}</span>
                <span class="text-white/30">&middot;</span>
                <span>{{ number_format($article->views_count) }} views</span>
            </div>
        </div>
    </div>
</section>

{{-- Article Content --}}
<article class="py-12 lg:py-16">
    <div class="max-w-[800px] mx-auto px-6 lg:px-12">
        <div class="font-body text-lg text-primary leading-[1.8] space-y-6 mb-12">
            {!! $article->body ?? '<p>' . e($article->excerpt) . '</p>' !!}
        </div>

        {{-- Source Attribution --}}
        <div class="bg-pearl rounded-2xl p-6 border border-silver mb-8">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-onion/5 flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-onion" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244"/>
                    </svg>
                </div>
                <div>
                    <p class="font-ui text-sm font-semibold text-ink">Originally published by {{ $article->source_name }}</p>
                    <p class="font-body text-xs text-muted mt-0.5">This article was curated and published on BLOSSOM from an external source.</p>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ $article->source_url }}" target="_blank" rel="noopener noreferrer"
                   class="btn-primary text-sm inline-flex items-center gap-2">
                    Read Original Article
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/>
                    </svg>
                </a>
            </div>
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

{{-- Related News --}}
@if($related->count())
    <section class="py-16 bg-pearl">
        <div class="container-blossom">
            <div class="section-header reveal">
                <h2 class="section-title"><span class="section-title-accent">Related News</span></h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 stagger-children">
                @foreach($related as $item)
                    <a href="{{ route('news.show', $item->slug) }}" class="article-card group">
                        <div class="article-card-image">
                            @if($item->source_image)
                                <img src="{{ $item->source_image }}" alt="{{ $item->title }}" loading="lazy">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-onion/20 to-orange/10"></div>
                            @endif
                            <div class="absolute top-4 left-4 z-10">
                                <span class="category-pill category-pill--green">{{ $item->category }}</span>
                            </div>
                        </div>
                        <div class="p-5">
                            <h3 class="font-display text-base font-bold text-onion leading-snug group-hover:text-orange transition-colors line-clamp-2">{{ $item->title }}</h3>
                            <span class="font-ui text-xs text-muted mt-2 block">{{ $item->source_name }} &middot; {{ $item->published_at?->diffForHumans() }}</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
@endif

@endsection
