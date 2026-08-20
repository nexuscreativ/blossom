@extends('layouts.app')
@section('title', 'Events')
@section('metaDescription', 'Discover upcoming events, festivals, and gatherings on the Plateau.')

@section('content')

<section class="pt-32 pb-12 bg-pearl">
    <div class="container-blossom">
        <div class="max-w-2xl">
            <span class="font-ui text-xs font-semibold tracking-[0.15em] uppercase text-sean block mb-3">Calendar</span>
            <h1 class="font-display text-4xl md:text-5xl font-bold text-onion leading-tight mb-4">Events</h1>
            <p class="font-body text-secondary text-lg">Festivals, conferences, exhibitions, and gatherings across Plateau State.</p>
        </div>
    </div>
</section>

<section class="py-12 lg:py-16">
    <div class="container-blossom">
        {{-- Featured Event --}}
        @php
            $featured = collect($events)->firstWhere('featured', true) ?? $events[0];
        @endphp
        <div class="mb-12 reveal">
            <a href="{{ route('events.show', $featured['slug']) }}" class="relative rounded-2xl overflow-hidden group block">
                <img src="{{ $featured['img'] ?? 'https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?w=1200&q=80' }}"
                     alt="" class="w-full h-[400px] object-cover transition-transform duration-700 group-hover:scale-105">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 p-8 md:p-12">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="event-date-badge" style="width:56px;height:64px">
                            <span class="month">{{ $featured['month'] }}</span>
                            <span class="day text-xl">{{ $featured['day'] }}</span>
                        </div>
                        <span class="category-pill category-pill--green">{{ $featured['type'] }}</span>
                    </div>
                    <h2 class="font-display text-2xl md:text-3xl font-bold text-white mb-2">{{ $featured['title'] }}</h2>
                    <p class="font-body text-white/70 max-w-lg">{{ $featured['desc'] }}</p>
                    <div class="flex items-center gap-4 mt-4 text-white/50 font-ui text-sm">
                        <span>{{ $featured['location'] }}</span>
                        <span>·</span>
                        <span>{{ $featured['duration'] }}</span>
                    </div>
                </div>
            </a>
        </div>

        {{-- Events Grid --}}
        <div class="section-header reveal">
            <h2 class="section-title"><span class="section-title-accent">Upcoming</span></h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 stagger-children">
            @foreach($events as $event)
                <a href="{{ route('events.show', $event['slug']) }}" class="event-card group">
                    <div class="event-date-badge">
                        <span class="month">{{ $event['month'] }}</span>
                        <span class="day">{{ $event['day'] }}</span>
                    </div>
                    <div class="flex flex-col justify-center min-w-0">
                        <span class="font-ui text-[10px] font-semibold tracking-wider uppercase text-sean">{{ $event['type'] }}</span>
                        <h3 class="font-display text-base font-bold text-ink leading-snug mt-1 group-hover:text-sean transition-colors">{{ $event['title'] }}</h3>
                        <p class="font-body text-xs text-muted mt-1 line-clamp-2">{{ $event['desc'] }}</p>
                        <div class="flex items-center gap-1.5 mt-2 font-ui text-xs text-muted">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                            </svg>
                            {{ $event['location'] }}
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

@endsection
