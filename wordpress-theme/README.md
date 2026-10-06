# Hydraulic Cartridges — WordPress theme

Custom theme migrated from the approved React + Vite frontend. The React app in `src/` remains the visual source of truth and was not deleted.

## Install

1. Copy `wordpress-theme/hydraulic-cartridges/` into `wp-content/themes/hydraulic-cartridges/` on a WordPress 6.4+ site (PHP 8.0+).
2. Appearance → Themes → Activate **Hydraulic Cartridges**.
3. Settings → Permalinks → **Post name** → Save (the theme also sets this on activation).
4. Activation seeds products, solutions, resources, FAQs, pages, and the primary menu from the React catalog data.

If you activate the theme a second time, seed is skipped (`hc_seeded` option). Delete that option and re-activate to reseed empty content only where slugs do not already exist.

## URLs (match the React routes)

| React | WordPress |
| --- | --- |
| `/` | Front page (`front-page.php`) |
| `/products` | Products CPT archive |
| `/products/:slug` | Single product |
| `/applications` | Solutions CPT archive |
| `/applications/:slug` | Single solution |
| `/about` `/resources` `/contact` `/request-quote` `/privacy` `/terms` | Pages with matching templates |

## Admin

- **Products** and **Solutions** custom post types power the existing cards and detail layouts.
- **Resources** and **FAQs** are admin-only post types used by the Resources UI.
- Appearance → Customize → Hydraulic Cartridges: email, phone, address, hours, ISO line.
- Appearance → Customize → Site Identity: optional logo (default remains the React SVG mark).
- Appearance → Menus: Primary location.

Do not restyle templates to “improve” the design. Change copy and catalog data only.

## Forms

Contact and Request a Quote keep the React validation rules (name 2–35, email format, non-whitespace message). Submission is frontend-only; nonce fields are present for a later mailer without UI changes.

## Visual QA

Compare against `npm run dev` in the original React project. Header, type, color, spacing, product SVGs, and breakpoints are copied from `src/styles` and `src/components`.
