/**
 * VACON DESIGN — Deep Architectural Graphite v4.0.9
 *
 * 1. Hero Slideshow — HOMEPAGE ONLY. CSS fade between 8 engineering photos, 5s interval.
 *    STRICT ORDER (hard-coded, index-locked — never re-sorted):
 *      [0] P1.jpg                  → P1 (homepage render)
 *      [1] ACCamera_81.jpg         → Hyatt Regency Kotor Bay Resort
 *      [2] 03.jpg                  → Luštica Bay – Upper Village
 *      [3] UKLOPLJENI-KONACNI-2    → Master Kvart
 *      [4] Emerald-Mountain.jpg    → Emerald Mountain Residence
 *      [5] Most1.jpg               → Mostovi sekcije 4 (Smokovac-Mateševo)
 *      [6] MOKA-1.jpg              → Moka Place
 *      [7] PZ-4-1.jpg              → Rezidencijalno naselje – Objekat 5
 *    Hides the static Elementor image after injection (desktop parity fix).
 *    Does NOT run on internal pages.
 * 2. Scroll Reveal — IntersectionObserver fade-in-up for homepage sections.
 */
(function () {
  'use strict';

  /* -------------------------------------------------------
     0. SCROLL RESTORATION — always start at top on load/refresh.
     Prevents browser from restoring a non-zero scroll position
     which would show the dark gradient zone at the hero bottom.
     ------------------------------------------------------- */
  if ('scrollRestoration' in history) {
    history.scrollRestoration = 'manual';
  }
  // Force top-of-page on every navigation (refresh, back-forward)
  if (window.location.hash === '') {
    window.scrollTo(0, 0);
  }

  /* -------------------------------------------------------
     1. HERO SLIDESHOW — HOMEPAGE ONLY
     Targets the homepage-specific hero widget element
     (.elementor-element-7c67e6e2). Exits silently on all
     other page types — no injection, no global hero.
     ------------------------------------------------------- */

  // 9 project hero images — index-locked:
  var SLIDE_IMAGES = [
    '/wp-content/uploads/2025/07/P1.jpg',                   // [0] P1 / homepage render
    '/wp-content/uploads/2025/07/hyatt-photo.webp',         // [1] Hyatt Regency Kotor Bay Resort
    '/wp-content/uploads/2025/07/master-quart_01_finished.jpg', // [2] Master Kvart
    '/wp-content/uploads/2025/07/TIVAT-GG-1.jpg',          // [3] Tivat
    '/wp-content/uploads/2025/07/MOSTOVI-2-1.jpg',          // [4] Mostovi sekcije 4
    '/wp-content/uploads/2025/07/03.jpg',                   // [5] Luštica Bay – Upper Village
    '/wp-content/uploads/2025/06/Emerald-Mountain.jpg',     // [6] Emerald Mountain Residence
    '/wp-content/uploads/2025/07/MOKA-1.jpg',               // [7] Moka Place
    '/wp-content/uploads/2025/07/PZ-4-1.jpg'                // [8] Rezidencijalno naselje – Objekat 5
  ];

  var SLIDE_DURATION = 5000;   // ms each slide is visible
  var FADE_DURATION  = 1500;   // ms for CSS opacity transition (matches transition: opacity 1.5s)

  function initSlideshow() {
    // Primary selector: specific Elementor widget ID (element-7c67e6e2)
    // Fallback: any ehp-flex-hero image wrapper on page-123 (handles ID regeneration by Elementor)
    var imageWrapper =
      document.querySelector('.elementor-element-7c67e6e2 .ehp-flex-hero__image-wrapper') ||
      (document.body.classList.contains('elementor-page-123')
        ? document.querySelector('.ehp-flex-hero__image-wrapper')
        : null);

    // Not homepage or no hero found — exit cleanly, zero DOM changes
    if (!imageWrapper) return;

    // Build slide layer stack inside the hero image wrapper
    var slides = [];

    SLIDE_IMAGES.forEach(function (src, i) {
      var slide = document.createElement('div');
      slide.className = 'vd-slide';
      if (i === 0) slide.classList.add('vd-slide-active');

      var img = document.createElement('img');
      img.src = src;
      img.alt = '';
      img.setAttribute('aria-hidden', 'true');
      img.setAttribute('loading', i === 0 ? 'eager' : 'lazy');

      slide.appendChild(img);
      imageWrapper.appendChild(slide);
      slides.push(slide);
    });

    if (slides.length <= 1) return;

    // Suppress the static Elementor hero image — slides take over completely.
    // CSS already sets .ehp-flex-hero__img { opacity: 0 }, but also hide the
    // container here so any Elementor inline styles cannot restore visibility.
    // pointer-events:none stops it intercepting hover (it was showing its
    // filename as a native browser tooltip via its title attribute).
    var staticContainer = imageWrapper.querySelector('.ehp-flex-hero__image-container');
    if (staticContainer) {
      staticContainer.style.cssText += '; opacity: 0 !important; z-index: 0 !important; pointer-events: none !important;';
      var staticImg = staticContainer.querySelector('img');
      if (staticImg) {
        staticImg.removeAttribute('title');
      }
    }

    // Preload the next image before it becomes active
    function preloadNext(idx) {
      var next = slides[(idx + 1) % slides.length];
      var img = next.querySelector('img');
      if (img && img.loading === 'lazy') {
        img.loading = 'eager';
      }
    }

    var current = 0;

    function advance() {
      var prev = current;
      current = (current + 1) % slides.length;

      // Cross-fade: bring new slide in, then remove active class from old
      slides[current].classList.add('vd-slide-active');
      setTimeout(function () {
        slides[prev].classList.remove('vd-slide-active');
      }, FADE_DURATION);

      preloadNext(current);
    }

    // Preload slide #1 immediately
    preloadNext(0);

    var timer = setInterval(advance, SLIDE_DURATION);

    // Pause on hover (accessibility) — same dual-selector approach
    var heroEl =
      document.querySelector('.elementor-element-7c67e6e2 .ehp-flex-hero') ||
      document.querySelector('.ehp-flex-hero');
    if (heroEl) {
      heroEl.addEventListener('mouseenter', function () { clearInterval(timer); });
      heroEl.addEventListener('mouseleave', function () {
        timer = setInterval(advance, SLIDE_DURATION);
      });
    }
  }


  /* -------------------------------------------------------
     2. SCROLL REVEAL ANIMATIONS (IntersectionObserver)
     ------------------------------------------------------- */

  var REVEAL_SELECTORS = [
    '.elementor-123 > .elementor-section-wrap > .elementor-element',
    '.elementor-123 > .elementor-element',
    '.elementor-widget-heading',
    '.elementor-widget-text-editor',
    '.elementor-widget-contact',
  ];

  var GROUP_SELECTORS = [
    '.elementor-123 .elementor-element.elementor-element-2cd3d4e',
    '.elementor-123 .elementor-element.elementor-element-d6b798c',
  ];

  function initRevealAnimations() {
    if (!('IntersectionObserver' in window)) return;

    var observer = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('vd-visible');
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.08, rootMargin: '0px 0px -48px 0px' });

    var seen = new Set();
    REVEAL_SELECTORS.forEach(function (sel) {
      try {
        document.querySelectorAll(sel).forEach(function (el) {
          if (seen.has(el)) return;
          if (el.closest('.elementor-element-2cd3d4e') &&
              !el.classList.contains('elementor-element-2cd3d4e')) return;
          seen.add(el);
          el.classList.add('vd-reveal');
          observer.observe(el);
        });
      } catch (e) {}
    });

    GROUP_SELECTORS.forEach(function (sel) {
      try {
        document.querySelectorAll(sel).forEach(function (el) {
          el.classList.remove('vd-reveal');
          el.classList.add('vd-reveal-group');

          var groupObserver = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
              if (entry.isIntersecting) {
                entry.target.classList.add('vd-visible');
                groupObserver.unobserve(entry.target);
              }
            });
          }, { threshold: 0.06, rootMargin: '0px 0px -32px 0px' });

          groupObserver.observe(el);
        });
      } catch (e) {}
    });
  }


  /* -------------------------------------------------------
     3. PROJECT PAGE — DOWN ARROW SCROLL
     Clicking the hero chevron (▼) scrolls smoothly to the
     first content section below the hero.
     ------------------------------------------------------- */
  function initProjectScroll() {
    // Only on single project/post pages
    if (!document.body.classList.contains('single') &&
        !document.body.classList.contains('single-post')) return;

    // Targets: common chevron selectors used by Elementor hero widgets
    var arrows = document.querySelectorAll(
      '.ehp-flex-hero__scroll-down, ' +
      '.elementor-scroll-down, ' +
      '[class*="scroll-down"], ' +
      '[class*="chevron-down"], ' +
      '.ehp-flex-hero__caret, ' +
      '.ehp-flex-hero__arrow'
    );

    arrows.forEach(function(arrow) {
      arrow.style.cursor = 'pointer';
      arrow.addEventListener('click', function(e) {
        e.preventDefault();
        // Find the first section AFTER the hero (first-child)
        var sections = document.querySelectorAll(
          '[data-elementor-type="wp-post"] .elementor-section, ' +
          '[data-elementor-type="wp-post"] .e-con, ' +
          '[data-elementor-type="single-post"] .elementor-section, ' +
          '[data-elementor-type="single-post"] .e-con'
        );
        // Skip the first (hero) section, scroll to the second
        var target = sections[1] || sections[0];
        if (target) {
          target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
      });
    });
  }

  /* -------------------------------------------------------
     4. PROJECT PAGE — BROKEN IMAGE FALLBACK
     When an Elementor image widget references a WordPress
     attachment URL that doesn't exist on the server (common
     after migrating to cPanel without syncing uploads), this
     tries alternative upload folder paths before giving up.
     Priority order: 2026/07 → 2025/06 → 2025/07 → 2025/05.
     ------------------------------------------------------- */
  function initImageFallback() {
    if (!document.body.classList.contains('single') &&
        !document.body.classList.contains('single-post')) return;

    // Alternative base paths to try when an image 404s
    var altBases = [
      '/wp-content/uploads/2026/07/',
      '/wp-content/uploads/2025/06/',
      '/wp-content/uploads/2025/07/',
      '/wp-content/uploads/2025/05/',
    ];

    function tryNextPath(img, bases, idx) {
      if (idx >= bases.length) return;   // all options exhausted
      var filename = (img.getAttribute('data-original-src') || img.src).split('/').pop();
      var candidate = bases[idx] + filename;
      if (candidate === img.src) {
        tryNextPath(img, bases, idx + 1);
        return;
      }
      img.onerror = function () { tryNextPath(img, bases, idx + 1); };
      img.src = candidate;
    }

    document.querySelectorAll(
      '[data-elementor-type="wp-post"] img, ' +
      '[data-elementor-type="single-post"] img'
    ).forEach(function (img) {
      if (!img.getAttribute('data-fallback-init')) {
        img.setAttribute('data-fallback-init', '1');
        img.setAttribute('data-original-src', img.src);
        img.addEventListener('error', function () {
          if (!img.getAttribute('data-fallback-started')) {
            img.setAttribute('data-fallback-started', '1');
            tryNextPath(img, altBases, 0);
          }
        }, { once: true });
      }
    });
  }


  /* -------------------------------------------------------
     INIT
     ------------------------------------------------------- */
  function init() {
    initSlideshow();
    initRevealAnimations();
    initProjectScroll();
    initImageFallback();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }

})();
