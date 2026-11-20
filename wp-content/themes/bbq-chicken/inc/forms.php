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
		$settings = isset( $def['additional_settings'] ) ? (string) $def['additional_settings'] : '';
		if ( 'local' === wp_get_environment_type() && false === strpos( $settings, 'skip_mail' ) ) {
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
