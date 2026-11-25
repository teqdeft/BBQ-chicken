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

/*
 * TranslatePress's own floating box (bottom right) is left out: the header has the languages.
 * Its other switchers (shortcode, menu items) keep working.
 */
function bbq_hide_floating_languages( $html ) {
	return bbq_languages() ? '' : $html;
}
add_filter( 'trp_floater_ls_html_v2', 'bbq_hide_floating_languages' );
add_filter( 'trp_floating_ls_html', 'bbq_hide_floating_languages' ); // TranslatePress's older ("legacy") switcher

/*
 * Form messages (Contact Form 7), such as "Thank you! Your message has been received.", reach the page after it has
 * loaded, as replies of Contact Form 7's REST address. TranslatePress translates the replies of the addresses listed
 * here: "message" (thank-you and error texts) and "error" (the checks while the visitor fills in the form).
 */
add_filter(
	'trp_rest_api_translation_config',
	function ( $config ) {
		$config                                    = (array) $config;
		$config['contact-form-7/v1/contact-forms'] = array( 'message', 'error' );
		return $config;
	}
);

/*
 * A translated page also holds its form's messages, hidden: TranslatePress then translates them with the page (not only
 * when a visitor sends the form) and lists them in its editor ("Translate Page"), where they can be corrected.
 */
add_filter(
	'wpcf7_form_elements',
	function ( $html ) {
		$form = class_exists( 'WPCF7_ContactForm' ) ? WPCF7_ContactForm::get_current() : null;
		if ( ! $form || ! bbq_languages() || bbq_is_default_language() ) {
			return $html;
		}
		$texts = array_map( 'trim', array_map( 'strval', (array) $form->prop( 'messages' ) ) );
		$mail  = (array) $form->prop( 'mail_2' );
		if ( ! empty( $mail['active'] ) && empty( $mail['use_html'] ) ) { // the confirmation to the visitor, see below
			foreach ( array( $mail['subject'], $mail['body'] ) as $text ) {
				foreach ( bbq_mail_pieces( $text ) as $piece ) {
					$texts[] = is_array( $piece ) ? $piece[1] : '';
				}
			}
		}
		$out = '';
		foreach ( array_unique( array_filter( $texts ) ) as $text ) {
			$out .= '<span>' . htmlspecialchars( $text, ENT_NOQUOTES, 'UTF-8', false ) . '</span>'; // apostrophes stay as they are in the reply, so both are the same text to TranslatePress
		}
		return '' === $out ? $html : $html . '<div class="form-messages" hidden>' . $out . '</div>';
	},
	20
);

/*
 * Form mails: TranslatePress would translate every mail sent from a translated page, and so keep the visitor's name,
 * address and message in its tables and send them to the translation service. Our forms' mails are left out:
 *   - the mails to the teams arrive as the visitor typed them;
 *   - the confirmation to the visitor (Mail (2)) has its own words translated, before the visitor's details are filled in.
 */
