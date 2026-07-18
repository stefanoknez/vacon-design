# Vacon Design — Website

The official website of Vacon (vacon-design.me), a leading construction and architectural engineering company based in Podgorica, Montenegro, specializing in structural design, seismic engineering, infrastructure and bridge projects, and construction supervision.

This repository contains the WordPress source for vacon-design.me — the active theme, custom scripts, and configuration that make up the live site.

## Tech stack

- **CMS**: WordPress
- **Page builder**: Elementor + Elementor Pro, built on Elementor's official **Hello Biz** theme (Hello+ plugin ecosystem)
- **Languages**: PHP (theme logic), JavaScript (custom animations and the bilingual language switcher), CSS
- **Bilingual EN ↔ CG**: A custom client-side translation layer toggles the entire site between Montenegrin (the source content) and English — navigation, headings, project data, and body text — without a page reload
- **Hosting**: cPanel shared hosting, deployed automatically via Git Version Control on every push to `main`
- **Local development**: Local by Flywheel (nginx + PHP + MySQL)

## Structure

- `wp-content/themes/hello-biz/` — the active theme
  - `functions.php` — security hardening (hides WordPress/Elementor version strings, blocks user enumeration, etc.) and custom asset loading
  - `assets/css/vacon-elite.css` — the site's design system: dark/graphite aesthetic, typography, layout grid, responsive rules
  - `assets/js/vacon-animations.js` — homepage hero slideshow, scroll-reveal animations, project-page interactions
  - `assets/js/vacon-lang.js` — the EN ↔ CG language switcher and its translation dictionaries
- `wp-content/plugins/` — Elementor Pro, PowerFolio (project portfolio), Header Footer Elementor, SpeedyCache, and other installed plugins
- `.cpanel.yml` — the deployment script cPanel's Git Version Control runs on every push

## Notes

- WordPress core (`wp-admin/`, `wp-includes/`), uploaded media, and backups are intentionally excluded from version control — see `.gitignore`.
- Pages are built in Elementor and stored as JSON in the database rather than as PHP templates, so most content edits happen through the WordPress admin / Elementor editor rather than this codebase.
