@extends('layouts.app')
@section('title', 'Advertise with BLOSSOM')
@section('metaDescription', 'Reach Plateau\'s most engaged audience. Discover BLOSSOM\'s advertising opportunities, audience, formats, and rates.')

@section('content')

{{-- Hero --}}
<section class="relative pt-32 pb-20 bg-ink overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-orange/20 via-transparent to-onion/10 pointer-events-none"></div>
    <div class="container-blossom relative z-10 text-center">
        <span class="font-ui text-xs font-semibold tracking-[0.15em] uppercase text-orange block mb-4">Advertise With Us</span>
        <h1 class="font-display text-4xl md:text-5xl lg:text-6xl font-bold text-white leading-tight mb-6">
            Put Your Brand at the <span class="text-gradient-orange">Heart of Plateau</span>
        </h1>
        <p class="font-body text-lg text-white/50 max-w-2xl mx-auto">
            BLOSSOM connects premium brands with Plateau's most engaged, discerning audience — from Jos to the diaspora.
        </p>
    </div>
</section>

{{-- Audience --}}
<section class="py-16 lg:py-24">
    <div class="container-blossom">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <div class="reveal">
                <span class="font-ui text-xs font-semibold tracking-[0.15em] uppercase text-onion block mb-3">Who We Reach</span>
                <h2 class="font-display text-3xl md:text-4xl font-bold text-onion leading-tight mb-6">
                    An Audience That Matters
                </h2>
                <div class="space-y-4 font-body text-secondary leading-relaxed">
                    <p>
                        Our readers are leaders, entrepreneurs, professionals, and culture lovers who are deeply invested
                        in Plateau State — its business, heritage, and future. They are decision-makers with real influence
                        and spending power.
                    </p>
                    <p>
                        By advertising with BLOSSOM, your brand is seen as part of the conversation that defines the Plateau.
                    </p>
                </div>
            </div>
            <div class="reveal" style="animation-delay: 0.2s">
                <div class="grid grid-cols-2 gap-6 stagger-children">
                    @php
                        $stats = [
                            ['value' => '7+', 'label' => 'Curated stories monthly'],
                            ['value' => '3', 'label' => 'Content verticals'],
                            ['value' => '1', 'label' => 'Devoted Plateau audience'],
                            ['value' => '24h', 'label' => 'Ad response time'],
                        ];
                    @endphp
                    @foreach($stats as $stat)
                        <div class="bg-white rounded-2xl p-6 border border-silver text-center hover:shadow-lg hover:shadow-orange/5 transition-all duration-500">
                            <div class="font-display text-4xl font-bold text-orange mb-2">{{ $stat['value'] }}</div>
                            <div class="font-ui text-xs text-secondary uppercase tracking-wider">{{ $stat['label'] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Formats --}}
<section class="py-16 bg-pearl">
    <div class="container-blossom">
        <div class="section-header reveal">
            <h2 class="section-title"><span class="section-title-accent">Advertising Formats</span></h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-12 stagger-children">
            @php
                $formats = [
                    ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 01-1.125-1.125M3.375 19.5h7.5c.621 0 1.125-.504 1.125-1.125m-9.75 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125m0 3.75h-7.5A1.125 1.125 0 0112 18.375m9.75-12.75c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125m19.5 0v1.5c0 .621-.504 1.125-1.125 1.125M2.25 5.625v1.5c0 .621.504 1.125 1.125 1.125m0 0h17.25m-17.25 0h7.5c.621 0 1.125.504 1.125 1.125M3.375 8.25c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125m17.25-3.75h-7.5c-.621 0-1.125.504-1.125 1.125m8.625-1.125c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125M12 10.875v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 10.875c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125M13.125 12h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125M20.625 12c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5M12 14.625v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 14.625c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125m0 1.5v-1.5m0 0c0 .621-.504 1.125-1.125 1.125m0 0h7.5"/>', 'title' => 'Display & Sponsored', 'desc' => 'Premium banner placements, sponsored articles, and integrated brand stories across our content verticals.'],
                    ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"/>', 'title' => 'Events & Sponsorships', 'desc' => 'Own the stage at Plateau\'s premier events, or partner on our listings directory to reach businesses and visitors.'],
                    ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>', 'title' => 'Newsletter & Native', 'desc' => 'Featured placements in our newsletter and native editorial partnerships that speak directly to a premium readership.'],
                ];
            @endphp
            @foreach($formats as $format)
                <div class="bg-white rounded-2xl p-8 border border-silver hover:shadow-lg hover:shadow-orange/5 transition-all duration-500">
                    <div class="w-14 h-14 mx-auto rounded-xl bg-orange/5 border border-orange/10 flex items-center justify-center mb-5">
                        <svg class="w-6 h-6 text-orange" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">{!! $format['icon'] !!}</svg>
                    </div>
                    <h3 class="font-display text-xl font-bold text-ink mb-3 text-center">{{ $format['title'] }}</h3>
                    <p class="font-body text-sm text-secondary leading-relaxed text-center">{{ $format['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="py-16 lg:py-24">
    <div class="container-blossom">
        <div class="newsletter-cta p-10 lg:p-16 text-center reveal">
            <span class="font-ui text-xs font-semibold tracking-[0.15em] uppercase text-orange block mb-4">Start a Conversation</span>
            <h2 class="font-display text-3xl md:text-4xl font-bold text-white mb-4">Let's Build Something Together</h2>
            <p class="font-body text-white/60 max-w-xl mx-auto mb-8">
                Tell us about your brand and goals, and we'll craft a package that fits your budget and objectives.
            </p>
            <a href="{{ route('contact') }}" class="btn-primary">Request a Media Kit</a>
        </div>
    </div>
</section>

@endsection