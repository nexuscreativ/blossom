<?php $__env->startSection('title', 'Accessibility'); ?>
<?php $__env->startSection('metaDescription', 'BLOSSOM is committed to making our content and services accessible to everyone, including people with disabilities.'); ?>

<?php $__env->startSection('content'); ?>

<section class="pt-32 pb-12 bg-pearl">
    <div class="container-blossom">
        <nav class="font-ui text-xs text-muted mb-6">
            <a href="<?php echo e(route('home')); ?>" class="hover:text-onion transition-colors">Home</a>
            <span class="mx-2">/</span>
            <span class="text-graphite">Accessibility</span>
        </nav>
        <span class="font-ui text-xs font-semibold tracking-[0.15em] uppercase text-onion block mb-3">Legal</span>
        <h1 class="font-display text-4xl md:text-5xl font-bold text-onion leading-tight mb-4">Accessibility</h1>
        <p class="font-body text-secondary text-lg">Last updated: August 2026</p>
    </div>
</section>

<section class="py-12 lg:py-16">
    <div class="container-blossom max-w-3xl">
        <div class="font-body text-lg text-primary leading-[1.8] space-y-8">
            <div>
                <h2 class="font-display text-2xl font-bold text-ink mb-3">Our Commitment</h2>
                <p>BLOSSOM is committed to ensuring our website is accessible to everyone, including people with disabilities. We strive to follow the Web Content Accessibility Guidelines (WCAG) 2.1 at Level AA as our standard.</p>
            </div>
            <div>
                <h2 class="font-display text-2xl font-bold text-ink mb-3">What We're Doing</h2>
                <p>We design with accessibility in mind from the start — including semantic HTML structure, keyboard-navigable interfaces, sufficient color contrast, and descriptive text alternatives for meaningful images.</p>
            </div>
            <div>
                <h2 class="font-display text-2xl font-bold text-ink mb-3">Feedback</h2>
                <p>We welcome your feedback. If you encounter an accessibility barrier on any page, please tell us — we will work to address it as quickly as possible.</p>
                <p class="mt-4">You can reach our accessibility team via the <a href="<?php echo e(route('contact')); ?>" class="text-onion font-semibold hover:text-orange transition-colors">contact page</a> or by email at <a href="mailto:accessibility@blossom.ng" class="text-onion font-semibold hover:text-orange transition-colors">accessibility@blossom.ng</a>.</p>
            </div>
        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\WebWorka\codeworkflow\blossom\resources\views/pages/accessibility/index.blade.php ENDPATH**/ ?>