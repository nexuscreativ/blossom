<?php $__env->startSection('title', setting('site.site.name', 'BLOSSOM')); ?>
<?php $__env->startSection('metaDescription', 'Celebrating the people, culture, heritage, and achievements of Plateau State. Your premier source for lifestyle, business, and community stories.'); ?>

<?php $__env->startSection('content'); ?>


<section class="hero-section">
    <div class="hero-image-wrapper">
        <img src="<?php echo e(asset('assets/hero-family.jpg')); ?>"
             alt="Family reading BLOSSOM Magazine"
             class="hero-image parallax-slow"
             loading="eager">
        <div class="hero-overlay"></div>
    </div>

    <div class="hero-content">
        <div class="max-w-3xl">
            <span class="hero-category-pill category-pill category-pill--green mb-6 inline-block">Culture & Heritage</span>

            <h1 class="hero-title font-display text-white text-4xl md:text-5xl lg:text-6xl font-bold leading-[1.1] mb-6 tracking-tight">
                The Remarkable Story of Plateau's Cultural Renaissance
            </h1>

            <p class="hero-deck font-body text-white/80 text-lg md:text-xl leading-relaxed mb-8 max-w-2xl">
                From the ancient rhythms of Nzem Berom to the modern art scene reshaping Jos,
                discover how Plateau State is writing its next chapter.
            </p>

            <div class="hero-meta flex flex-wrap items-center gap-4 text-white/60 font-ui text-sm mb-8">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-onion/40 border border-white/20 flex items-center justify-center text-white text-xs font-semibold">A</div>
                    <span>Amina Bello</span>
                </div>
                <span class="hidden sm:inline text-white/30">·</span>
                <span>8 min read</span>
                <span class="hidden sm:inline text-white/30">·</span>
                <span>August 18, 2026</span>
                <span class="badge-premium text-[9px]">Premium</span>
            </div>

            <div class="hero-cta flex flex-wrap gap-4">
                <a href="<?php echo e(route('articles.show', 'the-nzem-berom-festival-where-drums-speak-the-language-of-ancestors')); ?>" class="btn-primary">
                    Read Article
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                    </svg>
                </a>
                <a href="<?php echo e(route('articles.index')); ?>" class="btn-ghost">Explore More Stories</a>
            </div>
        </div>
    </div>

    
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 z-10 flex flex-col items-center gap-2 text-white/40">
        <span class="font-ui text-[10px] tracking-[0.2em] uppercase">Scroll</span>
        <div class="w-px h-8 bg-gradient-to-b from-white/40 to-transparent animate-pulse"></div>
    </div>
</section>



