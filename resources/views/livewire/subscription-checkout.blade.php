<div>
    {{-- Error --}}
    @if($error)
        <div class="mb-6 p-4 bg-orange/10 border border-orange/30 rounded-xl">
            <p class="font-ui text-sm text-orange">{{ $error }}</p>
        </div>
    @endif

    {{-- Success --}}
    @if($success)
        <div class="mb-6 p-4 bg-sean/10 border border-sean/30 rounded-xl">
            <p class="font-ui text-sm text-sean">{{ $success }}</p>
        </div>
    @endif

    {{-- Plan Selection --}}
    <div class="grid md:grid-cols-2 gap-8 max-w-3xl mx-auto">
        @foreach($plans as $key => $plan)
            <div
                class="pricing-card {{ $selectedPlan === $key ? 'pricing-card--featured' : '' }} cursor-pointer"
                wire:click="selectPlan('{{ $key }}')"
            >
                @if($selectedPlan === $key)
                    <div class="absolute top-4 right-4">
                        <svg class="w-6 h-6 text-orange" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/>
                        </svg>
                    </div>
                @endif

                <h3 class="font-display text-2xl font-bold mb-2 {{ $selectedPlan === $key ? 'text-white' : 'text-onion' }}">
                    {{ $plan['name'] }}
                </h3>
                <div class="mb-6">
                    <span class="font-display text-4xl font-bold {{ $selectedPlan === $key ? 'text-white' : 'text-ink' }}">
                        ₦{{ number_format($plan['price']) }}
                    </span>
                    <span class="font-ui text-sm {{ $selectedPlan === $key ? 'text-white/60' : 'text-ash' }}">
                        /{{ $key === 'yearly' ? 'year' : 'month' }}
                    </span>
                </div>

                <ul class="space-y-3 mb-8">
                    @foreach($plan['features'] as $feature)
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 mt-0.5 flex-shrink-0 {{ $selectedPlan === $key ? 'text-orange-light' : 'text-sean' }}" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/>
                            </svg>
                            <span class="font-ui text-sm {{ $selectedPlan === $key ? 'text-white/80' : 'text-graphite' }}">
                                {{ $feature }}
                            </span>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>

    {{-- Provider Selection (shown after plan is selected) --}}
    <div class="max-w-3xl mx-auto mt-8">
        <h3 class="font-ui text-sm font-semibold text-ink mb-3 text-center">Pay with</h3>
        <div class="grid grid-cols-3 gap-3 max-w-lg mx-auto">
            @foreach($providers as $key => $provider)
                <button
                    wire:click="selectProvider('{{ $key }}')"
                    class="p-3 rounded-xl border-2 text-center transition-all duration-200
                           {{ $selectedProvider === $key
                              ? 'border-onion bg-onion/5 shadow-sm'
                              : 'border-silver bg-white hover:border-onion/30' }}"
                >
                    <span class="text-xl block mb-1">{{ $provider['icon'] }}</span>
                    <span class="font-ui text-xs font-semibold text-ink block">{{ $provider['name'] }}</span>
                    <span class="font-ui text-[10px] text-muted block mt-0.5">{{ $provider['description'] }}</span>
                </button>
            @endforeach
        </div>
    </div>

    {{-- Subscribe Button --}}
    <div class="max-w-3xl mx-auto mt-8 text-center">
        <button
            wire:click="initiatePayment"
            wire:loading.attr="disabled"
            wire:loading.class="opacity-50"
            class="btn-primary px-8 py-3"
        >
            <span wire:loading.remove>Subscribe Now — ₦{{ number_format($plans[$selectedPlan]['price']) }}</span>
            <span wire:loading>Processing payment...</span>
        </button>
        <p class="font-ui text-xs text-muted mt-3">
            Secure payment via {{ $providers[$selectedProvider]['name'] }}. Cancel anytime.
        </p>
    </div>
</div>
