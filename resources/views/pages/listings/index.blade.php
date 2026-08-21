@extends('layouts.app')
@section('title', 'Featured Listings')
@section('metaDescription', 'Explore top businesses, services, and venues on the Plateau.')

@section('content')

<section class="pt-32 pb-12 bg-pearl">
    <div class="container-blossom">
        <div class="max-w-2xl">
            <span class="font-ui text-xs font-semibold tracking-[0.15em] uppercase text-gold block mb-3">Directory</span>
            <h1 class="font-display text-4xl md:text-5xl font-bold text-onion leading-tight mb-4">Nigeria's Finest</h1>
            <p class="font-body text-secondary text-lg">Discover the best businesses, personalities, and institutions across Nigeria.</p>
        </div>
    </div>
</section>

{{-- Search & Filter --}}
<section class="sticky top-[72px] z-[150] bg-white/95 backdrop-blur-xl border-b border-silver py-4">
    <div class="container-blossom">
        <div class="flex flex-col md:flex-row items-center gap-4">
            <div class="relative flex-1 w-full">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-ash" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                </svg>
                <input type="text" placeholder="Search businesses, people, institutions..."
                       class="form-input pl-10">
            </div>
            <div class="flex gap-2">
                @foreach(['Business', 'Personality', 'Institution'] as $type)
                    <button class="px-4 py-2 rounded-full font-ui text-sm font-medium border border-silver text-graphite hover:border-onion hover:text-onion transition-all">
                        {{ $type }}
                    </button>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- Listings Grid --}}
<section class="py-12 lg:py-16">
    <div class="container-blossom">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 stagger-children">
            @foreach($listings as $listing)
                <a href="{{ route('listings.show', $listing['slug']) }}" class="listing-card {{ $listing['featured'] ? 'listing-card--featured' : '' }} group">
                    <div class="aspect-[4/3] overflow-hidden">
                        <img src="{{ $listing['img'] }}" alt="{{ $listing['name'] }}"
                             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" loading="lazy">
                    </div>
                    <div class="p-5">
                        <div class="flex items-center justify-between">
                            <span class="font-ui text-[10px] font-semibold tracking-wider uppercase text-onion">{{ $listing['type'] }}</span>
                            @if($listing['featured'])
                                <span class="flex items-center gap-1">
                                    <svg class="w-3 h-3 text-gold" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    <span class="font-ui text-[10px] font-semibold text-gold">Featured</span>
                                </span>
                            @endif
                        </div>
                        <h3 class="font-display text-lg font-bold text-ink mt-2 group-hover:text-orange transition-colors">{{ $listing['name'] }}</h3>
                        <p class="font-body text-sm text-muted mt-1 line-clamp-2">{{ $listing['desc'] }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="py-16 bg-ink text-center">
    <div class="container-blossom">
        <h2 class="font-display text-2xl md:text-3xl font-bold text-white mb-4">Get Your Business Listed</h2>
        <p class="font-body text-white/50 mb-8 max-w-md mx-auto">Join Nigeria's premier business directory. Standard listings are free; featured listings start at ₦15,000/month.</p>
        <a href="{{ route('contact') }}" class="btn-primary">Submit Your Listing</a>
    </div>
</section>

@endsection