<section class="py-20 lg:py-28">
    <div class="container-blossom">
        <div class="section-header reveal">
            <span class="font-ui text-xs font-semibold tracking-[0.15em] uppercase text-muted block mb-3">Curated for you</span>
            <h2 class="section-title">
                <span class="section-title-accent">Editor's Picks</span>
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 stagger-children">
            <?php
                $picks = [
                    ['slug' => 'how-plateau-entrepreneurs-are-building-africas-next-tech-hub', 'img' => 'https://images.unsplash.com/photo-1590845947376-2638caa89305?w=800&q=80', 'cat' => 'Business', 'catColor' => 'purple', 'title' => 'How Plateau Entrepreneurs Are Building Africa\'s Next Tech Hub', 'excerpt' => 'From Jos to Lagos, Plateau founders are attracting millions in venture capital.', 'author' => 'Emmanuel Dung', 'time' => '6 min', 'premium' => true],
                    ['slug' => 'the-hidden-waterfalls-of-shere-hills', 'img' => 'https://images.unsplash.com/photo-1504173010664-32509aeebb62?w=800&q=80', 'cat' => 'Tourism', 'catColor' => 'green', 'title' => 'The Hidden Waterfalls of Shere Hills', 'excerpt' => 'A visual journey through Plateau\'s best-kept natural secrets.', 'author' => 'Grace Pam', 'time' => '4 min', 'premium' => false],
                    ['slug' => 'the-berom-people-guardians-of-plateaus-ancient-traditions', 'img' => 'https://images.unsplash.com/photo-1518611012118-696072aa579a?w=800&q=80', 'cat' => 'Culture', 'catColor' => 'orange', 'title' => 'The Berom People: Guardians of Plateau\'s Ancient Traditions', 'excerpt' => 'Centuries-old customs find new life in the hands of young custodians.', 'author' => 'Ibrahim Musa', 'time' => '10 min', 'premium' => true],
                ];
            ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $picks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pick): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('articles.show', $pick['slug'])); ?>" class="article-card group">
                    <div class="article-card-image">
                        <img src="<?php echo e($pick['img']); ?>" alt="<?php echo e($pick['title']); ?>" loading="lazy">
                        <div class="absolute top-4 left-4 z-10">
                            <span class="category-pill category-pill--<?php echo e($pick['catColor']); ?>"><?php echo e($pick['cat']); ?></span>
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($pick['premium']): ?>
                            <div class="absolute top-4 right-4 z-10">
                                <span class="badge-premium">Premium</span>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <div class="p-6">
                        <h3 class="font-display text-xl font-bold text-onion leading-snug mb-3 group-hover:text-orange transition-colors duration-300">
                            <?php echo e($pick['title']); ?>

                        </h3>
                        <p class="font-body text-secondary text-sm leading-relaxed mb-4"><?php echo e($pick['excerpt']); ?></p>
                        <div class="flex items-center gap-3 font-ui text-xs text-muted">
                            <span><?php echo e($pick['author']); ?></span>
                            <span class="w-1 h-1 rounded-full bg-silver"></span>
                            <span><?php echo e($pick['time']); ?> read</span>
                        </div>
                    </div>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
</section>



<section class="py-12 bg-pearl">
    <div class="container-blossom">
        <div class="flex items-center gap-3 mb-8 reveal">
            <div class="w-2 h-2 rounded-full bg-orange animate-pulse"></div>
            <span class="font-ui text-xs font-bold tracking-[0.15em] uppercase text-orange">Trending</span>
        </div>

        <div class="trending-strip flex gap-4 pb-4">
            <?php
                $trending = [
                    ['num' => '01', 'title' => 'Plateau State GDP Hits Record High', 'cat' => 'Business'],
                    ['num' => '02', 'title' => 'New Jos City Master Plan Unveiled', 'cat' => 'Government'],
                    ['num' => '03', 'title' => 'Nzem Berom Festival 2026 Dates Announced', 'cat' => 'Culture'],
                    ['num' => '04', 'title' => 'Top 10 Schools in Plateau State', 'cat' => 'Education'],
                    ['num' => '05', 'title' => 'Tourism Revenue Up 40% in Q2', 'cat' => 'Tourism'],
                ];
            ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $trending; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('articles.index')); ?>" class="trending-item">
                    <span class="trending-number"><?php echo e($item['num']); ?></span>
                    <div>
                        <span class="font-ui text-[10px] font-semibold tracking-wider uppercase text-onion"><?php echo e($item['cat']); ?></span>
                        <p class="font-ui text-sm font-medium text-ink leading-snug mt-0.5"><?php echo e($item['title']); ?></p>
                    </div>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
</section>



