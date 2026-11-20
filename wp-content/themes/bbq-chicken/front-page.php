<?php
/**
 * Home page (Settings → Reading → "A static page"). Content: templates/home.php, edited on the Home page.
 */
defined( 'ABSPATH' ) || exit;
get_header();
bbq_render_fields( 'home' );
get_footer();
