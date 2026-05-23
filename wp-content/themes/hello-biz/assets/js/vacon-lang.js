/**
 * VACON DESIGN — Language Switcher v4.0.4
 * EN ↔ CG (Crnogorski / Montenegrin) toggle.
 *
 * • Injects EN/CG button between KONTAKT and the mailbox icon in the navbar.
 * • Translates nav items, page headings, contact labels, service names, and
 *   known body text using a content-matching dictionary.
 * • Persists choice to localStorage across pages.
 * • On each page load, re-applies the stored language immediately so there is
 *   no flash of untranslated content (for fast Elementor renders).
 */
(function () {
  'use strict';

  var STORAGE_KEY = 'vd-lang';
  var currentLang = localStorage.getItem(STORAGE_KEY) || 'cg';

  /* ================================================================
     TRANSLATIONS DICTIONARY
     Keys are the exact Montenegrin source strings (trimmed, uppercased
     where relevant). Values are the English equivalents.
     ================================================================ */

  // Navigation items
  var NAV = {
    'NASLOVNA STRANA': 'HOME',
    'O NAMA':          'ABOUT US',
    'USLUGE':          'SERVICES',
    'PROJEKTI':        'PROJECTS',
    'KONTAKT':         'CONTACT',
  };

  // All heading-level translations (heading widget titles, labels, etc.)
  var HEADINGS = {
    'O NAMA':                          'ABOUT US',
    'NAŠE USLUGE':                     'OUR SERVICES',
    'NAŠI PROJEKTI':                   'OUR PROJECTS',
    'KONTAKT:':                        'CONTACT:',
    'KONTAKT':                         'CONTACT',
    'ZAŠTO ODABRATI NAS':              'WHY CHOOSE US',
    'POUZDANOST':                      'RELIABILITY',
    'PRECIZNOST':                      'PRECISION',
    'ISKUSTVO':                        'EXPERIENCE',
    'DETALJNOST':                      'ATTENTION TO DETAIL',
    'OPIS PROJEKTA':                   'PROJECT DESCRIPTION',
    'PODACI PROJEKTA':                 'PROJECT DATA',
    'PRETHODNI PROJEKAT':              'PREVIOUS PROJECT',
    'SLEDEĆI PROJEKAT':                'NEXT PROJECT',
    'SLJEDEĆI PROJEKAT':               'NEXT PROJECT',
    'DETALJNIJE O USLUGAMA →':         'LEARN MORE ABOUT OUR SERVICES →',
    'DETALJNIJE O PROJEKTIMA →':       'VIEW ALL PROJECTS →',
    'NAŠE USLUGE →':                   'OUR SERVICES →',
    'SVI PROJEKTI →':                  'ALL PROJECTS →',
    'USLUGE':                          'SERVICES',
    'PROJEKTI':                        'PROJECTS',
  };

  // Contact widget: subheadings (Radno Vrijeme, Lokacija, etc.)
  var CONTACT_LABELS = {
    'RADNO VRIJEME:':                  'WORKING HOURS:',
    'RADNO VRIJEME':                   'WORKING HOURS',
    'LOKACIJA':                        'LOCATION',
    'PRATITE NAS NA DRUŠTVENIM MREŽAMA': 'FOLLOW US ON SOCIAL MEDIA',
    'Ponedjeljak - Petak':             'Monday – Friday',
    'Ponedjeljak – Petak':             'Monday – Friday',
    '08:00 - 16:00':                   '08:00 – 16:00',
    'Đoka Miraševića 108/8':           'Đoka Miraševića 108/8', // address stays
  };

  // Service image-box titles
  var SERVICES = {
    'ARHITEKTONSKO PROJEKTOVANJE':     'ARCHITECTURAL DESIGN',
    'GRAĐEVINSKO PROJEKTOVANJE':       'STRUCTURAL ENGINEERING',
    'SAOBRAĆAJNO PROJEKTOVANJE':       'TRAFFIC ENGINEERING',
    'ELEKTRO PROJEKTOVANJE':           'ELECTRICAL ENGINEERING',
    'MAŠINSKO PROJEKTOVANJE':          'MECHANICAL ENGINEERING',
    'NADZOR I IZVOĐENJE':              'SUPERVISION & CONSTRUCTION',
    // Descriptions (image-box)
    'Izrada arhitektonskih projekata svih vrsta, od idejnih do izvedbenih, u skladu sa važećim propisima i zahtjevima investitora.':
      'Development of architectural projects of all types, from concept to detailed design, in compliance with applicable regulations and investor requirements.',
    'Izrada građevinskih projekata koji osiguravaju statičku stabilnost i sigurnost objekata u svim fazama izgradnje.':
      'Development of structural engineering projects ensuring the static stability and safety of buildings throughout all phases of construction.',
    'Izrada saobraćajnih projekata i projekata parkiranja, u skladu sa standardima i propisima u oblasti saobraćajne infrastrukture.':
      'Development of traffic engineering and parking design projects, compliant with standards and regulations in the field of traffic infrastructure.',
    'Izrada elektro projekata za sve vrste objekata, uključujući jake i slabe struje, osvetljenje i sistem zaštite.':
      'Development of electrical engineering projects for all types of buildings, including power, low-voltage systems, lighting, and protection systems.',
    'Izrada projekata mašinskih instalacija, grijanja, hlađenja, ventilacije i vodovoda za sve vrste objekata.':
      'Development of mechanical installation projects, including heating, cooling, ventilation, and plumbing for all types of buildings.',
    'Pružamo usluge stručnog nadzora i izvođenja radova, osiguravajući usklađenost sa projektnom dokumentacijom i propisima.':
      'We provide expert supervision and construction services, ensuring compliance with project documentation and applicable regulations.',
  };

  // Hero subheading (homepage)
  var HERO_SUBHEADING_CG = 'POUZDANOST U SVAKOM PRORAČUNU. STRUČNOST U SVAKOM DETALJU.';
  var HERO_SUBHEADING_EN = 'RELIABILITY IN EVERY CALCULATION. EXPERTISE IN EVERY DETAIL.';

  // Contact description paragraph
  var CONTACT_DESC_CG = 'Naše zadovoljstvo je da sarađujemo sa klijentima na svakom koraku realizacije projekta. Stojimo vam na raspolaganju za sve vrste usluga koje pružamo. Obratite nam se sa povjerenjem, a naš tim će vam obezbijediti stručnu podršku, kvalitetna rješenja i sigurnost u svakoj fazi gradnje.';
  var CONTACT_DESC_EN = 'Our pleasure is to collaborate with clients at every stage of project realization. We are at your disposal for all types of services we provide. Contact us with confidence — our team will provide expert support, quality solutions, and security at every phase of construction.';

  // Project page meta labels
  var PROJECT_LABELS = {
    'INVESTITOR:':                     'CLIENT:',
    'INVESTITOR':                      'CLIENT',
    'GODINA:':                         'YEAR:',
    'GODINA':                          'YEAR',
    'NIVO RAZRADE:':                   'DESIGN PHASE:',
    'NIVO RAZRADE':                    'DESIGN PHASE',
    'BGRP:':                           'GFA:',
    'BGRP':                            'GFA',
    'POVRŠINA:':                       'AREA:',
    'POVRŠINA':                        'AREA',
    'LOKACIJA:':                       'LOCATION:',
    'LOKACIJA':                        'LOCATION',
    'VRSTA OBJEKTA:':                  'BUILDING TYPE:',
    'VRSTA OBJEKTA':                   'BUILDING TYPE',
    'GLAVNI PROJEKAT':                 'MAIN PROJECT',
    'IDEJNI PROJEKAT':                 'CONCEPT DESIGN',
    'ARHITEKTONSKA SAGLASNOST':        'ARCHITECTURAL CONSENT',
    'IZVEDBENI PROJEKAT':              'EXECUTIVE DESIGN',
    'PROJEKAT ZA GRAĐEVINSKU DOZVOLU': 'BUILDING PERMIT PROJECT',
  };

  // About-page / O nama body text (truncated match)
  var ABOUT_TEXT = {
    'Kompanija Vacon Design': 'Vacon Design',
  };

  // Pillar descriptions ("Zašto odabrati nas" section)
  var PILLAR_DESC = {
    'Naši projekti su rezultat pažljivog planiranja': 'Our projects are the result of careful planning',
  };


  /* ================================================================
     ORIGINAL TEXT CACHE
     We store each element's original CG text on first translation
     so we can restore it perfectly when switching back.
     ================================================================ */
  var origCache = new WeakMap();

  function cacheOriginal(el) {
    if (!origCache.has(el)) origCache.set(el, el.textContent);
  }

  function getOriginal(el) {
    return origCache.has(el) ? origCache.get(el) : el.textContent;
  }

  /* ================================================================
     TRANSLATION HELPERS
     ================================================================ */

  function translateEl(el, dict, toLang) {
    cacheOriginal(el);
    var orig = getOriginal(el).trim();
    var origUpper = orig.toUpperCase();

    if (toLang === 'en') {
      // Try exact match first, then uppercase match
      var tr = dict[orig] || dict[origUpper];
      if (tr !== undefined) el.textContent = tr;
    } else {
      // Restore original
      el.textContent = getOriginal(el);
    }
  }

  /* Check if element text STARTS WITH a dictionary key (for partial matches) */
  function translateElPartial(el, dict, toLang) {
    cacheOriginal(el);
    if (toLang === 'en') {
      var text = el.textContent.trim();
      for (var key in dict) {
        if (text.indexOf(key) === 0) {
          el.textContent = dict[key];
          return;
        }
      }
    } else {
      el.textContent = getOriginal(el);
    }
  }


  /* ================================================================
     PAGE-LEVEL TRANSLATION
     ================================================================ */

  function applyLanguage(lang) {

    // 1 ── Navigation items
    document.querySelectorAll(
      '.ehp-header__item, ' +
      '.ehp-header__menu a, ' +
      '.elementor-nav-menu a.elementor-item'
    ).forEach(function (el) {
      translateEl(el, NAV, lang);
    });

    // 2 ── Heading widgets
    document.querySelectorAll(
      '.elementor-heading-title, ' +
      '.ehp-flex-hero__heading'
    ).forEach(function (el) {
      translateEl(el, HEADINGS, lang);
    });

    // 3 ── Hero subheading
    document.querySelectorAll('.ehp-flex-hero__subheading').forEach(function (el) {
      cacheOriginal(el);
      if (lang === 'en') {
        el.textContent = HERO_SUBHEADING_EN;
      } else {
        el.textContent = getOriginal(el);
      }
    });

    // 4 ── Contact subheadings (Radno Vrijeme, Lokacija, etc.)
    document.querySelectorAll(
      '.ehp-contact__subheading, ' +
      '.ehp-contact__subheading *'
    ).forEach(function (el) {
      translateEl(el, CONTACT_LABELS, lang);
    });

    // 5 ── Contact description paragraph
    document.querySelectorAll('.ehp-contact__description, .ehp-contact__description p').forEach(function (el) {
      cacheOriginal(el);
      if (lang === 'en' && el.textContent.trim().indexOf('Naše zadovoljstvo') >= 0) {
        el.textContent = CONTACT_DESC_EN;
      } else if (lang === 'cg') {
        el.textContent = getOriginal(el);
      }
    });

    // 6 ── Service image-box titles
    document.querySelectorAll('.elementor-image-box-title').forEach(function (el) {
      translateEl(el, SERVICES, lang);
    });

    // 7 ── Service image-box descriptions
    document.querySelectorAll('.elementor-image-box-description, .elementor-image-box-description p').forEach(function (el) {
      translateElPartial(el, SERVICES, lang);
    });

    // 8 ── Post navigation labels (PRETHODNI / SLJEDEĆI)
    document.querySelectorAll(
      '.elementor-post-navigation__prev--label, ' +
      '.elementor-post-navigation__next--label, ' +
      '.nav-previous .meta-nav, ' +
      '.nav-next .meta-nav'
    ).forEach(function (el) {
      translateEl(el, HEADINGS, lang);
    });

    // 9 ── Project page: section labels (PODACI PROJEKTA, OPIS PROJEKTA, etc.)
    document.querySelectorAll('.elementor-heading-title').forEach(function (el) {
      translateEl(el, PROJECT_LABELS, lang);
    });

    // 10 ── Project page inline labels (icon-text: INVESTITOR, GODINA, etc.)
    //  These are often plain <span> or <p> elements with icon prefix
    document.querySelectorAll(
      '.ehp-icon-list__text, ' +       // Hello Biz icon list
      '.elementor-icon-list__text, ' + // Elementor icon list
      'p, span'
    ).forEach(function (el) {
      // Only translate leaf nodes (no child elements) to avoid corrupting HTML structure
      if (el.children.length === 0) {
        translateEl(el, PROJECT_LABELS, lang);
      }
    });

    // 11 ── Radno Vrijeme text nodes (Mon–Fri, hours)
    document.querySelectorAll('.ehp-contact__contact-text').forEach(function (el) {
      translateEl(el, CONTACT_LABELS, lang);
    });

    // 12 ── Update <html lang> attribute for accessibility
    document.documentElement.setAttribute('lang', lang === 'en' ? 'en' : 'sr-Latn-ME');
  }


  /* ================================================================
     BUTTON INJECTION
     ================================================================ */

  function createToggleBtn() {
    var btn = document.createElement('button');
    btn.id = 'vd-lang-btn';
    btn.setAttribute('type', 'button');
    btn.setAttribute('aria-label', 'Switch language');
    btn.setAttribute('title', currentLang === 'cg' ? 'Switch to English' : 'Prebaci na crnogorski');
    btn.textContent = currentLang === 'cg' ? 'EN' : 'CG';

    btn.addEventListener('click', function () {
      currentLang = currentLang === 'cg' ? 'en' : 'cg';
      localStorage.setItem(STORAGE_KEY, currentLang);
      btn.textContent    = currentLang === 'cg' ? 'EN' : 'CG';
      btn.title          = currentLang === 'cg' ? 'Switch to English' : 'Prebaci na crnogorski';
      applyLanguage(currentLang);
    });

    return btn;
  }

  function injectButton() {
    // Prevent double-injection
    if (document.getElementById('vd-lang-btn')) return;

    // Real Hello Plus header class names (confirmed from helloplus-header.css):
    // .ehp-header__ctas-container  — wraps email + phone CTA buttons
    // .ehp-header__contact-buttons — individual contact buttons list
    // .ehp-header__navigation      — nav menu area (insert AFTER this as sibling)
    var target =
      document.querySelector('.ehp-header__ctas-container') ||
      document.querySelector('.ehp-header__contact-buttons') ||
      document.querySelector('.ehp-header__navigation');

    if (!target) {
      // Elementor may still be rendering — retry up to 10× with 200ms gaps
      if ((injectButton._tries = (injectButton._tries || 0) + 1) < 10) {
        setTimeout(injectButton, 200);
      }
      return;
    }

    var btn = createToggleBtn();

    if (target.classList.contains('ehp-header__navigation')) {
      // Insert as next sibling of the nav (between nav and CTAs)
      target.parentNode.insertBefore(btn, target.nextSibling);
    } else {
      // Prepend inside the CTAs container (before email icon)
      target.insertBefore(btn, target.firstChild);
    }
  }


  /* ================================================================
     INIT
     ================================================================ */

  function init() {
    injectButton();

    // Re-apply saved language immediately (no flash of CG on EN preference)
    if (currentLang === 'en') {
      // Small delay to let Elementor finish its own DOM manipulation
      requestAnimationFrame(function () {
        applyLanguage('en');
      });
    }
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }

})();
