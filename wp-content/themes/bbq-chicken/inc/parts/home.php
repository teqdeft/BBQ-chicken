<?php
/**
 * Helpers for the Home page template (templates/home.php).
 */

defined( 'ABSPATH' ) || exit;

/**
 * Items of a scrolling band (.marquee__track): editable rows of text, each followed by a sparkle.
 * $defaults: array( array( 'text' => 'Since 1995', 'strong' => 1 ), … ).
 */
function bbq_home_marquee( $key, $label, $defaults ) {
	$rows = bbq_rows(
		$key,
		$label,
		array(
			'text'   => array( 'text', 'Text' ),
			'strong' => array( 'toggle', 'Bold' ),
		),
		$defaults
	);
	foreach ( $rows as $row ) {
		if ( '' === trim( (string) $row['text'] ) ) {
			continue;
		}
		echo "\n    " . '<span class="marquee__item' . ( $row['strong'] ? ' marquee__item--strong' : '' ) . '">' . esc_html( $row['text'] ) . '</span>' . bbq_icon_svg( 'sparkle' ); // phpcs:ignore WordPress.Security.EscapeOutput -- escaped text + fixed SVG
	}
	echo "\n  ";
}

/**
 * The most recent news posts for the home "What's new" row: published posts, newest first,
 * leaving out placeholder cards (News card box → "Placeholder card").
 */
function bbq_home_news_ids( $count = 5 ) {
	$ids = get_posts(
		array(
			'post_type'           => 'post',
			'post_status'         => 'publish',
			'posts_per_page'      => max( 10, $count * 4 ),
			'orderby'             => 'date',
			'order'               => 'DESC',
			'fields'              => 'ids',
			'ignore_sticky_posts' => true,
			'no_found_rows'       => true,
		)
	);
	$out = array();
	foreach ( $ids as $id ) {
		if ( bbq_news_field( $id, 'placeholder' ) ) {
			continue;
		}
		$out[] = (int) $id;
		if ( count( $out ) >= $count ) {
			break;
		}
	}
	return $out;
}