<section class="py-20 lg:py-28" x-data="{ activeTab: 'culture' }">
    <div class="container-blossom">
        <div class="section-header reveal">
            <span class="font-ui text-xs font-semibold tracking-[0.15em] uppercase text-muted block mb-3">Explore</span>
            <h2 class="section-title">
                <span class="section-title-accent">By Category</span>
            </h2>
        </div>

        
        <div class="flex gap-1 overflow-x-auto pb-4 mb-10 scrollbar-hide reveal">
            <?php
                $tabs = [
                    ['id' => 'culture', 'label' => 'Culture & Heritage'],
                    ['id' => 'politics', 'label' => 'Politics & Government'],
                    ['id' => 'business', 'label' => 'Business & Economy'],
                    ['id' => 'tourism', 'label' => 'Tourism & Lifestyle'],
                    ['id' => 'education', 'label' => 'Education & Youth'],
                ];
            ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $tabs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tab): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <button @click="activeTab = '<?php echo e($tab['id']); ?>'"
                        class="px-5 py-2.5 rounded-full font-ui text-sm font-medium whitespace-nowrap transition-all duration-300"
                        :class="activeTab === '<?php echo e($tab['id']); ?>' ? 'bg-onion text-white shadow-onion' : 'bg-white text-graphite hover:text-onion border border-silver'">
                    <?php echo e($tab['label']); ?>

                </button>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <div class="lg:col-span-7 reveal-left">
                <article class="article-card group cursor-pointer h-full">
                    <div class="article-card-image aspect-[16/10]">
                        <img src="https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?w=1200&q=80"
                             alt="Featured article" class="w-full h-full object-cover" loading="lazy">
                        <div class="absolute bottom-0 left-0 right-0 p-8 bg-gradient-to-t from-black/80 to-transparent">
                            <span class="category-pill category-pill--green mb-3 inline-block">Culture</span>
                            <h3 class="font-display text-2xl md:text-3xl font-bold text-white leading-snug mb-3">
                                The Nzem Berom Festival: Where Drums Speak the Language of Ancestors
                            </h3>
                            <p class="font-body text-white/70 text-sm max-w-lg">
                                Every year, the Berom people gather to celebrate centuries of tradition through music, dance, and storytelling.
                            </p>
                        </div>
                    </div>
                </article>
            </div>

            
            <div class="lg:col-span-5 flex flex-col gap-4 reveal-right">
                <?php
                    $sideArticles = [
                        ['slug' => 'how-plateaus-youth-are-redefining-nigerian-music', 'title' => 'How Plateau\'s Youth Are Redefining Nigerian Music', 'cat' => 'Entertainment', 'time' => '5 min', 'img' => 'https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?w=400&q=80'],
                        ['slug' => 'the-rise-of-agritech-in-plateau-state', 'title' => 'The Rise of Agritech in Plateau State', 'cat' => 'Business', 'time' => '7 min', 'img' => 'https://images.unsplash.com/photo-1574943320219-553eb213f72d?w=400&q=80'],
                        ['slug' => 'jos-museum-a-journey-through-time', 'title' => 'Jos Museum: A Journey Through Time', 'cat' => 'Tourism', 'time' => '4 min', 'img' => 'https://images.unsplash.com/photo-1554907984-15263bfd63bd?w=400&q=80'],
                    ];
                ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $sideArticles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('articles.show', $article['slug'])); ?>" class="flex gap-4 p-4 rounded-xl bg-white border border-silver hover:border-onion hover:shadow-md transition-all duration-300 group">
                        <img src="<?php echo e($article['img']); ?>" alt="" class="w-20 h-20 rounded-lg object-cover flex-shrink-0" loading="lazy">
                        <div class="flex flex-col justify-center min-w-0">
                            <span class="font-ui text-[10px] font-semibold tracking-wider uppercase text-onion"><?php echo e($article['cat']); ?></span>
                            <h4 class="font-display text-sm font-bold text-ink leading-snug mt-1 group-hover:text-orange transition-colors line-clamp-2">
                                <?php echo e($article['title']); ?>

                            </h4>
                            <span class="font-ui text-xs text-muted mt-1"><?php echo e($article['time']); ?> read</span>
                        </div>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </div>
</section>



<section class="py-20">
    <div class="container-blossom">
        <div class="newsletter-cta p-10 md:p-16 text-center relative z-10 reveal-scale">
            <h2 class="font-display text-3xl md:text-4xl font-bold text-white mb-4">
                Stay Connected to Plateau
            </h2>
            <p class="font-body text-white/60 text-lg mb-8 max-w-lg mx-auto">
                Get the best stories, news, and insights from BLOSSOM delivered to your inbox every week.
            </p>

            <div class="max-w-md mx-auto">
                <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('newsletter-subscribe', []);

$__key = null;

$__key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-2986318937-0', $__key);

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

            <p class="font-ui text-xs text-white/30 mt-4">No spam. Unsubscribe anytime. Join 2,000+ readers.</p>
        </div>
    </div>
</section>



