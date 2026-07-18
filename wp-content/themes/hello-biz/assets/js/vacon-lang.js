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
    // USLUGE page zigzag — rewritten 2026-07-18. CG titles are the new
    // source content (see zigzag widget on page 137); EN wording below
    // is verbatim as supplied for the rewrite.
    '1. PROJEKTOVANJE OBJEKATA':              '1. STRUCTURAL DESIGN FOR BUILDINGS',
    'PROJEKTOVANJE OBJEKATA':                 'STRUCTURAL DESIGN FOR BUILDINGS',

    '2. SEIZMIČKO PROJEKTOVANJE':             '2. SEISMIC ENGINEERING & STRUCTURAL ANALYSIS',
    'SEIZMIČKO PROJEKTOVANJE':                'SEISMIC ENGINEERING & STRUCTURAL ANALYSIS',

    '3. ZAŠTITA ISKOPA':                      '3. RETAINING STRUCTURES & GEOTECHNICAL SYSTEMS',
    'ZAŠTITA ISKOPA':                         'RETAINING STRUCTURES & GEOTECHNICAL SYSTEMS',

    '4. MOSTOVI I INFRASTRUKTURNI OBJEKTI':   '4. BRIDGE & INFRASTRUCTURE ENGINEERING',
    'MOSTOVI I INFRASTRUKTURNI OBJEKTI':      'BRIDGE & INFRASTRUCTURE ENGINEERING',

    '5. OPTIMIZACIJA KONSTRUKCIJA':           '5. STRUCTURAL OPTIMIZATION',
    'OPTIMIZACIJA KONSTRUKCIJA':              'STRUCTURAL OPTIMIZATION',

    '6. PODRŠKA U PROJEKTOVANJU KONSTRUKCIJA': '6. STRUCTURAL DESIGN SUPPORT',
    'PODRŠKA U PROJEKTOVANJU KONSTRUKCIJA':   'STRUCTURAL DESIGN SUPPORT',

    // Homepage short-form titles (no number prefix, shorter names)
    'IZVOĐENJE':                              'CONSTRUCTION',
    'TENDERI':                                'TENDERS',

    // ── Descriptions (matched via opening phrase) ─────────────────
    // USLUGE page — rewritten 2026-07-18, EN text supplied verbatim.

    // 1. Projektovanje objekata
    'Projektujemo armirano-betonske, čelične i spregnute konstruktivne sisteme':
      'We design reinforced concrete, steel, and composite structural systems for residential developments, mixed-use projects, hotels, office buildings, and commercial facilities. Our approach focuses on creating structurally efficient solutions aligned with architectural intent, construction feasibility, and long-term structural performance. From concept development to detailed engineering documentation, each project is developed with emphasis on technical precision, coordination efficiency, and rational structural design.',

    // 2. Seizmičko projektovanje
    'Pružamo napredne konstruktivne analize i seizmički otporno projektovanje':
      'We provide advanced structural analysis and seismic-resistant design for projects located in demanding seismic regions. Our expertise includes structural behavior assessment, performance-oriented engineering, and development of structurally reliable systems according to Eurocode 8 requirements. This allows us to support projects where structural safety, seismic resilience, and technical reliability are critical.',

    // 3. Zaštita iskopa
    'Razvijamo potporne sisteme i sisteme zaštite za projekte':
      'We develop retaining and support systems for projects requiring technically reliable solutions in challenging terrain and excavation conditions. Our work includes retaining walls, anchored systems, excavation support structures, and integration of structural solutions with geotechnical design requirements.',

    // 4. Mostovi i infrastrukturni objekti
    'Naše iskustvo obuhvata učešće u infrastrukturnim':
      'Our experience includes participation in infrastructure and transportation-related projects involving bridges, retaining structures, and technically complex reinforced concrete systems. This background contributes to a deeper understanding of structural behavior, durability, large-scale coordination, and engineering performance under demanding loading and environmental conditions.',

    // 5. Optimizacija konstrukcija
    'Efikasnom konstruktivnom projektovanju pristupamo kroz optimizaciju':
      'Efficient structural design is approached through optimization of material usage, constructability, and structural performance. The objective is to develop rational structural systems that balance safety, architectural flexibility, construction efficiency, and long-term durability.',

    // 6. Podrška u projektovanju konstrukcija
    'Sarađujemo sa arhitektonskim i inženjerskim':
      'We collaborate with architectural and engineering practices requiring reliable structural engineering support for Eurocode-based projects. Our services include structural analysis, reinforced concrete and steel design, technical detailing, BIM-compatible workflows, and engineering documentation. We integrate into multidisciplinary international teams with focus on technical precision, efficient coordination, and dependable project delivery.',

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
    'GLAVNI PROJEKAT (USAGLAŠAVANJE SA EVROKODOVIMA)': 'MAIN PROJECT (EUROCODE COMPLIANCE)',

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

    // ── PODACI PROJEKTA — whole-line icon-list items (building type /
    //  role blurb, no "LABEL: value" split) that are unique per project.
    'OBJEKAT MJEŠOVITE NAMJENE NA LOKACIJI ZGRADE "STARE POŠTE"':
      'Mixed-use building on the site of the former Post Office building',
    'PROJEKTANT KONSTRUKCIJE U SARADNJU SA PROBUILDING DOO PODGORICA':
      'Structural engineer in cooperation with PROBUILDING doo Podgorica',
    'AUTOPUT SMOKOVAC-UVAČ-MATEŠEVO':  'SMOKOVAC-UVAČ-MATEŠEVO MOTORWAY',
    'KOLEKTIVNI STAMBENI OBJEKAT SA DJELATNOSTIMA':
      'Collective residential building with commercial units',
    'PROJEKTANT KONSTRUKCIJE U OKVIRU BIROA ARHITEKTONSKI ATELJE':
      'Structural engineer within the Arhitektonski Atelje practice',
    'STAMBENO NASELJE UPPER VILLAGE':  'Upper Village Residential Complex',
    'OBJEKAT 5 U OKVIRU REZIDENCIJALNOG NASELJA':
      'BUILDING 5 within the residential complex',
    'REGIONALNI PUT R13':              'R13 REGIONAL ROAD',
    'STAMBENO NASELJE LJUBOVIĆ HILL HOMES': 'Ljubović Hill Homes Residential Complex',
    'PROJEKTANT KONSTRUKCIJE U SARADNJU SA RZUP AD PODGORICA':
      'Structural engineer in cooperation with RZUP AD Podgorica',
    'STAMBENO NASELJE MASTER KVART':   'Master Kvart Residential Complex',
    'TURISTIČKO-APARTMANSKI BLOK 2*':  'TOURIST-APARTMENT BLOCK 2*',
    'STAMBENI OBJEKAT POSH RESIDENCE': 'RESIDENTIAL BUILDING – POSH RESIDENCE',
    'POSLOVNI OBJEKAT CUNGU':          'COMMERCIAL BUILDING – CUNGU',
    'MAGISTRALNI PUT M21':             'M21 MAIN ROAD',
    'STAMBENI OBJEKAT MOKA PLACE':     'RESIDENTIAL BUILDING – MOKA PLACE',
    'OBJEKAT OBRAZOVANJA - FILOLOŠKI FAKULTET':
      'EDUCATIONAL BUILDING - FACULTY OF PHILOLOGY',
    'OBJEKAT MJEŠOVITE NAMJENE (MN), HOTEL SA KONDO MODELOM POSLOVANJA':
      'MIXED-USE BUILDING (MU), HOTEL WITH A CONDO-HOTEL BUSINESS MODEL',
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

    // ── USLUGE page — intro paragraph (rewritten 2026-07-18)
    'Naša firma pruža sveobuhvatna rješenja':
      'Our company delivers comprehensive civil engineering solutions, seamlessly combining technical expertise, precision, and modern technology. We support our clients through every stage of the project lifecycle—from initial conceptual design and detailed planning to flawless execution and expert site supervision. Every project is driven by our commitment to responsibility, ensuring the highest standards of safety, quality, and structural functionality.',

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
    'Rođen je 17. jula 1989. godine u Baru.':
      'Born on 17 July 1989 in Bar, he completed his primary and secondary education in his hometown of Ulcinj, where he was awarded the "Luča" diploma. He earned a Specialist degree from the Faculty of Civil Engineering in Podgorica in 2012, in the Structural Engineering track. At the same institution, he earned a Master\'s degree in Civil Engineering in 2023 in the field of concrete structures and earthquake engineering, and since 2024 has been a doctoral student. He began his professional career in 2013 at "Arhitektonski Atelje" in Podgorica as a structural design engineer, where he contributed to numerous building construction projects. His ambition to work on infrastructure projects led him, in 2018, to "CRBC Montenegro Branch" as a bridge design engineer, where he made a significant contribution to the technical documentation for bridges and retaining structures on the Smokovac–Mateševo motorway section. After completing the motorway project, he founded "VACON" d.o.o. Podgorica in 2022, with the goal of putting his previously gained knowledge and extensive experience at the service of partners seeking maximum reliability and expertise in the preparation of project documentation.',

    // ── O NAMA page — Marija Knežević Jovanović biography
    'Rođena je 8. marta 1990. godine u Bijelom Polju':
      'Born on 8 March 1990 in Bijelo Polje, where she completed her primary and secondary education as a recipient of the "Luča" diploma. She earned a Specialist degree from the Faculty of Civil Engineering in Podgorica on 6 February 2013, in the Structural Engineering track, specialising in structural statics. She began her professional career in 2013 at "Bemax" in Podgorica, in the technical preparation department, where she contributed to the realisation of some of Montenegro\'s largest construction projects. During this engagement, she made a significant contribution to the preparation and revision of project documentation, with particular emphasis on the design of retaining structures in infrastructure projects. She joined our team in 2024, since when she has successfully led the construction execution department, working on retaining structure design and the preparation of tender documentation.',

    // ── PROJECT PAGES — "OPIS PROJEKTA" description paragraphs.
    //  Keys are full source paragraphs (or exact opening ones for long
    //  single-paragraph descriptions) from each project post's Elementor
    //  text-editor widget(s). Matched by translateElPartialHtml in step 14.

    // Hyatt Regency Kotor Bay Resort
    'Luksuzni hotelski kompleks “Blue Kotor Bay” nalazi se u naselju Stoliv, opština Kotor. U okviru projekta urađena je rekonstrukcija postojećeg hotela Vrmac kao i izrada novih hotelskih zgrada, vila, bazena i ostalih tehničkih objekata ukupne površine BGRP: 27.908,43m2.Svi objekti su projektovani u skladu sa važećim Evrokod propisima, sa posebnom pažnjom naseizmičku otpornost objekata, zbog visokog seizmičkog rizika predmetne lokacije.':
      'The luxury hotel complex "Blue Kotor Bay" is located in Stoliv, Municipality of Kotor. The project included the reconstruction of the existing Hotel Vrmac as well as the design of new hotel buildings, villas, pools, and other technical facilities, with a total gross floor area (GFA) of 27,908.43 m². All buildings were designed in accordance with applicable Eurocode standards, with particular attention to seismic resistance given the high seismic risk of the site.',

    // Sanacija klizišta kod mosta Uvač 4
    'Usled pojave klizišta i pomjeranje oporca mosta Uvač 4, bilo je neophodno produžavanje pomenutog mosta do novoizgrađenog oporca i sanacija klizišta.Sanacija je urađena korištenjem zidova od šipova, AB roštilja sa prednapregnutim geosidrima i izradom sistema za odvodnjavanje atmosferskih voda.Kontrola globalne stabilnosti urađena je korištenjem softvera PLAXIS 2D, dok je dimenzionisanje izvršeno u programu TOWER 8.':
      'Following the occurrence of a landslide and displacement of the Uvač 4 bridge abutment, it was necessary to extend the bridge to a newly built abutment and remediate the landslide. Remediation was carried out using pile walls, a reinforced-concrete (RC) grillage with prestressed ground anchors, and a stormwater drainage system. Global stability was checked using PLAXIS 2D software, while dimensioning was performed in TOWER 8.',

    // Mostovi sekcije 4, dionice autoputa Smokovac-Uvač-Mateševo
    'Zbog nepovoljnog terena na pomenutoj sekciji, bilo je neophodno uraditi veliki broj mosta. Na tom potezu imamo sledeće mostove: ':
      'Due to unfavourable terrain along this section, a large number of bridges had to be built. Along this stretch we have the following bridges:',
    'Mištica, Zagrade, Čestogaz, Uvač 1:4, Pajkov Vir, Jabuka 1:2, Tara 1:2, kao i mostovi na petlji Mateševo.':
      'Mištica, Zagrade, Čestogaz, Uvač 1–4, Pajkov Vir, Jabuka 1–2, Tara 1–2, as well as the bridges at the Mateševo interchange.',
    'Svi mostovi su projektovani kao betonski(puni ili sandučasti presjek) sa prednapregnutim kablovima, fundirani na šipovima zbog loše nosivosti tla.':
      'All bridges were designed as concrete structures (solid or box cross-section) with prestressed cables, founded on piles due to poor soil bearing capacity.',
    'Projekti su urađeni u skladu sa “Smjernice za projektovanje, građenje, održavanje i nadzor na putevima - BiH” i Evrokod 8 pravilnikom.':
      'The designs were prepared in accordance with the "Guidelines for the Design, Construction, Maintenance and Supervision of Roads – BiH" and Eurocode 8.',

    // Volvox inženjering
    'Usvojeni konstruktivni sistem za prijem i prenos gravitacionog i horizontalnog opterećenja čine AB tavanice, ramovi i zidna platna, koji služe za prenos navedenih opterećenja do AB temelja, tako da se sistem može klasifikovati kao mješoviti sistem sa dominantnim zidovima.':
      'The adopted structural system for resisting and transferring gravity and horizontal loads consists of RC slabs, frames, and shear walls, which transfer these loads down to the RC foundations, so the system can be classified as a mixed system with dominant walls.',
    'Krovnu i spratne tavanice POS T 300 – T 1000 čini AB ploča debljine d=20,0 cm, oslonjena na AB grede i AB zidove i stubove. Horizontalnu međuspratnu konstrukciju podzemnih etaza T 100 i t 200 čine AB ploče d=22,0 cm oslonjene na AB zidna platna i stubove oslonjene preko kapitela debljine 50cm. Podna ploča suterena je ploča koja ne učestvuje u prenošenju ukupnog opterećenja objekta na tlo, zbog čega je usvojene debljine 15,0 cm, lako armirana. Izvodi se na sloju od nabijenog šljunkovitog tampona debljine 45,0 cm, između temeljne trake, i zidova suterana. Konstruktivni sistem, odnosno vertikalni noseći sistem konstrukcije čini armirano-betonski stubovi i AB zidna platna u dva međusobno ortogonalna pravca obezbjeđujući potrebnu krutost objekt tako da, osim gravitacionih opterećenja, primaju horizontalne uticaje od vjetra i sezmičkih sila, prenoseći ih do temelja. AB ZP su debljine dz=20,0; 25,0; 30,0 i 40,0 cm. Stubovi su dim 40/40 cm, 40/60 cm i 40/90 cm, kao i kružni stubovi prečnika 60cm. Grede su različitih dimenzija širine od 20 do 40 cm, visine od 40 do 60cm.Stepenišna kosa ploča je debljine 18,00 cm.':
      'The roof and floor slabs at levels T300–T1000 consist of a 20.0 cm thick RC slab, supported on RC beams, RC walls, and columns. The horizontal floor structure of the basement levels T100 and T200 consists of 22.0 cm thick RC slabs supported on RC shear walls and columns via 50 cm thick capitals. The basement floor slab does not participate in transferring the building\'s overall load to the ground, so it was adopted at a thickness of 15.0 cm, lightly reinforced. It is cast on a 45.0 cm layer of compacted gravel fill, between the foundation strip and the basement walls. The structural system — i.e. the vertical load-bearing system — consists of reinforced-concrete columns and RC shear walls in two mutually orthogonal directions, providing the building with the stiffness needed to resist, besides gravity loads, horizontal wind and seismic actions and transfer them to the foundations. The RC shear walls are 20.0, 25.0, 30.0, and 40.0 cm thick. Columns measure 40/40 cm, 40/60 cm and 40/90 cm, as well as circular columns of 60 cm diameter. Beams vary in width from 20 to 40 cm and depth from 40 to 60 cm. The sloped staircase slab is 18.00 cm thick.',

    // Luštica bay – Upper village
    'Usvojeni konstruktivni sistem za prijem i prenos gravitacionog i horizontalnog opterećenja činepune armiranobetonske ploče koje se oslanjaju na grede i zidove na svim spratovima. Dalje se prekoplatana opterećenje prenosi na temelje. Konstrukcija se može klasifikovati kao masivni AB zid.Krovna ploča je kosa AB ploča debljine 20 cm. Krov je formiran iz više krovnih ravni koje sudenivelisane. Međuspratna tavanica i ploča balkona su debljine 20 i 14cm. AB ploče su oslonjene na ABgrede i zidove. Podna ploča objekta je debljine 10 cm. Izvodi se na sloju nabijenog šljunkovitogtampona (Ms=40 000 kN/m2), kako je naglašeno u geomehaničkom elaboratu.AB zidovi su debljine dz=20cm. AB grede su pravougaonog poprečnog presjeka dimenzija20/35, 20/40, 20/50, 20-62 i 20/811cm. Stepenišna ploča je koljenasta kosa ploča debljine 15cm.':
      'The adopted structural system for resisting and transferring gravity and horizontal loads consists of solid RC slabs supported on beams and walls at every floor. Loads are then transferred through the slabs down to the foundations. The structure can be classified as a massive RC-wall system. The roof slab is a sloped RC slab, 20 cm thick. The roof is formed from several roof planes at different levels. The floor slab and balcony slabs are 20 cm and 14 cm thick respectively. The RC slabs are supported on RC beams and walls. The building\'s ground-floor slab is 10 cm thick, cast on a layer of compacted gravel fill (Ms = 40,000 kN/m²), as specified in the geotechnical report. The RC walls are 20 cm thick. The RC beams have rectangular cross-sections measuring 20/35, 20/40, 20/50, 20/62 and 20/80 cm. The staircase slab is a bent sloped slab, 15 cm thick.',

    // Rezidencijalno naselje – Objekat 5
    'Konstrukcija objekta je koncipirana kao armirano betonska kontrukcija, koja se sastoji se od ab zidova, stubova ploča i greda. Dispoziciono, rješenje konstrukcije je uslovljeno usvojenim arhitektonskim rješenjem i na osnovu analize na proračunskom modelu. Sve međuspratne tavanice na nadzemnom dijelu objekta, uključujući i ploču na koti prizemlja (38.50mnm), su projektovane kao ab ploče debljine 18cm. Ploča nad prvim i drugim nivoom garaže je debljine 20cm. Ploče se oslanjaju na ab grede i zidove. Najčešće korištene grede u predmetnoj konstrukciji su presjeka b/d=25/60cm. Osim njih, na pojedinim mjestima su primijenjene i grede presjeka b/d=20/60cm, b/d=25/50cm, b/d=20/50cm, b/d=25/40cm, b/d=25/100cm I b/d=20/100cm. Armirano betonski stubovi i zidovi prihvataju sva gravitaciona opterećenja (stalno i povremeno) i prenose ih na temeljnu konstrukciju. U prihvatanju seizmičkih uticaja dominantno učešće imaju AB zidovi raspoređeni u dva ortogonalna pravca. Svi obodni zidovi, koji su u kontaktu sa zasipom, do nivoa prizemlja su debljine 25cm. Ovo iz razloga što na njih djeluje bočni pritisak tla, kako u miru tako i u uslovima seizmičke pobude. Problem djelovanja bočnog pritiska tla na obodne zidove objekta je relativno lako riješen jer međuspratne tavanice predstavljaju oslonac za zid napregnut upravno na svoju ravan. Obodni zid koji oivičava stepenišni prostor nema oslonac u nivou međuspratnih tavanica pa je na tom dijelu dodata greda (b/d=30/90cm) u horizontalnoj ravni na koti 38.20mnm, i stub (b/d=30/90) na polovini raspona ove grede, u svemu kao što je prikazano na planovima pozicija i oplate. Na ovaj način je dobijena prihvatljiva količina potrebne armature u obodnom zidu. Zidovi na objektu na nadzemnom dijelu su većinom debljine 25cm, dok je debljina nekolicine 20cm. AB stubova javljaju je samo na mjestima povlačenja tavanice, gdje nemamo kontinuitet vertikalnih elemenata, te se iste izvode iz greda. Stepenište je jednokrako, sa zavojnim dijelom na početku i kraju. Zavojni dio je krutno vezan za ploču u svom nivou i za zid koji ga oivičava sa desne strane. Pravi dio stepenišne ploče se oslanja na zavojni dio sa lijeve strane. Debljina stepenišne ploče je 16cm a dimenzije gazišta su 16.66/28cm.':
      'The building\'s structure is conceived as a reinforced-concrete structure consisting of RC walls, columns, slabs and beams. The structural layout is dictated by the adopted architectural design and by analysis of the calculation model. All floor slabs above ground, including the ground-floor slab (at el. 38.50 m), are designed as 18 cm thick RC slabs. The slab above the first and second garage levels is 20 cm thick. The slabs are supported on RC beams and walls. The most commonly used beams in this structure have a cross-section of b/d = 25/60 cm. In addition, beams with cross-sections of b/d = 20/60 cm, 25/50 cm, 20/50 cm, 25/40 cm, 25/100 cm and 20/100 cm are used in certain locations. Reinforced-concrete columns and walls carry all gravity loads (permanent and live) and transfer them to the foundation structure. RC walls arranged in two orthogonal directions play the dominant role in resisting seismic actions. All perimeter walls in contact with backfill, up to ground level, are 25 cm thick, since they are subject to lateral soil pressure both at rest and under seismic excitation. The effect of lateral soil pressure on the building\'s perimeter walls is relatively easily resolved, since the floor slabs act as supports for the wall spanning perpendicular to its plane. The perimeter wall enclosing the staircase has no support at floor-slab level, so a beam (b/d = 30/90 cm) was added at that location, in a horizontal plane at el. 38.20 m, together with a column (b/d = 30/90 cm) at the mid-span of this beam, all as shown on the position and formwork drawings. This arrangement resulted in an acceptable amount of reinforcement in the perimeter wall. The above-ground walls are mostly 25 cm thick, with a few at 20 cm. RC columns occur only where the slab is set back, where there is no continuity of vertical elements, so they are formed from beams. The staircase is single-flight, with a helical section at the top and bottom. The helical section is rigidly connected to the slab at its level and to the wall bounding it on the right-hand side. The straight part of the staircase slab is supported on the helical section on the left-hand side. The staircase slab is 16 cm thick, with tread dimensions of 16.66/28 cm.',

    // Rekonstrukcija regionalnog puta R13, Bioča – Petnjica
    'Izmjena glavnog projekta „Rekonstrukcija lokalnog puta Gusare(Petnjica) - Bioča (Bijelo Polje)“, preprojektovanjem gabionskih potpornih zidova u AB zidove u dužini od 2200m u skladu sa Evrokod propisima. Visina zidova kreće se u rasponu od 2,0-8,0m, gdje je na pojedinim mjestima zbog neposredne blizine rijeke Lješnice bilo neophodno predvidjeti izradu obaloutvrda.':
      'Revision of the main design "Reconstruction of the local road Gusare (Petnjica) – Bioča (Bijelo Polje)", by redesigning gabion retaining walls into RC walls along a length of 2,200 m in accordance with Eurocode standards. Wall heights range from 2.0–8.0 m, and in certain locations, due to the immediate proximity of the Lješnica river, riverbank protection works also had to be designed.',
    'Takođe je urađeno i usaglađavanje dva integralna mosta sa Evrokod propisima.':
      'Two integral bridges were also brought into compliance with Eurocode standards.',

    // LJUBOVIĆ HILL HOMES
    'Stambeno naselje "Ljubović Hill Homes" sastoji se od 6 lamela spratnosti G+P+6 sa centralnom garažom na jednom nivou. BGRP≈ 30 485m2':
      'The "Ljubović Hill Homes" residential complex consists of 6 blocks with a basement + ground floor + 6 storeys configuration and a central single-level garage. GFA ≈ 30,485 m²',
    'Krovnu i spratne tavanice POS T200 – T 800 čini AB ploča debljine d=20,0 cm i konzolna ploča d=14,0 cm, oslonjena na AB grede i AB zidove. Horizontalnu međuspratnu konstrukciju podzemne etaze T 100 čine AB ploče d=22 cm oslonjene na AB zidna platna. Podna ploča suterena je ploča koja ne učestvuje u prenošenju ukupnog opterećenja objekta na tlo, zbog čega je usvojene debljine 15,0 cm, lako armirana. Izvodi se na sloju od nabijenog šljunkovitog tampona debljine 45,0 cm, između temeljnih traka. Konstruktivni sistem, odnosno vertikalni noseći sistem konstrukcije čini AB zidna platna u dva međusobno ortogonalna pravca obezbjeđujući potrebnu krutost objekt tako da, osim gravitacionih opterećenja, primaju horizontalne uticaje od vjetra i sezmičkih sila, prenoseći ih do temelja. AB ZP su debljine dz=20,0 i 25,0 cm. Grede su različitih dimenzija širine od 20 do 25 cm, visine od 40 do 60cm.Stepenišna kosa ploča je debljine 16,00 cm.':
      'The roof and floor slabs at levels T200–T800 consist of a 20.0 cm thick RC slab and a 14.0 cm cantilever slab, supported on RC beams and RC walls. The horizontal floor structure of basement level T100 consists of 22 cm thick RC slabs supported on RC shear walls. The basement floor slab does not participate in transferring the building\'s overall load to the ground, so it was adopted at a thickness of 15.0 cm, lightly reinforced. It is cast on a 45.0 cm layer of compacted gravel fill, between the foundation strips. The structural system — i.e. the vertical load-bearing system — consists of RC shear walls in two mutually orthogonal directions, providing the building with the stiffness needed to resist, besides gravity loads, horizontal wind and seismic actions and transfer them to the foundations. The RC shear walls are 20.0 and 25.0 cm thick. Beams vary in width from 20 to 25 cm and depth from 40 to 60 cm. The sloped staircase slab is 16.00 cm thick.',

    // STARA POŠTA
    'Objekat mješovite namjene na lokaciji zgrade "Stare Pošte" sastoji od tri lamele spratnosti G+P+10 i G+P+4 ukupne bruto površine 12 632 m2':
      'The mixed-use building on the site of the former Post Office building consists of three blocks with basement + ground floor + 10 and basement + ground floor + 4 storey configurations, with a total gross floor area of 12,632 m²',
    'Krovnu i spratne tavanice POS T300 – T 1000 čini AB ploča debljine d=16,0 (17) cm, oslonjena na AB grede i AB zidove i stubove. Horizontalnu međuspratnu konstrukciju podzemne etaze T 100 i T200 čine AB ploče d=20,0 cm oslonjene na AB obodne fasadne grede i AB zidna platna i stubove na koje se oslanja na kapitele debljine d=40,0cm. Konstruktivni sistem, odnosno vertikalni noseći sistem konstrukcije čini armirano-betonski stubovi i AB zidna platna u dva međusobno ortogonalna pravca obezbjeđujući potrebnu krutost objekt tako da, osim gravitacionih opterećenja, primaju horizontalne uticaje od vjetra i sezmičkih sila, prenoseći ih do temelja. AB ZP su debljine dz=20,0; 25,0; 30,0 i 40,0 cm. Stubovi su dim 40/40; 40/60 i 60/60cm. Grede su različitih dimenzija širine od 20 do 25 cm, visine 60cm.Stepenišna kosa ploča je debljine 16,00 cm.':
      'The roof and floor slabs at levels T300–T1000 consist of a 16.0 (17) cm thick RC slab, supported on RC beams, RC walls, and columns. The horizontal floor structure of basement levels T100 and T200 consists of 20.0 cm thick RC slabs supported on RC perimeter façade beams and RC shear walls, and on columns resting on 40.0 cm thick capitals. The structural system — i.e. the vertical load-bearing system — consists of reinforced-concrete columns and RC shear walls in two mutually orthogonal directions, providing the building with the stiffness needed to resist, besides gravity loads, horizontal wind and seismic actions and transfer them to the foundations. The RC shear walls are 20.0, 25.0, 30.0, and 40.0 cm thick. Columns measure 40/40, 40/60, and 60/60 cm. Beams vary in width from 20 to 25 cm and are 60 cm deep. The sloped staircase slab is 16.00 cm thick.',

    // MASTER KVART
    'Stambeno naselje "Master Kvart" sastoji se od 14 lamela spratnosti G-2+P+10 sa centralnom garažom na dva nivoa. BGRP≈ 100 000m2':
      'The "Master Kvart" residential complex consists of 14 blocks with a 2 basement + ground floor + 10 storeys configuration and a two-level central garage. GFA ≈ 100,000 m²',
    'Usvojeni konstruktivni sistem za prijem i prenos gravitacionog i horizontalnog opterećenja čine AB tavanice, ramovi i zidna platna, koja služe za prenos navedenih opterećenja do AB temelja, tako da sistem nezavisnih zidova u oba pravca. ':
      'The adopted structural system for resisting and transferring gravity and horizontal loads consists of RC slabs, frames and shear walls, which transfer these loads to the RC foundations, forming a system of independent walls in both directions.',
    'Krovnu i spratne tavanice POS T300 – T 1300 čini AB ploča debljine d=17,0 cm, konzolna ploča d=14,0 cm i ploče balkona d=12,0cm, oslonjena na AB grede i AB zidove i stubove. Horizontalnu međuspratnu konstrukciju podzemne etaze T 100 i T200 čine AB ploče d=20,0 i 17,0 cm oslonjene na AB zidna platna i grede. Podna ploča suterena je ploča koja ne učestvuje u prenošenju ukupnog opterećenja objekta na tlo, zbog čega je usvojene debljine 16,0 cm, lako armirana. Izvodi se na sloju od nabijenog šljunkovitog tampona debljine 45,0 cm, između temeljnih traka. Konstruktivni sistem, odnosno vertikalni noseći sistem konstrukcije čini armirano-betonski stubovi i AB zidna platna u dva međusobno ortogonalna pravca obezbjeđujući potrebnu krutost objekt tako da, osim gravitacionih opterećenja, primaju horizontalne uticaje od vjetra i sezmičkih sila, prenoseći ih do temelja. AB ZP su debljine dz=20,0; 25,0; 35,0 i 45,0 cm. Stubovi su dim 25/50 cm i 45/50 cm. Grede su različitih dimenzija širine od 20 do 25 cm, visine od 40 do 60cm.Stepenišna kosa ploča je debljine 15,00 cm.':
      'The roof and floor slabs at levels T300–T1300 consist of a 17.0 cm thick RC slab, a 14.0 cm cantilever slab, and 12.0 cm balcony slabs, supported on RC beams, RC walls, and columns. The horizontal floor structure of basement levels T100 and T200 consists of 20.0 and 17.0 cm thick RC slabs supported on RC shear walls and beams. The basement floor slab does not participate in transferring the building\'s overall load to the ground, so it was adopted at a thickness of 16.0 cm, lightly reinforced. It is cast on a 45.0 cm layer of compacted gravel fill, between the foundation strips. The structural system — i.e. the vertical load-bearing system — consists of reinforced-concrete columns and RC shear walls in two mutually orthogonal directions, providing the building with the stiffness needed to resist, besides gravity loads, horizontal wind and seismic actions and transfer them to the foundations. The RC shear walls are 20.0, 25.0, 35.0, and 45.0 cm thick. Columns measure 25/50 cm and 45/50 cm. Beams vary in width from 20 to 25 cm and depth from 40 to 60 cm. The sloped staircase slab is 15.00 cm thick.',

    // EFEL BUDVA
    'Usvojeni konstruktivni sistem za prijem i prenos gravitacionog i horizontalnog opterećenja čine AB tavanice, ramovi i zidna platna, koja služe za prenos navedenih opterećenja do AB temelja, tako da se sistem može klasifikovati kao dvojni sistem sa dominantnim zidovima u X pravcu i kao sistem nezavisnih zidova u Y pravcu.':
      'The adopted structural system for resisting and transferring gravity and horizontal loads consists of RC slabs, frames and shear walls, which transfer these loads to the RC foundations, so the system can be classified as a dual system with dominant walls in the X direction and a system of independent walls in the Y direction.',
    'Krov je riješen kao neprohodni ravni krov koji čini AB ploča debljine 20cm. Horizontalnu međuspratnu konstrukciju spratova čine AB ploče debljine dp=16cm, oslonjene na AB grede i zidna platna. Stepenišne ploče i međupodesti su monolitni, betonirani na licu mjesta u glatkoj oplati debljine dp=16,0 cm. Konstruktivni sistem, odnosno vertikalni noseći sistem konstrukcije čini armirano-betonski stubovi i zidovi (zidna platna) u dva međusobno ortogonalna pravca obezbjeđujući potrebnu krutost objekt tako da, osim gravitacionih opterećenja, primaju horizontalne uticaje od vjetra i sezmičkih sila, prenoseći ih do temelja. Dimenzije stubova (proširenja platina) su 50x40, 80x25 i 70x25 cm, debljine zidova su 30 i 25 cm. Armirano-betonske grede su pravougaonog poprečnog presjeka širine 25 i 20 cm, visine od 40, 45, 50 i 60cm.':
      'The roof is designed as a non-accessible flat roof consisting of a 20 cm thick RC slab. The horizontal floor structure of the storeys consists of RC slabs 16 cm thick, supported on RC beams and shear walls. The staircase slabs and landings are monolithic, cast in place in smooth formwork, 16.0 cm thick. The structural system — i.e. the vertical load-bearing system — consists of reinforced-concrete columns and walls (shear walls) in two mutually orthogonal directions, providing the building with the stiffness needed to resist, besides gravity loads, horizontal wind and seismic actions and transfer them to the foundations. Column dimensions (wall extensions) are 50×40, 80×25, and 70×25 cm; wall thicknesses are 30 and 25 cm. The reinforced-concrete beams have rectangular cross-sections, 25 and 20 cm wide and 40, 45, 50, and 60 cm deep.',

    // POSH Residence
    'Usvojeni konstruktivni sistem za prijem i prenos gravitacionog i horizontalnog opterećenja čine AB tavanice i zidna platna, koja služe za prenos navedenih opterećenja do AB temelja, tako da se sistem može klasifikovati kao sistem nezavisnih zidova.':
      'The adopted structural system for resisting and transferring gravity and horizontal loads consists of RC slabs and shear walls, which transfer these loads to the RC foundations, so the system can be classified as a system of independent walls.',
    'Krov je riješen kao drveni kosi krov pod nagibom od 250.Horizontalnu međuspratnu konstrukciju spratova i krova čine AB ploče debljine dp=16cm, oslonjene na AB grede i zidna platna. Stepenišne ploče i međupodesti su monolitni, betonirani na licu mjesta u glatkoj oplati debljine dp=16,0 cm. Konstruktivni sistem, odnosno vertikalni noseći sistem konstrukcije čini armirano-betonski zidovi (zidna platna) u dva međusobno ortogonalna pravca obezbjeđujući potrebnu krutost objekt tako da, osim gravitacionih opterećenja, primaju horizontalne uticaje od vjetra i sezmičkih sila, prenoseći ih do temelja. Debljine zidova su 20,0 cm. Armirano-betonske grede su pravougaonog poprečnog presjeka 20x50cm.':
      'The roof is designed as a timber pitched roof with a 25° slope. The horizontal floor structure of the storeys and roof consists of RC slabs 16 cm thick, supported on RC beams and shear walls. The staircase slabs and landings are monolithic, cast in place in smooth formwork, 16.0 cm thick. The structural system — i.e. the vertical load-bearing system — consists of reinforced-concrete walls (shear walls) in two mutually orthogonal directions, providing the building with the stiffness needed to resist, besides gravity loads, horizontal wind and seismic actions and transfer them to the foundations. Wall thicknesses are 20.0 cm. The reinforced-concrete beams have a rectangular cross-section of 20×50 cm.',

    // CUNGU Bar
    'Objekat je u osnovi približno kvadratnog oblika gabarita 33.9x39.7m bruto površine 1374,49m2, visine krova 5,3:6,0m. Osnovna konstrukcija objekta je prefabrikovana  armirano betonska, organizovana kao dvobrodna hala raspona 2 x 16.70 m , u podužnom rasteru 10.65 m.':
      'In plan, the building is approximately square, with overall dimensions of 33.9 × 39.7 m, a gross floor area of 1,374.49 m², and a roof height of 5.3–6.0 m. The building\'s primary structure is precast reinforced concrete, organised as a two-bay hall with spans of 2 × 16.70 m on a longitudinal grid of 10.65 m.',
    "Glavne nosače unutrašnjih ramova čine krovni ''A'' nosači raspona 16,70m, visine 83,5:164,0cm sa gornjim pojasom u nagibima koji oblikuju dvovodne krovove nagiba 10%.":
      'The main girders of the internal frames are roof "A" girders spanning 16.70 m, 83.5–164.0 cm deep, with a sloped top chord forming twin-pitched roofs with a 10% slope.',
    'Glavni nosači fasadnih ramova su raspona 5x 8,35 m , T- presjeka, konstantne visine 70 cm , projektovani po nagibima krovnih ravni.':
      'The main girders of the façade frames span 5 × 8.35 m, have a T-shaped cross-section, a constant depth of 70 cm, and are designed following the slope of the roof planes.',
    'Rožnjače su projektovane kao amiranobetonski nosači T-presjeka , visine 65 cm, raspona 10.65m , na razmaku 270 cm , sistema proste grede. Krovni pokrivač je sendvič panel sa ispunom od kamene vune , debljine 12 cm . Krajnje rožnjače oblikovane su kao olučna korita za horizontalno odvodjenje vode sa krovnih površina.':
      'The purlins are designed as reinforced-concrete T-section beams, 65 cm deep, spanning 10.65 m at 270 cm centres, acting as simply supported beams. The roof covering is a sandwich panel with a 12 cm rock-wool core. The end purlins are shaped as gutters for horizontal drainage of water from the roof surfaces.',
    'Stubovi su presjeka 60x60cm za stubove unutrašnjih ramova i 50x50cm za fasadne stubove.Stubovi su posredstvom prefabrikovanih temeljnih čašica uklješteni u temeljne stope.  Dimenzije čašica su 125x125 x100 cm i 115x115x100cm. Kao dodatna mjera ukrućenja uvedeni su vertikalni spregovi profila 200x100x6 koji su ankerisani za stubove i koji su povezani dijagonalnim spregovima profila 120x80x4. Veza čeličnog sprega i betonskog stuba ostvaruje se preko čeličnih ploča koje su prethodno ugrađeni u betonske stubove, na koje se vari čelični stub ugaonim varom debljine 6mm.':
      'Columns have a 60×60 cm cross-section for the internal-frame columns and 50×50 cm for the façade columns. The columns are fixed into the foundation footings via precast socket bases. Socket dimensions are 125×125×100 cm and 115×115×100 cm. As an additional stiffening measure, vertical bracing of 200×100×6 profiles was introduced, anchored to the columns and connected by diagonal bracing of 120×80×4 profiles. The connection between the steel bracing and the concrete column is achieved via steel plates pre-embedded in the concrete columns, to which the steel bracing is welded with a 6 mm fillet weld.',
    'Fundiranje objekta je na monolitnim temeljnim stopama dimenzija 260 x 260 x 50 cm ispod stubova širine 60cm , odnosno 220 x 220 x 50 cm ispod stubova širine 50cm. Temelji su povezani veznim gredama dimenzije 30x50cm.':
      'The building is founded on monolithic footings measuring 260×260×50 cm beneath the 60 cm columns, and 220×220×50 cm beneath the 50 cm columns. The footings are tied together by 30×50 cm tie beams.',
    'Ukrućenje krovnih ravni i omogućavanje prostornog angažovanja konstrukcije predvidjeni su čelični spregovi u svim krovnim ravnima . Spregove sačinjavaju profili prstenastog presjeka prečnika 219mm koji se stavljaju naizmenično u oba smjera. Veza profila za glavne nosače ostvaruje se ankerisanjem čelične pločice klinom Φ28, za koje se spreg vezuje varom debljine 5mm.':
      'To stiffen the roof planes and enable spatial (3D) action of the structure, steel bracing is provided in all roof planes. The bracing consists of circular hollow-section profiles of 219 mm diameter, placed alternately in both directions. The profiles are connected to the main girders by anchoring a steel plate with a Φ28 dowel, to which the bracing is welded with a 5 mm weld.',

    // Rekonstrukcija magistralnog puta M21, Barski Most-Bijelo Polje
    'Glavni projekat rekontrukcije magistralnog puta M21 Barski Most-Bijelo Polje u dužini od 10,5km od raskrsnice ispred marketa VOLI do graničnog prelaza Dobrakovo':
      'Main design for the reconstruction of the M21 main road, Barski Most–Bijelo Polje section, 10.5 km long, from the junction in front of the VOLI supermarket to the Dobrakovo border crossing',
    'Predviđa se ojačanje mosta na stacionaži 1+200 i izradu novog integralnog mosta na stacionaži 5+300 i rušenja postojećeg usled velikog oštećenja.':
      'The design provides for strengthening of the bridge at station 1+200 and construction of a new integral bridge at station 5+300, along with demolition of the existing one due to severe damage.',
    'Zbog proširenja saobraćajnih traka na brojnim mjestima su rađene potporne konstrukcije od klasičnih potpornih zidova i zidova sa šipovima na mjestima potencijalnih klizišta.':
      'Due to the widening of traffic lanes, retaining structures were designed at numerous locations, consisting of conventional retaining walls and pile walls at locations of potential landslides.',

    // MOKA PLACE
    'Krov je riješen kao drveni kosi krov pod nagibom od 250.Horizontalnu međuspratnu konstrukciju spratova i krova čine AB ploče debljine dp=17cm, oslonjene na AB grede i zidna platna. Stepenišne ploče i međupodesti su monolitni, betonirani na licu mjesta u glatkoj oplati debljine dp=17,0 cm. Konstruktivni sistem, odnosno vertikalni noseći sistem konstrukcije čini armirano-betonski zidovi (zidna platna) u dva međusobno ortogonalna pravca obezbjeđujući potrebnu krutost objekt tako da, osim gravitacionih opterećenja, primaju horizontalne uticaje od vjetra i sezmičkih sila, prenoseći ih do temelja. Debljine zidova su 20,0 cm. Armirano-betonske grede su pravougaonog poprečnog presjeka 20x50cm.':
      'The roof is designed as a timber pitched roof with a 25° slope. The horizontal floor structure of the storeys and roof consists of RC slabs 17 cm thick, supported on RC beams and shear walls. The staircase slabs and landings are monolithic, cast in place in smooth formwork, 17.0 cm thick. The structural system — i.e. the vertical load-bearing system — consists of reinforced-concrete walls (shear walls) in two mutually orthogonal directions, providing the building with the stiffness needed to resist, besides gravity loads, horizontal wind and seismic actions and transfer them to the foundations. Wall thicknesses are 20.0 cm. The reinforced-concrete beams have a rectangular cross-section of 20×50 cm.',

    // Stambeni objekat Tološi-ETG/INGCON
    'Usvojeni konstruktivni sistem za prijem i prenos gravitacionog i horizontalnog opterećenja čine AB tavanice i zidna platna, koja služe za prenos navedenih opterećenja do AB temelja, tako da se sistem može klasifikovati kao sistem nezavisnih zidova.Krov je riješen kao drveni kosi krov pod nagibom od 23o':
      'The adopted structural system for resisting and transferring gravity and horizontal loads consists of RC slabs and shear walls, which transfer these loads to the RC foundations, so the system can be classified as a system of independent walls. The roof is designed as a timber pitched roof with a 23° slope.',
    'Horizontalnu međuspratnu konstrukciju spratova i krova čine AB ploče debljine dp=16 i 20 cm, oslonjene na AB grede i zidna platna. Stepenišne ploče i međupodesti su monolitni, betonirani na licu mjesta u glatkoj oplati debljine dp=16,0 cm. Konstruktivni sistem, odnosno vertikalni noseći sistem konstrukcije čini armirano-betonski zidovi (zidna platna) u dva međusobno ortogonalna pravca obezbjeđujući potrebnu krutost objekt tako da, osim gravitacionih opterećenja, primaju horizontalne uticaje od vjetra i sezmičkih sila, prenoseći ih do temelja. Debljine zidova je 20,0 cm. Armirano-betonske grede su pravougaonog poprečnog presjeka širine 2, cm, visine od 50 do 70cm.':
      'The horizontal floor structure of the storeys and roof consists of RC slabs 16 and 20 cm thick, supported on RC beams and shear walls. The staircase slabs and landings are monolithic, cast in place in smooth formwork, 16.0 cm thick. The structural system — i.e. the vertical load-bearing system — consists of reinforced-concrete walls (shear walls) in two mutually orthogonal directions, providing the building with the stiffness needed to resist, besides gravity loads, horizontal wind and seismic actions and transfer them to the foundations. Wall thickness is 20.0 cm. The reinforced-concrete beams have a rectangular cross-section, 20 cm wide, with a depth ranging from 50 to 70 cm.',

    // FILOLOŠKI FAKULTET
    'Glavni projekat Filološkog fakulteta u Nikšiću je rađen 2012.godine po tada važećim propisima i standardima.  Iz tog razloga bilo je neophodno sprovesti inoviranje, dopunu, doradu i usaglašavanje glavnog projekta izgradnje iz 2012. godine (svih njegovih faza) sa ciljem da se dobije savremen objekat koji će odgovoriti potrebama naučno-obrazovne ustanove. ':
      'The main design for the Faculty of Philology in Nikšić was prepared in 2012 under the regulations and standards in force at the time. For this reason, it was necessary to update, supplement, and harmonise the 2012 main design (all its phases) with the aim of achieving a modern building that meets the needs of a scientific and educational institution.',
    'Osnovni konstruktivni sistem objekta čine ab zidovi, debljine 25cm, stubovi  i grede, na koje je oslonjena međuspratna tavanica. Međuspratna tavanica je monolitna armirano-betonska ploča, beskonačne krutosti u svojoj ravni. Debljina svih međuspratnih tavanica, i krovne ploče je 20cm. Na krovnoj ploči projektovan je pokrivač od sendvič panela debljine 12cm. Ovaj pokrivač je oslonjen na čeličnu podkonstrukciju. Za vertikalnu komunikaciju unutar objekta predviđena su dva lifta i dvoje armirano betonskih stepenica. Zidovi liftovskog jezgra su armirano betonski, debljine 20cm. Stepenice su takođe armirano betonske, sa podestima i kosim pločama debljine 16cm. Na suterenskom dijelu, po čitavom obodu objekta projektovani su armirano betonski zidovi, debljine 25cm. Dominantno učešće u prihvatanju seizmičkih uticaja imaju armirano-betonski zidovi, dok je uloga stubova, prvenstveno, da prihvati i prenese gravitaciono opterećenje.':
      'The building\'s primary structural system consists of 25 cm thick RC walls, columns, and beams, on which the floor slabs are supported. The floor slab is a monolithic reinforced-concrete slab, infinitely rigid in its own plane. The thickness of all floor slabs, and of the roof slab, is 20 cm. A 12 cm sandwich-panel covering is designed on the roof slab, supported on a steel substructure. Two lifts and two reinforced-concrete staircases are provided for vertical circulation within the building. The lift-core walls are reinforced concrete, 20 cm thick. The stairs are also reinforced concrete, with landings and sloped slabs 16 cm thick. In the basement, reinforced-concrete walls 25 cm thick are designed around the entire perimeter of the building. Reinforced-concrete walls play the dominant role in resisting seismic actions, while the primary role of the columns is to receive and transfer gravity loads.',

    // Emerald Mountain Residence
    'Emerald Mountain Residence na Žabljaku je kompleks koji čine dva objekta površine od približno 14 000m2. U njemu je predviđen niz pratećih sadržaja, koji zadovoljavaju najviše kriterijume i standarde lokacije, a ogleda se u idealnoj mjeri apartmanskog i resort sistema poslovanja. Pored recepcije i službe za održavanje koje su dostupne 24 časa, 365 dana u godini, vlasnicima i gostima Emerald Residence rental koncepta na raspolaganju su Wellness & Spa centar, sa unutrašnjim i spoljašnjim bazenom, fitness centar, restoran  i dječija igraonica. Takođe, Emerald Residence posjedovaće i skijašnicu kao i garažni sistem koji boravak na ovom mestu čine jednostavnijim i ugodnijim u svakom dijelu godine.':
      'Emerald Mountain Residence in Žabljak is a complex consisting of two buildings with a total area of approximately 14,000 m². It offers a range of amenities that meet the highest standards for the location, reflecting an ideal blend of an apartment and resort-style business model. In addition to a reception and maintenance service available 24 hours a day, 365 days a year, owners and guests of the Emerald Residence rental concept have access to a Wellness & Spa centre with indoor and outdoor pools, a fitness centre, a restaurant, and a children\'s playroom. Emerald Residence will also feature a ski room and a garage system, making a stay here more convenient and enjoyable at any time of year.',
    'Kako bi ispunili sve navedene zahtjeve, bilo je neophodno koncipirati konstrukciju tako da se unutar samog objekta nalazi što manji broj vertikalnih elemenata. Iz tog razloga se zidna platna nalaze dominantno na fasadi objekata i imaju funkciju preuzimanja horizontalnog opterećenja.':
      'In order to meet all of these requirements, the structure had to be conceived so that the smallest possible number of vertical elements would be located within the building itself. For this reason, the shear walls are predominantly located on the building façades and serve to resist horizontal loads.',

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

    // 3c ── Contact page main heading ("KONTAKT:" — Hello Plus contact widget)
    document.querySelectorAll('.ehp-contact__heading').forEach(function (el) {
      translateEl(el, HEADINGS, lang);
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
    //    • ehp-contact__description — Hello Plus contact widget (KONTAKT section)
    //    • ehp-cta__description     — Hello Plus CTA widget (team bios on O NAMA;
    //      this is a theme widget, NOT Elementor Pro's own "elementor-cta__"
    //      widget, despite both being called "cta" — real rendered class differs)
    //  Uses innerHTML cache so <br> markup is fully restored on CG switch.
    document.querySelectorAll(
      '.ehp-contact__description, .ehp-contact__description p, ' +
      '.ehp-cta__description, .ehp-cta__description p'
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
      '.elementor-icon-list-text'      // Elementor icon list (real class is
                                        // hyphenated, not BEM __text)
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

    // 13 ── Hello Plus button text spans (hero CTA "NAŠI PROJEKTI", header
    //  KONTAKT button, zigzag buttons). The text lives in a leaf
    //  <span class="ehp-button__text">, which the generic steps skip.
    document.querySelectorAll('.ehp-button__text').forEach(function (el) {
      if (el.children.length === 0) {
        translateEl(el, HEADINGS, lang);
        translateEl(el, NAV, lang);
        translateElPartial(el, BODY_TEXT, lang);
      }
    });

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

    // Re-apply saved language immediately (no flash of CG on EN preference).
    // setTimeout (not requestAnimationFrame) — rAF only fires on an actual
    // paint tick, which some browsers defer indefinitely for background/
    // inactive tabs, leaving the page stuck showing CG despite an EN
    // preference. setTimeout always fires on the next event-loop turn.
    if (currentLang === 'en') {
      setTimeout(function () {
        applyLanguage('en');
      }, 0);
    }
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }

})();
