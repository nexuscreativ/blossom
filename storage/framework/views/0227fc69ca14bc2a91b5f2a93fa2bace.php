
<div x-data="{ open: false, email: '', submitted: false }"
     @open-newsletter-modal.window="open = true"
     x-show="open" x-cloak
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-[500] flex items-center justify-center p-4"
     @keydown.escape.window="open = false">

    
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="open = false"></div>

    
    <div x-show="open"
         x-transition:enter="transition ease-out duration-300 delay-100"
         x-transition:enter-start="opacity-0 scale-95 translate-y-4"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="relative w-full max-w-lg rounded-2xl overflow-hidden shadow-2xl"
         @click.outside="open = false">

        
        <div class="absolute inset-0 bg-gradient-to-br from-onion-deeper via-onion-dark to-ink"></div>
        <div class="absolute top-0 right-0 w-64 h-64 rounded-full bg-orange/10 blur-3xl pointer-events-none"></div>

        
        <div class="relative p-8 md:p-10 text-center">
            
            <button @click="open = false" class="absolute top-4 right-4 w-8 h-8 rounded-full bg-white/10 flex items-center justify-center text-white/60 hover:text-white hover:bg-white/20 transition-all duration-300">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            
            <div class="w-16 h-16 mx-auto mb-6 rounded-full bg-orange/10 border border-orange/20 flex items-center justify-center">
                <svg class="w-8 h-8 text-orange" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                </svg>
            </div>

            <h3 class="font-display text-2xl md:text-3xl font-bold text-white mb-3">
                <?php echo e(setting('featured.featured.cta_title', 'Stay Connected to Plateau')); ?>

            </h3>
            <p class="font-body text-white/50 text-sm mb-8 max-w-sm mx-auto">
                <?php echo e(setting('featured.featured.cta_subtitle', 'Get the best stories, news, and insights from BLOSSOM delivered to your inbox every week.')); ?>

            </p>

            
            <form @submit.prevent="submitted = true" x-show="!submitted">
                <div class="flex flex-col sm:flex-row items-center gap-3">
                    <input type="email" x-model="email" placeholder="Enter your email address" required
                           class="flex-1 w-full bg-white/10 border border-white/20 rounded-full px-6 py-3.5 text-white placeholder:text-white/40 font-ui text-sm focus:outline-none focus:border-orange focus:ring-2 focus:ring-orange/20 transition-all duration-300">
                    <button type="submit" class="btn-primary whitespace-nowrap w-full sm:w-auto">
                        Subscribe
                    </button>
                </div>
            </form>

            
            <div x-show="submitted" class="py-4">
                <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-sean/20 border border-sean/30 flex items-center justify-center">
                    <svg class="w-8 h-8 text-sean" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                    </svg>
                </div>
                <h4 class="font-display text-xl font-bold text-white mb-2">Welcome to BLOSSOM!</h4>
                <p class="font-ui text-sm text-white/50">Check your inbox to confirm your subscription.</p>
            </div>

            <p class="font-ui text-xs text-white/30 mt-6"><?php echo e(setting('newsletter.newsletter.count_text', 'No spam. Unsubscribe anytime.')); ?></p>
        </div>
    </div>
</div>
<?php /**PATH C:\WebWorka\codeworkflow\blossom\resources\views/layouts/components/newsletter-modal.blade.php ENDPATH**/ ?>