add_filter(
	'wpcf7_mail_components',
	function ( $components, $form, $mail ) {
		$GLOBALS['bbq_form_mail'] = $mail; // the mail about to be sent
		return $components;
	},
	99,
	3
);
add_filter(
	'wp_mail',
	function ( $args ) {
		$mail                     = isset( $GLOBALS['bbq_form_mail'] ) ? $GLOBALS['bbq_form_mail'] : null;
		$GLOBALS['bbq_form_mail'] = null;
		$headers                  = isset( $args['headers'] ) ? implode( "\n", (array) $args['headers'] ) : '';
		if ( ! $mail || false === stripos( $headers, 'X-WPCF7-Content-Type' ) || ! class_exists( 'TRP_Translate_Press' ) ) {
			return $args; // not a form mail
		}
		$render = TRP_Translate_Press::get_trp_instance()->get_component( 'translation_render' );
		if ( is_object( $render ) && remove_filter( 'wp_mail', array( $render, 'wp_mail_filter' ), 1 ) ) {
			$restore = function ( $args ) use ( &$restore, $render ) { // TranslatePress is back for the next mail
				remove_filter( 'wp_mail', $restore, 2 );
				add_filter( 'wp_mail', array( $render, 'wp_mail_filter' ), 1 );
				return $args;
			};
			add_filter( 'wp_mail', $restore, 2 );
		}
		if ( 'mail_2' === $mail->name() && ! bbq_is_default_language() ) {
			$form     = wpcf7_get_current_contact_form();
			$template = $form ? (array) $form->prop( 'mail_2' ) : array();
			if ( $template && empty( $template['use_html'] ) ) {
				$args['subject'] = wpcf7_strip_newline( $mail->replace_tags( bbq_translate_mail( $mail->get( 'subject' ) ) ) );
				$args['message'] = $mail->replace_tags( bbq_translate_mail( $mail->get( 'body' ) ), array( 'exclude_blank' => ! empty( $template['exclude_blank'] ) ) );
			}
		}
		if ( class_exists( 'TRP_Gettext_Manager' ) && method_exists( 'TRP_Gettext_Manager', 'strip_gettext_tags' ) ) { // its markers around WordPress's own texts
			$args['subject'] = TRP_Gettext_Manager::strip_gettext_tags( $args['subject'] );
			$args['message'] = TRP_Gettext_Manager::strip_gettext_tags( $args['message'] );
		}
		return $args;
	},
	0
);

/**
 * A mail's text in pieces: strings to keep (mail-tags such as [your-name], web addresses, line breaks) and
 * array( before, text, after ) for the words in between ("before" and "after" hold spaces and punctuation).
 */
function bbq_mail_pieces( $text ) {
	$out = array();
	foreach ( (array) preg_split( '~(\[[^\[\]\r\n]+\]|https?://[^\s<>"]*[^\s<>".,;:!?)]|\r\n|\r|\n)~', (string) $text, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY ) as $part ) {
		$words = ! preg_match( '~^(\[[^\[\]]+\]$|https?://|[\r\n])~', $part ) && preg_match( '~^([\s.,;:!?–—-]*)(.*?)(\s*)$~su', $part, $m ) && preg_match( '~\p{L}~u', $m[2] );
		$out[] = $words ? array( $m[1], $m[2], $m[3] ) : $part;
	}
	return $out;
}

/** A mail's text in the language of the page: its words translated, its mail-tags untouched, our own addresses in that language. */
function bbq_translate_mail( $text ) {
	global $TRP_LANGUAGE; // phpcs:ignore WordPress.NamingConventions.ValidVariableName
	$out       = '';
	$converter = TRP_Translate_Press::get_trp_instance()->get_component( 'url_converter' );
	foreach ( bbq_mail_pieces( $text ) as $piece ) {
		if ( is_array( $piece ) ) {
			$out .= $piece[0] . html_entity_decode( trp_translate( $piece[1], $TRP_LANGUAGE, false ), ENT_QUOTES, 'UTF-8' ) . $piece[2]; // phpcs:ignore WordPress.NamingConventions.ValidVariableName
		} elseif ( is_object( $converter ) && 0 === strpos( $piece, untrailingslashit( get_option( 'home' ) ) ) ) {
			$out .= $converter->get_url_for_language( $TRP_LANGUAGE, $piece, '' ); // phpcs:ignore WordPress.NamingConventions.ValidVariableName
		} else {
			$out .= $piece;
		}
	}
	return $out;
}

/** Is the page shown in the site's own (default) language? True without TranslatePress. */
function bbq_is_default_language() {
	global $TRP_LANGUAGE; // phpcs:ignore WordPress.NamingConventions.ValidVariableName
	$settings = (array) get_option( 'trp_settings', array() );
	return empty( $TRP_LANGUAGE ) || empty( $settings['default-language'] ) || $TRP_LANGUAGE === $settings['default-language']; // phpcs:ignore WordPress.NamingConventions.ValidVariableName
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
