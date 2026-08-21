{{-- Premium Footer --}}
<footer class="relative bg-ink text-white/70 overflow-hidden">
    {{-- Decorative top border --}}
    <div class="h-px bg-gradient-to-r from-transparent via-onion/50 to-transparent"></div>

    {{-- Main Footer Content --}}
    <div class="max-w-[1440px] mx-auto px-6 lg:px-12 py-16 lg:py-20">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-12 lg:gap-8">

            {{-- Brand Column --}}
            <div class="lg:col-span-2">
                <a href="{{ route('home') }}" class="inline-block mb-6">
                    <img src="{{ asset('assets/blossom-logo.png') }}" alt="BLOSSOM Logo" class="h-12 w-auto mb-2">
                    <div class="font-ui text-xs tracking-[0.3em] uppercase text-ash mt-1">{{ setting('site.site.tagline', 'Global Stories, Nigerian Soul') }}</div>
                </a>
                <p class="font-body text-sm leading-relaxed text-white/50 max-w-sm mb-8">
                    Nigerian vibes, global reach, Plateau roots. A premium digital magazine telling Nigeria's stories to the world.
                </p>

                {{-- Newsletter Mini --}}
                <div class="flex items-center gap-2 max-w-sm">
                    <input type="email" placeholder="Your email address"
                           class="flex-1 bg-white/5 border border-white/10 rounded-lg px-4 py-2.5 text-sm text-white placeholder:text-ash focus:outline-none focus:border-onion transition-all duration-300 font-ui">
                    <a href="{{ route('newsletter') }}" class="px-5 py-2.5 rounded-lg bg-orange text-white text-sm font-semibold font-ui hover:bg-orange-600 transition-all duration-300 whitespace-nowrap">
                        Join
                    </a>
                </div>

                {{-- Contact Info --}}
                @php
                    $contactEmail = setting('site.site.contact_email', 'hello@blossom.ng');
                    $contactPhone = setting('site.site.contact_phone', '+234 800 000 0000');
                    $contactAddress = setting('site.site.contact_address', 'Jos, Plateau State, Nigeria');
                @endphp
                <div class="font-ui text-xs text-white/40 mt-4 space-y-1 max-w-sm">
                    <p><a href="mailto:{{ $contactEmail }}" class="hover:text-orange transition-colors">{{ $contactEmail }}</a></p>
                    <p>{{ $contactPhone }}</p>
                    <p>{{ $contactAddress }}</p>
                </div>

                {{-- Social Links --}}
                <div class="flex items-center gap-3 mt-6">
                    @php
                        $socialSettings = social_links();
                        $socials = [
                            ['name' => 'Twitter', 'url' => $socialSettings['twitter'] ?? 'https://x.com/blossommagazine', 'icon' => 'M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72,1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z'],
                            ['name' => 'Instagram', 'url' => $socialSettings['instagram'] ?? 'https://instagram.com/blossommagazine', 'icon' => 'M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z'],
                            ['name' => 'Facebook', 'url' => $socialSettings['facebook'] ?? 'https://facebook.com/blossommagazine', 'icon' => 'M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z'],
                            ['name' => 'WhatsApp', 'url' => $socialSettings['whatsapp'] ?? 'https://wa.me/2348000000000', 'icon' => 'M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z'],
                        ];
                    @endphp

                    @foreach($socials as $social)
                        <a href="{{ $social['url'] }}" target="_blank" rel="noopener noreferrer" class="w-9 h-9 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-white/50 hover:text-orange hover:border-orange/30 hover:bg-orange/5 transition-all duration-300" aria-label="{{ $social['name'] }}">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                                <path d="{{ $social['icon'] }}"/>
                            </svg>
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Explore --}}
            <div>
                <h4 class="font-ui text-xs font-semibold tracking-[0.15em] uppercase text-white mb-6">Explore</h4>
                <ul class="space-y-3">
                    @foreach(['Articles' => 'articles.index', 'Events' => 'events.index', 'Listings' => 'listings.index', 'Community' => 'community.index', 'Categories' => 'articles.index'] as $label => $route)
                        <li>
                            <a href="{{ route($route) }}" class="font-ui text-sm text-white/50 hover:text-orange transition-colors duration-300">{{ $label }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Company --}}
            <div>
                <h4 class="font-ui text-xs font-semibold tracking-[0.15em] uppercase text-white mb-6">Company</h4>
                <ul class="space-y-3">
                    @foreach(['About Us' => 'about', 'Contact' => 'contact', 'Advertise' => 'advertise', 'Careers' => 'careers', 'Press Kit' => 'press-kit'] as $label => $route)
                        <li>
                            <a href="{{ route($route) }}" class="font-ui text-sm text-white/50 hover:text-orange transition-colors duration-300">{{ $label }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Legal --}}
            <div>
                <h4 class="font-ui text-xs font-semibold tracking-[0.15em] uppercase text-white mb-6">Legal</h4>
                <ul class="space-y-3">
                    @foreach(['Privacy Policy' => 'privacy', 'Terms of Service' => 'terms', 'Cookie Policy' => 'cookies', 'Accessibility' => 'accessibility'] as $label => $route)
                        <li>
                            <a href="{{ route($route) }}" class="font-ui text-sm text-white/50 hover:text-orange transition-colors duration-300">{{ $label }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    {{-- Bottom Bar --}}
    <div class="border-t border-white/5">
        <div class="max-w-[1440px] mx-auto px-6 lg:px-12 py-6 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p class="font-ui text-xs text-white/30">
                {!! setting('site.site.copyright_text', '© ' . date('Y') . ' ' . setting('site.site.company_name', 'Emerald Colours Nigeria Limited') . '. All rights reserved.') !!}
            </p>
            <p class="font-ui text-xs text-white/30">
                Made with pride in Nigeria.
            </p>
        </div>
    </div>

    {{-- Decorative gradient --}}
    <div class="absolute bottom-0 left-0 right-0 h-32 bg-gradient-to-t from-onion/5 to-transparent pointer-events-none"></div>
</footer>