<section class="py-20 lg:py-28 bg-pearl">
    <div class="container-blossom">
        <div class="flex items-end justify-between mb-10">
            <div class="section-header reveal">
                <span class="font-ui text-xs font-semibold tracking-[0.15em] uppercase text-muted block mb-3">Directory</span>
                <h2 class="section-title">
                    <span class="section-title-accent">Plateau's Finest</span>
                </h2>
            </div>
            <a href="<?php echo e(route('listings.index')); ?>" class="hidden md:flex items-center gap-2 font-ui text-sm font-medium text-onion hover:text-orange transition-colors">
                View All
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                </svg>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 stagger-children">
            <?php
                $listings = [
                    ['slug' => 'jos-business-hub', 'name' => 'Jos Business Hub', 'type' => 'Business', 'img' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=400&q=80', 'featured' => true],
                    ['slug' => 'prof-david-danladi', 'name' => 'Prof. David Danladi', 'type' => 'Personality', 'img' => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?w=400&q=80', 'featured' => true],
                    ['slug' => 'university-of-jos', 'name' => 'University of Jos', 'type' => 'Institution', 'img' => 'https://images.unsplash.com/photo-1562774053-701939374585?w=400&q=80', 'featured' => false],
                    ['slug' => 'plateau-tourism-board', 'name' => 'Plateau Tourism Board', 'type' => 'Government', 'img' => 'https://images.unsplash.com/photo-1497366216548-37526070297c?w=400&q=80', 'featured' => false],
                ];
            ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $listings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $listing): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('listings.show', $listing['slug'])); ?>" class="listing-card <?php echo e($listing['featured'] ? 'listing-card--featured' : ''); ?> group">
                    <div class="aspect-[4/3] overflow-hidden">
                        <img src="<?php echo e($listing['img']); ?>" alt="<?php echo e($listing['name']); ?>"
                             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" loading="lazy">
                    </div>
                    <div class="p-5">
                        <span class="font-ui text-[10px] font-semibold tracking-wider uppercase text-onion"><?php echo e($listing['type']); ?></span>
                        <h3 class="font-display text-lg font-bold text-ink mt-1 group-hover:text-orange transition-colors"><?php echo e($listing['name']); ?></h3>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($listing['featured']): ?>
                            <div class="flex items-center gap-1 mt-2">
                                <svg class="w-3 h-3 text-gold" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <span class="font-ui text-[10px] font-semibold text-gold">Featured</span>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
</section>



<section class="py-20 lg:py-28">
    <div class="container-blossom">
        <div class="flex items-end justify-between mb-10">
            <div class="section-header reveal">
                <span class="font-ui text-xs font-semibold tracking-[0.15em] uppercase text-muted block mb-3">Happening soon</span>
                <h2 class="section-title">
                    <span class="section-title-accent">What's On</span>
                </h2>
            </div>
            <a href="<?php echo e(route('events.index')); ?>" class="hidden md:flex items-center gap-2 font-ui text-sm font-medium text-sean hover:text-sean-dark transition-colors">
                View All Events
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                </svg>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 stagger-children">
            <?php
                $events = [
                    ['slug' => 'nzem-berom-cultural-festival-2026', 'month' => 'SEP', 'day' => '15', 'title' => 'Nzem Berom Cultural Festival 2026', 'location' => 'Ryom, Plateau State', 'type' => 'Festival'],
                    ['slug' => 'plateau-tech-summit-2026', 'month' => 'SEP', 'day' => '22', 'title' => 'Plateau Tech Summit', 'location' => 'Jos Business Hub', 'type' => 'Conference'],
                    ['slug' => 'plateau-state-art-exhibition', 'month' => 'OCT', 'day' => '05', 'title' => 'Plateau State Art Exhibition', 'location' => 'Jos Museum', 'type' => 'Exhibition'],
                ];
            ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('events.show', $event['slug'])); ?>" class="event-card group">
                    <div class="event-date-badge">
                        <span class="month"><?php echo e($event['month']); ?></span>
                        <span class="day"><?php echo e($event['day']); ?></span>
                    </div>
                    <div class="flex flex-col justify-center min-w-0">
                        <span class="font-ui text-[10px] font-semibold tracking-wider uppercase text-sean"><?php echo e($event['type']); ?></span>
                        <h3 class="font-display text-base font-bold text-ink leading-snug mt-1 group-hover:text-sean transition-colors line-clamp-2">
                            <?php echo e($event['title']); ?>

                        </h3>
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



