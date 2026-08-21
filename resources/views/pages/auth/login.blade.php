@extends('layouts.app')
@section('title', 'Sign In')
@section('metaDescription', 'Sign in to your BLOSSOM account.')

@section('content')

<section class="min-h-screen flex items-center justify-center bg-pearl py-24 px-6">
    <div class="w-full max-w-md reveal">
        {{-- Logo --}}
        <div class="text-center mb-8">
            <a href="/" class="inline-flex items-center gap-3 mb-4">
                <div class="w-12 h-12 rounded-full bg-onion flex items-center justify-center shadow-lg shadow-onion/20">
                    <span class="font-display text-xl font-bold text-white leading-none">B</span>
                </div>
                <span class="font-display text-2xl font-bold text-onion tracking-tight">BLOSSOM</span>
            </a>
            <p class="font-body text-secondary">Welcome back to BLOSSOM.</p>
        </div>

        {{-- Form Card --}}
        <div class="bg-white rounded-2xl p-8 shadow-xl shadow-onion/5 border border-silver">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="space-y-5">
                    <div>
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                               class="form-input @error('email') border-red-500 focus:border-red-500 focus:ring-red-500/20 @enderror"
                               placeholder="you@example.com">
                        @error('email')
                            <p class="mt-1 font-ui text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="password" class="form-label">Password</label>
                            <a href="{{ route('contact') }}" class="font-ui text-xs text-onion hover:text-orange transition-colors">Forgot?</a>
                        </div>
                        <input type="password" id="password" name="password" required
                               class="form-input @error('password') border-red-500 focus:border-red-500 focus:ring-red-500/20 @enderror"
                               placeholder="Enter your password">
                        @error('password')
                            <p class="mt-1 font-ui text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center gap-2">
                        <input type="checkbox" id="remember" name="remember" class="w-4 h-4 rounded border-silver text-onion focus:ring-onion/20">
                        <label for="remember" class="font-ui text-sm text-secondary">Remember me</label>
                    </div>

                    <button type="submit" class="btn-primary w-full py-3.5 text-center">
                        Sign In
                    </button>
                </div>
            </form>

            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-silver"></div></div>
                <div class="relative flex justify-center text-sm"><span class="px-4 bg-white text-muted font-ui">or</span></div>
            </div>

            {{-- Social Login --}}
            <div class="space-y-3">
                <button class="w-full flex items-center justify-center gap-3 px-4 py-3 rounded-full border border-silver font-ui text-sm text-graphite hover:bg-pearl hover:border-onion/30 transition-all duration-300">
                    <svg class="w-5 h-5" viewBox="0 0 24 24"><path fill="#4285F4" d="M23.745 12.27c0-.79-.07-1.54-.19-2.27h-11.3v4.51h6.47c-.29 1.48-1.14 2.73-2.4 3.58v3h3.86c2.26-2.09 3.56-5.17 3.56-8.82z"/><path fill="#34A853" d="M12.255 24c3.24 0 5.95-1.08 7.93-2.91l-3.86-3c-1.08.72-2.45 1.16-4.07 1.16-3.13 0-5.78-2.11-6.73-4.96h-3.98v3.09C3.515 21.3 7.565 24 12.255 24z"/><path fill="#FBBC05" d="M5.525 14.29c-.25-.72-.38-1.49-.38-2.29s.14-1.57.38-2.29V6.62h-3.98a11.86 11.86 0 000 10.76l3.98-3.09z"/><path fill="#EA4335" d="M12.255 4.75c1.77 0 3.35.61 4.6 1.8l3.42-3.42C18.205 1.19 15.495 0 12.255 0c-4.69 0-8.74 2.7-10.71 6.62l3.98 3.09c.95-2.85 3.6-4.96 6.73-4.96z"/></svg>
                    Continue with Google
                </button>
            </div>
        </div>

        {{-- Register Link --}}
        <p class="text-center mt-6 font-ui text-sm text-secondary">
            Don't have an account?
            <a href="{{ route('register') }}" class="text-onion font-semibold hover:text-orange transition-colors">Create one</a>
        </p>
    </div>
</section>

@endsection
