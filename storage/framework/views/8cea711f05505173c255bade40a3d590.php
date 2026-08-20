<?php $__env->startSection('title', 'Community'); ?>
<?php $__env->startSection('metaDescription', 'Join the conversation. Share stories, connect with Plateau people, and build community.'); ?>

<?php $__env->startSection('content'); ?>

<section class="pt-32 pb-12 bg-pearl">
    <div class="container-blossom">
        <div class="max-w-2xl">
            <span class="font-ui text-xs font-semibold tracking-[0.15em] uppercase text-sean block mb-3">Community</span>
            <h1 class="font-display text-4xl md:text-5xl font-bold text-onion leading-tight mb-4">The BLOSSOM Network</h1>
            <p class="font-body text-secondary text-lg">Connect with fellow Plateau enthusiasts. Share stories, debate ideas, and celebrate our heritage together.</p>
        </div>
    </div>
</section>

<section class="py-12 lg:py-16">
    <div class="container-blossom">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            
            <div class="lg:col-span-2 space-y-6">
                <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('community-feed', []);

$__key = null;

$__key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-1296481362-0', $__key);

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

            
            <div class="space-y-6">
                
                <div class="bg-white rounded-2xl p-6 border border-silver shadow-sm">
                    <h3 class="font-display text-lg font-bold text-ink mb-4">Trending Topics</h3>
                    <div class="space-y-3">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = ['#PlateauTech', '#NzemBerom2026', '#JosFoodFestival', '#PlateauHeritage', '#JosNightLife']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $topic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e(route('community.index')); ?>" class="flex items-center gap-3 group">
                                <span class="font-ui text-sm font-semibold text-onion group-hover:text-orange transition-colors"><?php echo e($topic); ?></span>
                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

                
                <div class="bg-white rounded-2xl p-6 border border-silver shadow-sm">
                    <h3 class="font-display text-lg font-bold text-ink mb-4">Active Members</h3>
                    <div class="flex flex-wrap gap-2">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = ['G', 'I', 'N', 'F', 'D', 'A', 'E', 'R']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $avatar): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="w-10 h-10 rounded-full bg-onion/10 flex items-center justify-center text-onion font-semibold text-sm cursor-pointer hover:bg-onion hover:text-white transition-all">
                                <?php echo e($avatar); ?>

                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

                
                <div class="rounded-2xl bg-gradient-to-br from-onion to-onion-deep p-6 text-white">
                    <h3 class="font-display text-lg font-bold mb-2">Join the Conversation</h3>
                    <p class="font-body text-sm text-white/60 mb-4">Subscribe to BLOSSOM Premium and unlock the full community experience.</p>
                    <a href="<?php echo e(route('pricing')); ?>" class="btn-primary bg-orange hover:bg-orange-deep w-full text-center text-sm block py-3">Subscribe Now</a>
                </div>
            </div>

        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\WebWorka\codeworkflow\blossom\resources\views/pages/community/index.blade.php ENDPATH**/ ?>