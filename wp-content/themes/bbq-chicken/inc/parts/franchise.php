<?php
/**
 * Helpers for templates/franchise.php (functions can't live in the template itself).
 */

defined( 'ABSPATH' ) || exit;

/**
 * The application form in the Franchise page's #apply section.
 *
 * It is the same Contact Form 7 form as on the Apply page (inc/forms/application.php), printed as
 * the static page had it: the form id "franchise-application-form" (so the page's "Submit your
 * application" buttons still open the pop-up, which looks for #application-form on the Apply page)
 * and the field ids f-… instead of app-…, so they never clash with the pop-up's copy.
 */
function bbq_franchise_application_form() {
	ob_start();
	bbq_form( 'application', array( 'html_id' => 'franchise-application-form' ) );
	$html = (string) ob_get_clean();
	echo preg_replace( '/\b(id|for|aria-describedby)="app-/', '$1="f-', $html ); // phpcs:ignore WordPress.Security.EscapeOutput -- CF7 output
}

/**
 * width/height attributes for a row image that is one of the design's files in assets/
 * (media-library images get theirs from WordPress). Returns array( 'width' => …, 'height' => … ) or array().
 */
function bbq_franchise_img_size( $value ) {
	static $cache = array();
	if ( is_numeric( $value ) || ! is_string( $value ) || '' === $value || preg_match( '#^(https?:)?//#', $value ) ) {
		return array();
	}
	if ( ! isset( $cache[ $value ] ) ) {
		$file            = BBQ_DIR . '/assets/' . ( false === strpos( $value, '/' ) ? 'img/' . $value : ltrim( str_replace( '..', '', $value ), '/' ) );
		$size            = is_file( $file ) ? @getimagesize( $file ) : false; // phpcs:ignore WordPress.PHP.NoSilencedErrors
		$cache[ $value ] = $size ? array( 'width' => (int) $size[0], 'height' => (int) $size[1] ) : array();
	}
	return $cache[ $value ];
}
