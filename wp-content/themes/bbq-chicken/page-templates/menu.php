<?php
/**
 * Template Name: The menu
 *
 * Page content: templates/menu.php (edited in the page's "Page content" box).
 */
defined( 'ABSPATH' ) || exit;
get_header();
bbq_render_fields( 'menu' );
get_footer();
