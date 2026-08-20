@extends('layouts.app')
@section('title', 'Community')
@section('metaDescription', 'Join the conversation. Share stories, connect with Plateau people, and build community.')

@section('content')

<section class="pt-32 pb-12 bg-pearl">
    <div class="container-blossom">
        <div class="max-w-2xl">
            <span class="font-ui text-xs font-semibold tracking-[0.15em] uppercase text-sean block mb-3">Community</span>
            <h1 class="font-display text-4xl md:text-5xl font-bold text-onion leading-tight mb-4">The BLOSSOM Network</h1>
            <p class="font-body text-secondary text-lg">Connect with fellow Plateau enthusiasts. Share stories, debate ideas, and celebrate our heritage together.</p>
        </div>
    </div>
</section>

<section class="py-12 lg:py-16">
    <div class="container-blossom">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Main Feed --}}
            <div class="lg:col-span-2 space-y-6">
                <livewire:community-feed />
            </div>

            {{-- Sidebar --}}
            <div class="space-y-6">
                {{-- Trending Topics --}}
                <div class="bg-white rounded-2xl p-6 border border-silver shadow-sm">
                    <h3 class="font-display text-lg font-bold text-ink mb-4">Trending Topics</h3>
                    <div class="space-y-3">
                        @foreach(['#PlateauTech', '#NzemBerom2026', '#JosFoodFestival', '#PlateauHeritage', '#JosNightLife'] as $topic)
                            <a href="{{ route('community.index') }}" class="flex items-center gap-3 group">
                                <span class="font-ui text-sm font-semibold text-onion group-hover:text-orange transition-colors">{{ $topic }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- Active Members --}}
                <div class="bg-white rounded-2xl p-6 border border-silver shadow-sm">
                    <h3 class="font-display text-lg font-bold text-ink mb-4">Active Members</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach(['G', 'I', 'N', 'F', 'D', 'A', 'E', 'R'] as $avatar)
                            <div class="w-10 h-10 rounded-full bg-onion/10 flex items-center justify-center text-onion font-semibold text-sm cursor-pointer hover:bg-onion hover:text-white transition-all">
                                {{ $avatar }}
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- BLOSSOM Card --}}
                <div class="rounded-2xl bg-gradient-to-br from-onion to-onion-deep p-6 text-white">
                    <h3 class="font-display text-lg font-bold mb-2">Join the Conversation</h3>
                    <p class="font-body text-sm text-white/60 mb-4">Subscribe to BLOSSOM Premium and unlock the full community experience.</p>
                    <a href="{{ route('pricing') }}" class="btn-primary bg-orange hover:bg-orange-deep w-full text-center text-sm block py-3">Subscribe Now</a>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection
