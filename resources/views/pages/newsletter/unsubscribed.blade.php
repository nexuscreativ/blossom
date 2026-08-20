@extends('layouts.app')
@section('title', 'Unsubscribed')

@section('content')

<section class="min-h-screen flex items-center justify-center bg-pearl py-24 px-6">
    <div class="w-full max-w-md text-center">
        <div class="bg-white rounded-2xl p-10 shadow-xl border border-silver">
            <div class="w-16 h-16 mx-auto mb-6 rounded-full bg-sean/10 border border-sean/20 flex items-center justify-center">
                <svg class="w-8 h-8 text-sean" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                </svg>
            </div>
            <h1 class="font-display text-2xl font-bold text-onion mb-3">You've been unsubscribed</h1>
            <p class="font-body text-secondary text-sm mb-8 leading-relaxed">
                You will no longer receive the BLOSSOM newsletter. We're sorry to see you go.
            </p>
            <a href="{{ route('home') }}" class="btn-primary inline-flex">
                Back to BLOSSOM
            </a>
        </div>
    </div>
</section>

@endsection
