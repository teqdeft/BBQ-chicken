<?php
/**
 * Careers page helpers (loaded on every request by functions.php; keep them cheap).
 */
defined( 'ABSPATH' ) || exit;

/**
 * Open application form: the CV field's hint (aria-describedby), which CF7 form-tags can't set.
 */
add_filter(
	'wpcf7_form_elements',
	function ( $html ) {
		$form = class_exists( 'WPCF7_ContactForm' ) ? WPCF7_ContactForm::get_current() : null;
		if ( ! $form || (int) $form->id() !== bbq_form_id( 'careers' ) ) {
			return $html;
		}
		return preg_replace_callback(
			'/<input\b[^>]*\bid="ca-cv"[^>]*>/',
			function ( $m ) {
				// CF7 itself sets aria-describedby while the field shows an error; don't add a second one.
				return false === strpos( $m[0], 'aria-describedby' ) ? str_replace( 'id="ca-cv"', 'id="ca-cv" aria-describedby="ca-cv-hint"', $m[0] ) : $m[0];
			},
			$html
		);
	}
);

