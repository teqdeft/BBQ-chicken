<?php
if ( PHP_SAPI !== 'cli' ) { exit; } // command line only
// Tiny command runner for the local bb.q WordPress (no WP-CLI needed). Run with XAMPP's php.exe:
//   php wp-cli-lite.php <wp dir> activate      – activate the bbq-chicken theme and Contact Form 7
//   php wp-cli-lite.php <wp dir> setup [reset-forms] – run the theme's "bb.q setup"
//   php wp-cli-lite.php <wp dir> eval '<php code>'
$dir = rtrim( $argv[1], '/' );
$_SERVER['HTTP_HOST']   = 'localhost';
$_SERVER['REQUEST_URI'] = '/bbq-chicken/';
$_SERVER['SERVER_NAME'] = 'localhost';
define( 'WP_ADMIN', true );
require $dir . '/wp-load.php';
require_once ABSPATH . 'wp-admin/includes/admin.php';
wp_set_current_user( 1 );

$cmd = isset( $argv[2] ) ? $argv[2] : '';
if ( 'activate' === $cmd ) {
	$r = activate_plugin( 'contact-form-7/wp-contact-form-7.php' );
	echo is_wp_error( $r ) ? 'CF7: ' . $r->get_error_message() . "\n" : "CF7 active\n";
	switch_theme( 'bbq-chicken' );
	echo 'Theme: ' . get_stylesheet() . "\n";
} elseif ( 'setup' === $cmd ) {
	// CF7 loads its classes on plugins_loaded; make sure they are there.
	foreach ( bbq_run_setup( isset( $argv[3] ) && 'reset-forms' === $argv[3] ) as $line ) {
		echo $line . "\n";
	}
} elseif ( 'eval' === $cmd ) {
	eval( $argv[3] ); // phpcs:ignore Squiz.PHP.Eval -- local dev helper
}
