<?php $__env->startSection('title', 'Press Kit'); ?>
<?php $__env->startSection('metaDescription', 'BLOSSOM\'s press kit — our story, brand assets, facts, and media contact information.'); ?>

<?php $__env->startSection('content'); ?>


<section class="relative pt-32 pb-20 bg-ink overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-onion/20 via-transparent to-orange/10 pointer-events-none"></div>
    <div class="container-blossom relative z-10 text-center">
        <span class="font-ui text-xs font-semibold tracking-[0.15em] uppercase text-orange block mb-4">For the Press</span>
        <h1 class="font-display text-4xl md:text-5xl lg:text-6xl font-bold text-white leading-tight mb-6">
            BLOSSOM <span class="text-gradient-orange">Press Kit</span>
        </h1>
        <p class="font-body text-lg text-white/50 max-w-2xl mx-auto">
            Everything you need to write, cover, or feature BLOSSOM — from our story to our brand assets.
        </p>
    </div>
</section>


<section class="py-16 lg:py-24">
    <div class="container-blossom max-w-3xl">
        <div class="reveal">
            <span class="font-ui text-xs font-semibold tracking-[0.15em] uppercase text-onion block mb-3">The Basics</span>
            <h2 class="font-display text-3xl font-bold text-onion leading-tight mb-6">Who We Are</h2>
            <div class="space-y-4 font-body text-lg text-secondary leading-relaxed">
                <p>
                    BLOSSOM is Plateau State's prestige magazine — a premium platform documenting and celebrating the
                    people, heritage, culture, institutions, and achievements of Plateau State, Nigeria.
                </p>
                <p>
                    Founded in 2024 by Emerald Colours Nigeria Limited, BLOSSOM publishes curated articles, event
                    listings, and a business directory, and offers premium subscriptions for readers who want the full story.
                </p>
            </div>
        </div>
    </div>
</section>


<section class="py-16 bg-pearl">
    <div class="container-blossom">
        <div class="section-header reveal">
            <h2 class="section-title"><span class="section-title-accent">Key Facts</span></h2>
        </div>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 mt-12 stagger-children">
            <?php
                $facts = [
                    ['value' => '2024', 'label' => 'Founded'],
                    ['value' => 'Jos', 'label' => 'Headquarters'],
                    ['value' => '7+', 'label' => 'Stories per month'],
                    ['value' => '3', 'label' => 'Content verticals'],
                ];
            ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $facts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fact): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bg-white rounded-2xl p-6 border border-silver text-center hover:shadow-lg hover:shadow-onion/5 transition-all duration-500">
                    <div class="font-display text-4xl font-bold text-onion mb-2"><?php echo e($fact['value']); ?></div>
                    <div class="font-ui text-xs text-muted uppercase tracking-wider"><?php echo e($fact['label']); ?></div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
</section>


<section class="py-16 lg:py-24">
    <div class="container-blossom">
        <div class="section-header reveal">
            <h2 class="section-title"><span class="section-title-accent">Brand Assets</span></h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-12 stagger-children">
            <div class="bg-white rounded-2xl p-8 border border-silver flex items-center gap-6 hover:shadow-lg transition-all duration-500">
                <div class="w-20 h-20 rounded-xl bg-ink flex items-center justify-center flex-shrink-0">
                    <img src="<?php echo e(asset('assets/blossom-logo.png')); ?>" alt="BLOSSOM logo on dark" class="h-12 w-auto object-contain">
                </div>
                <div>
                    <h3 class="font-display text-lg font-bold text-ink mb-1">Logo on Dark</h3>
                    <p class="font-body text-sm text-secondary mb-3">PNG with transparency, for dark backgrounds.</p>
                    <a href="<?php echo e(asset('assets/blossom-logo.png')); ?>" download class="font-ui text-sm text-onion font-semibold hover:text-orange transition-colors">Download →</a>
                </div>
            </div>
            <div class="bg-white rounded-2xl p-8 border border-silver flex items-center gap-6 hover:shadow-lg transition-all duration-500">
                <div class="w-20 h-20 rounded-xl bg-white border border-silver flex items-center justify-center flex-shrink-0">
                    <img src="<?php echo e(asset('assets/blossom-logo.png')); ?>" alt="BLOSSOM logo on light" class="h-12 w-auto object-contain">
                </div>
                <div>
                    <h3 class="font-display text-lg font-bold text-ink mb-1">Logo on Light</h3>
                    <p class="font-body text-sm text-secondary mb-3">PNG with transparency, for light backgrounds.</p>
                    <a href="<?php echo e(asset('assets/blossom-logo.png')); ?>" download class="font-ui text-sm text-onion font-semibold hover:text-orange transition-colors">Download →</a>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="py-16 lg:py-24 pt-0">
    <div class="container-blossom">
        <div class="newsletter-cta p-10 lg:p-16 text-center reveal">
            <span class="font-ui text-xs font-semibold tracking-[0.15em] uppercase text-orange block mb-4">Media Enquiries</span>
            <h2 class="font-display text-3xl md:text-4xl font-bold text-white mb-4">Talk to Our Team</h2>
            <p class="font-body text-white/60 max-w-xl mx-auto mb-8">
                For interviews, features, or media partnerships, reach our editorial and communications team.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="mailto:press@blossom.ng" class="btn-primary">Email Press Desk</a>
                <a href="<?php echo e(route('contact')); ?>" class="btn-ghost">Use Contact Form</a>
            </div>
        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\WebWorka\codeworkflow\blossom\resources\views/pages/press-kit/index.blade.php ENDPATH**/ ?>