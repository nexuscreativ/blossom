@extends('layouts.app')
@section('title', 'Dashboard')
@section('metaDescription', 'Manage your BLOSSOM account, subscription, and listings.')

@section('content')

<section class="pt-32 pb-16 bg-pearl">
    <div class="container-blossom">
        <h1 class="font-display text-3xl font-bold text-onion mb-2">Welcome back, {{ Auth::user()->first_name ?? 'Member' }}</h1>
        <p class="font-body text-secondary">Manage your account, subscription, and listings.</p>
    </div>
</section>

<section class="py-12">
    <div class="container-blossom">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            {{-- Subscription Status --}}
            <div class="bg-white rounded-2xl p-6 border border-silver">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-lg bg-orange/10 flex items-center justify-center">
                        <svg class="w-5 h-5 text-orange" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/></svg>
                    </div>
                    <div>
                        <span class="font-ui text-xs text-muted">Subscription</span>
                        <h3 class="font-display text-lg font-bold text-ink">{{ Auth::user()->subscription?->status === 'active' ? 'Active' : 'Free' }}</h3>
                    </div>
                </div>
                @if(!Auth::user()->subscription || Auth::user()->subscription?->status !== 'active')
                    <a href="{{ route('pricing') }}" class="btn-primary w-full text-center text-sm block py-2.5 mt-2">Upgrade to Premium</a>
                @endif
            </div>

            {{-- My Listings --}}
            <div class="bg-white rounded-2xl p-6 border border-silver">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-lg bg-sean/10 flex items-center justify-center">
                        <svg class="w-5 h-5 text-sean" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016A3.001 3.001 0 0021 9.349"/></svg>
                    </div>
                    <div>
                        <span class="font-ui text-xs text-muted">Listings</span>
                        <h3 class="font-display text-lg font-bold text-ink">0 Active</h3>
                    </div>
                </div>
                <a href="{{ route('contact') }}" class="btn-secondary w-full text-center text-sm block py-2.5 mt-2">Create Listing</a>
            </div>

            {{-- Profile --}}
            <div class="bg-white rounded-2xl p-6 border border-silver">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-lg bg-onion/10 flex items-center justify-center">
                        <svg class="w-5 h-5 text-onion" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                    </div>
                    <div>
                        <span class="font-ui text-xs text-muted">Profile</span>
                        <h3 class="font-display text-lg font-bold text-ink">Edit Profile</h3>
                    </div>
                </div>
                <a href="{{ route('contact') }}" class="btn-secondary w-full text-center text-sm block py-2.5 mt-2">Manage</a>
            </div>

        </div>
    </div>
</section>

@endsection
