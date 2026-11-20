# bb.q Chicken Europe – website

Built from the Figma file **BB.Q Chicken Global – Design**. The site is a **WordPress theme**; the earlier
static HTML version is kept as a backup.

| Folder | What it is |
| --- | --- |
| `wp-content/themes/bbq-chicken/` | The WordPress theme (see below) |
| `html-backup/` | The static HTML site, unchanged (git tag `static-html-v4` marks it at the repo root) |
| `design-data/` | Figma data and build notes; `design-data/tools/` has the comparison and helper scripts |

## WordPress theme

Every page is a WordPress page with its own template that prints the design's markup. **Every text, image and
button is an editable field** whose default is the design's content, so a fresh install looks exactly like the
design before anyone edits anything. Lists (cards, sauces, team, vacancies, FAQ, steps …) are rows that editors
can add, remove and reorder. News stories are normal posts. Forms use **Contact Form 7**.

Where editors find things:

| What | Where in WP admin |
| --- | --- |
| Page texts, images, buttons, lists | Pages → (page) → "Page content" box (each field has "Use default") |
| SEO title and meta description | Same box, "SEO" section (empty = the design's default) |
| News stories | Posts (featured image = card photo; "News card" box: date line, outside link, placeholder) |
| Header, mobile menu, footer texts, ordering platforms, social links, delivery map | Appearance → bb.q settings |
| Navigation links (header dropdowns, footer columns) | Appearance → Menus |
| Forms (fields, emails, messages) | Contact → Contact Forms |

### Install on a WordPress site

1. Upload the theme and activate it: Appearance → Themes → Add New → Upload with `dist/bbq-chicken.zip`
   (build it with `powershell -File design-data/tools/make-theme-zip.ps1`; about 21 MB, so if the host's upload
   limit is lower, copy the `wp-content/themes/bbq-chicken` folder by FTP/SFTP instead).
2. Install and activate **Contact Form 7**.
3. Go to **Appearance → bb.q setup** and click **Run setup**: it creates the pages with their templates, sets the
   home and news pages, builds the menus, adds the news posts with their photos and creates the forms.
   Running it again only adds what is missing.
4. Set where form emails go (Contact → Contact Forms → each form → Mail) and make sure the site can send
   email (an SMTP plugin is recommended).
5. Fill in the real links in Appearance → bb.q settings (ordering platforms, social links, map key).

### Theme structure

| Path | What it is |
| --- | --- |
| `templates/<page>.php` | Page content with editable fields (`bbq_text()`, `bbq_image()`, `bbq_rows()` …) |
| `templates/site-header.php`, `site-footer.php`, `site-settings.php` | Header/footer and site-wide settings |
| `page-templates/`, `front-page.php`, `home.php`, `single.php` | Thin WordPress templates that load the above |
| `inc/fields.php`, `inc/fields-admin.php` | The field system and its admin box (no plugins needed) |
| `inc/forms/*.php` | Contact Form 7 form definitions used by the setup |
| `inc/import/` | Starter content for the setup (news posts, privacy policy text) |
| `inc/importer.php` | Appearance → bb.q setup |
| `assets/` | The design's CSS, JS and images (same files as the static site) + `css/wp.css` for WordPress-only rules |
| `CONVERTING.md` | How templates are written (for developers) |

### Local development (XAMPP)

The local site is `http://localhost/bbq-chicken/` (WordPress in `C:\xampp\htdocs\bbq-chicken`, database
`bbq_chicken`). The theme folder in this repo is linked into it (a directory junction), so edits show up
immediately. Login details for the local test admin are in `.claude/wp-local-credentials.txt` (not in git).
Start XAMPP's MySQL and Apache, then open the site. `design-data/tools/wp-cli-lite.php` runs small commands
without WP-CLI, e.g. `php design-data/tools/wp-cli-lite.php C:/xampp/htdocs/bbq-chicken setup`.

The static backup is also served by XAMPP at `http://localhost/bbq-static/` and the tools at
`http://localhost/bbq-tools/`, so a WordPress page can be compared with the static one (see `CONVERTING.md` →
"Checking"). Local installs create the forms with `skip_mail: on` (no mail server); a production install
doesn't.

## Static HTML backup

```bash
node html-backup/build.js       # assemble html-backup/src/pages/*.html + partials → html-backup/*.html
node html-backup/serve.js 5173  # preview at http://localhost:5173
```

## Breakpoints

Desktop design 1680 px wide, mobile design 390 px wide. CSS breakpoints: ≤1439 (compact header), ≤1199
(tablet: burger menu, stacked columns), ≤767 (mobile layout from the 390 frames).

## Delivery map

The home page map starts as a static picture. When it scrolls near the window, `assets/js/map.js` loads a live
map over it: Google Maps in a dark style if a key is set (Appearance → bb.q settings → Delivery map), otherwise
Leaflet (from jsDelivr) with Esri's dark grey tiles. Before launch: Esri's tiles need an ArcGIS account for
production use, so add a Google Maps or ArcGIS key. Both maps contact a third-party server, so list them in the
cookie/privacy notice. If the map scripts can't load, the static picture stays.

## Still to connect / confirm

Copy in [square brackets] is placeholder text from the design (e.g. kitchen name, dates, links to be supplied by
BLT). Ordering-platform links, social links and the postcode check are not connected yet.

Waiting on the client (from the design team's overview, 19–20 Nov 2026):

- Sauce list with descriptions and spice levels; "Jamaica Mayo" or "Jamaican Mayo"
- Photos of the three formats: flagship, traditional restaurant, shop-in-shop
- The Madrid article (next week) and the UK article (before Christmas)
- The direct ordering link, and confirmation of the aggregator (Glovo, Uber Eats, Just Eat, Deliveroo) links
- The Privacy Policy text (for the legal page template)
- Which name to use in the news article: "BLT F&B Group" (as in the press) or "BLT Global Brands"
- María's alternative headshot (only if she still wants it)
- A Google Maps API key and the address of the Madrid kitchen

Decided: the text colour in the menu slider stays as it is (WCAG contrast). bbqchicken.com/media is empty, so
news cards can't pull articles from it yet. The floating "Submit your application" button was removed at the
client's request (18 Nov).
