<?php
/**
 * Real estate page helpers (loaded on every request by functions.php; keep them cheap).
 */
defined( 'ABSPATH' ) || exit;

/**
 * Premises offer form: attributes from the static markup that CF7 form-tags can't set –
 * the file field's hint (aria-describedby) and a decimal keypad / free decimals for the size.
 */
add_filter(
	'wpcf7_form_elements',
	function ( $html ) {
		$form = class_exists( 'WPCF7_ContactForm' ) ? WPCF7_ContactForm::get_current() : null;
		if ( ! $form || (int) $form->id() !== bbq_form_id( 'real-estate' ) ) {
			return $html;
		}
		return preg_replace_callback(
			'/<input\b[^>]*\bid="re-(files|size)"[^>]*>/',
			function ( $m ) {
				if ( 'files' === $m[1] ) {
					// CF7 itself sets aria-describedby while the field shows an error; don't add a second one.
					return false === strpos( $m[0], 'aria-describedby' ) ? str_replace( 'id="re-files"', 'id="re-files" aria-describedby="re-files-hint"', $m[0] ) : $m[0];
				}
				return false === strpos( $m[0], ' step=' ) ? str_replace( 'id="re-size"', 'id="re-size" inputmode="decimal" step="any"', $m[0] ) : $m[0];
			},
			$html
		);
	}
);

