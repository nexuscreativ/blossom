<?php $__env->startSection('title', 'Newsletter'); ?>
<?php $__env->startSection('metaDescription', 'Subscribe to the BLOSSOM newsletter. Weekly curated stories from the Plateau delivered to your inbox.'); ?>

<?php $__env->startSection('content'); ?>

<section class="pt-32 pb-16 bg-ink text-center relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-onion/20 via-transparent to-orange/10 pointer-events-none"></div>
    <div class="container-blossom relative z-10">
        <span class="font-ui text-xs font-semibold tracking-[0.15em] uppercase text-orange block mb-4">Newsletter</span>
        <h1 class="font-display text-4xl md:text-5xl font-bold text-white leading-tight mb-4">
            The Weekly BLOSSOM
        </h1>
        <p class="font-body text-white/50 text-lg max-w-xl mx-auto">
            The best stories, insights, and events from Plateau — delivered every Friday morning.
        </p>
    </div>
</section>

<section class="py-16 lg:py-24 -mt-8">
    <div class="container-blossom max-w-2xl">
        
        <div class="bg-white rounded-2xl p-8 md:p-10 shadow-xl shadow-onion/5 border border-silver reveal">
            <h2 class="font-display text-2xl font-bold text-onion mb-2 text-center">Subscribe Free</h2>
            <p class="font-body text-secondary text-sm text-center mb-6">Join 4,500+ Plateau enthusiasts who read BLOSSOM every week.</p>
            <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('newsletter-subscribe', []);

$__key = null;

$__key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-4020496923-0', $__key);

$__html = app('livewire')->mount($__name, $__params, $__key);

echo $__html;

unset($__html);
unset($__key);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
            <p class="font-ui text-xs text-muted text-center mt-4">No spam. Unsubscribe anytime.</p>
        </div>

        
        <div class="mt-12 reveal" style="animation-delay: 0.2s">
            <h3 class="font-display text-xl font-bold text-ink mb-6 text-center">Recent Issues</h3>
            <div class="space-y-4">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = [
                    ['issue' => '#47', 'title' => 'The Tin Mining Museum Renaissance', 'date' => 'Aug 15, 2026'],
                    ['issue' => '#46', 'title' => 'Jos Night Economy: A Visual Journey', 'date' => 'Aug 8, 2026'],
                    ['issue' => '#45', 'title' => '5 Startups Changing Plateau\'s Future', 'date' => 'Aug 1, 2026'],
                ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $past): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('articles.index')); ?>" class="flex items-center gap-4 p-4 rounded-xl bg-white border border-silver hover:border-onion/30 hover:shadow-md transition-all duration-300 group">
                        <span class="font-ui text-xs font-bold text-onion bg-onion/5 rounded-lg px-3 py-2 shrink-0"><?php echo e($past['issue']); ?></span>
                        <div class="min-w-0">
                            <h4 class="font-display text-sm font-bold text-ink group-hover:text-orange transition-colors truncate"><?php echo e($past['title']); ?></h4>
                            <span class="font-ui text-xs text-muted"><?php echo e($past['date']); ?></span>
                        </div>
                        <svg class="w-4 h-4 text-muted group-hover:text-onion transition-colors shrink-0 ml-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\WebWorka\codeworkflow\blossom\resources\views/pages/newsletter/index.blade.php ENDPATH**/ ?>