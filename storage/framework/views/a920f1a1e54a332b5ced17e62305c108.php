<?php
    $siteName = setting('site.site.name', 'BLOSSOM');
    $siteTagline = setting('site.site.tagline', "Plateau's Prestige Magazine");
    $siteDescription = setting('seo.seo.default_description', 'Celebrating the people, culture, heritage, and achievements of Plateau State.');
    $gaId = setting('seo.seo.google_analytics_id', '');
    $twitterHandle = setting('seo.seo.twitter_handle', '@blossom_mag');
?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo $__env->yieldContent('metaDescription', $siteDescription); ?>">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="<?php echo e($twitterHandle); ?>">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta property="og:site_name" content="<?php echo e($siteName); ?>">
    <meta property="og:type" content="website">
    <title><?php echo $__env->yieldContent('title', $siteName); ?> — <?php echo e($siteTagline); ?></title>

    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700&family=Source+Serif+4:ital,opsz,wght@0,8..60,300;0,8..60,400;0,8..60,500;0,8..60,600;0,8..60,700;1,8..60,400;1,8..60,500&family=Inter:wght@300;400;500;600;700&family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400;1,500&display=swap" rel="stylesheet">

    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js"></script>

    
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/blossom.css')); ?>">

    
    <link rel="icon" type="image/png" href="<?php echo e(asset('assets/blossom-logo.png')); ?>">

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($gaId): ?>
        
        <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo e($gaId); ?>"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '<?php echo e($gaId); ?>');
        </script>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</head>
<body class="font-body bg-page text-primary antialiased" x-data="{ mobileMenuOpen: false, theme: localStorage.getItem('theme') || 'light' }" :data-theme="theme">

    
    <div id="preloader" class="fixed inset-0 z-[9999] flex items-center justify-center bg-ink transition-opacity duration-700">
        <div class="text-center">
            <div class="preloader-logo mb-4 opacity-0" id="preloader-logo">
                <img src="<?php echo e(asset('assets/blossom-logo.png')); ?>" alt="BLOSSOM Logo" class="h-20 w-auto object-contain mx-auto">
            </div>
            <div class="preloader-tagline font-ui text-ash text-sm tracking-[0.3em] uppercase opacity-0" id="preloader-tagline"><?php echo e($siteTagline); ?></div>
            <div class="preloader-line w-16 h-0.5 bg-orange mx-auto mt-6 origin-left scale-x-0" id="preloader-line"></div>
        </div>
    </div>

    
    <?php echo $__env->make('layouts.components.nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    
    <main id="main-content" class="opacity-0">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    
    <?php echo $__env->make('layouts.components.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    
    <?php echo $__env->make('layouts.components.newsletter-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    
    <?php echo $__env->make('layouts.components.chat-widget', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('theme', {
                init() {
                    this.theme = localStorage.getItem('theme') || 
                        (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
                    document.documentElement.setAttribute('data-theme', this.theme);
                },
                toggle() {
                    this.theme = this.theme === 'light' ? 'dark' : 'light';
                    localStorage.setItem('theme', this.theme);
                    document.documentElement.setAttribute('data-theme', this.theme);
                }
            });
        });
    </script>

    
    <script src="<?php echo e(asset('assets/js/animations.js')); ?>"></script>

    
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\WebWorka\codeworkflow\blossom\resources\views/layouts/app.blade.php ENDPATH**/ ?>