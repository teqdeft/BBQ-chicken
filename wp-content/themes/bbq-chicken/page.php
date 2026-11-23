<?php
/**
 * Pages without a theme template: their ACF "Sections" when the page has any (built like the other pages,
 * see inc/sections.php), else the plain text column of index.php.
 */
defined( 'ABSPATH' ) || exit;

if ( null === bbq_stored_sections( get_queried_object_id() ) ) {
	require __DIR__ . '/index.php';
	return;
}
get_header();
bbq_render_page( '', get_queried_object_id() );
get_footer();
