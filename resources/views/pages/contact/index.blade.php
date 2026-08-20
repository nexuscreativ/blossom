@extends('layouts.app')
@section('title', 'Contact Us')
@section('metaDescription', 'Get in touch with BLOSSOM Magazine. We love hearing from our readers, partners, and the Plateau community.')

@section('content')

{{-- Hero --}}
<section class="pt-32 pb-16 bg-ink text-center relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-onion/20 via-transparent to-sean/10 pointer-events-none"></div>
    <div class="container-blossom relative z-10">
        <span class="font-ui text-xs font-semibold tracking-[0.15em] uppercase text-orange block mb-4">Get in Touch</span>
        <h1 class="font-display text-4xl md:text-5xl font-bold text-white leading-tight mb-4">
            Let's Connect
        </h1>
        <p class="font-body text-white/50 text-lg max-w-xl mx-auto">
            Have a story tip, partnership inquiry, or just want to say hello? We'd love to hear from you.
        </p>
    </div>
</section>

{{-- Contact Content --}}
<section class="py-16 lg:py-24">
    <div class="container-blossom">
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-16">

            {{-- Contact Form --}}
            <div class="reveal">
                <h2 class="font-display text-2xl font-bold text-ink mb-6">Send Us a Message</h2>

                @if(session('contact_success'))
                    <div class="mb-6 p-4 rounded-xl bg-sean/10 border border-sean/30 font-ui text-sm text-sean-dark">
                        {{ session('contact_success') }}
                    </div>
                @endif
                @if(session('contact_error'))
                    <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 font-ui text-sm text-red-600">
                        {{ session('contact_error') }}
                    </div>
                @endif

                <form class="space-y-5" action="{{ route('contact.send') }}" method="POST">
                    @csrf
                    <div class="grid sm:grid-cols-2 gap-5">
                        <div>
                            <label class="font-ui text-sm font-medium text-ink block mb-1.5">First Name</label>
                            <input type="text" name="first_name" required
                                   class="w-full px-4 py-3 rounded-xl border border-silver bg-white font-ui text-sm text-ink focus:outline-none focus:ring-2 focus:ring-onion/30 focus:border-onion transition-colors"
                                   placeholder="Dung">
                        </div>
                        <div>
                            <label class="font-ui text-sm font-medium text-ink block mb-1.5">Last Name</label>
                            <input type="text" name="last_name" required
                                   class="w-full px-4 py-3 rounded-xl border border-silver bg-white font-ui text-sm text-ink focus:outline-none focus:ring-2 focus:ring-onion/30 focus:border-onion transition-colors"
                                   placeholder="Gyang">
                        </div>
                    </div>
                    <div>
                        <label class="font-ui text-sm font-medium text-ink block mb-1.5">Email</label>
                        <input type="email" name="email" required
                               class="w-full px-4 py-3 rounded-xl border border-silver bg-white font-ui text-sm text-ink focus:outline-none focus:ring-2 focus:ring-onion/30 focus:border-onion transition-colors"
                               placeholder="hello@example.com">
                    </div>
                    <div>
                        <label class="font-ui text-sm font-medium text-ink block mb-1.5">Subject</label>
                        <select name="subject"
                                class="w-full px-4 py-3 rounded-xl border border-silver bg-white font-ui text-sm text-ink focus:outline-none focus:ring-2 focus:ring-onion/30 focus:border-onion transition-colors">
                            <option value="">Select a topic</option>
                            <option value="story">Story Tip</option>
                            <option value="partnership">Partnership Inquiry</option>
                            <option value="advertising">Advertising</option>
                            <option value="listing">Business Listing</option>
                            <option value="feedback">Feedback</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div>
                        <label class="font-ui text-sm font-medium text-ink block mb-1.5">Message</label>
                        <textarea name="message" rows="5" required
                                  class="w-full px-4 py-3 rounded-xl border border-silver bg-white font-ui text-sm text-ink focus:outline-none focus:ring-2 focus:ring-onion/30 focus:border-onion transition-colors resize-none"
                                  placeholder="Tell us what's on your mind..."></textarea>
                    </div>
                    <button type="submit" class="btn-primary">
                        Send Message
                    </button>
                </form>
            </div>

            @php
    $contactEmail = setting('site.site.contact_email', 'hello@blossom.ng');
    $contactPhone = setting('site.site.contact_phone', '+234 800 000 0000');
    $contactAddress = setting('site.site.contact_address', 'Jos, Plateau State, Nigeria');
    $responseTime = setting('page.page.contact.response_time_text', 'We typically respond within 24 hours.');
    $partnershipEmail = setting('page.page.contact.partnership_email', 'partnerships@blossom.ng');
    $siteSocials = social_links();
@endphp

            {{-- Contact Info --}}
            <div class="reveal">
                <h2 class="font-display text-2xl font-bold text-ink mb-6">Other Ways to Reach Us</h2>

                <div class="space-y-6">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-onion/10 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-onion" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-ui text-sm font-semibold text-ink">Email</h3>
                            <a href="mailto:{{ $contactEmail }}" class="font-body text-secondary hover:text-onion transition-colors">{{ $contactEmail }}</a>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-sean/10 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-sean" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-ui text-sm font-semibold text-ink">Location</h3>
                            <p class="font-body text-secondary">{{ $contactAddress }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-orange/10 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-orange" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-ui text-sm font-semibold text-ink">Response Time</h3>
                            <p class="font-body text-secondary">{{ $responseTime }}</p>
                        </div>
                    </div>
                </div>

                {{-- Social Links --}}
                <div class="mt-10 pt-8 border-t border-silver">
                    <h3 class="font-ui text-sm font-semibold text-ink mb-4">Follow Us</h3>
                    <div class="flex gap-3">
                        @foreach($siteSocials as $name => $url)
                            <a href="{{ $url }}" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-xl bg-pearl hover:bg-onion/10 flex items-center justify-center transition-colors group" title="{{ ucfirst($name) }}">
                                <span class="font-ui text-xs font-bold text-muted group-hover:text-onion transition-colors">{{ strtoupper(substr($name, 0, 2)) }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- Partnership CTA --}}
                <div class="mt-10 p-6 rounded-2xl bg-gradient-to-br from-onion/5 to-sean/5 border border-onion/10">
                    <h3 class="font-display text-lg font-bold text-ink mb-2">Partner with BLOSSOM</h3>
                    <p class="font-body text-secondary text-sm mb-4">
                        Reach Plateau's most engaged audience through sponsored content, featured listings, and event partnerships.
                    </p>
                    <a href="mailto:{{ $partnershipEmail }}" class="font-ui text-sm font-semibold text-onion hover:text-onion-dark transition-colors">
                        {{ $partnershipEmail }} →
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
