<?php
/**
 * Shared setup for the legal sections (included by each of them): the page and its policy text,
 * split into sections at its h2 headings (inc/parts/legal.php). Read once per request.
 */
defined( 'ABSPATH' ) || exit;
$live     = ! bbq_schema_mode();
$the_page = $live && get_queried_object() instanceof WP_Post ? get_queried_object() : null;
$title    = $the_page && '' !== trim( $the_page->post_title ) ? $the_page->post_title : 'Privacy policy';

if ( ! isset( $GLOBALS['bbq_legal'] ) ) {
	$GLOBALS['bbq_legal'] = array( 'html' => '', 'toc' => array() );
	if ( $the_page ) {
		$GLOBALS['bbq_legal'] = bbq_legal_sections( str_replace( ']]>', ']]&gt;', apply_filters( 'the_content', $the_page->post_content ) ) );
	}
}
$legal = $GLOBALS['bbq_legal'];
?>
