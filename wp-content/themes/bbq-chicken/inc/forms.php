<?php
/**
 * Forms (Contact Form 7).
 *
 * Each form is defined in inc/forms/<name>.php (returns its title, form markup with CF7 form-tags,
 * mail settings and messages). "Appearance → bb.q setup" creates or updates the CF7 forms from these
 * definitions; afterwards they can be edited under Contact → Contact Forms.
 * Templates print a form with bbq_form( 'contact' ).
 */

defined( 'ABSPATH' ) || exit;

/** Our form markup is written with its own wrappers: don't let CF7 add <p> and <br>. */
add_filter( 'wpcf7_autop_or_not', '__return_false' );

/**
 * Is $host (default: this site's host) a local development host: localhost, 127.0.0.1, ::1, *.test,
 * *.localhost, *.local? Decided by the address rather than WP_ENVIRONMENT_TYPE, because a wp-config.php
 * copied from a local install keeps saying "local" on the live server.
 */
function bbq_is_local_host( $host = null ) {
	$host = strtolower( trim( (string) ( null === $host ? wp_parse_url( home_url(), PHP_URL_HOST ) : $host ), '[]' ) );
	return in_array( $host, array( 'localhost', '127.0.0.1', '::1' ), true ) || (bool) preg_match( '/\.(test|localhost|local)$/', $host );
}

/** Domain part of the first email address in $text ('' if none). */
function bbq_email_domain( $text ) {
	return preg_match( '/@([a-z0-9.-]+)/i', (string) $text, $m ) ? strtolower( $m[1] ) : '';
}

/** IDs of the CF7 forms this theme created. */
function bbq_form_ids() {
	return array_map( 'intval', array_values( (array) get_option( 'bbq_forms', array() ) ) );
}

/*
 * A database copied from a local install (e.g. with WP Migrate DB) brings local-only mail settings to the
 * live site: "skip_mail: on" (added on local installs, see bbq_install_forms()) and a sender address at the
 * local domain. On a live host our forms always send mail, and a local sender becomes wordpress@<site domain>.
 */
add_filter(
	'wpcf7_skip_mail',
	function ( $skip, $contact_form ) {
		if ( $skip && $contact_form && ! bbq_is_local_host() && in_array( (int) $contact_form->id(), bbq_form_ids(), true ) ) {
			return false;
		}
		return $skip;
	},
	10,
	2
);
/*
 * Routing: a form definition's 'routing' => array( field => array( chosen option => email ) ) sends the main
 * mail for that choice to its own team (e.g. the contact form's "Careers" to jobs@…) instead of the To address.
 */
add_filter(
	'wpcf7_mail_components',
	function ( $components, $contact_form, $mail ) {
		if ( ! $contact_form || ! $mail || 'mail' !== $mail->name() || ! class_exists( 'WPCF7_Submission' ) ) {
			return $components;
		}
		$name = array_search( (int) $contact_form->id(), array_map( 'intval', (array) get_option( 'bbq_forms', array() ) ), true );
		$defs = bbq_form_definitions();
		if ( false === $name || empty( $defs[ $name ]['routing'] ) ) {
			return $components;
		}
		$submission = WPCF7_Submission::get_instance();
		foreach ( (array) $defs[ $name ]['routing'] as $field => $map ) {
			$value = $submission ? $submission->get_posted_data( $field ) : null;
			$value = is_array( $value ) ? reset( $value ) : $value;
			if ( is_string( $value ) && isset( $map[ $value ] ) && is_email( $map[ $value ] ) ) {
				$components['recipient'] = $map[ $value ];
			}
		}
		return $components;
	},
	20,
	3
);
add_filter(
	'wpcf7_mail_components',
	function ( $components ) {
		$domain = bbq_email_domain( $components['sender'] );
		if ( '' === $domain || ! bbq_is_local_host( $domain ) || bbq_is_local_host() ) {
			return $components;
		}
		$site = preg_replace( '/^www\./', '', strtolower( (string) wp_parse_url( home_url(), PHP_URL_HOST ) ) );
		$components['sender'] = preg_replace( '/[^\s<>"]+@' . preg_quote( $domain, '/' ) . '/i', 'wordpress@' . $site, $components['sender'] );
		return $components;
	}
);

/** Form definitions: array( name => array( title, form, mail, mail_2?, messages?, additional_settings?, html_id?, html_class? ) ). */
function bbq_form_definitions() {
	$defs = array();
	foreach ( glob( BBQ_DIR . '/inc/forms/*.php' ) as $file ) {
		$def = include $file;
		if ( is_array( $def ) ) {
			$defs[ basename( $file, '.php' ) ] = $def;
		}
	}
	return $defs;
}

