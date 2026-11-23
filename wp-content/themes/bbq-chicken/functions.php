<?php
/**
 * bb.q Chicken Europe theme.
 *
 * Structure
 *   templates/<key>.php       page content with editable fields (see CONVERTING.md)
 *   page-templates/<key>.php  thin WordPress page templates that load templates/<key>.php
 *   inc/                      theme code (fields, admin, menus, forms, importer)
 *   assets/                   the site's CSS, JS and images (same files as the static site)
 */

defined( 'ABSPATH' ) || exit;

define( 'BBQ_VERSION', '1.0.0' );
define( 'BBQ_DIR', get_template_directory() );
define( 'BBQ_URI', get_template_directory_uri() );

require BBQ_DIR . '/inc/helpers.php';
require BBQ_DIR . '/inc/templates.php';
require BBQ_DIR . '/inc/fields.php';
require BBQ_DIR . '/inc/layouts.php';
require BBQ_DIR . '/inc/sections.php';
require BBQ_DIR . '/inc/acf-fields.php';
require BBQ_DIR . '/inc/acf-migrate.php';
require BBQ_DIR . '/inc/fields-admin.php';
require BBQ_DIR . '/inc/options.php';
require BBQ_DIR . '/inc/menus.php';
require BBQ_DIR . '/inc/news.php';
require BBQ_DIR . '/inc/forms.php';
require BBQ_DIR . '/inc/analytics.php';
require BBQ_DIR . '/inc/importer.php';

// Helpers that belong to one page template (functions can't live in templates/*.php, which run more than once).
foreach ( glob( BBQ_DIR . '/inc/parts/*.php' ) as $bbq_part ) {
	require $bbq_part;
}
unset( $bbq_part );

// Card post types (Team, Food cards, Chicken cards, Sauces); after the parts, it uses their helpers.
require BBQ_DIR . '/inc/card-types.php';
