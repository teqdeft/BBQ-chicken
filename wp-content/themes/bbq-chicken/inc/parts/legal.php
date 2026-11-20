<?php
/**
 * Legal page (templates/legal.php): the policy text is the page content (block editor). Every
 * top-level h2 starts one of the design's sections and gets an entry in "On this page".
 */

defined( 'ABSPATH' ) || exit;

/**
 * Split rendered page content into the design's sections:
 *   <section class="legal-section" id="who-we-are" aria-labelledby="who-we-are-title"><h2 id="who-we-are-title">…
 * The id is the heading's own anchor (block editor: Advanced → HTML anchor), else made from its
 * text without the leading number ("1. Who we are" → who-we-are).
 * Returns array( 'html' => sections markup, 'toc' => array( array( 'id' => …, 'text' => … ), … ) ).
 */
function bbq_legal_sections( $html ) {
	$void  = array( 'area', 'base', 'br', 'col', 'embed', 'hr', 'img', 'input', 'link', 'meta', 'param', 'source', 'track', 'wbr' );
	$cuts  = array();
	$depth = 0;
	// Positions of the h2 tags that are not nested in another element.
	if ( preg_match_all( '#<(/?)([a-zA-Z][a-zA-Z0-9-]*)\b[^>]*?(/?)>#', $html, $tags, PREG_SET_ORDER | PREG_OFFSET_CAPTURE ) ) {
		foreach ( $tags as $t ) {
			$name = strtolower( $t[2][0] );
			if ( '/' === $t[1][0] ) {
				$depth = max( 0, $depth - 1 );
				continue;
			}
			if ( 0 === $depth && 'h2' === $name ) {
				$cuts[] = $t[0][1];
			}
			if ( ! in_array( $name, $void, true ) && '/' !== $t[3][0] ) {
				$depth++;
			}
		}
	}

	$out    = '';
	$toc    = array();
	$used   = array();
	$starts = array_merge( array( 0 ), $cuts );
	foreach ( $starts as $i => $start ) {
		$end  = isset( $starts[ $i + 1 ] ) ? $starts[ $i + 1 ] : strlen( $html );
		$part = substr( $html, $start, $end - $start );
		if ( '' === trim( $part ) ) {
			continue;
		}
		if ( ! $i && ( ! $cuts || $cuts[0] > 0 ) ) {
			$out .= '<div class="legal-section">' . $part . "</div>\n"; // text before the first heading
			continue;
		}
		if ( ! preg_match( '#^<h2\b([^>]*)>(.*?)</h2>#is', $part, $m ) ) {
			$out .= '<div class="legal-section">' . $part . "</div>\n";
			continue;
		}
		$text = trim( preg_replace( '/\s+/', ' ', wp_strip_all_tags( $m[2] ) ) );
		$id   = preg_match( '#\sid=(["\'])(.*?)\1#i', $m[1], $idm ) ? sanitize_title( $idm[2] ) : '';
		if ( '' === $id ) {
			$id = sanitize_title( preg_replace( '/^\s*\d+[.)]?\s*/', '', html_entity_decode( $text, ENT_QUOTES, 'UTF-8' ) ) );
		}
		$id   = '' !== $id ? $id : 'section';
		$base = $id;
		for ( $n = 2; isset( $used[ $id ] ); $n++ ) {
			$id = $base . '-' . $n;
		}
		$used[ $id ] = true;

		$attrs = preg_replace( '#\sid=(["\']).*?\1#i', '', $m[1] );
		$out  .= '<section class="legal-section" id="' . esc_attr( $id ) . '" aria-labelledby="' . esc_attr( $id ) . '-title">'
			. '<h2' . $attrs . ' id="' . esc_attr( $id ) . '-title">' . $m[2] . '</h2>'
			. substr( $part, strlen( $m[0] ) ) . "</section>\n";
		$toc[] = array( 'id' => $id, 'text' => $text );
	}
	return array( 'html' => $out, 'toc' => $toc );
}

/** The policy text is printed as typed (no curly quotes), like every other text of the design. */
add_action(
	'template_redirect',
	function () {
		if ( is_page() && 'legal' === bbq_current_key() ) {
			remove_filter( 'the_content', 'wptexturize' );
		}
	}
);
