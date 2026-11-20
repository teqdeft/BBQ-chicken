# bb.q Chicken Europe – static website

HTML/CSS/JS build of the Figma file **BB.Q Chicken Global – Design**
(page "bb.q Chicken Europe – Design (desktop and mobile)"). No framework, no dependencies; only Node.js is
needed for the tiny build and preview scripts.

## Quick start

```bash
node build.js          # assemble src/pages/*.html + shared header/footer → *.html in this folder
node serve.js 5173     # preview at http://localhost:5173
```

The built `*.html` files in this folder are the finished pages: upload the `.html` files together with
`assets/` to any static host.

## Structure

| Path | What it is |
| --- | --- |
| `src/partials/` | Shared `<head>`, header (nav, order dropdown, mobile menu) and footer |
| `src/pages/` | One file per page (content only) – edit these, then run `node build.js` |
| `assets/css/styles.css` | Design tokens and shared components (buttons, marquees, cards, forms, header, footer) |
| `assets/css/pages/` | Page-specific styles |
| `assets/js/main.js` | Dropdowns, mobile menu, marquee loop, card sliders and swipe rows, footer accordions, form placeholders |
| `assets/js/motion.js`, `assets/css/motion.css` | Scroll reveals, count-ups, parallax, glow, steam, hover effects (all off for reduced motion) |
| `assets/js/map.js` | Live delivery map on the home page (see below) |
| `assets/img/`, `assets/svg/` | Images exported from Figma (originals in `assets/img/raw/`), logo, map and icons |
| `design-data/` | Figma data used for the build: node trees per frame, image index, build notes |

## Breakpoints

Desktop design 1680 px wide, mobile design 390 px wide. CSS breakpoints: ≤1439 (compact header), ≤1199
(tablet: burger menu, stacked columns), ≤767 (mobile layout from the 390 frames).

## Still to connect / confirm

Copy in [square brackets] is placeholder text from the design (e.g. kitchen name, dates, links to be supplied
by BLT). Ordering-platform links, social links, the postcode check and form submissions are not connected to
any backend yet – the forms show a confirmation message only.

Waiting on the client (from the design team's overview, 19–20 Nov 2026):

- Sauce list with descriptions and spice levels; "Jamaica Mayo" or "Jamaican Mayo"
- Photos of the three formats: flagship, traditional restaurant, shop-in-shop
- The Madrid article (next week) and the UK article (before Christmas)
- The direct ordering link, and confirmation of the aggregator (Glovo, Uber Eats, Just Eat, Deliveroo) links
- The Privacy Policy text (for the legal page template)
- Which name to use in the news article: "BLT F&B Group" (as in the press) or "BLT Global Brands"
- María's alternative headshot (only if she still wants it)
- A Google Maps API key and the address of the Madrid kitchen

## Delivery map

The home page map starts as a static picture. When it scrolls near the window, `assets/js/map.js` loads a
live map over it: Google Maps in a dark style if a key is set, otherwise Leaflet (from jsDelivr) with Esri's dark
grey tiles. Set it on the `.map-card` element in `src/pages/index.html`:

```html
<div class="map-card" data-lat="40.4168" data-lng="-3.7038" data-zoom="13" data-radius="2400" data-gmaps-key="…">
```

Before launch: Esri's tiles need an ArcGIS account for production use, so either add a Google Maps key or an
ArcGIS key. Both maps contact a third-party server, so list them in the cookie/privacy notice. If the map
scripts can't load, the static picture stays.

Decided: the text colour in the menu slider stays as it is (WCAG contrast). bbqchicken.com/media is empty, so
news cards can't pull articles from it yet. The floating "Submit your application" button was removed at the
client's request (18 Nov).
