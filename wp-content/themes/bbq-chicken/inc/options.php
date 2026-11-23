<?php
/**
 * Site settings (Appearance → bb.q settings): the header and footer texts, ordering links,
 * social links and the delivery map. Fields are defined in templates/site-header.php and
 * templates/site-footer.php and stored in the "bbq_site" option.
 */

defined( 'ABSPATH' ) || exit;

function bbq_site_schema() {
	return bbq_collect_schema( array( 'site-header', 'site-footer', 'site-settings' ), 'options' );
}

/** A site setting value (with the schema default) for use outside the header/footer templates. */
function bbq_opt( $key, $default = '' ) {
	$values = get_option( BBQ_OPTION, array() );
	return is_array( $values ) && array_key_exists( $key, $values ) ? $values[ $key ] : $default;
}

add_action(
	'admin_menu',
	function () {
		if ( bbq_acf_ready() ) {
			return; // replaced by the ACF options page "Website settings" (inc/acf-fields.php)
		}
		add_theme_page( 'bb.q settings', 'bb.q settings', 'edit_theme_options', 'bbq-settings', 'bbq_settings_screen' );
	}
);

function bbq_settings_screen() {
	$values = get_option( BBQ_OPTION, array() );
	echo '<div class="wrap bbq-settings-wrap"><h1>bb.q settings</h1>';
	if ( isset( $_GET['updated'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
		echo '<div class="notice notice-success is-dismissible"><p>Settings saved.</p></div>';
	}
	echo '<p>Texts and links in the header, the mobile menu and the footer, the ordering platforms and the delivery map. Navigation links are edited under <a href="' . esc_url( admin_url( 'nav-menus.php' ) ) . '">Appearance → Menus</a>.</p>';
	echo '<form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '">';
	echo '<input type="hidden" name="action" value="bbq_save_settings">';
	wp_nonce_field( 'bbq_settings_save', 'bbq_settings_nonce' );
	bbq_render_schema( bbq_site_schema(), is_array( $values ) ? $values : array() );
	submit_button( 'Save settings' );
	echo '</form></div>';
}

add_action(
	'admin_post_bbq_save_settings',
	function () {
		if ( ! current_user_can( 'edit_theme_options' ) || ! isset( $_POST['bbq_settings_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['bbq_settings_nonce'] ), 'bbq_settings_save' ) ) {
			wp_die( 'Not allowed.' );
		}
		$input = isset( $_POST['bbq'] ) && is_array( $_POST['bbq'] ) ? wp_unslash( $_POST['bbq'] ) : array(); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput -- sanitized per field
		update_option( BBQ_OPTION, bbq_sanitize_schema( bbq_site_schema(), $input ), false );
		wp_safe_redirect( admin_url( 'themes.php?page=bbq-settings&updated=1' ) );
		exit;
	}
);
