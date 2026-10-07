# Hydraulic Cartridges — WordPress theme

Copy `hydraulic-cartridges/` into `wp-content/themes/` and activate. No npm build is required.

## Install

1. Copy this folder to `wp-content/themes/hydraulic-cartridges/`.
2. Activate **Hydraulic Cartridges**.
3. Settings → Permalinks → **Post name** → Save (required after this catalog URL update).
4. Load any front-end page once so families seed (`hc_catalog_seeded`).

## URLs

| Path | What it shows |
| --- | --- |
| `/` | Homepage overview |
| `/products/` | Catalog hub |
| `/products/valves/` | Major category |
| `/products/valves/proportional-cartridge-valves/` | Product group listing |
| `/products/valves/proportional-cartridge-valves/{slug}/` | Product detail |
| `/applications/` | Solutions |
| `/about/` `/resources/` `/contact/` `/request-quote/` | Pages |

## Product discovery

- **Homepage:** six family cards with a short group preview (not the full tree).
- **Header → Products:** hover a family to reveal every subgroup; click the family to open its category page.
- **Category pages:** sidebar accordion (one family open) + listing.
- **Mobile:** tap to expand, one family at a time; hamburger does not become an X.

## Admin

Products, Product families, Solutions, Resources, FAQs. Customize → Hydraulic Cartridges for contact details.
