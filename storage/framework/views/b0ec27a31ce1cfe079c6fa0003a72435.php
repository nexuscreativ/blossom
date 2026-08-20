<div>
    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($success): ?>
        <div class="flex items-center gap-3 p-4 bg-sean/10 border border-sean/30 rounded-xl">
            <svg class="w-5 h-5 text-sean flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            <span class="font-ui text-sm text-sean"><?php echo e($status); ?></span>
        </div>
    <?php else: ?>
        
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

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p class="mt-2 text-sm text-orange-light font-ui"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php /**PATH C:\WebWorka\codeworkflow\blossom\resources\views/livewire/newsletter-subscribe.blade.php ENDPATH**/ ?>