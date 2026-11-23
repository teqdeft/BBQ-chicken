<?php
/**
 * Pages built from sections, the way the Sokkies site works: each page has an ACF Flexible Content field
 * "Sections" (inc/acf-fields.php); every layout is one section file in template-parts/sections/<page>/,
 * listed in inc/layouts.php. Editors add, reorder and remove sections and fill in their fields.
 *
 * A page whose "Sections" field was never filled in shows its template's default sections
 * (templates/<page>.php) with the older field values, so nothing changes until the content is moved
 * into ACF (Appearance → bb.q setup → "Move the content into ACF", inc/acf-migrate.php).
 */

defined( 'ABSPATH' ) || exit;

/** The default sections (layout names) of a page template; empty for templates that aren't section lists. */
function bbq_default_sections( $key ) {
	static $cache = array();
	if ( ! isset( $cache[ $key ] ) ) {
		$file          = BBQ_DIR . '/templates/' . $key . '.php';
		$list          = file_exists( $file ) && in_array( $key, bbq_section_pages(), true ) ? include $file : array();
		$cache[ $key ] = is_array( $list ) ? $list : array();
	}
	return $cache[ $key ];
}

/** Page templates that are built from sections. */
function bbq_section_pages() {
	return array( 'home', 'franchise', 'apply', 'apply-thank-you', 'discover', 'menu', 'about', 'real-estate', 'careers', 'contact', 'legal', 'news' );
}

/** The layouts stored in a page's "Sections" field (in order), or null when it was never filled in (an empty field counts as not filled in). */
function bbq_stored_sections( $post_id ) {
	if ( ! $post_id || ! metadata_exists( 'post', (int) $post_id, 'sections' ) ) {
		return null;
	}
	$layouts = get_post_meta( (int) $post_id, 'sections', true );
	return is_array( $layouts ) && $layouts ? array_values( $layouts ) : null;
}

/** Print one section with the given field store (see bbq_ctx_start()). */
function bbq_render_layout( $layout, $store ) {
	$layouts = bbq_layouts();
	if ( ! isset( $layouts[ $layout ] ) ) {
		return;
	}
	$saved = $GLOBALS['bbq_ctx'];
	bbq_ctx_start( $store );
	include BBQ_DIR . '/' . $layouts[ $layout ]['file'];
	$GLOBALS['bbq_ctx'] = $saved;
}

/** Print a page: the sections from its "Sections" field, or the template's default sections. */
function bbq_render_page( $key, $post_id ) {
	$stored = bbq_stored_sections( $post_id );
	if ( null === $stored ) {
		foreach ( bbq_default_sections( $key ) as $layout ) {
			bbq_render_layout( $layout, (int) $post_id );
		}
		return;
	}
	foreach ( $stored as $i => $layout ) {
		bbq_render_layout(
			$layout,
			array(
				'acf'    => (int) $post_id,
				'prefix' => 'sections_' . $i . '_',
				'legacy' => null,
			)
		);
	}
}

/** The fields of one section (its file run in schema mode). */
function bbq_layout_schema( $layout, $store = 0 ) {
	$layouts = bbq_layouts();
	if ( ! isset( $layouts[ $layout ] ) ) {
		return array();
	}
	$saved = $GLOBALS['bbq_ctx'];
	bbq_ctx_start( $store, true );
	ob_start();
	try {
		include BBQ_DIR . '/' . $layouts[ $layout ]['file'];
	} catch ( \Throwable $e ) {
		error_log( 'bbq schema: ' . $layout . ': ' . $e->getMessage() ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions
	}
	ob_end_clean();
	$schema             = $GLOBALS['bbq_ctx']['schema'];
	$GLOBALS['bbq_ctx'] = $saved;
	return $schema;
}
