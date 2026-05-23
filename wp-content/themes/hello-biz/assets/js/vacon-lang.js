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
    'TAMO GDJE IDEJE POSTAJU KONSTRUKCIJE': 'WHERE IDEAS BECOME STRUCTURES',
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

  // ----------------------------------------------------------------
  // BODY TEXT — full paragraphs across all pages (partial-start match).
  // Keys = unique opening phrase; values = complete English paragraph.
  // Processed by translateElPartialHtml so innerHTML is preserved on CG restore.
  // ----------------------------------------------------------------
  var BODY_TEXT = {

    // ── Homepage "O NAMA" section — paragraph 1 (has <strong>VACON</strong>)
    'Firma VACON osnovana je 2022. godine':
      'Vacon Design was founded in 2022 with a clear vision — to transform years of experience into quality, reliable, and long-lasting projects in the field of structural engineering. Although the firm is relatively young, behind us stands a team with extensive work experience gained across a diverse range of construction projects.',

    // ── Homepage "O NAMA" section — paragraph 2
    'Specijalizovani smo za projektovanje':
      'We specialise in structural engineering design, offering reliable solutions for various types of buildings — from residential structures to infrastructure projects. By applying modern engineering standards and years of experience, we deliver high-quality, cost-effective designs tailored to investor requirements. Our team consists of licensed engineers who ensure a professional approach at every phase of the design process.',

    // ── O NAMA page — paragraph 1 (plain, no bold)
    'Firma Vacon osnovana je 2022. godine':
      'Vacon Design was founded in 2022 with a clear vision — to transform years of experience into quality, reliable, and long-lasting projects in the field of structural engineering. Although the firm is relatively young, behind us stands a team with extensive work experience gained across a diverse range of construction projects.',

    // ── O NAMA page — paragraph 2
    'Od samog početka posvećeni':
      'From the very beginning, we have been committed to delivering high-standard services, with special attention to precision, safety, and efficiency in every aspect of our work. Our goal is to offer clients solutions that not only meet their needs but exceed expectations.',

    // ── O NAMA page — paragraph 3
    'Vjerujemo u važnost odgovornog':
      'We believe in the importance of a responsible approach, professionalism, and open communication — the foundations on which we build long-term partnerships and successful projects.',

    // ── O NAMA page — paragraph 4
    'Ako tražite partnera':
      'If you are looking for a partner to turn your ideas into solid, functional structures — we are here to build the future together.',

    // ── USLUGE page — intro paragraph
    'Naša firma pruža sveobuhvatne':
      'Our firm provides comprehensive engineering services in the field of civil engineering, combining expertise, precision, and modern technologies. We offer clients a complete process — from concept and design, through construction, to expert supervision. Every task is approached responsibly, with the goal of achieving maximum safety, quality, and functionality.',

    // ── Homepage "Zašto odabrati nas" — PRECIZNOST pillar
    'Naši projekti nisu samo tehnički ispravni':
      'Our projects are not only technically sound — they are carefully conceived, functionally optimised, and aesthetically aligned. We believe a quality project begins with precision and ends with client satisfaction, and this philosophy guides every step of our work.',

    // ── Homepage "Zašto odabrati nas" — ISKUSTVO pillar
    'Naš tim čine stručnjaci sa višegodišnjim':
      'Our team consists of experts with extensive experience in design and construction. Knowledge gained in the field and through various project phases gives us the ability to identify potential challenges in the planning stage — and to resolve them efficiently.',

    // ── Homepage "Zašto odabrati nas" — DETALJNOST pillar
    'Redovno pohađamo stručne obuke':
      'We regularly attend professional training, seminars, and courses to stay current with the latest software solutions and technological innovations in the construction and design industry — enabling us to deliver modern, long-term sustainable solutions.',

    // ── Homepage "Zašto odabrati nas" — POUZDANOST pillar
    'Birajući nas, birate partnera':
      'By choosing us, you choose a partner who understands the importance of every millimetre, every plan, and every deadline. Quality, reliability, and expertise are not just our promises — they are the foundations on which we build every project.',

    // ── Homepage / Kontakt — "Detaljnije o našim uslugama" CTA link text
    'Detaljnije o našim uslugama':           'Learn more about our services',
    'Detaljnije o projektima':               'View all projects',
  };


  /* ================================================================
     ORIGINAL TEXT CACHE
     We store each element's original CG text on first translation
     so we can restore it perfectly when switching back.
     origCache      — textContent (for plain-text elements)
     origHtmlCache  — innerHTML  (for elements with inline HTML like <strong>)
     ================================================================ */
  var origCache    = new WeakMap();
  var origHtmlCache = new WeakMap();

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

  /**
   * Like translateElPartial but preserves innerHTML when restoring CG.
   * Use this for elements that may contain inline HTML (<strong>, <span>…).
   * EN mode:  replace with plain text (no formatting needed in translation).
   * CG mode:  restore full innerHTML (bold, coloured spans etc. intact).
   */
  function translateElPartialHtml(el, dict, toLang) {
    if (!origHtmlCache.has(el)) origHtmlCache.set(el, el.innerHTML);
    if (!origCache.has(el))     origCache.set(el, el.textContent);

    if (toLang === 'en') {
      var text = el.textContent.trim();
      for (var key in dict) {
        if (text.indexOf(key) === 0) {
          el.textContent = dict[key];   // plain text is fine for EN
          return;
        }
      }
    } else {
      el.innerHTML = origHtmlCache.get(el);  // restore with all original markup
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

    // 13 ── Hero CTA button ("NAŠI PROJEKTI →" / "OUR PROJECTS →")
    var heroCta = document.getElementById('vd-hero-cta');
    if (heroCta) {
      heroCta.textContent = lang === 'en'
        ? (heroCta.getAttribute('data-en') || 'OUR PROJECTS →')
        : (heroCta.getAttribute('data-cg') || 'NAŠI PROJEKTI →');
    }

    // 14 ── Body text paragraphs (O NAMA, USLUGE intro, pillar descriptions).
    //  Uses translateElPartialHtml so switching back to CG restores original
    //  innerHTML (preserving <strong>, <span> inline markup).
    document.querySelectorAll(
      '.elementor-widget-text-editor p, ' +
      '.elementor-text-editor p'
    ).forEach(function (el) {
      translateElPartialHtml(el, BODY_TEXT, lang);
    });

    // 15 ── Leaf-node spans inside text-editor widgets (pillar descriptions
    //  that Elementor wraps in <span style="...">).
    document.querySelectorAll(
      '.elementor-widget-text-editor span, ' +
      '.elementor-text-editor span'
    ).forEach(function (el) {
      if (el.children.length === 0) {
        translateElPartial(el, BODY_TEXT, lang);
      }
    });

    // 16 ── CTA / link text inside widgets ("Detaljnije o …")
    document.querySelectorAll(
      '.elementor-button-text, ' +
      '.elementor-widget-button .elementor-button, ' +
      'a.ehp-button'
    ).forEach(function (el) {
      if (el.children.length === 0) {
        translateElPartial(el, BODY_TEXT, lang);
      }
    });
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

    // IMPORTANT: Hello Plus renders TWO .ehp-header__ctas-container elements:
    //   1. INSIDE <nav class="ehp-header__navigation"> — mobile dropdown (hidden on desktop)
    //   2. As direct child of .ehp-header__elements-container — desktop bar (visible)
    // Using plain querySelector gets the FIRST (mobile) one, so the button is never
    // visible on desktop. Must use the child combinator > to target only the desktop one.
    var target =
      // Desktop CTA bar: direct child of elements-container (not nested inside nav)
      document.querySelector('.ehp-header__elements-container > .ehp-header__ctas-container') ||
      // Fallback: any ctas-container that is NOT inside the nav element
      document.querySelector('.ehp-header__ctas-container:not(nav .ehp-header__ctas-container)') ||
      // Last resort: insert after the nav element itself
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
      // Prepend inside the desktop CTAs container (before mail/phone icons)
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
