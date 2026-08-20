<div>
    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($error): ?>
        <div class="mb-6 p-4 bg-orange/10 border border-orange/30 rounded-xl">
            <p class="font-ui text-sm text-orange"><?php echo e($error); ?></p>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($success): ?>
        <div class="mb-6 p-4 bg-sean/10 border border-sean/30 rounded-xl">
            <p class="font-ui text-sm text-sean"><?php echo e($success); ?></p>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <div class="grid md:grid-cols-2 gap-8 max-w-3xl mx-auto">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div
                class="pricing-card <?php echo e($selectedPlan === $key ? 'pricing-card--featured' : ''); ?> cursor-pointer"
                wire:click="selectPlan('<?php echo e($key); ?>')"
            >
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedPlan === $key): ?>
                    <div class="absolute top-4 right-4">
                        <svg class="w-6 h-6 text-orange" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/>
                        </svg>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <h3 class="font-display text-2xl font-bold mb-2 <?php echo e($selectedPlan === $key ? 'text-white' : 'text-onion'); ?>">
                    <?php echo e($plan['name']); ?>

                </h3>
                <div class="mb-6">
                    <span class="font-display text-4xl font-bold <?php echo e($selectedPlan === $key ? 'text-white' : 'text-ink'); ?>">
                        ₦<?php echo e(number_format($plan['price'])); ?>

                    </span>
                    <span class="font-ui text-sm <?php echo e($selectedPlan === $key ? 'text-white/60' : 'text-ash'); ?>">
                        /<?php echo e($key === 'yearly' ? 'year' : 'month'); ?>

                    </span>
                </div>

                <ul class="space-y-3 mb-8">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $plan['features']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 mt-0.5 flex-shrink-0 <?php echo e($selectedPlan === $key ? 'text-orange-light' : 'text-sean'); ?>" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/>
                            </svg>
                            <span class="font-ui text-sm <?php echo e($selectedPlan === $key ? 'text-white/80' : 'text-graphite'); ?>">
                                <?php echo e($feature); ?>

                            </span>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </ul>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    
    <div class="max-w-3xl mx-auto mt-8">
        <h3 class="font-ui text-sm font-semibold text-ink mb-3 text-center">Pay with</h3>
        <div class="grid grid-cols-3 gap-3 max-w-lg mx-auto">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $providers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $provider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <button
                    wire:click="selectProvider('<?php echo e($key); ?>')"
                    class="p-3 rounded-xl border-2 text-center transition-all duration-200
                           <?php echo e($selectedProvider === $key
                              ? 'border-onion bg-onion/5 shadow-sm'
                              : 'border-silver bg-white hover:border-onion/30'); ?>"
                >
                    <span class="text-xl block mb-1"><?php echo e($provider['icon']); ?></span>
                    <span class="font-ui text-xs font-semibold text-ink block"><?php echo e($provider['name']); ?></span>
                    <span class="font-ui text-[10px] text-muted block mt-0.5"><?php echo e($provider['description']); ?></span>
                </button>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>

    
    <div class="max-w-3xl mx-auto mt-8 text-center">
        <button
            wire:click="initiatePayment"
            wire:loading.attr="disabled"
            wire:loading.class="opacity-50"
            class="btn-primary px-8 py-3"
        >
            <span wire:loading.remove>Subscribe Now — ₦<?php echo e(number_format($plans[$selectedPlan]['price'])); ?></span>
            <span wire:loading>Processing payment...</span>
        </button>
        <p class="font-ui text-xs text-muted mt-3">
            Secure payment via <?php echo e($providers[$selectedProvider]['name']); ?>. Cancel anytime.
        </p>
    </div>
</div>
<?php /**PATH C:\WebWorka\codeworkflow\blossom\resources\views/livewire/subscription-checkout.blade.php ENDPATH**/ ?>