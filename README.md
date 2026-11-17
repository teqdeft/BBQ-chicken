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
| `src/partials/` | Shared `<head>`, header (nav, order dropdown, mobile menu, floating CTA) and footer |
| `src/pages/` | One file per page (content only) – edit these, then run `node build.js` |
| `assets/css/styles.css` | Design tokens and shared components (buttons, marquees, cards, forms, header, footer) |
| `assets/css/pages/` | Page-specific styles |
| `assets/js/main.js` | Dropdowns, mobile menu, marquee loop, card slider, footer accordions, form placeholders |
| `assets/img/`, `assets/svg/` | Images exported from Figma (originals in `assets/img/raw/`), logo, map and icons |
| `design-data/` | Figma data used for the build: node trees per frame, image index, build notes |

## Breakpoints

Desktop design 1680 px wide, mobile design 390 px wide. CSS breakpoints: ≤1439 (compact header), ≤1199
(tablet: burger menu, stacked columns), ≤767 (mobile layout from the 390 frames).

## Still to connect / confirm

Copy in [square brackets] is placeholder text from the design (e.g. kitchen name, dates, links to be supplied
by BLT). Ordering-platform links, social links, the postcode check and form submissions are not connected to
any backend yet – the forms show a confirmation message only.
