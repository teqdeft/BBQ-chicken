# bb.q Chicken Europe – WordPress site

This repository is the complete WordPress site for bb.q Chicken Europe (built from the Figma file
**BB.Q Chicken Global – Design**): WordPress core, the plugins and the custom theme
`wp-content/themes/bbq-chicken`.

Not in the repository: `wp-config.php` (database password and keys), `.htaccess`, `wp-content/uploads/`
(media) and logs. The site's content (pages, menus, news posts, forms) lives in the database and is created by
the theme's one-click setup, so a fresh install needs no database import.

The earlier static HTML version of the site is kept in git history: tag **`static-html-v4`**.

## What's in it

| Path | What it is |
| --- | --- |
| `wp-admin/`, `wp-includes/`, `*.php` | WordPress core (7.1.5) |
| `wp-content/plugins/contact-form-7/` | Contact Form 7 (the site's forms) |
| `wp-content/themes/bbq-chicken/` | The custom theme (see below) |
| `wp-content/themes/twentytwenty*`, `plugins/akismet`, `plugins/hello.php` | Bundled with WordPress, not used |

## Install

1. Put the files on a PHP 8+ server (or clone into XAMPP's `htdocs`), create an empty MySQL/MariaDB database.
2. Copy `wp-config-sample.php` to `wp-config.php`, fill in the database details and new keys
   (https://api.wordpress.org/secret-key/1.1/salt/), then open the site and run the WordPress installer.
3. In WP admin: Plugins → activate **Contact Form 7**; Appearance → Themes → activate **bb.q Chicken Europe**.
4. **Appearance → bb.q setup → Run setup**: creates the pages with their templates, sets the home and news
   pages, builds the menus, adds the news posts with their photos and creates the forms. Running it again only
   adds what is missing.
5. Settings → Permalinks → "Post name" (pretty URLs), and make sure the site can send email (an SMTP plugin is
   recommended). Set where form emails go under Contact → Contact Forms → each form → Mail.
6. Fill in the real links under Appearance → bb.q settings (ordering platforms, social links, map key).

To install only the theme on an existing WordPress, zip `wp-content/themes/bbq-chicken` and upload it under
Appearance → Themes → Add New → Upload (it's about 21 MB; use FTP/SFTP if the host's upload limit is lower).

## Editing the site

Every page is a WordPress page with its own template that prints the design's markup. **Every text, image and
button is an editable field** whose default is the design's content. Lists (cards, sauces, team, vacancies, FAQ,
steps …) are rows editors can add, remove and reorder. News stories are posts.

| What | Where in WP admin |
| --- | --- |
| Page texts, images, buttons, lists | Pages → (page) → "Page content" box (each field has "Use default") |
| SEO title and meta description | Same box, "SEO" section (empty = the design's default) |
| News stories | Posts (featured image = card photo; "News card" box: date line, outside link, no link, placeholder) |
| Header, mobile menu, footer texts, ordering platforms, social links, delivery map | Appearance → bb.q settings |
| Navigation links (header dropdowns, footer columns) | Appearance → Menus |
| Forms (fields, emails, messages) | Contact → Contact Forms |

## Theme structure

| Path (in `wp-content/themes/bbq-chicken/`) | What it is |
| --- | --- |
| `templates/<page>.php` | Page content with editable fields (`bbq_text()`, `bbq_image()`, `bbq_rows()` …) |
| `templates/site-header.php`, `site-footer.php`, `site-settings.php` | Header/footer and site-wide settings |
| `page-templates/`, `front-page.php`, `home.php`, `single.php` | Thin WordPress templates that load the above |
| `inc/fields.php`, `inc/fields-admin.php` | The field system and its admin box (no extra plugins needed) |
| `inc/forms/*.php` | Contact Form 7 form definitions used by the setup |
| `inc/import/` | Starter content for the setup (news posts, privacy policy text) |
| `inc/importer.php` | Appearance → bb.q setup |
| `assets/` | The design's CSS, JS and images + `css/wp.css` for WordPress-only rules |
| `CONVERTING.md` | How the templates are written (for developers) |

Breakpoints: desktop design 1680 px, mobile design 390 px; CSS breakpoints ≤1439 (compact header), ≤1199
(tablet: burger menu, stacked columns), ≤767 (mobile layout).

## Delivery map

The home page map starts as a static picture. When it scrolls near the window, the theme's `assets/js/map.js`
loads a live map over it: Google Maps in a dark style if a key is set (Appearance → bb.q settings → Delivery
map), otherwise Leaflet (from jsDelivr) with Esri's dark grey tiles. Before launch: Esri's tiles need an ArcGIS
account for production use, so add a Google Maps or ArcGIS key. Both maps contact a third-party server, so list
them in the cookie/privacy notice. If the map scripts can't load, the static picture stays.

## Still to connect / confirm

Copy in [square brackets] is placeholder text from the design (kitchen name, dates, links to be supplied by
BLT). Ordering-platform links, social links and the postcode check are not connected yet.

Waiting on the client (from the design team's overview, 19–20 Nov 2026):

- Sauce list with descriptions and spice levels; "Jamaica Mayo" or "Jamaican Mayo"
- Photos of the three formats: flagship, traditional restaurant, shop-in-shop
- The Madrid article (next week) and the UK article (before Christmas)
- The direct ordering link, and confirmation of the aggregator (Glovo, Uber Eats, Just Eat, Deliveroo) links
- The Privacy Policy text
- Which name to use in the news article: "BLT F&B Group" (as in the press) or "BLT Global Brands"
- María's alternative headshot (only if she still wants it)
- A Google Maps API key and the address of the Madrid kitchen

Decided: the text colour in the menu slider stays as it is (WCAG contrast). bbqchicken.com/media is empty, so
news cards can't pull articles from it yet. The floating "Submit your application" button was removed at the
client's request (18 Nov).
