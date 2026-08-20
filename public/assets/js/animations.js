/* BLOSSOM — Cinematic Animations (GSAP + ScrollTrigger) */
document.addEventListener('DOMContentLoaded', () => {
  gsap.registerPlugin(ScrollTrigger);

  /* Preloader */
  const preloaderTl = gsap.timeline({
    onComplete: () => {
      document.getElementById('preloader').classList.add('loaded');
      document.getElementById('main-content').style.opacity = '1';
      animateHero();
    }
  });
  preloaderTl
    .to('#preloader-logo', { opacity: 1, y: 0, duration: 0.8, ease: 'power3.out' })
    .to('#preloader-tagline', { opacity: 1, y: 0, duration: 0.6, ease: 'power3.out' }, '-=0.3')
    .to('#preloader-line', { scaleX: 1, duration: 0.8, ease: 'power2.inOut' }, '-=0.2')
    .to({}, { duration: 0.4 });

  /* Hero reveal */
  function animateHero() {
    var hc = document.querySelector('.hero-content');
    if (!hc) return;
    gsap.timeline()
      .from('.hero-category-pill', { opacity: 0, y: 20, duration: 0.6, ease: 'power3.out' })
      .from('.hero-title', { opacity: 0, y: 40, duration: 0.8, ease: 'power3.out' }, '-=0.3')
      .from('.hero-deck', { opacity: 0, y: 30, duration: 0.6, ease: 'power3.out' }, '-=0.4')
      .from('.hero-meta', { opacity: 0, y: 20, duration: 0.5, ease: 'power3.out' }, '-=0.3')
      .from('.hero-cta', { opacity: 0, y: 20, duration: 0.5, ease: 'power3.out' }, '-=0.2');
  }

  /* Scroll reveal */
  var reveals = document.querySelectorAll('.reveal, .reveal-left, .reveal-right, .reveal-scale, .stagger-children');
  var observer = new IntersectionObserver(function(entries) {
    entries.forEach(function(entry) {
      if (entry.isIntersecting) {
        entry.target.classList.add('revealed');
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });
  reveals.forEach(function(el) { observer.observe(el); });

  /* Hero parallax */
  var heroImage = document.querySelector('.hero-image');
  if (heroImage) {
    gsap.to(heroImage, {
      yPercent: 20, ease: 'none',
      scrollTrigger: { trigger: '.hero-section', start: 'top top', end: 'bottom top', scrub: 1.5 }
    });
  }

  /* General parallax */
  document.querySelectorAll('.parallax-slow').forEach(function(el) {
    gsap.to(el, {
      yPercent: -15, ease: 'none',
      scrollTrigger: { trigger: el, start: 'top bottom', end: 'bottom top', scrub: 1 }
    });
  });

  /* Smooth counter animation */
  document.querySelectorAll('[data-count]').forEach(function(el) {
    var target = parseInt(el.getAttribute('data-count'));
    gsap.from(el, {
      textContent: 0, duration: 2, ease: 'power2.out', snap: { textContent: 1 },
      scrollTrigger: { trigger: el, start: 'top 85%', toggleActions: 'play none none none' },
      onUpdate: function() { el.textContent = Math.ceil(parseFloat(el.textContent)).toLocaleString(); }
    });
  });
});
