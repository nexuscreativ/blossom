<?php $__env->startSection('title', 'Pricing'); ?>
<?php $__env->startSection('metaDescription', 'Choose a BLOSSOM subscription plan. Unlock premium stories, featured listings, and exclusive community access.'); ?>

<?php $__env->startSection('content'); ?>


<section class="pt-32 pb-16 bg-ink text-center relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-onion/20 via-transparent to-sean/10 pointer-events-none"></div>
    <div class="container-blossom relative z-10">
        <span class="font-ui text-xs font-semibold tracking-[0.15em] uppercase text-orange block mb-4">Membership</span>
        <h1 class="font-display text-4xl md:text-5xl font-bold text-white leading-tight mb-4">
            Unlock the Full BLOSSOM Experience
        </h1>
        <p class="font-body text-white/50 text-lg max-w-xl mx-auto">
            Premium stories, exclusive events, and deeper insights into Plateau's most compelling narratives.
        </p>
    </div>
</section>


<section class="py-16 lg:py-24 -mt-8">
    <div class="container-blossom">
        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('subscription-checkout', []);

$__key = null;

$__key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-719107972-0', $__key);

$__html = app('livewire')->mount($__name, $__params, $__key);

echo $__html;

unset($__html);
unset($__key);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
    </div>
</section>


<section class="py-16 bg-pearl">
    <div class="container-blossom">
        <div class="section-header reveal">
            <h2 class="section-title"><span class="section-title-accent">Frequently Asked</span></h2>
        </div>
        <div class="max-w-2xl mx-auto space-y-4 mt-8" x-data="{ open: null }">
            <?php
                $faqs = [
                    ['q' => 'Can I cancel anytime?', 'a' => 'Yes. You can cancel your subscription at any time. Your access continues until the end of your billing period.'],
                    ['q' => 'Do you accept bank transfers?', 'a' => 'Yes. We accept Paystack (card/bank), Monnify (bank transfer), and Nomba payments. All major Nigerian banks are supported.'],
                    ['q' => 'What payment frequency options are available?', 'a' => 'Monthly and annual plans. Annual plans save you ₦10,000 compared to paying monthly.'],
                    ['q' => 'Can businesses get team access?', 'a' => 'Contact us at hello@blossom.ng for corporate and team subscription plans with bulk pricing.'],
                ];
            ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="rounded-xl border border-silver bg-white overflow-hidden transition-all duration-300"
                     :class="open === <?php echo e($i); ?> ? 'ring-2 ring-onion/20 border-onion/30' : ''">
                    <button @click="open === <?php echo e($i); ?> ? open = null : open = <?php echo e($i); ?>"
                            class="w-full flex items-center justify-between p-5 text-left">
                        <span class="font-display text-base font-bold text-ink"><?php echo e($faq['q']); ?></span>
                        <svg class="w-5 h-5 text-muted transition-transform duration-300 shrink-0 ml-4"
                             :class="open === <?php echo e($i); ?> ? 'rotate-180' : ''" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                        </svg>
                    </button>
                    <div x-show="open === <?php echo e($i); ?>" x-collapse class="px-5 pb-5">
                        <p class="font-body text-secondary text-sm leading-relaxed"><?php echo e($faq['a']); ?></p>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\WebWorka\codeworkflow\blossom\resources\views/pages/subscription/index.blade.php ENDPATH**/ ?>