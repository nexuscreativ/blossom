@extends('layouts.app')
@section('title', $event['title'])
@section('metaDescription', $event['desc'])

@section('content')

{{-- Event Hero --}}
<section class="pt-32 pb-12 bg-pearl">
    <div class="container-blossom">
        <nav class="font-ui text-xs text-muted mb-6">
            <a href="{{ route('home') }}" class="hover:text-onion transition-colors">Home</a>
            <span class="mx-2">/</span>
            <a href="{{ route('events.index') }}" class="hover:text-onion transition-colors">Events</a>
            <span class="mx-2">/</span>
            <span class="text-graphite">{{ $event['title'] }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2">
                <div class="flex items-center gap-3 mb-4">
                    <span class="category-pill category-pill--green">{{ $event['type'] }}</span>
                    <span class="font-ui text-sm text-muted">{{ $event['duration'] }}</span>
                </div>
                <h1 class="font-display text-3xl md:text-5xl font-bold text-onion leading-tight mb-6">{{ $event['title'] }}</h1>
                <div class="flex flex-wrap items-center gap-5 font-ui text-sm text-secondary">
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-sean" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                        {{ $event['month'] }} {{ $event['day'] }}, 2026
                    </span>
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-sean" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                        {{ $event['location'] }}
                    </span>
                </div>
            </div>

            <div class="flex items-end">
                <a href="{{ route('contact') }}" class="btn-primary w-full text-center">Reserve a Spot</a>
            </div>
        </div>
    </div>
</section>

{{-- Event Body --}}
<section class="py-12 lg:py-16">
    <div class="container-blossom">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <div class="lg:col-span-8">
                <div class="rounded-2xl overflow-hidden mb-10">
                    <img src="{{ $event['img'] }}" alt="{{ $event['title'] }}" class="w-full h-[380px] object-cover">
                </div>

                <div class="font-body text-lg text-primary leading-[1.8] space-y-6">
                    <p class="text-xl text-secondary leading-relaxed">{{ $event['desc'] }}</p>
                    <p>
                        BLOSSOM Magazine brings you the most anticipated gatherings on the Plateau. This {{ strtolower($event['type']) }}
                        is a highlight of the 2026 calendar, drawing residents and visitors from across Nigeria to celebrate
                        the culture, talent, and energy of Plateau State.
                    </p>
                    <p>
                        Full details — including the programme of activities, ticketing, and accommodation options — will be
                        announced as the event approaches. Follow BLOSSOM across our channels and subscribe to the weekly
                        newsletter so you never miss an update.
                    </p>
                </div>

                <div class="mt-10 p-6 rounded-2xl bg-pearl border border-silver">
                    <h3 class="font-display text-lg font-bold text-ink mb-3">Event Details</h3>
                    <ul class="space-y-2 font-ui text-sm text-secondary">
                        <li><span class="font-semibold text-ink">Date:</span> {{ $event['month'] }} {{ $event['day'] }}, 2026</li>
                        <li><span class="font-semibold text-ink">Location:</span> {{ $event['location'] }}</li>
                        <li><span class="font-semibold text-ink">Type:</span> {{ $event['type'] }}</li>
                        <li><span class="font-semibold text-ink">Duration:</span> {{ $event['duration'] }}</li>
                    </ul>
                </div>
            </div>

            <aside class="lg:col-span-4 space-y-6">
                <div class="bg-white rounded-2xl p-6 border border-silver shadow-sm">
                    <h3 class="font-display text-lg font-bold text-ink mb-4">Other Events</h3>
                    <div class="space-y-4">
                        @foreach(collect($events)->filter(fn ($e) => $e['slug'] !== $event['slug'])->take(4) as $other)
                            <a href="{{ route('events.show', $other['slug']) }}" class="flex items-start gap-3 group">
                                <div class="event-date-badge shrink-0" style="width:44px;height:52px">
                                    <span class="month text-[9px]">{{ $other['month'] }}</span>
                                    <span class="day text-base">{{ $other['day'] }}</span>
                                </div>
                                <div class="min-w-0">
                                    <span class="font-ui text-[10px] font-semibold tracking-wider uppercase text-sean">{{ $other['type'] }}</span>
                                    <h4 class="font-display text-sm font-bold text-ink leading-snug mt-1 group-hover:text-sean transition-colors line-clamp-2">{{ $other['title'] }}</h4>
                                    <span class="font-ui text-xs text-muted">{{ $other['location'] }}</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="rounded-2xl bg-gradient-to-br from-onion to-onion-deep p-6 text-white">
                    <h3 class="font-display text-lg font-bold mb-2">Get Event Alerts</h3>
                    <p class="font-body text-sm text-white/60 mb-4">Subscribe to the BLOSSOM newsletter for event announcements and exclusive previews.</p>
                    <a href="{{ route('newsletter') }}" class="btn-primary bg-orange hover:bg-orange-deep w-full text-center text-sm block py-3">Subscribe</a>
                </div>
            </aside>
        </div>
    </div>
</section>

@endsection