<?php
/**
 * Helpers for templates/menu.php.
 */

defined( 'ABSPATH' ) || exit;

/** Spice levels offered for a sauce ("tbc" = not confirmed yet: no level is read out). */
function bbq_menu_spice_levels() {
	return array(
		'0'   => 'No chilli (0 of 3)',
		'1'   => '1 chilli (1 of 3)',
		'2'   => '2 chillies (2 of 3)',
		'3'   => '3 chillies (3 of 3)',
		'tbc' => 'Not confirmed yet',
	);
}

/**
 * The chilli rating of a sauce card: a screen-reader text, three chilli icons (the first $level lit)
 * and an optional note such as "(draft)". Same markup as the static page (no whitespace between spans).
 */
function bbq_menu_spice( $level, $note, $sr_label ) {
	$level = (string) $level;
	$known = in_array( $level, array( '0', '1', '2', '3' ), true );
	$lit   = $known ? (int) $level : 0;
	$html  = '<p class="spice"><span class="sr-only">' . esc_html( $known ? $sr_label . ' ' . $lit . ' of 3' : $sr_label ) . '</span>';
	for ( $i = 1; $i <= 3; $i++ ) {
		$html .= '<span class="chili' . ( $i <= $lit ? ' chili--on' : '' ) . '" aria-hidden="true"></span>';
	}
	if ( '' !== trim( (string) $note ) ) {
		$html .= '<span class="spice__note">' . esc_html( $note ) . '</span>';
	}
	return $html . '</p>';
}
