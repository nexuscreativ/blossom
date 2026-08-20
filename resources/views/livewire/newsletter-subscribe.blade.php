<div>
    {{-- Success state --}}
    @if($success)
        <div class="flex items-center gap-3 p-4 bg-sean/10 border border-sean/30 rounded-xl">
            <svg class="w-5 h-5 text-sean flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            <span class="font-ui text-sm text-sean">{{ $status }}</span>
        </div>
    @else
        {{-- Form --}}
        <form wire:submit="subscribe" class="flex flex-col sm:flex-row gap-3">
            <input
                type="email"
                wire:model="email"
                placeholder="Your email address"
                class="flex-1 px-5 py-3.5 rounded-full bg-white/10 border border-white/20 text-white placeholder-white/50 font-ui text-sm focus:outline-none focus:border-orange focus:bg-white/15 transition-all"
                required
            />
            <button
                type="submit"
                class="px-8 py-3.5 rounded-full bg-orange text-white font-ui font-semibold text-sm hover:bg-orange-deep transition-all duration-300 disabled:opacity-50"
                wire:loading.attr="disabled"
                wire:loading.class="opacity-50"
            >
                <span wire:loading.remove>Subscribe</span>
                <span wire:loading>Sending...</span>
            </button>
        </form>

        @error('email')
            <p class="mt-2 text-sm text-orange-light font-ui">{{ $message }}</p>
        @enderror
    @endif
</div>
