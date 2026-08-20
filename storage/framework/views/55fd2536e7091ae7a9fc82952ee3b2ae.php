<?php $__env->startSection('title', 'Articles'); ?>
<?php $__env->startSection('metaDescription', 'Read the latest articles on lifestyle, culture, business, and community from Plateau State.'); ?>

<?php $__env->startSection('content'); ?>


<section class="pt-32 pb-12 bg-pearl">
    <div class="container-blossom">
        <div class="max-w-2xl">
            <span class="font-ui text-xs font-semibold tracking-[0.15em] uppercase text-onion block mb-3">Stories</span>
            <h1 class="font-display text-4xl md:text-5xl font-bold text-onion leading-tight mb-4">
                Latest Stories
            </h1>
            <p class="font-body text-secondary text-lg">
                In-depth reporting, compelling features, and inspiring stories from across Plateau State.
            </p>
        </div>
    </div>
</section>


<section class="sticky top-[72px] z-[150] bg-white/95 backdrop-blur-xl border-b border-silver">
    <div class="container-blossom">
        <div class="flex gap-1 overflow-x-auto py-3 scrollbar-hide" x-data="{ active: 'all' }">
            <?php
                $categories = ['all' => 'All', 'culture' => 'Culture', 'business' => 'Business', 'politics' => 'Politics', 'tourism' => 'Tourism', 'education' => 'Education', 'heritage' => 'Heritage'];
            ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slug => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <button @click="active = '<?php echo e($slug); ?>'"
                        class="px-4 py-2 rounded-full font-ui text-sm font-medium whitespace-nowrap transition-all duration-300"
                        :class="active === '<?php echo e($slug); ?>' ? 'bg-onion text-white' : 'text-graphite hover:text-onion hover:bg-onion/5'">
                    <?php echo e($label); ?>

                </button>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
</section>


<section class="py-12 lg:py-16">
    <div class="container-blossom">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 stagger-children">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('articles.show', $article['slug'])); ?>" class="article-card group">
                    <div class="article-card-image">
                        <img src="<?php echo e($article['img']); ?>" alt="<?php echo e($article['title']); ?>" loading="lazy">
                        <div class="absolute top-4 left-4 z-10">
                            <span class="category-pill category-pill--purple"><?php echo e($article['cat']); ?></span>
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($article['premium']): ?>
                            <div class="absolute top-4 right-4 z-10">
                                <span class="badge-premium">Premium</span>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <div class="p-6">
                        <h3 class="font-display text-lg font-bold text-onion leading-snug mb-2 group-hover:text-orange transition-colors duration-300 line-clamp-2">
                            <?php echo e($article['title']); ?>

                        </h3>
                        <p class="font-body text-secondary text-sm leading-relaxed mb-4 line-clamp-2"><?php echo e($article['excerpt']); ?></p>
                        <div class="flex items-center justify-between font-ui text-xs text-muted">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-full bg-onion/10 flex items-center justify-center text-onion text-[10px] font-semibold"><?php echo e(substr($article['author'], 0, 1)); ?></div>
                                <span><?php echo e($article['author']); ?></span>
                            </div>
                            <span><?php echo e($article['time']); ?> · <?php echo e($article['date']); ?></span>
                        </div>
                    </div>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        
        <div class="text-center mt-12">
            <button class="btn-secondary">Load More Stories</button>
        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\WebWorka\codeworkflow\blossom\resources\views/pages/articles/index.blade.php ENDPATH**/ ?>