# Build notes – bb.q Chicken Europe (Figma → HTML)

Static HTML/CSS/JS, no framework. Source of truth is the Figma file
"BB.Q Chicken Global – Design" (desktop frames 1680 wide, mobile frames 390 wide).

## Project layout

```
src/partials/head.html, header.html, footer.html   shared chrome (do NOT edit unless told)
src/pages/<page>.html                               page body only (between header and footer)
build.js                                            node build.js [page.html ...] → writes /<page>.html
serve.js                                            node serve.js 5173 (already running at http://localhost:5173)
assets/css/styles.css                               shared tokens + components (do NOT edit unless told)
assets/css/pages/<page>.css                         page-specific CSS (one file per page you build)
assets/js/main.js                                   shared behaviour (dropdowns, menu, marquee, slider, accordions)
assets/img/                                         web-ready images (see design-data/IMAGES.md)
assets/svg/                                         logo-on-dark.svg, stamp-emblem.svg, europe-map.svg, pin.svg, icons
design-data/frame_<id>.json                         full Figma node tree per frame (exact text, fonts, colours, sizes)
design-data/IMAGES.md                               which image file belongs to which Figma layer
```

Readable outlines of every frame (one line per node: type, name, size, position, auto-layout,
fills, text style + content) are in
`C:/Users/dell/AppData/Local/Temp/claude/d21ac4d8f552d5a7/ad9ac252-8b27-444f-9963-f23481175525/scratchpad/outlines/<frame-id>.txt`.
Outline legend: `F` frame, `T` text, `I` instance, `R` rect, `E` ellipse; `AL:V gap24 p[t,r,b,l] MAIN/CROSS` = vertical
auto-layout; `sz:FH` = fill width / hug height; `{Pretendard ExtraBold 60/102% ls-2.0% #221E1F LEFT}` = font, size/line-height,
letter-spacing, colour, alignment; `[chip #E31937]` = the small arrow chip inside a button; `[stamp]` = the "since 1995" stamp.
Figma `rot:N` is counter-clockwise around the node's top-left: in CSS use `transform-origin: 0 0; transform: rotate(-Ndeg)`.

## Page file format

```html
<!-- page {"title": "Menu – bb.q Chicken Europe", "description": "…", "active": "discover",
           "bodyClass": "page-menu", "extraHead": "<link rel=\"stylesheet\" href=\"assets/css/pages/menu.css\">"} -->
<section class="page-hero"> … </section>
```
`active` highlights the nav item: discover | franchise | markets | realestate | careers.
Placeholders: `{{icon:arrow}}` (button chip arrow), `{{icon:chevdown}}`, `{{icon:left}}`, `{{icon:right}}`,
`{{icon:sparkle}}` (marquee sparkle), `{{icon:sparkleplain}}`, `{{icon:instagram}}`, `{{icon:facebook}}`, `{{icon:linkedin}}`,
`{{stamp}}` (full "since 1995" stamp SVG, put inside `<div class="stamp">`).
Build one page: `node build.js menu.html`. Header, mobile menu, floating CTA and footer are added automatically.

## Design tokens (CSS custom properties in styles.css)

--red #E31937 · --yellow #F2B33D · --cream #F5F1E8 · --char #221E1F · --char-2 #2E2829 · --ink-deep #161213 ·
--sand #D6D2C4 · --muted #6B605C · --muted-light #CFC6BF · font Pretendard (loaded from CDN).
Desktop content width 1440 inside 120px gutters; mobile gutter 20px. Breakpoints: ≤1199 tablet, ≤767 mobile.

## Shared components (use these; copy exact Figma values for anything page-specific)

- `.section` – full-bleed section with responsive side padding that keeps content ≤1440 wide.
- Type: `.h-display` (84/98% ExtraBold, clamps to 40 on mobile), `.h2` (60/102%, → 34), `.lead` (18/150% muted),
  `.label-caps` (13 Bold, 12% tracking, uppercase).
- `.eyebrow` red pill label; `.eyebrow--dark` charcoal. Centered in `.section-head`, `.food__head`, `.is-centered` parents.
- `.section-head` – centered column (eyebrow + .h2 + .lead), left-aligned on mobile.
- Buttons: `<a class="btn btn--red">Label <span class="btn__chip">{{icon:arrow}}</span></a>`;
  variants `btn--red`, `btn--cream`, `btn--dark`, `btn--outline-dark`, `btn--outline-light`. Group in `.btn-row`
  (stacks full-width on mobile, as in the mobile designs). Buttons that should open the application form get `data-apply`.
- `.marquee marquee--dark|--yellow|--red [marquee--ltr]` > `.marquee__track[data-marquee]` > items
  `<span class="marquee__item marquee__item--strong">…</span>{{icon:sparkle}}` (JS duplicates for the loop).
- `.stamp` (absolute, 184px) with `{{stamp}}` inside.
- `.cutout` (absolute food cut-out; set width/height/left/top/transform per page) with optional `.cutout--shadow`
  / `.cutout--shadow-dark`.
- `.pill pill--open` / `.pill pill--active` (market status pills).
- `.page-hero` (860 tall interior hero: dark with red glow, text left in `.page-hero__text`, big image in
  `.page-hero__media` which you position per page) and `.page-hero--short` (600 tall "Page header").
- `.closing` + `.cta-card` closing call-to-action (see src/pages/index.html, section 14), reuse as-is.
- `.form-section` > `.form-card` (cream card, intro column + form column) with fields:
  `.form`, `.form-row` (2 columns), `.field` > `label.field__label` + `.input` / `select.select` / `textarea.textarea`,
  `label.check` > `input[type=checkbox]` + text, `.form-submit` > button + `.form-submit__note`,
  `.info-box` > `.info-box__title` + `.info-box__step` (auto-numbered "Good to know" steps).
- `.swipe` horizontal scroll-snap row (mobile carousels).
- `.reason` glass card, `.news-card`, `.food-card`, `.market-row`, `.europe-card`, `.map-card` exist from the home page.
- `.only-desktop` / `.only-mobile` visibility helpers (mobile = ≤767px).

## Rules

1. Match the Figma desktop frame at 1680 and the mobile frame at 390; make 768–1199 look sensible (stack columns).
2. Copy all text exactly from the outlines (including [bracketed placeholders]). Keep British spelling.
3. Use the images in assets/img (see design-data/IMAGES.md). Decorative images get `alt=""`; content images get a short alt.
   Add `loading="lazy"` below the fold and width/height attributes.
4. Page-specific CSS goes in assets/css/pages/<page>.css only. Don't edit styles.css, main.js, partials or other pages'
   files. If you believe a shared change is needed, describe it in your final report instead.
5. Use semantic HTML (one h1 per page, section headings h2, labels for every form field, buttons vs links).
6. Forms: plain HTML forms with `action="#"` and `data-form` attribute; mark required fields `required`.
7. After building, run `node build.js <page>.html` and make sure it prints "built".
