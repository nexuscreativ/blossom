@extends('layouts.app')
@section('title', $listing['name'])
@section('metaDescription', $listing['desc'])

@section('content')

{{-- Listing Hero --}}
<section class="pt-32 pb-12 bg-pearl">
    <div class="container-blossom">
        <nav class="font-ui text-xs text-muted mb-6">
            <a href="{{ route('home') }}" class="hover:text-onion transition-colors">Home</a>
            <span class="mx-2">/</span>
            <a href="{{ route('listings.index') }}" class="hover:text-onion transition-colors">Listings</a>
            <span class="mx-2">/</span>
            <span class="text-graphite">{{ $listing['name'] }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2">
                <div class="flex items-center gap-3 mb-4">
                    <span class="font-ui text-xs font-semibold tracking-[0.15em] uppercase text-gold">Directory</span>
                    <span class="category-pill category-pill--purple">{{ $listing['type'] }}</span>
                    @if($listing['featured'])
                        <span class="flex items-center gap-1">
                            <svg class="w-3 h-3 text-gold" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <span class="font-ui text-[10px] font-semibold text-gold">Featured</span>
                        </span>
                    @endif
                </div>
                <h1 class="font-display text-3xl md:text-5xl font-bold text-onion leading-tight mb-6">{{ $listing['name'] }}</h1>
                <p class="font-body text-xl text-secondary leading-relaxed">{{ $listing['desc'] }}</p>
            </div>

            <div class="flex flex-col items-start lg:items-end justify-end gap-3">
                <a href="{{ route('contact') }}" class="btn-primary">Contact / Claim</a>
                <a href="{{ route('listings.index') }}" class="btn-ghost">Browse More Listings</a>
            </div>
        </div>
    </div>
</section>

{{-- Listing Body --}}
<section class="py-12 lg:py-16">
    <div class="container-blossom">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <div class="lg:col-span-8">
                <div class="rounded-2xl overflow-hidden mb-10">
                    <img src="{{ $listing['img'] }}" alt="{{ $listing['name'] }}" class="w-full h-[380px] object-cover">
                </div>

                <div class="font-body text-lg text-primary leading-[1.8] space-y-6">
                    <p>
                        {{ $listing['name'] }} is one of the standout {{ strtolower($listing['type']) }} entries in
                        the BLOSSOM directory — a curated showcase of the businesses, personalities, and institutions
                        that make Plateau State exceptional.
                    </p>
                    <p>
                        Listings are independently vetted by the BLOSSOM editorial team to ensure every entry reflects
                        the quality, integrity, and heritage that define our community. A featured listing signals
                        exceptional standing within the Plateau ecosystem.
                    </p>
                    <p>
                        To learn more about {{ $listing['name'] }}, request an introduction, or update this listing,
                        please get in touch with our directory team.
                    </p>
                </div>
            </div>

            <aside class="lg:col-span-4 space-y-6">
                <div class="bg-white rounded-2xl p-6 border border-silver shadow-sm">
                    <h3 class="font-display text-lg font-bold text-ink mb-4">More from the Directory</h3>
                    <div class="space-y-4">
                        @foreach(collect($listings)->filter(fn ($l) => $l['slug'] !== $listing['slug'])->take(4) as $other)
                            <a href="{{ route('listings.show', $other['slug']) }}" class="flex items-center gap-3 group">
                                <img src="{{ $other['img'] }}" alt="{{ $other['name'] }}" class="w-12 h-12 rounded-lg object-cover flex-shrink-0">
                                <div class="min-w-0">
                                    <span class="font-ui text-[10px] font-semibold tracking-wider uppercase text-onion">{{ $other['type'] }}</span>
                                    <h4 class="font-display text-sm font-bold text-ink leading-snug mt-0.5 group-hover:text-orange transition-colors line-clamp-1">{{ $other['name'] }}</h4>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="rounded-2xl bg-gradient-to-br from-onion to-onion-deep p-6 text-white">
                    <h3 class="font-display text-lg font-bold mb-2">Get Your Business Listed</h3>
                    <p class="font-body text-sm text-white/60 mb-4">Join Plateau's premier directory. Featured listings start at ₦15,000/month.</p>
                    <a href="{{ route('contact') }}" class="btn-primary bg-orange hover:bg-orange-deep w-full text-center text-sm block py-3">Submit Your Listing</a>
                </div>
            </aside>
        </div>
    </div>
</section>

@endsection