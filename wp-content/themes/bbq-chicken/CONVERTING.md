# Converting a static page to the theme

The static site is in git tag `static-html-v4` (and, on the development machine, in `html-backup/`, with the
comparison tools in `design-data/tools/`; both are kept out of the repository's main branch). Page sources:
`html-backup/src/pages/*.html`. Each page becomes
`templates/<key>.php`, which prints **exactly the same markup** with every text, image and link turned
into an editable field. `templates/contact.php` (+ `inc/forms/contact.php`) is the worked example.

## Field functions (inc/fields.php)

| Static | Template |
| --- | --- |
| section boundary | `bbq_section( 'Hero' );` – groups the following fields in the editor |
| plain text | `bbq_text( 'hero_title', 'Default text', 'Heading' );` |
| longer plain text | `bbq_textarea( 'hero_lead', '…', 'Intro text' );` |
| text with `<strong>`, `<br>`, `<em>`, `<a>`, `<span>` | `bbq_html( 'key', 'Text with <br> markup', 'Label' );` |
| `<img>` | `bbq_image( 'key', 'file-in-assets-img.png', 'Label', array( 'class' => …, 'alt' => …, 'width' => …, 'height' => …, 'loading' => 'lazy' ) );` (`'svg/x.svg'` for assets/svg) |
| image URL (CSS background, data-attribute) | `bbq_image_url( 'key', 'file.jpg', 'Label' )` |
| link / button | `$l = bbq_link( 'key', array( 'label' => 'Order now', 'url' => 'page:home#find' ), 'Label' );` then `<a class="btn btn--cream"<?php bbq_link_attrs( $l ); ?>><?php bbq_e( $l['label'] ); ?> <span class="btn__chip"><?php bbq_icon( 'arrow' ); ?></span></a>` |
| value for an attribute/condition | `bbq_get( 'key', 'default', 'Label' )` (escape yourself) |
| choice | `bbq_select( 'key', 'red', 'Colour', array( 'red' => 'Red', … ) )` |
| show/hide | `bbq_toggle( 'key', true, 'Show this section' )` |
| list of similar items (cards, rows, FAQ, steps, people, sauces …) | `foreach ( bbq_rows( 'key', 'Label', $subfields, $default_rows ) as $row )` – editors add/remove/reorder rows |

Row sub-field types: `text`, `textarea`, `html`, `image`, `link`, `select` (3rd item = choices), `toggle`.
Print row values with `bbq_e()` (escaped text), `bbq_k()` (simple HTML), `bbq_img( $row['img'], $attrs )`,
`bbq_link_attrs( $row['cta'] )`.

Rules:

- **Same markup as the static page.** Same elements, classes, ids, aria and data attributes. The page CSS and
  JS are the static files, unchanged, so any markup difference shows up as a visual difference.
- **Keys** are short, unique per page, snake_case, and never change once published (they are the storage).
- **Labels** are for editors: plain words ("Heading", "Intro text", "Primary button", "Cards").
- **Every visible text** is a field (headings, paragraphs, labels/eyebrows, button texts, alt texts of
  meaningful images, numbers, captions, notes). Decorative SVGs, icons and layout-only elements stay in code.
- **Repeated items** (anything an editor might add or remove) are `bbq_rows`. If items differ only by a
  modifier class (card colours), make that a `select` sub-field. Fixed design structures with exactly N items
  that can't change (e.g. a bento grid with fixed tile positions) may be individual fields instead.
- **Links between pages** use `page:<key>` with an optional `#hash`: `page:home#find`, `page:franchise#faq`,
  `page:apply`, `page:news`, `page:legal`. Keys: home, news, franchise, apply, apply-thank-you, discover,
  menu, about, real-estate, careers, contact, legal. Links to the apply page automatically get `data-apply`
  (opens the application pop-up). `{{icon:name}}` → `bbq_icon( 'name' )`, `{{stamp}}` → `bbq_stamp()`.
- **No functions in templates** (they run more than once per request). Put helpers in `inc/parts/<key>.php`.
- **No side effects** in templates: they also run in "schema mode" in the admin to build the edit form
  (output is discarded). Use `bbq_schema_mode()` to skip expensive work if needed.
- The SEO title/description fields are added automatically.

## Forms (Contact Form 7)

One file per form in `inc/forms/<name>.php`, returning
`array( 'title', 'form' (markup with CF7 form-tags), 'mail', 'messages', 'html_id', 'html_class', 'thank_you' )`.
Write the static form's markup with its wrappers, replacing each control with a form-tag that keeps the
id and class: `[text* full-name id:app-name class:input autocomplete:name placeholder "First and last name"]`,
`[email* …]`, `[tel …]`, `[select* topic id:… class:select first_as_label "Placeholder" "Option 1" "Option 2"]`,
`[textarea* message id:… class:textarea x5 placeholder "…"]`, `[file cv limit:10mb filetypes:pdf|doc|docx]`,
`[radio … use_label_element "A" "B"]`, `[acceptance consent]Text with <a href="…">link</a>[/acceptance]`.
Submit: `<button class="btn btn--red wpcf7-submit" type="submit">Label <span class="btn__chip">…</span></button>`.
`'thank_you' => true` sends the visitor to the thank-you page after a successful submission.
Print in the template with `bbq_form( 'name' )`. CF7 adds wrappers (`span.wpcf7-form-control-wrap`, the
`div.wpcf7` around the form, list items for radios/checkboxes); adapt in your page CSS (or ask for a shared
rule in `assets/css/wp.css`). Option values are the option texts, so CSS/JS that matched old values needs updating.
Create/refresh forms: `C:/xampp/php/php.exe E:/vishal/blt-global/design-data/tools/wp-cli-lite.php C:/xampp/htdocs/bbq-chicken eval 'print_r( bbq_install_forms( true ) );'`
(local installs get `skip_mail: on`, so submissions succeed without a mail server).

## Checking

- Lint: `C:/xampp/php/php.exe -l file.php`
- Fields as the editor sees them: `C:/xampp/php/php.exe E:/vishal/blt-global/design-data/tools/wp-cli-lite.php C:/xampp/htdocs/bbq-chicken eval '$p = bbq_find_page("contact"); foreach ( bbq_post_schema( $p->ID ) as $k => $f ) echo $f["section"], " | ", $k, " | ", $f["type"], " | ", $f["label"], "\n";'`
  (home: `get_post( get_option( "page_on_front" ) )`, news: `get_post( get_option( "page_for_posts" ) )`)
- **Parity with the static page** (open any page on http://localhost in the browser, then run):
  `(0,eval)(await (await fetch('/bbq-tools/parity.js')).text()); await parity('/bbq-static/contact.html', '/bbq-chicken/contact/', [1680, 1440, 390])`
  Every width should report the same main height and no `diffs`/`missing`/`extra` (3px tolerance).
- Debug log: `C:/xampp/htdocs/bbq-chicken/wp-content/debug.log`