<section class="py-20 lg:py-28 bg-ink relative overflow-hidden">
    
    <div class="absolute top-0 right-0 w-96 h-96 rounded-full bg-onion/5 blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 w-72 h-72 rounded-full bg-orange/5 blur-3xl pointer-events-none"></div>

    <div class="container-blossom relative z-10">
        <div class="text-center max-w-2xl mx-auto mb-16 reveal">
            <span class="font-ui text-xs font-semibold tracking-[0.15em] uppercase text-orange block mb-4">Premium Access</span>
            <h2 class="font-display text-3xl md:text-5xl font-bold text-white mb-6 leading-tight">
                Unlock Plateau's Full Story
            </h2>
            <p class="font-body text-white/50 text-lg">
                Get unlimited access to premium articles, exclusive interviews, in-depth reports, and the complete BLOSSOM archive.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-4xl mx-auto stagger-children">
            
            <div class="pricing-card text-center">
                <span class="font-ui text-xs font-semibold tracking-wider uppercase text-muted">Reader</span>
                <div class="mt-4 mb-6">
                    <span class="font-display text-4xl font-bold text-ink">Free</span>
                </div>
                <ul class="space-y-3 text-left mb-8">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = ['5 articles per month', 'Basic event listings', 'Newsletter access', 'Community (read-only)']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="flex items-start gap-2 font-ui text-sm text-secondary">
                            <svg class="w-4 h-4 text-sean mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                            </svg>
                            <?php echo e($feature); ?>

                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </ul>
                <a href="<?php echo e(route('login')); ?>" class="btn-ghost w-full">Get Started</a>
            </div>

            
            <div class="pricing-card pricing-card--featured text-center">
                <span class="font-ui text-xs font-semibold tracking-wider uppercase text-orange-light">Insider</span>
                <div class="mt-4 mb-6">
                    <span class="font-display text-4xl font-bold text-white">₦2,500</span>
                    <span class="font-ui text-sm text-white/50">/month</span>
                </div>
                <ul class="space-y-3 text-left mb-8">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = ['Unlimited articles', 'Full premium content', 'Community access', 'Event early access', 'Ad-free experience']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="flex items-start gap-2 font-ui text-sm text-white/80">
                            <svg class="w-4 h-4 text-orange mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                            </svg>
                            <?php echo e($feature); ?>

                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </ul>
                <a href="<?php echo e(route('pricing')); ?>" class="btn-primary w-full">Subscribe Now</a>
            </div>

            
            <div class="pricing-card text-center">
                <span class="font-ui text-xs font-semibold tracking-wider uppercase text-muted">Patron</span>
                <div class="mt-4 mb-6">
                    <span class="font-display text-4xl font-bold text-ink">₦20,000</span>
                    <span class="font-ui text-sm text-muted">/year</span>
                </div>
                <ul class="space-y-3 text-left mb-8">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = ['Everything in Insider', 'Priority event tickets', '1 free listing/year', 'Patron badge', 'Editorial access']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="flex items-start gap-2 font-ui text-sm text-secondary">
                            <svg class="w-4 h-4 text-gold mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                            </svg>
                            <?php echo e($feature); ?>

                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </ul>
                <a href="<?php echo e(route('pricing')); ?>" class="btn-ghost w-full">Become a Patron</a>
            </div>
        </div>
    </div>
</section>



<section class="py-16 border-t border-b border-silver bg-snow">
    <div class="container-blossom">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center stagger-children">
            <?php
                $stats = [
                    ['value' => '500+', 'label' => 'Articles Published'],
                    ['value' => '50K', 'label' => 'Monthly Readers'],
                    ['value' => '200+', 'label' => 'Featured Personalities'],
                    ['value' => '12', 'label' => 'Content Categories'],
                ];
            ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $stats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div>
                    <div class="font-display text-3xl md:text-4xl font-bold text-onion"><?php echo e($stat['value']); ?></div>
                    <div class="font-ui text-sm text-muted mt-1"><?php echo e($stat['label']); ?></div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\WebWorka\codeworkflow\blossom\resources\views/pages/home.blade.php ENDPATH**/ ?>