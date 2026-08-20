
<nav class="fixed top-0 left-0 right-0 z-[200] transition-all duration-500"
     x-data="{ scrolled: false, searchOpen: false }"
     x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 50 })"
     :class="scrolled ? 'nav-scrolled' : 'nav-transparent'">

    
    <div class="absolute inset-0 transition-all duration-500"
         :class="scrolled ? 'bg-ink/95 backdrop-blur-xl shadow-lg' : 'bg-gradient-to-b from-black/60 via-black/30 to-transparent'">
    </div>

    <div class="relative max-w-[1440px] mx-auto px-6 lg:px-12">
        <div class="flex items-center justify-between h-[72px]">

            
            <a href="<?php echo e(route('home')); ?>" class="flex items-center gap-3 group">
                <div class="relative">
                    <img src="<?php echo e(asset('assets/blossom-logo.png')); ?>" alt="BLOSSOM Logo" class="w-10 h-10 object-contain transition-transform duration-500 group-hover:scale-110">
                </div>
                <div class="hidden sm:block">
                    <div class="font-display text-white text-xl font-bold tracking-wider leading-none"><?php echo e(setting('site.site.name', 'BLOSSOM')); ?></div>
                    <div class="font-ui text-[10px] tracking-[0.25em] uppercase mt-0.5"
                         :class="scrolled ? 'text-ash' : 'text-white/60'"><?php echo e(setting('site.site.tagline', "Plateau's Prestige")); ?></div>
                </div>
            </a>

            
            <div class="hidden lg:flex items-center gap-8">
                <?php
                    $navItems = [
                        ['label' => 'Blog', 'route' => 'articles.index'],
                        ['label' => 'Events', 'route' => 'events.index'],
                        ['label' => 'Listings', 'route' => 'listings.index'],
                        ['label' => 'Community', 'route' => 'community.index'],
                    ];
                ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $navItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route($item['route'])); ?>"
                       class="font-ui text-sm font-medium tracking-wide transition-all duration-300 relative group
                              <?php echo e(request()->routeIs($item['route']) ? 'text-orange' : 'text-white/80 hover:text-white'); ?>">
                        <?php echo e($item['label']); ?>

                        <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-orange transition-all duration-300 group-hover:w-full"
                              <?php echo e(request()->routeIs($item['route']) ? 'style="width: 100%"' : ''); ?>></span>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            
            <div class="flex items-center gap-4">

                
                <button @click="searchOpen = !searchOpen"
                        class="w-10 h-10 rounded-full flex items-center justify-center text-white/70 hover:text-white hover:bg-white/10 transition-all duration-300"
                        aria-label="Search">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                    </svg>
                </button>

                
                <button @click="$dispatch('open-newsletter-modal')"
                        class="hidden md:flex items-center gap-2 px-4 py-2 rounded-full border border-white/20 text-white/80 hover:text-white hover:border-orange hover:bg-orange/10 transition-all duration-300 font-ui text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                    </svg>
                    <span>Newsletter</span>
                </button>

                
                <a href="<?php echo e(route('pricing')); ?>"
                   class="hidden sm:flex items-center gap-2 px-5 py-2.5 rounded-full bg-orange text-white font-ui text-sm font-semibold
                          hover:bg-orange-600 transition-all duration-300 hover:shadow-lg hover:shadow-orange/25 hover:-translate-y-0.5">
                    Subscribe
                </a>

                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(route('dashboard')); ?>"
                       class="w-9 h-9 rounded-full bg-onion/20 border border-onion/30 flex items-center justify-center text-white font-ui text-sm font-semibold hover:bg-onion/30 transition-all duration-300">
                        <?php echo e(substr(Auth::user()->first_name, 0, 1)); ?>

                    </a>
                <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>"
                       class="hidden sm:block font-ui text-sm text-white/70 hover:text-white transition-colors duration-300">
                        Sign In
                    </a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                
                <button @click="mobileMenuOpen = !mobileMenuOpen"
                        class="lg:hidden w-10 h-10 rounded-full flex items-center justify-center text-white/70 hover:text-white hover:bg-white/10 transition-all duration-300"
                        aria-label="Menu">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"
                         x-show="!mobileMenuOpen">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9h16.5m-16.5 6.75h16.5"/>
                    </svg>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"
                         x-show="mobileMenuOpen" x-cloak>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    
    <div x-show="searchOpen" x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-4"
         class="absolute top-full left-0 right-0 bg-ink/98 backdrop-blur-2xl border-t border-white/5 shadow-2xl"
         @click.outside="searchOpen = false">
        <div class="max-w-[800px] mx-auto px-6 py-8">
            <div class="relative">
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-6 h-6 text-ash" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                </svg>
                <input type="text" placeholder="Search articles, events, listings..."
                       class="w-full bg-white/5 border border-white/10 rounded-xl pl-12 pr-4 py-4 text-white font-ui text-lg placeholder:text-ash focus:outline-none focus:border-onion focus:ring-2 focus:ring-onion/20 transition-all duration-300"
                       x-ref="searchInput"
                       x-init="$watch('searchOpen', value => { if(value) setTimeout(() => $refs.searchInput.focus(), 100) })">
                <kbd class="absolute right-4 top-1/2 -translate-y-1/2 px-2 py-1 rounded bg-white/10 text-ash text-xs font-ui">ESC</kbd>
            </div>
        </div>
    </div>

    
    <div x-show="mobileMenuOpen" x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="lg:hidden fixed inset-0 top-[72px] bg-ink/98 backdrop-blur-2xl z-[100]">
        <div class="flex flex-col items-center justify-center h-full gap-8 -mt-[72px]">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $navItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route($item['route'])); ?>"
                   class="font-display text-3xl text-white/80 hover:text-orange transition-colors duration-300"
                   @click="mobileMenuOpen = false">
                    <?php echo e($item['label']); ?>

                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <div class="flex flex-col items-center gap-4 mt-8">
                <a href="<?php echo e(route('pricing')); ?>"
                   class="px-8 py-3 rounded-full bg-orange text-white font-ui font-semibold hover:bg-orange-600 transition-all duration-300"
                   @click="mobileMenuOpen = false">
                    Subscribe Now
                </a>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->guest()): ?>
                    <a href="<?php echo e(route('login')); ?>"
                       class="font-ui text-white/60 hover:text-white transition-colors"
                       @click="mobileMenuOpen = false">
                        Sign In
                    </a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </div>
</nav>
<?php /**PATH C:\WebWorka\codeworkflow\blossom\resources\views/layouts/components/nav.blade.php ENDPATH**/ ?>