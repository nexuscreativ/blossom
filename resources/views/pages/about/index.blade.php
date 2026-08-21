@extends('layouts.app')
@section('title', 'About Us')
@section('metaDescription', 'Learn about BLOSSOM — Global Stories, Nigerian Soul. Our mission, values, and the team behind the stories.')

@section('content')

{{-- About Hero --}}
<section class="relative pt-32 pb-20 bg-ink overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-onion/20 via-transparent to-sean/10 pointer-events-none"></div>
    <div class="container-blossom relative z-10 text-center">
        <span class="font-ui text-xs font-semibold tracking-[0.15em] uppercase text-orange block mb-4">Our Story</span>
        <h1 class="font-display text-4xl md:text-5xl lg:text-6xl font-bold text-white leading-tight mb-6">
            Global Stories, <span class="text-gradient-orange">Nigerian Soul</span>
        </h1>
        <p class="font-body text-lg text-white/50 max-w-2xl mx-auto">
            BLOSSOM is more than a magazine. It's a love letter to Nigeria — its people, its culture, its resilience, and its future, with deep roots on the Plateau.
        </p>
    </div>
</section>

{{-- Mission --}}
<section class="py-16 lg:py-24">
    <div class="container-blossom">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <div class="reveal">
                <span class="font-ui text-xs font-semibold tracking-[0.15em] uppercase text-onion block mb-3">Who We Are</span>
                <h2 class="font-display text-3xl md:text-4xl font-bold text-onion leading-tight mb-6">
                    Stories That Define Nigeria
                </h2>
                <div class="space-y-4 font-body text-secondary leading-relaxed">
                    <p>
                        Founded in 2024, BLOSSOM Magazine was born from a simple belief: Nigeria has stories worth telling — stories of resilience, innovation, culture, and beauty that deserve a premium platform. From our home on the Plateau, we tell Nigeria's stories to the world.
                    </p>
                    <p>
                        We are a team of journalists, designers, and storytellers united by our commitment to showcasing Nigeria's best to the world — with deep roots in the Plateau.
                    </p>
                    <p>
                        From the cool hills of Shere to the bustling markets of Jos, from ancient traditions to cutting-edge tech startups, BLOSSOM captures the full spectrum of Nigerian life.
                    </p>
                </div>
            </div>
            <div class="reveal" style="animation-delay: 0.2s">
                <div class="relative rounded-2xl overflow-hidden aspect-square">
                    <img src="https://images.unsplash.com/photo-1504173010664-32509aeebb62?w=800&q=80"
                         alt="Plateau State landscape" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-tr from-onion/20 to-transparent"></div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Values --}}
<section class="py-16 bg-pearl">
    <div class="container-blossom">
        <div class="section-header reveal">
            <h2 class="section-title"><span class="section-title-accent">Our Values</span></h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-12 stagger-children">
            @php
                $values = [
                    ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418"/>', 'title' => 'Authenticity', 'desc' => 'Every story we tell is rooted in truth. We celebrate Nigeria as it is — complex, vibrant, and real.'],
                    ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.455 2.456L21.75 6l-1.036.259a3.375 3.375 0 00-2.455 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z"/>', 'title' => 'Excellence', 'desc' => 'Premium storytelling meets premium design. We hold ourselves to the highest standards in everything we publish.'],
                    ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/>', 'title' => 'Community', 'desc' => 'We exist to connect Nigerian people everywhere. Our platform brings together voices, ideas, and shared heritage.'],
                ];
            @endphp
            @foreach($values as $value)
                <div class="bg-white rounded-2xl p-8 border border-silver hover:shadow-lg hover:shadow-onion/5 transition-all duration-500 text-center">
                    <div class="w-14 h-14 mx-auto rounded-xl bg-onion/5 border border-onion/10 flex items-center justify-center mb-5">
                        <svg class="w-6 h-6 text-onion" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">{!! $value['icon'] !!}</svg>
                    </div>
                    <h3 class="font-display text-xl font-bold text-ink mb-3">{{ $value['title'] }}</h3>
                    <p class="font-body text-sm text-secondary leading-relaxed">{{ $value['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Team --}}
<section class="py-16 lg:py-24">
    <div class="container-blossom">
        <div class="section-header reveal">
            <h2 class="section-title"><span class="section-title-accent">The Team</span></h2>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mt-12 stagger-children">
            @php
                $team = [
                    ['name' => 'Dung Gyang', 'role' => 'Editor-in-Chief', 'img' => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?w=400&q=80'],
                    ['name' => 'Amina Bello', 'role' => 'Features Editor', 'img' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=400&q=80'],
                    ['name' => 'Ibrahim Musa', 'role' => 'Culture Editor', 'img' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&q=80'],
                    ['name' => 'Grace Pam', 'role' => 'Digital Director', 'img' => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?w=400&q=80'],
                ];
            @endphp
            @foreach($team as $member)
                <div class="text-center group">
                    <div class="relative rounded-xl overflow-hidden aspect-square mb-4">
                        <img src="{{ $member['img'] }}" alt="{{ $member['name'] }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    </div>
                    <h4 class="font-display text-base font-bold text-ink">{{ $member['name'] }}</h4>
                    <span class="font-ui text-xs text-muted">{{ $member['role'] }}</span>
                </div>
            @endforeach
        </div>
    </div>
</section>

@endsection
