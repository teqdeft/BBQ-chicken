# Figma "Design v4" update (20 Nov 2026)

The designer updated the Figma file (key `mHHxF30QEViaqh0HYKA7MX`): every page frame is now "Design v4",
new **1440-wide desktop frames** were added for every page, content was filled in (real news, team, jobs,
menu items…), and the visual style was tightened. `design-data/frame_<id>.json` is the OLD (v3) snapshot the
site was built from; the diff tool below tells you what changed.

## Already done in shared files (don't redo)

- Tokens in `assets/css/styles.css`: `--radius-btn: 6px`, `--radius-card: 16px`, `--radius-img: 12px`,
  `--radius-tag: 4px`, `--red-text: #D61834` (darker red for small red text: dates, ↗ arrows).
- Side gutter: 120px at 1680, **80px at 1440** (linear in between), 40px tablet (≤1199), 20px mobile.
  Type sizes (84 / 60 / 18) stay full size down to 1440.
- `.eyebrow` is now **charcoal (#221E1F) with white text, radius 4** (the red label is gone).
  On dark backgrounds Figma uses a translucent label: add class `eyebrow--glass` (fill #F5F1E8 at 14%).
- Buttons: radius 6, text 16/20, all 52px tall (outline buttons included). Mobile buttons 50px.
- Header radius 12 (mobile 8), nav items/buttons radius 6, dropdowns radius 8.
- **Floating "Submit your application" CTA removed** (client request, 18 Nov) on all pages and mobile.
- Closing CTA (`.closing`): photo background (`assets/img/closing-bg.jpg`, mobile `closing-bg-m.jpg`) fading
  to #161213; padding 160/180 (mobile 72/78); card radius 16. Stamp, cutout and sparkles stay.
- Footer: photo background (`footer-bg.jpg` / `footer-bg-m.jpg`), padding-top 96 (mobile 56), fries cutout
  removed, 56px red social circles, link columns 120px apart, links SemiBold, mobile accordion with 44px
  +/– toggles.
- Mobile menu rebuilt to the Figma "Mobile menu – open" design.
- Home shared bits: card radii (food, reason, map, europe, team, news, brand), marquee colours
  ("OUR SIGNATURE SAUCES" now charcoal, "SINCE 1995" now white), proof band labels white.

## How to find what changed in a frame

1. `node design-data/tools/make-diff.js <frame-id>` → writes `design-data/diffs/code_<id>.js`.
2. Read that file and pass its full content as `code` to the Figma `use_figma` tool with
   `fileKey: "mHHxF30QEViaqh0HYKA7MX"`. The code is **read-only**; never run code that changes the Figma file.
3. Save the result to `design-data/diffs/<id>.txt` (keep it for the record).
4. Legend: `~` = layer whose own properties changed (the line shows the NEW values), `+` = new layer (root of a
   new subtree), lines starting with a space = inside a new subtree, `REMOVED:` = ids that no longer exist.
   Positions (x/y) and hug sizes are ignored when comparing. Old values: look the id up in
   `design-data/frame_<id>.json` (e.g. with a small node one-liner).
5. For a quick look at a whole section use `get_screenshot` (Figma tool) on the section's node id and download
   the PNG with curl to `assets/img/raw/v4/` — don't embed base64.

## New or changed images

- `download_assets` (Figma tool) with the **image layer's** node id → `rawImages[].url` is the original image;
  download immediately with `curl -f -L -o <file> "<url>"` into `assets/img/raw/v4/` (URLs expire quickly).
- Resize for the web: write a map file (`<source-prefix> <dest-name> <max-width>` per line) and run
  `powershell -File design-data/tools/resize.ps1 -map <map> -src assets/img/raw/v4 -dst assets/img`.
  PNG keeps transparency (cutouts), JPG quality 82. Use descriptive kebab-case names.
- For CROP image fills, prefer the `export` render of that image layer, or reproduce the crop in CSS.

## 1440 frames

The 1440 frames mostly keep the 1680 typography with 80px side padding (content 1280). Compare section by
section with a small read-only `use_figma` query (sizes, paddings, gaps, font sizes) and fix anything that the
fluid CSS doesn't already produce at 1440.

## After the v4 pass (20 Nov)

- Home was matched to the other developer's prototype (the dev.studioubique.com build, same files as the
  `assets.zip` they shared): animations, hover effects and the remaining layout values at 1680 and 390.
  Check a page against another build with `design-data/tools/layout-probe.js` (positions, sizes and type of
  every text element and image, per section).
- Shared v4 styles now live in `styles.css`: form section + form card + fields + drop zone, the short
  page-header photo background, and the inner-page swipe-row controls (`.row-nav`). Page CSS keeps only
  layout that really differs per page. Before/after checks used `design-data/tools/style-snapshot.js`
  (computed styles on several pages and widths; the diff must be empty for a pure refactor).
- `make-diff.js` now fills in the `const FRAME` / `const OLD` lines (it used to replace the comment only).
