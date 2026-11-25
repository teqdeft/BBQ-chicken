<?php
/**
 * Languages (TranslatePress): the dropdown in the header and the language links in the mobile menu and the footer.
 * The languages, their names and addresses come from TranslatePress (Settings → TranslatePress); each link leads to
 * the same page in the other language. Without TranslatePress, or with one language, the theme's own texts are shown.
 */

defined( 'ABSPATH' ) || exit;

/**
 * The published languages: array of array( code 'es_ES', tag 'es-ES', short 'ES', name 'Español', url, current ).
 * Empty without TranslatePress or with a single language.
 */
function bbq_languages() {
	static $list = null;
	if ( bbq_schema_mode() || ! function_exists( 'trp_custom_language_switcher' ) || ! class_exists( 'TRP_Translate_Press' ) ) {
		return array();
	}
	if ( null !== $list ) {
		return $list;
	}
	global $TRP_LANGUAGE; // phpcs:ignore WordPress.NamingConventions.ValidVariableName -- TranslatePress's current language
	$list  = array();
	$items = trp_custom_language_switcher();
	if ( ! is_array( $items ) || count( $items ) < 2 ) {
		return $list;
	}
	// each language in its own words ("Español"), whatever TranslatePress's own switcher shows
	$names = array();
	$trp   = TRP_Translate_Press::get_trp_instance()->get_component( 'languages' );
	if ( is_object( $trp ) && method_exists( $trp, 'get_language_names' ) ) {
		$names = (array) $trp->get_language_names( array_keys( $items ), 'native_name' );
	}
	foreach ( $items as $code => $item ) {
		$list[] = array(
			'code'    => $code,
			'tag'     => str_replace( '_', '-', $code ),
			'short'   => strtoupper( substr( $code, 0, 2 ) ),
			'name'    => ! empty( $names[ $code ] ) ? $names[ $code ] : $item['language_name'],
			'url'     => $item['current_page_url'],
			'current' => $code === $TRP_LANGUAGE, // phpcs:ignore WordPress.NamingConventions.ValidVariableName
		);
	}
	return $list;
}

/** A link to a language. (The links stand inside data-no-translation: TranslatePress leaves their address and name alone.) */
function bbq_language_link( $lang, $class = '' ) {
	return '<a' . ( '' !== $class ? ' class="' . esc_attr( $class ) . '"' : '' ) . ' href="' . esc_url( $lang['url'] ) . '" hreflang="' . esc_attr( $lang['tag'] ) . '" lang="' . esc_attr( $lang['tag'] ) . '"' . ( $lang['current'] ? ' aria-current="true"' : '' ) . '>' . esc_html( $lang['name'] ) . '</a>';
}

/** Header: the language dropdown ("EN ▾"). False when there is nothing to choose. */
function bbq_language_menu() {
	$langs = bbq_languages();
	if ( ! $langs ) {
		return false;
	}
	$short = $langs[0]['short'];
	$links = '';
	foreach ( $langs as $lang ) {
		$short  = $lang['current'] ? $lang['short'] : $short;
		$links .= bbq_language_link( $lang, 'dropdown__link' );
	}
	echo '<div class="lang-menu" data-dropdown>';
	echo '<button class="lang-switch" type="button" aria-expanded="false" aria-controls="dd-lang"><span class="sr-only">Language:</span> <span data-no-translation>' . esc_html( $short ) . '</span> <span class="lang-switch__mark" aria-hidden="true" data-no-translation>▾</span></button>';
	echo '<div class="dropdown" id="dd-lang" data-no-translation>' . $links . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput -- escaped in bbq_language_link()
	echo '</div>';
	return true;
}

/** Mobile menu and footer: "English · Español". $link_current: the current language is a link too. False when there is nothing to choose. */
function bbq_language_links( $link_current = false ) {
	$out = array();
	foreach ( bbq_languages() as $lang ) {
		$out[] = $lang['current'] && ! $link_current ? '<span lang="' . esc_attr( $lang['tag'] ) . '" aria-current="true">' . esc_html( $lang['name'] ) . '</span>' : bbq_language_link( $lang );
	}
	if ( ! $out ) {
		return false;
	}
	echo '<span data-no-translation>' . implode( ' · ', $out ) . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput -- escaped above
	return true;
}
