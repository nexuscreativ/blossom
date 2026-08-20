<?php $__env->startSection('title', 'Careers at BLOSSOM'); ?>
<?php $__env->startSection('metaDescription', 'Join the BLOSSOM team — we\'re hiring storytellers, designers, and builders who love Plateau State.'); ?>

<?php $__env->startSection('content'); ?>


<section class="relative pt-32 pb-20 bg-ink overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-sean/20 via-transparent to-onion/10 pointer-events-none"></div>
    <div class="container-blossom relative z-10 text-center">
        <span class="font-ui text-xs font-semibold tracking-[0.15em] uppercase text-orange block mb-4">Join Our Team</span>
        <h1 class="font-display text-4xl md:text-5xl lg:text-6xl font-bold text-white leading-tight mb-6">
            Do Work That <span class="text-gradient-orange">Matters</span>
        </h1>
        <p class="font-body text-lg text-white/50 max-w-2xl mx-auto">
            We're building the definitive platform for Plateau's stories. If you share our passion, we want to hear from you.
        </p>
    </div>
</section>


<section class="py-16 lg:py-24">
    <div class="container-blossom">
        <div class="section-header reveal">
            <h2 class="section-title"><span class="section-title-accent">Why Work With Us</span></h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-12 stagger-children">
            <?php
                $perks = [
                    ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>', 'title' => 'Purpose-Driven', 'desc' => 'Every story we publish celebrates a place and people we love. Your work has meaning beyond the bottom line.'],
                    ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5"/>', 'title' => 'Grow With Us', 'desc' => 'We invest in our team — training, mentorship, and real ownership over projects from day one.'],
                    ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M6.115 5.19l.319 1.913A6.75 6.75 0 008.11 10.36L9.75 12l-.387.775c-.217.433-.132.956.21 1.298l1.348 1.348c.21.21.329.497.329.795v1.089c0 .426.24.815.622 1.006l.153.076c.433.217.956.132 1.298-.21l.723-.723a8.7 8.7 0 002.288-4.042 1.087 1.087 0 00-.358-1.099l-1.33-1.108c-.251-.21-.582-.299-.905-.245l-1.17.195a1.125 1.125 0 01-.98-.314l-.295-.295a1.125 1.125 0 010-1.591l.13-.132a1.125 1.125 0 011.445-.194l.02.013c.19.125.437.17.665.117l1.41-.322a2.25 2.25 0 001.488-2.025l.035-.24c.032-.22.104-.43.21-.624l.256-.47a6.75 6.75 0 00-5.1-3.07l-1.207-.24a1.125 1.125 0 00-1.2.441l-.306.459c-.178.268-.3.568-.351.878l-.106.64a2.25 2.25 0 01-1.55 1.85l-1.294.368a2.25 2.25 0 01-2.138-.44l-.73-.56a1.125 1.125 0 00-1.226-.063l-.294.164a2.25 2.25 0 01-2.09.064l-.606-.303A6.75 6.75 0 006.115 5.19z"/>', 'title' => 'Remote & Flexible', 'desc' => 'Work from Jos, Lagos, or anywhere in the world. We care about output and impact, not clocking in.'],
                ];
            ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $perks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $perk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bg-white rounded-2xl p-8 border border-silver hover:shadow-lg hover:shadow-sean/5 transition-all duration-500 text-center">
                    <div class="w-14 h-14 mx-auto rounded-xl bg-sean/5 border border-sean/10 flex items-center justify-center mb-5">
                        <svg class="w-6 h-6 text-sean" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><?php echo $perk['icon']; ?></svg>
                    </div>
                    <h3 class="font-display text-xl font-bold text-ink mb-3"><?php echo e($perk['title']); ?></h3>
                    <p class="font-body text-sm text-secondary leading-relaxed"><?php echo e($perk['desc']); ?></p>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
</section>


<section class="py-16 bg-pearl">
    <div class="container-blossom">
        <div class="section-header reveal">
            <h2 class="section-title"><span class="section-title-accent">Open Roles</span></h2>
        </div>
        <div class="mt-12 space-y-4 max-w-3xl mx-auto stagger-children">
            <?php
                $roles = [
                    ['title' => 'Features Writer (Plateau-based)', 'type' => 'Freelance / Remote'],
                    ['title' => 'Multimedia Designer', 'type' => 'Full-time · Jos'],
                    ['title' => 'Community Manager', 'type' => 'Full-time · Remote'],
                    ['title' => 'Advertising Partnerships Lead', 'type' => 'Full-time · Remote'],
                ];
            ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bg-white rounded-2xl p-6 border border-silver flex items-center justify-between gap-6 hover:shadow-lg hover:shadow-onion/5 transition-all duration-500">
                    <div>
                        <h3 class="font-display text-lg font-bold text-ink"><?php echo e($role['title']); ?></h3>
                        <span class="font-ui text-xs text-muted uppercase tracking-wider"><?php echo e($role['type']); ?></span>
                    </div>
                    <a href="<?php echo e(route('contact')); ?>" class="btn-ghost w-full !w-auto !px-6 !py-2.5 !min-h-0">Apply Now</a>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
        <p class="text-center mt-10 font-body text-secondary max-w-xl mx-auto">
            Don't see a role that fits? We're always open to exceptional people. Send your CV and portfolio to
            <a href="mailto:careers@blossom.ng" class="text-onion font-semibold hover:text-orange transition-colors">careers@blossom.ng</a>.
        </p>
    </div>
</section>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\WebWorka\codeworkflow\blossom\resources\views/pages/careers/index.blade.php ENDPATH**/ ?>