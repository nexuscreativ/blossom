<?php $__env->startSection('title', 'Cookie Policy'); ?>
<?php $__env->startSection('metaDescription', 'How BLOSSOM uses cookies to keep you signed in, remember preferences, and understand how the site is used.'); ?>

<?php $__env->startSection('content'); ?>

<section class="pt-32 pb-12 bg-pearl">
    <div class="container-blossom">
        <nav class="font-ui text-xs text-muted mb-6">
            <a href="<?php echo e(route('home')); ?>" class="hover:text-onion transition-colors">Home</a>
            <span class="mx-2">/</span>
            <span class="text-graphite">Cookie Policy</span>
        </nav>
        <span class="font-ui text-xs font-semibold tracking-[0.15em] uppercase text-onion block mb-3">Legal</span>
        <h1 class="font-display text-4xl md:text-5xl font-bold text-onion leading-tight mb-4">Cookie Policy</h1>
        <p class="font-body text-secondary text-lg">Last updated: August 2026</p>
    </div>
</section>

<section class="py-12 lg:py-16">
    <div class="container-blossom max-w-3xl">
        <div class="font-body text-lg text-primary leading-[1.8] space-y-8">
            <div>
                <h2 class="font-display text-2xl font-bold text-ink mb-3">1. What Are Cookies?</h2>
                <p>Cookies are small text files stored on your device when you visit a website. They help websites remember your actions and preferences over time, so you don't have to re-enter them on every visit.</p>
            </div>
            <div>
                <h2 class="font-display text-2xl font-bold text-ink mb-3">2. How We Use Cookies</h2>
                <p>We use cookies to keep you signed in to your account, remember your theme and reading preferences, and understand how readers engage with our articles so we can improve the platform.</p>
            </div>
            <div>
                <h2 class="font-display text-2xl font-bold text-ink mb-3">3. Types of Cookies We Use</h2>
                <p><strong class="text-ink">Essential cookies</strong> are required for the site to function — including session management and security. <strong class="text-ink">Preference cookies</strong> remember choices such as your light/dark theme. <strong class="text-ink">Analytics cookies</strong> help us measure traffic and understand which stories resonate.</p>
            </div>
            <div>
                <h2 class="font-display text-2xl font-bold text-ink mb-3">4. Third-Party Cookies</h2>
                <p>Our payment providers and analytics tools may set their own cookies when you interact with their services. We do not control these cookies, and we encourage you to review their policies.</p>
            </div>
            <div>
                <h2 class="font-display text-2xl font-bold text-ink mb-3">5. Managing Cookies</h2>
                <p>You can control or delete cookies through your browser settings at any time. Please note that disabling essential cookies may affect how the site functions.</p>
            </div>
            <div>
                <h2 class="font-display text-2xl font-bold text-ink mb-3">6. Contact</h2>
                <p>Questions about this cookie policy can be directed to our team via the <a href="<?php echo e(route('contact')); ?>" class="text-onion font-semibold hover:text-orange transition-colors">contact page</a>.</p>
            </div>
        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\WebWorka\codeworkflow\blossom\resources\views/pages/legal/cookies.blade.php ENDPATH**/ ?>