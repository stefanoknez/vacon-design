/**
 * VACON DESIGN — Language Switcher v4.0.9d
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

    // Pillar headings (homepage — stored as uppercase with number prefix)
    '1. DETALJNOST':                   '1. ATTENTION TO DETAIL',
    '2. ISKUSTVO':                     '2. EXPERIENCE',
    '3. ZNANJE':                       '3. KNOWLEDGE',
    '4. PRECIZNOST':                   '4. PRECISION',

    // Without number prefix (fallback)
    'DETALJNOST':                      'ATTENTION TO DETAIL',
    'PRECIZNOST':                      'PRECISION',
    'ISKUSTVO':                        'EXPERIENCE',
    'ZNANJE':                          'KNOWLEDGE',
    'POUZDANOST':                      'RELIABILITY',

    // O NAMA page section headings
    'NAŠA PRIČA':                      'OUR STORY',
    'NAŠ TIM':                         'OUR TEAM',

    // PROJEKTI page category headings and portfolio filter labels
    'STAMBENO - POSLOVNI OBJEKTI':     'RESIDENTIAL - COMMERCIAL BUILDINGS',
    'STAMBENO-POSLOVNI OBJEKTI':       'RESIDENTIAL-COMMERCIAL BUILDINGS',
    'INFRASTRUKTURNI OBJEKTI':         'INFRASTRUCTURE PROJECTS',
    'INFRASTRUKTURA':                  'INFRASTRUCTURE',
    'ZAŠTITA ISKOPA':                  'EXCAVATION PROTECTION',

    // Page 648 — Construction sector contact
    'POŠALJITE PORUKU NAŠEM SEKTORU ZA IZVOĐENJE RADOVA': 'SEND A MESSAGE TO OUR CONSTRUCTION SECTOR',

    // Project page navigation labels (both -AT and -T endings used across templates)
    'OPIS PROJEKTA':                   'PROJECT DESCRIPTION',
    'PODACI PROJEKTA':                 'PROJECT DATA',
    'PODACI PROJEKTA:':                'PROJECT DATA:',
    'PRETHODNI PROJEKAT':              'PREVIOUS PROJECT',
    'PRETHODNI PROJEKT':               'PREVIOUS PROJECT',
    'SLEDEĆI PROJEKAT':                'NEXT PROJECT',
    'SLEDEĆI PROJEKT':                 'NEXT PROJECT',
    'SLJEDEĆI PROJEKAT':               'NEXT PROJECT',
    'SLJEDEĆI PROJEKT':                'NEXT PROJECT',

    // Project page section headings
    'SLIKE PROJEKTA':                  'PROJECT IMAGES',
    'GALERIJA':                        'GALLERY',

    // CTA links / section labels
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

    // Contact link labels (phone/email with sector info)
    'Telefon - 067/321-295 - sektor za projektovanje': 'Phone - 067/321-295 - design dept.',
    'Telefon - 067/011-166 - sektor za izvođenje':     'Phone - 067/011-166 - construction dept.',
    'Email - sektor za projektovanje':                 'Email - design dept.',
    'Email - sektor za izvođenje':                     'Email - construction dept.',
  };

  // ----------------------------------------------------------------
  // SERVICE titles and descriptions
  // Keys are matched case-insensitively via translateEl (title, exact)
  // and translateElPartial (description, opening-phrase match).
  // ----------------------------------------------------------------
  var SERVICES = {

    // ── Titles (matched via dict[origUpper]) ──────────────────────
    '1. PROJEKTOVANJE OBJEKATA':              '1. STRUCTURAL DESIGN',
    'PROJEKTOVANJE OBJEKATA':                 'STRUCTURAL DESIGN',

    '2. SAOBRAĆAJNA INFRASTRUKTURA':          '2. TRAFFIC INFRASTRUCTURE',
    'SAOBRAĆAJNA INFRASTRUKTURA':             'TRAFFIC INFRASTRUCTURE',

    '3. ZAŠTITA ISKOPA':                      '3. EXCAVATION PROTECTION',
    'ZAŠTITA ISKOPA':                         'EXCAVATION PROTECTION',

    '4. IZVOĐENJE RADOVA':                    '4. CONSTRUCTION SERVICES',
    'IZVOĐENJE RADOVA':                       'CONSTRUCTION SERVICES',

    '5. STRUČNI NADZOR':                      '5. PROFESSIONAL SUPERVISION',
    'STRUČNI NADZOR':                         'PROFESSIONAL SUPERVISION',

    '6. ELABORAT ENERGETSKE EFIKASNOSTI':     '6. ENERGY EFFICIENCY REPORT',
    'ELABORAT ENERGETSKE EFIKASNOSTI':        'ENERGY EFFICIENCY REPORT',

    // Homepage short-form titles (no number prefix, shorter names)
    'IZVOĐENJE':                              'CONSTRUCTION',
    'TENDERI':                                'TENDERS',

    // ── Descriptions (matched via opening phrase) ─────────────────

    // 1. Projektovanje objekata (USLUGE page — concrete/steel focus)
    'Specijalizovani smo za projektovanje betonskih':
      'We specialise in the design of concrete and steel structures, applying modern software solutions for structural analysis, reinforcement detailing, and workshop drawings. Our projects comply with Eurocode standards, ensuring the safety, durability, and reliability of every structure. We pay special attention to aesthetic and functional aspects, ensuring each building is fully tailored to the investor\'s requirements.',

    // 2. Saobraćajna infrastruktura
    'Izrađujemo projekte konstrukcija za sve vrste':
      'We design structural systems for all types of road infrastructure, including bridges, retaining walls, culverts, overpasses, underpasses, and other ancillary structures in line with guidelines for motorways and main roads. Our engineering team uses modern software tools and designs in accordance with domestic and international standards. Regardless of terrain complexity or object function, we deliver safe, durable, and optimised solutions adapted to every location.',

    // 3. Zaštita iskopa
    'Projektujemo sve vrste sistema zaštite':
      'We design all types of foundation pit protection systems, including piles, diaphragm walls, anchored walls, steel shoring, and temporary structures. We approach each project individually, analysing soil conditions, excavation depth, and site-specific requirements. Our goal is to ensure maximum stability, safety, and cost optimisation — without compromising on quality.',

    // 4. Izvođenje radova
    'Pored projektovanja, pružamo usluge izvođenja':
      'In addition to design, we provide construction services in full compliance with all technical regulations and legal requirements. We focus on finishing works, but also have the capacity for a broader range of civil engineering activities. We guarantee quality, efficiency, and delivery within set deadlines, with full compliance with project documentation.',

    // 5. Stručni nadzor
    'Naš tim pruža stručni nadzor nad':
      'Our team provides professional supervision of construction works, ensuring compliance with design, legislation, and industry standards. Our engineers monitor all phases of work, control quality, timelines, and budget, and respond promptly to any challenges on site. Your construction is under expert supervision, with full commitment to maintaining the highest level of quality.',

    // 6. Elaborat energetske efikasnosti
    'Naš tim izrađuje elaborate energetske':
      'Our team prepares energy efficiency reports in accordance with applicable regulations and standards. These documents form the basis for obtaining building and occupancy permits, and are also an important tool for assessing and optimising energy consumption in buildings.',

    // ── Homepage image-box descriptions (different wording from USLUGE page) ──

    // Homepage: Projektovanje objekata (commercial/residential focus)
    'Izrađujemo kompletne projekte za sve vrste':
      'We develop complete design documentation for all types of commercial and residential buildings, in compliance with applicable regulations, technical standards, and investor-specific requirements. Our team of engineers delivers reliable, functional, and aesthetically consistent solutions — whether for smaller residential buildings, mixed-use complexes, or commercial centres.',

    // Homepage: Zaštita iskopa (slightly different phrasing)
    'Projektujemo sve vrste sistema za zaštitu iskopa':
      'We design all types of foundation pit protection systems, including piles, diaphragm walls, anchored walls, steel shoring, and temporary structures. We approach each case individually, taking into account soil conditions, excavation depth, and site requirements. Our goal is maximum stability, safety, and cost optimisation.',

    // Homepage: Izvođenje (short form — construction execution)
    'Pored projektovanja, bavimo se i izvođenjem':
      'In addition to design, we carry out structural works in full compliance with all technical and legal requirements. We realise projects from foundations to the roof, with controlled construction phases and full compliance with project documentation. We guarantee quality and efficient construction, delivered within set deadlines.',

    // Homepage: Tenderi (tender preparation — homepage only service)
    'Pripremamo kompletnu tehničku dokumentaciju za učešće':
      'We prepare complete technical documentation for participation in tenders in the fields of building construction and infrastructure. Our team produces accurate cost estimates, technical descriptions, and graphic annexes in accordance with client and procurement procedure requirements. With our support, you maximise your chances of success in every public call.',

    // Homepage: Stručni nadzor (different wording from USLUGE page)
    'Pružamo usluge stručnog nadzora nad izvođenjem':
      'We provide professional supervision services for construction works, ensuring quality, compliance with design and legal requirements, and control of timelines and budget. Our engineers oversee all technical details and respond promptly to on-site challenges. Your construction is under expert supervision.',
  };

  // Hero subheading (homepage)
  var HERO_SUBHEADING_EN = 'RELIABILITY IN EVERY CALCULATION. EXPERTISE IN EVERY DETAIL.';

  // Contact description paragraph
  var CONTACT_DESC_CG = 'Naše zadovoljstvo je da sarađujemo sa klijentima na svakom koraku realizacije projekta.';
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
    'PROJEKAT ZA IZVOĐENJE':           'EXECUTION DESIGN',
    'PROJEKAT ZAŠTITE ISKOPA':         'EXCAVATION PROTECTION DESIGN',
    'KONSTRUKCIJA':                    'STRUCTURE',
    'ARMIRANOBETONSKA KONSTRUKCIJA':   'REINFORCED CONCRETE STRUCTURE',
    'ČELIČNA KONSTRUKCIJA':            'STEEL STRUCTURE',
    // Common building types
    'STAMBENI OBJEKAT':                'RESIDENTIAL BUILDING',
    'STAMBENO-POSLOVNI OBJEKAT':       'MIXED-USE BUILDING',
    'POSLOVNI OBJEKAT':                'COMMERCIAL BUILDING',
    'MOST':                            'BRIDGE',
    'POTPORNI ZID':                    'RETAINING WALL',
    'INFRASTRUKTURNI OBJEKAT':         'INFRASTRUCTURE STRUCTURE',
    'TURISTIČKI OBJEKAT':              'TOURISM FACILITY',
    'MONTAŽNI OBJEKAT':                'PREFABRICATED BUILDING',
    'JAVNI OBJEKAT':                   'PUBLIC BUILDING',

    // ── Additional project label keys ─────────────────────────────
    'VRIJEDNOST PROJEKTA:':            'PROJECT VALUE:',
    'VRIJEDNOST PROJEKTA':             'PROJECT VALUE',
    'BROJ OBJEKATA:':                  'NUMBER OF BUILDINGS:',
    'BROJ OBJEKATA':                   'NUMBER OF BUILDINGS',
    'SPRATNOST:':                      'STOREYS:',
    'SPRATNOST':                       'STOREYS',
    'DUŽINA:':                         'LENGTH:',
    'DUŽINA':                          'LENGTH',
    'VISINA:':                         'HEIGHT:',
    'VISINA':                          'HEIGHT',

    // Design phase values (for translateProjectLabel to translate the value part)
    'IDEJNI PROJEKAT':                 'CONCEPT DESIGN',
    'GLAVNI PROJEKAT':                 'MAIN PROJECT',
    'IZVEDBENI PROJEKAT':              'EXECUTIVE DESIGN',
    'PROJEKAT ZA GRAĐEVINSKU DOZVOLU': 'BUILDING PERMIT PROJECT',
    'ARHITEKTONSKA SAGLASNOST':        'ARCHITECTURAL CONSENT',
    'PROJEKAT IZVEDENOG STANJA':       'AS-BUILT PROJECT',
    'IZRADA GLAVNOG PROJEKTA':         'MAIN PROJECT PREPARATION',
    'IZMJENA GLAVNOG PROJEKTA':        'MAIN PROJECT REVISION',
    'USAGLAŠAVANJE SA EVROKODOVIMA':   'EUROCODE COMPLIANCE',

    // Common investors / client names (government bodies)
    'VLADA CRNE GORE':                 'GOVERNMENT OF MONTENEGRO',
    'UPRAVA ZA SAOBRAĆAJ':             'DIRECTORATE FOR TRANSPORT',
    'UNIVERZITET CRNE GORE':           'UNIVERSITY OF MONTENEGRO',

    // Extended building types
    'OBJEKAT VIŠEPORODIČNOG STANOVANJA':          'MULTI-FAMILY RESIDENTIAL BUILDING',
    'OBJEKAT MJEŠOVITE NAMJENE':                  'MIXED-USE BUILDING',
    'TURISTIČKO-APARTMANSKI BLOK':                'TOURIST-APARTMENT COMPLEX',
    'OBJEKAT OBRAZOVANJA':                        'EDUCATIONAL BUILDING',

    // Section separators used as icon-list items inside project data lists
    'OPIS PROJEKTA':                   'PROJECT DESCRIPTION',
    'PODACI PROJEKTA':                 'PROJECT DATA',
    'PODACI PROJEKTA:':                'PROJECT DATA:',
    'SLIKE PROJEKTA':                  'PROJECT IMAGES',
    'GALERIJA':                        'GALLERY',
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

    // ── Homepage "Zašto odabrati nas" — PRECIZNOST / 4th pillar
    'Naši projekti nisu samo tehnički ispravni':
      'Our projects are not only technically sound — they are carefully conceived, functionally optimised, and aesthetically aligned. We believe a quality project begins with precision and ends with client satisfaction, and this philosophy guides every step of our work.',

    // ── Homepage "Zašto odabrati nas" — ISKUSTVO / 2nd pillar
    'Naš tim čine stručnjaci sa višegodišnjim':
      'Our team consists of experts with extensive experience in design and construction. Knowledge gained in the field and through various project phases gives us the ability to identify potential challenges in the planning stage — and to resolve them efficiently.',

    // ── Homepage "Zašto odabrati nas" — ZNANJE / 3rd pillar
    'Redovno pohađamo stručne obuke':
      'We regularly attend professional training, seminars, and courses to stay current with the latest software solutions and technological innovations in the construction and design industry — enabling us to deliver modern, long-term sustainable solutions.',

    // ── Homepage "Zašto odabrati nas" — DETALJNOST / 1st pillar
    'Birajući nas, birate partnera':
      'By choosing us, you choose a partner who understands the importance of every millimetre, every plan, and every deadline. Quality, reliability, and expertise are not just our promises — they are the foundations on which we build every project.',

    // ── O NAMA page — Vladimir Jovanović biography
    'Rođen 17-og Jula 1989 godine u Baru':
      'Born on 17 July 1989 in Bar, he completed his primary and secondary education in his hometown of Ulcinj, graduating with distinction. He earned a Specialist degree from the Faculty of Civil Engineering in Podgorica in 2012, specialising in structural engineering. At the same institution, he obtained a Master\'s degree in Civil Engineering in 2023, with a focus on concrete structures and seismic engineering. Since 2024, he has been a doctoral student at the Faculty of Civil Engineering in Podgorica. He began his professional career in 2013 at "Arhitektonski Atelje" in Podgorica as a structural design engineer, contributing to numerous building and construction projects. In 2018, his ambition to work on major infrastructure led him to "CRBC Montenegro branch," where he served as a bridge design engineer, contributing to the documentation of bridges and retaining structures on the Smokovac–Mateševo motorway section. Following the completion of the motorway project in 2022, he founded "VACON" d.o.o. Podgorica — bringing together expertise and experience to serve partners who demand reliability and professionalism in every aspect of structural design.',

    // ── O NAMA page — Marija Knežević Jovanović biography
    'Rođena 8-og marta 1990. godine u Bijelom Polju':
      'Born on 8 March 1990 in Bijelo Polje, she completed her primary and secondary education there, graduating with distinction. She earned a Specialist degree from the Faculty of Civil Engineering in Podgorica on 06.02.2013, specialising in structural engineering with a focus on structural statics. She began her professional career in 2013 at "Bemax" in Podgorica in the technical preparation department, contributing to the realisation of some of Montenegro\'s largest construction projects. She also participated in the preparation and revision of project documentation, with particular emphasis on the design of retaining structures in infrastructure works. She joined our team in 2024, where she leads the construction execution department, working on retaining structure design and the preparation of tender documentation.',

    // ── Short CTA / button texts
    'Detaljnije o našim uslugama':     'Learn more about our services',
    'Detaljnije o projektima':         'View all projects',
    'Projekti':                        'Projects',
    'Kontakt':                         'Contact',

    // ── Form submit buttons
    'Pošalji poruku':                  'Send Message',
    'Pošaljite poruku':                'Send Message',
    'Pošalji':                         'Send',
    'Pošaljite':                       'Send',
    'Pošalji upit':                    'Send Enquiry',

    // ── CTA widget buttons (O NAMA team bio cards)
    'Portfolio':                       'Portfolio',
    'Kontakt':                         'Contact',
    'Pogledaj više':                   'View More',
    'Saznaj više':                     'Learn More',
    'Saznajte više':                   'Learn More',
    'Pogledajte više':                 'View More',
  };


  // ----------------------------------------------------------------
  // FORM LABELS — Elementor Pro form field <label> elements.
  // Exact match only (labels are short, explicit strings).
  // ----------------------------------------------------------------
  var FORM_LABELS = {
    'Ime':              'Name',
    'Ime i prezime':    'Full Name',
    'Tema':             'Subject',
    'Email':            'Email',
    'Poruka':           'Message',
    'Prilog':           'Attachment',
    'Telefon':          'Phone',
    'Naziv firme':      'Company Name',
    'Kompanija':        'Company',
    'Adresa':           'Address',
    'Grad':             'City',
    'Komentar':         'Comment',
    'Pitanje':          'Question',
    'Vaše ime':         'Your Name',
    'Vaš email':        'Your Email',
    'Vaša poruka':      'Your Message',
  };

  // ----------------------------------------------------------------
  // FORM PLACEHOLDERS — placeholder attribute values on <input> and
  // <textarea> elements inside Elementor Pro forms.
  // ----------------------------------------------------------------
  var FORM_PLACEHOLDERS = {
    'Ime i prezime / Naziv firme':
      'Full Name / Company Name',
    'Opišite vrstu radova za koji želite upit':
      'Describe the type of works you are enquiring about',
    'Opišite vrstu radova za koje želite upit':
      'Describe the type of works you are enquiring about',
    'Vaš email preko koga ćemo Vas kontaktirati':
      'Your email address — we will reply here',
    'Vaš email':
      'Your email address',
    'Poruka':
      'Message',
    'Vaša poruka':
      'Your message',
    'Ime i prezime':
      'Full Name',
    'Naziv firme':
      'Company Name',
  };

  /* ================================================================
     ORIGINAL TEXT CACHE
     We store each element's original CG text on first translation
     so we can restore it perfectly when switching back.
     origCache      — textContent (for plain-text elements)
     origHtmlCache  — innerHTML  (for elements with inline HTML like <strong>)
     ================================================================ */
  var origCache           = new WeakMap();
  var origHtmlCache       = new WeakMap();
  var origPlaceholderCache = new WeakMap(); // for input/textarea placeholder attributes

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
   * Translate a "LABEL: value" combined string.
   * Translates the LABEL prefix using dict (uppercase key matching), then
   * also attempts to translate the value part if it is a known term.
   * Example: "INVESTITOR: MOKA DN d.o.o." → "CLIENT: MOKA DN d.o.o."
   * Example: "NIVO RAZRADE: GLAVNI PROJEKAT" → "DESIGN PHASE: MAIN PROJECT"
   *
   * Caches both textContent and innerHTML so elements with inline <b>/<strong>
   * tags (e.g. FILOLOŠKI FAKULTET project) are fully restored on CG switch.
   */
  function translateProjectLabel(el, dict, toLang) {
    // Cache both plain text and markup on first call
    if (!origHtmlCache.has(el)) origHtmlCache.set(el, el.innerHTML);
    if (!origCache.has(el))     origCache.set(el, el.textContent);

    if (toLang === 'en') {
      var text = el.textContent.trim();
      var textUpper = text.toUpperCase();
      // Find the longest matching label prefix (prefer "INVESTITOR:" over "INVESTITOR")
      var bestKey = '';
      for (var key in dict) {
        if (textUpper.indexOf(key) === 0 && key.length > bestKey.length) {
          bestKey = key;
        }
      }
      if (bestKey) {
        var labelEn  = dict[bestKey];
        var valueRaw = text.slice(bestKey.length).replace(/^\s+/, ''); // trim leading spaces
        var valueEn  = dict[valueRaw.toUpperCase()] || valueRaw;       // translate value if known
        el.textContent = labelEn + (valueRaw ? ' ' + valueEn : '');
        return;
      }
    } else {
      // Restore full original markup (preserves <b> tags in bold-label items)
      el.innerHTML = origHtmlCache.get(el);
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

    // 5 ── Contact/CTA description paragraphs.
    //  Covers:
    //    • ehp-contact__description   — Hello Plus contact widget (KONTAKT section)
    //    • elementor-cta__description — Elementor CTA widget (team bios on O NAMA)
    //  Uses innerHTML cache so <br> markup is fully restored on CG switch.
    document.querySelectorAll(
      '.ehp-contact__description, .ehp-contact__description p, ' +
      '.elementor-cta__description, .elementor-cta__description p'
    ).forEach(function (el) {
      // Cache both text and markup on first pass
      if (!origHtmlCache.has(el)) origHtmlCache.set(el, el.innerHTML);
      if (!origCache.has(el))     origCache.set(el, el.textContent);

      if (lang === 'en') {
        var text = el.textContent.trim();
        // First: main contact description (hard-coded full translation)
        if (text.indexOf(CONTACT_DESC_CG) === 0) {
          el.textContent = CONTACT_DESC_EN;
          return;
        }
        // Fallback: BODY_TEXT partial-start match (biographies, other paras)
        for (var key in BODY_TEXT) {
          if (text.indexOf(key) === 0) {
            el.textContent = BODY_TEXT[key];
            return;
          }
        }
      } else {
        // Restore full original markup (preserves <br> line breaks in bios)
        el.innerHTML = origHtmlCache.get(el);
      }
    });

    // 6 ── Service titles: image-box (homepage pillars) + zigzag (Usluge page)
    document.querySelectorAll(
      '.elementor-image-box-title, ' +
      '.ehp-zigzag__title'
    ).forEach(function (el) {
      translateEl(el, SERVICES, lang);
    });

    // 7 ── Service descriptions: image-box + zigzag
    document.querySelectorAll(
      '.elementor-image-box-description, ' +
      '.elementor-image-box-description p, ' +
      '.ehp-zigzag__description'
    ).forEach(function (el) {
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

    // 9 ── Project page: section labels (PODACI PROJEKTA, etc.) via heading widgets
    document.querySelectorAll('.elementor-heading-title').forEach(function (el) {
      translateEl(el, PROJECT_LABELS, lang);
    });

    // 9b ── Divider text labels (OPIS PROJEKTA, SLIKE PROJEKTA) on project pages
    document.querySelectorAll('.elementor-divider__text').forEach(function (el) {
      translateEl(el, HEADINGS, lang);
      translateEl(el, PROJECT_LABELS, lang);
    });

    // 10 ── Project page inline labels (icon-text: INVESTITOR, GODINA, etc.)
    //  Icon-list items combine label + value: "INVESTITOR: MOKA DN d.o.o."
    //  translateProjectLabel splits on the label prefix, translates both halves.
    //  Allow single inline child (e.g. <b>INVESTITOR</b>: value) — these use
    //  innerHTML caching inside translateProjectLabel so <b> tags are restored.
    document.querySelectorAll(
      '.ehp-icon-list__text, ' +       // Hello Biz icon list
      '.elementor-icon-list__text'     // Elementor icon list
    ).forEach(function (el) {
      // el.children.length <= 1 covers both plain text and <b>label</b>: value format
      if (el.children.length <= 1) {
        translateProjectLabel(el, PROJECT_LABELS, lang);
      }
    });
    // Generic leaf <p> and <span> — plain exact match only (avoids false positives
    // on elements whose text combines label+value in unknown format)
    document.querySelectorAll('p, span').forEach(function (el) {
      if (el.children.length === 0) {
        translateEl(el, PROJECT_LABELS, lang);
      }
    });

    // 11 ── Contact text nodes (Mon–Fri, hours, phone/email labels)
    document.querySelectorAll(
      '.ehp-contact__contact-text, ' +
      '.ehp-contact__contact-link-label'
    ).forEach(function (el) {
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

    // 16 ── CTA / link text inside widgets ("Detaljnije o …", "Projekti", etc.)
    //  Covers: Elementor button widget, Hello Biz button, CTA widget buttons,
    //  and standalone .elementor-button-text spans.
    document.querySelectorAll(
      '.elementor-button-text, ' +
      '.elementor-widget-button .elementor-button, ' +
      '.elementor-cta__button, ' +                // CTA widget buttons (O NAMA team bios)
      '.elementor-cta .elementor-button, ' +      // alternate CTA button selector
      'a.ehp-button'
    ).forEach(function (el) {
      if (el.children.length === 0) {
        translateElPartial(el, BODY_TEXT, lang);
      }
    });

    // 17 ── Zigzag CTA button text ("Projekti") — also covered by step 16
    //  via a.ehp-button, but add explicit selector as safety net.
    document.querySelectorAll('.ehp-zigzag__button').forEach(function (el) {
      if (el.children.length === 0) {
        translateElPartial(el, BODY_TEXT, lang);
      }
    });

    // 18 ── Elementor Pro form: field <label> elements.
    //  Exact match against FORM_LABELS (labels are always short, unambiguous).
    document.querySelectorAll(
      '.elementor-field-label, ' +
      '.elementor-field-group > label'
    ).forEach(function (el) {
      if (el.children.length === 0) {
        translateEl(el, FORM_LABELS, lang);
      }
    });

    // 19 ── Elementor Pro form: placeholder attributes + submit button text.
    //  placeholder is an attribute, not textContent, so we cache with a
    //  separate WeakMap and swap the attribute value directly.
    document.querySelectorAll(
      '.elementor-form input[placeholder], ' +
      '.elementor-form textarea[placeholder]'
    ).forEach(function (el) {
      // Cache original CG placeholder on first encounter
      if (!origPlaceholderCache.has(el)) {
        origPlaceholderCache.set(el, el.getAttribute('placeholder') || '');
      }
      if (lang === 'en') {
        var origPh = origPlaceholderCache.get(el);
        var translated = FORM_PLACEHOLDERS[origPh];
        if (translated !== undefined) el.setAttribute('placeholder', translated);
      } else {
        el.setAttribute('placeholder', origPlaceholderCache.get(el));
      }
    });

    // Submit button — handled by step 16 (.elementor-button-text) when
    // "Pošalji poruku" appears in BODY_TEXT; this step is an explicit safety net
    // for the top-level button element that Elementor sometimes renders without
    // an inner .elementor-button-text span.
    document.querySelectorAll(
      '.elementor-form .elementor-button[type="submit"]'
    ).forEach(function (el) {
      // Only process if the button renders its text directly (no .elementor-button-text child)
      var textSpan = el.querySelector('.elementor-button-text');
      if (!textSpan && el.children.length === 0) {
        translateElPartial(el, BODY_TEXT, lang);
      }
    });

    // 20 ── PowerFolio portfolio filter buttons (PROJEKTI page category tabs).
    //  These render as <button class="portfolio-filter-item"> with the WordPress
    //  category/tag name as their text content.
    document.querySelectorAll('.portfolio-filter-item').forEach(function (el) {
      if (el.children.length === 0) {
        translateEl(el, HEADINGS, lang);
      }
    });

    // 21 ── Post/archive category badges & labels rendered by Elementor or
    //  WordPress theme (e.g. category tag chips on the PROJEKTI portfolio grid).
    document.querySelectorAll(
      '.elementor-post__badge, ' +
      '.elementor-post-info__item--type-category a, ' +
      '.elemenfoliocategory-label'
    ).forEach(function (el) {
      if (el.children.length === 0) {
        translateEl(el, HEADINGS, lang);
      }
    });
  }


  /* ================================================================
     BUTTON INJECTION
     ================================================================ */

  /**
   * Update all injected lang buttons to reflect the current language.
   * Call after every language switch so desktop and mobile stay in sync.
   */
  function syncButtons() {
    document.querySelectorAll('.vd-lang-toggle').forEach(function (b) {
      b.textContent = currentLang === 'cg' ? 'EN' : 'CG';
      b.title = currentLang === 'cg' ? 'Switch to English' : 'Prebaci na crnogorski';
    });
  }

  function createToggleBtn(btnId) {
    var btn = document.createElement('button');
    btn.id = btnId || 'vd-lang-btn';
    btn.className = 'vd-lang-toggle';
    btn.setAttribute('type', 'button');
    btn.setAttribute('aria-label', 'Switch language');
    btn.setAttribute('title', currentLang === 'cg' ? 'Switch to English' : 'Prebaci na crnogorski');
    btn.textContent = currentLang === 'cg' ? 'EN' : 'CG';

    btn.addEventListener('click', function () {
      currentLang = currentLang === 'cg' ? 'en' : 'cg';
      localStorage.setItem(STORAGE_KEY, currentLang);
      syncButtons();             // keep desktop ↔ mobile in sync
      applyLanguage(currentLang);
    });

    return btn;
  }

  function injectButton() {
    // ── DESKTOP button ────────────────────────────────────────────────
    // Hello Plus renders TWO .ehp-header__ctas-container elements:
    //   1. INSIDE <nav class="ehp-header__navigation"> — mobile dropdown
    //   2. As direct child of .ehp-header__elements-container — desktop bar
    // We MUST target only the desktop one (child combinator >).
    if (!document.getElementById('vd-lang-btn')) {
      var desktopTarget =
        document.querySelector('.ehp-header__elements-container > .ehp-header__ctas-container') ||
        document.querySelector('.ehp-header__ctas-container:not(nav .ehp-header__ctas-container)') ||
        document.querySelector('.ehp-header__navigation');

      if (desktopTarget) {
        var desktopBtn = createToggleBtn('vd-lang-btn');
        if (desktopTarget.classList.contains('ehp-header__navigation')) {
          desktopTarget.parentNode.insertBefore(desktopBtn, desktopTarget.nextSibling);
        } else {
          desktopTarget.insertBefore(desktopBtn, desktopTarget.firstChild);
        }
      }
    }

    // ── MOBILE button (inside hamburger dropdown) ─────────────────────
    // Injected into the CTA container INSIDE the nav dropdown so it
    // appears when the hamburger menu is open on ≤1024px screens.
    if (!document.getElementById('vd-lang-btn-mobile')) {
      var mobileTarget =
        document.querySelector('nav.ehp-header__navigation .ehp-header__ctas-container') ||
        document.querySelector('.ehp-header__navigation .ehp-header__ctas-container');

      if (mobileTarget) {
        var mobileBtn = createToggleBtn('vd-lang-btn-mobile');
        mobileBtn.classList.add('vd-lang-btn-mobile');
        mobileTarget.insertBefore(mobileBtn, mobileTarget.firstChild);
      }
    }

    // Retry up to 10× at 200ms if either target wasn't ready yet
    var desktopMissing = !document.getElementById('vd-lang-btn');
    var mobileMissing  = !document.getElementById('vd-lang-btn-mobile');
    if ((desktopMissing || mobileMissing) &&
        (injectButton._tries = (injectButton._tries || 0) + 1) < 10) {
      setTimeout(injectButton, 200);
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
