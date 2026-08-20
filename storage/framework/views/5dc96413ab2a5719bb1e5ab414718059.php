<?php $__env->startSection('title', 'Events'); ?>
<?php $__env->startSection('metaDescription', 'Discover upcoming events, festivals, and gatherings on the Plateau.'); ?>

<?php $__env->startSection('content'); ?>

<section class="pt-32 pb-12 bg-pearl">
    <div class="container-blossom">
        <div class="max-w-2xl">
            <span class="font-ui text-xs font-semibold tracking-[0.15em] uppercase text-sean block mb-3">Calendar</span>
            <h1 class="font-display text-4xl md:text-5xl font-bold text-onion leading-tight mb-4">Events</h1>
            <p class="font-body text-secondary text-lg">Festivals, conferences, exhibitions, and gatherings across Plateau State.</p>
        </div>
    </div>
</section>

<section class="py-12 lg:py-16">
    <div class="container-blossom">
        
        <?php
            $featured = collect($events)->firstWhere('featured', true) ?? $events[0];
        ?>
        <div class="mb-12 reveal">
            <a href="<?php echo e(route('events.show', $featured['slug'])); ?>" class="relative rounded-2xl overflow-hidden group block">
                <img src="<?php echo e($featured['img'] ?? 'https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?w=1200&q=80'); ?>"
                     alt="" class="w-full h-[400px] object-cover transition-transform duration-700 group-hover:scale-105">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 p-8 md:p-12">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="event-date-badge" style="width:56px;height:64px">
                            <span class="month"><?php echo e($featured['month']); ?></span>
                            <span class="day text-xl"><?php echo e($featured['day']); ?></span>
                        </div>
                        <span class="category-pill category-pill--green"><?php echo e($featured['type']); ?></span>
                    </div>
                    <h2 class="font-display text-2xl md:text-3xl font-bold text-white mb-2"><?php echo e($featured['title']); ?></h2>
                    <p class="font-body text-white/70 max-w-lg"><?php echo e($featured['desc']); ?></p>
                    <div class="flex items-center gap-4 mt-4 text-white/50 font-ui text-sm">
                        <span><?php echo e($featured['location']); ?></span>
                        <span>·</span>
                        <span><?php echo e($featured['duration']); ?></span>
                    </div>
                </div>
            </a>
        </div>

        
        <div class="section-header reveal">
            <h2 class="section-title"><span class="section-title-accent">Upcoming</span></h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 stagger-children">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('events.show', $event['slug'])); ?>" class="event-card group">
                    <div class="event-date-badge">
                        <span class="month"><?php echo e($event['month']); ?></span>
                        <span class="day"><?php echo e($event['day']); ?></span>
                    </div>
                    <div class="flex flex-col justify-center min-w-0">
                        <span class="font-ui text-[10px] font-semibold tracking-wider uppercase text-sean"><?php echo e($event['type']); ?></span>
                        <h3 class="font-display text-base font-bold text-ink leading-snug mt-1 group-hover:text-sean transition-colors"><?php echo e($event['title']); ?></h3>
                        <p class="font-body text-xs text-muted mt-1 line-clamp-2"><?php echo e($event['desc']); ?></p>
                        <div class="flex items-center gap-1.5 mt-2 font-ui text-xs text-muted">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                            </svg>
                            <?php echo e($event['location']); ?>

                        </div>
                    </div>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\WebWorka\codeworkflow\blossom\resources\views/pages/events/index.blade.php ENDPATH**/ ?>