/** CF7 form id for one of our forms (0 if it hasn't been created yet). */
function bbq_form_id( $name ) {
	$ids = get_option( 'bbq_forms', array() );
	$id  = isset( $ids[ $name ] ) ? (int) $ids[ $name ] : 0;
	return $id && 'wpcf7_contact_form' === get_post_type( $id ) ? $id : 0;
}

/**
 * Print one of our forms. $args: html_id, html_class (added to the <form>).
 * Before setup has run (or without CF7) admins see a hint; visitors see nothing.
 */
function bbq_form( $name, $args = array() ) {
	if ( bbq_schema_mode() ) {
		return;
	}
	$defs = bbq_form_definitions();
	$def  = isset( $defs[ $name ] ) ? $defs[ $name ] : array();
	$args = array_merge(
		array(
			'html_id'    => isset( $def['html_id'] ) ? $def['html_id'] : '',
			'html_class' => isset( $def['html_class'] ) ? $def['html_class'] : 'form',
		),
		$args
	);
	$id = bbq_form_id( $name );
	if ( ! $id || ! shortcode_exists( 'contact-form-7' ) ) {
		if ( current_user_can( 'manage_options' ) ) {
			echo '<p class="form-status">[Form "' . esc_html( $name ) . '": install Contact Form 7 and run Appearance → bb.q setup.]</p>';
		}
		return;
	}
	$sc = sprintf( '[contact-form-7 id="%d" html_id="%s" html_class="%s"]', $id, esc_attr( $args['html_id'] ), esc_attr( $args['html_class'] ) );
	echo do_shortcode( $sc ); // phpcs:ignore WordPress.Security.EscapeOutput -- CF7 output
}

/** Create or update the CF7 forms from the definitions ($only: limit to these form names). Returns array( name => id ). */
function bbq_install_forms( $overwrite = false, $only = array() ) {
	if ( ! class_exists( 'WPCF7_ContactForm' ) ) {
		return array();
	}
	$ids = get_option( 'bbq_forms', array() );
	foreach ( bbq_form_definitions() as $name => $def ) {
		if ( $only && ! in_array( $name, (array) $only, true ) ) {
			continue;
		}
		$id = bbq_form_id( $name );
		if ( $id && ! $overwrite ) {
			continue;
		}
		$form = $id ? WPCF7_ContactForm::get_instance( $id ) : WPCF7_ContactForm::get_template();
		$form->set_title( $def['title'] );
		$props = array( 'form' => $def['form'] );
		foreach ( array( 'mail', 'mail_2', 'messages' ) as $prop ) {
			if ( isset( $def[ $prop ] ) ) {
				$props[ $prop ] = array_merge( (array) $form->prop( $prop ), $def[ $prop ] );
			}
		}
		// A reset keeps a To address set by hand (anything other than the theme's default, the site admin email).
		$old = $id ? (array) $form->prop( 'mail' ) : array();
		if ( isset( $props['mail'], $old['recipient'] ) && '' !== trim( $old['recipient'] ) && '[_site_admin_email]' !== trim( $old['recipient'] ) ) {
			$props['mail']['recipient'] = $old['recipient'];
		}
		$settings = isset( $def['additional_settings'] ) ? (string) $def['additional_settings'] : '';
		if ( bbq_is_local_host() && false === strpos( $settings, 'skip_mail' ) ) {
			// Local install: no mail server, so CF7 would report every submission as failed.
			$settings = trim( $settings . "\nskip_mail: on" );
		}
		$props['additional_settings'] = $settings;
		$form->set_properties( $props );
		$ids[ $name ] = $form->save();
	}
	update_option( 'bbq_forms', $ids, false );
	return $ids;
}

/** After a successful application, go to the thank-you page (the form defines 'thank_you' => true). */
add_action(
	'wp_enqueue_scripts',
	function () {
		$redirect = array();
		foreach ( bbq_form_definitions() as $name => $def ) {
			if ( ! empty( $def['thank_you'] ) && bbq_form_id( $name ) ) {
				$redirect[] = bbq_form_id( $name );
			}
		}
		if ( ! $redirect ) {
			return;
		}
		wp_add_inline_script(
			'bbq-main',
			// The application pop-up shows its own thank-you state, so it is skipped here.
			'document.addEventListener("wpcf7mailsent",function(e){if(e.target&&e.target.closest&&e.target.closest(".apply-modal"))return;var ids=' . wp_json_encode( $redirect ) . ';if(ids.indexOf(Number(e.detail.contactFormId))>-1){window.location.href=' . wp_json_encode( bbq_page_url( 'apply-thank-you' ) ) . ';}});'
		);
	},
	20
);
