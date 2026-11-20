<?php
/**
 * Helpers for templates/about.php.
 */

defined( 'ABSPATH' ) || exit;

/**
 * <source> of a <picture> for an image field value: a media-library image (its own size) or a
 * design image in assets/ ($width × $height). Prints nothing when there is no image.
 */
function bbq_about_source( $value, $media, $width, $height ) {
	if ( is_numeric( $value ) && (int) $value > 0 ) {
		$img = wp_get_attachment_image_src( (int) $value, 'full' );
		if ( ! $img ) {
			return;
		}
		list( $src, $width, $height ) = $img;
	} else {
		$src = bbq_image_src( $value );
	}
	if ( ! $src ) {
		return;
	}
	echo '<source media="' . esc_attr( $media ) . '" srcset="' . esc_url( $src ) . '" width="' . esc_attr( $width ) . '" height="' . esc_attr( $height ) . '">'; // phpcs:ignore WordPress.Security.EscapeOutput -- escaped above
}
