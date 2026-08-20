<?php $__env->startSection('title', 'Privacy Policy'); ?>
<?php $__env->startSection('metaDescription', 'How BLOSSOM collects, uses, and protects your personal information.'); ?>

<?php $__env->startSection('content'); ?>

<section class="pt-32 pb-12 bg-pearl">
    <div class="container-blossom">
        <nav class="font-ui text-xs text-muted mb-6">
            <a href="<?php echo e(route('home')); ?>" class="hover:text-onion transition-colors">Home</a>
            <span class="mx-2">/</span>
            <span class="text-graphite">Privacy Policy</span>
        </nav>
        <span class="font-ui text-xs font-semibold tracking-[0.15em] uppercase text-onion block mb-3">Legal</span>
        <h1 class="font-display text-4xl md:text-5xl font-bold text-onion leading-tight mb-4">Privacy Policy</h1>
        <p class="font-body text-secondary text-lg">Last updated: August 2026</p>
    </div>
</section>

<section class="py-12 lg:py-16">
    <div class="container-blossom max-w-3xl">
        <div class="font-body text-lg text-primary leading-[1.8] space-y-8">
            <div>
                <h2 class="font-display text-2xl font-bold text-ink mb-3">1. Information We Collect</h2>
                <p>We collect information you provide directly — such as your name, email address, and profile details when you register, subscribe, or contact us — as well as standard usage data to improve your experience.</p>
            </div>
            <div>
                <h2 class="font-display text-2xl font-bold text-ink mb-3">2. How We Use Your Information</h2>
                <p>Your information is used to deliver our services: personalising content, processing subscriptions and payments, sending newsletters (with your consent), and communicating about your account.</p>
            </div>
            <div>
                <h2 class="font-display text-2xl font-bold text-ink mb-3">3. Payment Data</h2>
                <p>Payments are processed by licensed third-party providers (e.g., Paystack, Monnify, Nomba). We do not store full card details on our servers.</p>
            </div>
            <div>
                <h2 class="font-display text-2xl font-bold text-ink mb-3">4. Cookies & Analytics</h2>
                <p>We use cookies to keep you signed in, remember preferences, and understand how the site is used. You can control cookies through your browser settings.</p>
            </div>
            <div>
                <h2 class="font-display text-2xl font-bold text-ink mb-3">5. Data Sharing</h2>
                <p>We do not sell your personal information. We share data only with service providers who help us operate the platform, and where required by law.</p>
            </div>
            <div>
                <h2 class="font-display text-2xl font-bold text-ink mb-3">6. Your Rights</h2>
                <p>You may access, correct, or delete your personal data at any time, and you can unsubscribe from communications with one click.</p>
            </div>
            <div>
                <h2 class="font-display text-2xl font-bold text-ink mb-3">7. Contact</h2>
                <p>For any privacy questions, reach our team via the <a href="<?php echo e(route('contact')); ?>" class="text-onion font-semibold hover:text-orange transition-colors">contact page</a>.</p>
            </div>
        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\WebWorka\codeworkflow\blossom\resources\views/pages/legal/privacy.blade.php ENDPATH**/ ?>