<?php $__env->startSection('title', 'Terms of Service'); ?>
<?php $__env->startSection('metaDescription', 'The terms of service governing your use of the BLOSSOM magazine website and services.'); ?>

<?php $__env->startSection('content'); ?>

<section class="pt-32 pb-12 bg-pearl">
    <div class="container-blossom">
        <nav class="font-ui text-xs text-muted mb-6">
            <a href="<?php echo e(route('home')); ?>" class="hover:text-onion transition-colors">Home</a>
            <span class="mx-2">/</span>
            <span class="text-graphite">Terms of Service</span>
        </nav>
        <span class="font-ui text-xs font-semibold tracking-[0.15em] uppercase text-onion block mb-3">Legal</span>
        <h1 class="font-display text-4xl md:text-5xl font-bold text-onion leading-tight mb-4">Terms of Service</h1>
        <p class="font-body text-secondary text-lg">Last updated: August 2026</p>
    </div>
</section>

<section class="py-12 lg:py-16">
    <div class="container-blossom max-w-3xl">
        <div class="font-body text-lg text-primary leading-[1.8] space-y-8">
            <div>
                <h2 class="font-display text-2xl font-bold text-ink mb-3">1. Agreement to Terms</h2>
                <p>These Terms of Service govern your access to and use of the BLOSSOM website and services, operated by Emerald Colours Nigeria Limited. By accessing the site, you agree to be bound by these terms.</p>
            </div>
            <div>
                <h2 class="font-display text-2xl font-bold text-ink mb-3">2. Accounts</h2>
                <p>To access certain features — including the community, dashboard, and premium content — you must register for an account. You are responsible for safeguarding your credentials and for all activity under your account.</p>
            </div>
            <div>
                <h2 class="font-display text-2xl font-bold text-ink mb-3">3. Subscriptions & Payments</h2>
                <p>Premium subscriptions grant access to full content and exclusive benefits. Payments are processed securely through licensed payment providers. Subscriptions renew according to the plan selected and can be cancelled at any time.</p>
            </div>
            <div>
                <h2 class="font-display text-2xl font-bold text-ink mb-3">4. Content & Intellectual Property</h2>
                <p>All editorial content, branding, and materials on BLOSSOM are the property of Emerald Colours Nigeria Limited or its licensors. You may not reproduce or redistribute content without prior written permission.</p>
            </div>
            <div>
                <h2 class="font-display text-2xl font-bold text-ink mb-3">5. Community Conduct</h2>
                <p>We are committed to a respectful community. Posting content that is unlawful, defamatory, hateful, or infringing is prohibited. We reserve the right to remove content and suspend accounts that violate these standards.</p>
            </div>
            <div>
                <h2 class="font-display text-2xl font-bold text-ink mb-3">6. Limitation of Liability</h2>
                <p>To the fullest extent permitted by law, BLOSSOM shall not be liable for any indirect, incidental, or consequential damages arising from your use of the service.</p>
            </div>
            <div>
                <h2 class="font-display text-2xl font-bold text-ink mb-3">7. Contact</h2>
                <p>Questions about these terms can be directed to our team via the <a href="<?php echo e(route('contact')); ?>" class="text-onion font-semibold hover:text-orange transition-colors">contact page</a>.</p>
            </div>
        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\WebWorka\codeworkflow\blossom\resources\views/pages/legal/terms.blade.php ENDPATH**/ ?>