<?php
/**
 * Moving the content into ACF (one click under Appearance → bb.q setup, or the notice shown until it ran):
 *   - every page built from sections gets its "Sections" field filled with the template's default sections,
 *     each with the page's current texts (values saved in the old "Page content" box, else the design's);
 *   - "Website settings" gets the header/footer/ordering/map texts (old "bb.q settings") and the news
 *     article texts (formerly on the News page);
 *   - every post gets its "News card" fields;
 *   - the design's images (theme files) are added to the Media Library once, so the image fields show them.
 * Pages whose "Sections" field already has content are left alone. The old values stay in the database.
 */

defined( 'ABSPATH' ) || exit;

/** ACF is active and our field groups exist. */
function bbq_acf_ready() {
	return function_exists( 'update_field' ) && function_exists( 'acf_get_field' );
}

/** True once the content was moved into ACF. */
function bbq_acf_migrated() {
	return (bool) get_option( 'bbq_acf_migrated' );
}

/** A theme image (assets/img/<file> or assets/<path>) as a Media Library attachment, added once. SVGs are skipped (0). */
function bbq_acf_import_asset( $value ) {
	if ( is_numeric( $value ) ) {
		return (int) $value;
	}
	$value = (string) $value;
	if ( '' === $value || preg_match( '#^(https?:)?//#', $value ) || preg_match( '/\.svg$/i', $value ) ) {
		return 0;
	}
	$file = BBQ_DIR . '/assets/' . ( false === strpos( $value, '/' ) ? 'img/' . $value : ltrim( str_replace( '..', '', $value ), '/' ) );
	if ( ! is_file( $file ) ) {
		return 0;
	}
	$map = (array) get_option( 'bbq_asset_media', array() );
	if ( ! empty( $map[ $value ] ) && get_post( (int) $map[ $value ] ) ) {
		return (int) $map[ $value ];
	}
	require_once ABSPATH . 'wp-admin/includes/image.php';
	$upload = wp_upload_bits( basename( $file ), null, file_get_contents( $file ) ); // phpcs:ignore WordPress.WP.AlternativeFunctions
	if ( ! empty( $upload['error'] ) ) {
		return 0;
	}
	$type = wp_check_filetype( $upload['file'] );
	$id   = wp_insert_attachment(
		array(
			'post_mime_type' => $type['type'],
			'post_title'     => ucfirst( trim( preg_replace( '/[-_]+/', ' ', pathinfo( $file, PATHINFO_FILENAME ) ) ) ),
			'post_status'    => 'inherit',
		),
		$upload['file']
	);
	if ( ! $id || is_wp_error( $id ) ) {
		return 0;
	}
	wp_update_attachment_metadata( $id, wp_generate_attachment_metadata( $id, $upload['file'] ) );
	update_post_meta( $id, '_bbq_asset', $value );
	$map[ $value ] = $id;
	update_option( 'bbq_asset_media', $map, false );
	return $id;
}

/** One of our values in the shape ACF stores it, for update_field(). $key_prefix: the field key without the field name. */
function bbq_acf_convert( $type, $value, $args, $key_prefix, $name ) {
	switch ( $type ) {
		case 'image':
			$id = bbq_acf_import_asset( $value );
			return $id ? $id : '';
		case 'link':
			$value = array_merge( array( 'label' => '', 'url' => '', 'new_tab' => false ), (array) $value );
			if ( '' === trim( (string) $value['label'] ) && '' === trim( (string) $value['url'] ) ) {
				return '';
			}
			return array(
				'title'  => (string) $value['label'],
				'url'    => bbq_url( (string) $value['url'] ),
				'target' => ! empty( $value['new_tab'] ) ? '_blank' : '',
			);
		case 'toggle':
			return (int) $value;
		case 'rows':
			$rows = array();
			foreach ( (array) $value as $row ) {
				$out = array();
				foreach ( (array) $args['fields'] as $sub => $def ) {
					$sub_value = isset( $row[ $sub ] ) ? $row[ $sub ] : ( 'link' === $def[0] ? array() : '' );
					$out[ $key_prefix . $name . '__' . $sub ] = bbq_acf_convert( $def[0], $sub_value, array(), $key_prefix, $name . '__' . $sub );
				}
				$rows[] = $out;
			}
			return $rows;
		default:
			return (string) $value;
	}
}

/** Values of a schema in ACF shape (keyed by field key): the old saved value, else the design default. */
function bbq_acf_values( $schema, $legacy, $key_prefix, $name_prefix = '' ) {
	$out = array();
	foreach ( $schema as $f ) {
		$value = array_key_exists( $f['key'], $legacy ) ? $legacy[ $f['key'] ] : $f['default'];
		$out[ $key_prefix . $name_prefix . $f['key'] ] = bbq_acf_convert( $f['type'], $value, (array) $f['args'], $key_prefix, $name_prefix . $f['key'] );
	}
	return $out;
}

/** The section-built template of a page ('' if it has none). */
function bbq_acf_page_key( $post_id ) {
	if ( (int) get_option( 'page_on_front' ) === (int) $post_id ) {
		return 'home';
	}
	if ( (int) get_option( 'page_for_posts' ) === (int) $post_id ) {
		return 'news';
	}
	$template = (string) get_post_meta( $post_id, '_wp_page_template', true );
	$key      = preg_match( '#^page-templates/([a-z0-9-]+)\.php$#', $template, $m ) ? $m[1] : '';
	return in_array( $key, bbq_section_pages(), true ) ? $key : '';
}

/** Fill the "Sections" field of one page. */
function bbq_acf_migrate_page( $post_id, $force = false ) {
	$key = bbq_acf_page_key( $post_id );
	if ( '' === $key || ( ! $force && null !== bbq_stored_sections( $post_id ) ) ) {
		return '';
	}
	$legacy = get_post_meta( $post_id, BBQ_META, true );
	$legacy = is_array( $legacy ) ? $legacy : array();
	$rows   = array();
	foreach ( bbq_default_sections( $key ) as $layout ) {
		$rows[] = array( 'acf_fc_layout' => $layout ) + bbq_acf_values( bbq_layout_schema( $layout, $post_id ), $legacy, 'field_' . $layout . '_' );
	}
	update_field( 'field_bbq_page_sections', $rows, $post_id );
	foreach ( array( 'seo_title', 'seo_description' ) as $seo ) {
		if ( ! empty( $legacy[ $seo ] ) ) {
			update_field( 'field_bbq_page_' . $seo, $legacy[ $seo ], $post_id );
		}
	}
	return get_the_title( $post_id ) . ': ' . count( $rows ) . ' sections';
}

/** Run the whole move. Returns a log. */
function bbq_acf_migrate( $force = false ) {
	if ( ! bbq_acf_ready() ) {
		return array( 'ACF Pro is not active: nothing was moved.' );
	}
	if ( function_exists( 'set_time_limit' ) ) {
		set_time_limit( 600 ); // phpcs:ignore Squiz.PHP.DiscouragedFunctions -- image import
	}
	$log = array();
	// Pages
	$pages = get_posts( array( 'post_type' => 'page', 'post_status' => array( 'publish', 'private', 'draft' ), 'numberposts' => -1, 'fields' => 'ids' ) );
	foreach ( $pages as $id ) {
		$line = bbq_acf_migrate_page( $id, $force );
		if ( $line ) {
			$log[] = 'Page ' . $line;
		}
	}
	// Website settings (header, footer, ordering, map) and the news article texts
	if ( $force || ! get_option( 'bbq_acf_site_moved' ) ) {
		$site    = get_option( BBQ_OPTION, array() );
		$article = get_post_meta( (int) get_option( 'page_for_posts' ), BBQ_META, true );
		foreach ( bbq_acf_values( bbq_site_schema(), is_array( $site ) ? $site : array(), 'field_site_' ) as $field => $value ) {
			update_field( $field, $value, 'option' );
		}
		foreach ( bbq_acf_values( bbq_collect_schema( 'news-article', 0 ), is_array( $article ) ? $article : array(), 'field_site_' ) as $field => $value ) {
			update_field( $field, $value, 'option' );
		}
		update_option( 'bbq_acf_site_moved', 1, false );
		$log[] = 'Website settings filled in.';
	}
	// News cards
	$posts = get_posts( array( 'post_type' => 'post', 'post_status' => 'any', 'numberposts' => -1, 'fields' => 'ids' ) );
	$n     = 0;
	foreach ( $posts as $id ) {
		if ( ! $force && metadata_exists( 'post', $id, 'news_card_meta' ) ) {
			continue;
		}
		$legacy = get_post_meta( $id, BBQ_META, true );
		foreach ( bbq_news_schema() as $f ) {
			$value = is_array( $legacy ) && array_key_exists( $f['key'], $legacy ) ? $legacy[ $f['key'] ] : $f['default'];
			update_field( 'field_news_' . $f['key'], bbq_acf_convert( $f['type'], $value, (array) $f['args'], 'field_news_', $f['key'] ), $id );
		}
		$n++;
	}
	if ( $n ) {
		$log[] = 'News cards filled in: ' . $n . ' posts.';
	}
	$log = array_merge( $log, bbq_cards_setup_all() ); // Team, Food cards, Chicken cards, Sauces (inc/card-types.php)
	$log[] = 'Images in the Media Library: ' . count( (array) get_option( 'bbq_asset_media', array() ) ) . '.';
	update_option( 'bbq_acf_migrated', time(), false );
	return $log;
}

/* ---------- Admin: notice + button ---------- */

add_action(
	'admin_notices',
	function () {
		if ( ! bbq_acf_ready() || bbq_acf_migrated() || ! current_user_can( 'manage_options' ) ) {
			return;
		}
		echo '<div class="notice notice-warning"><p><strong>bb.q theme:</strong> the page content is not in ACF yet. Move it there once: each page gets its sections with today\'s texts, "Website settings" gets the header and footer, and the design\'s images are added to the Media Library.</p><form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '"><input type="hidden" name="action" value="bbq_acf_migrate">';
		wp_nonce_field( 'bbq_acf_migrate' );
		echo '<p><button class="button button-primary">Move the content into ACF</button></p></form></div>';
	}
);

add_action(
	'admin_post_bbq_acf_migrate',
	function () {
		if ( ! current_user_can( 'manage_options' ) || ! check_admin_referer( 'bbq_acf_migrate' ) ) {
			wp_die( 'Not allowed.' );
		}
		$log = bbq_acf_migrate();
		set_transient( 'bbq_setup_log', '<li>' . implode( '</li><li>', array_map( 'esc_html', $log ) ) . '</li>', 300 );
		wp_safe_redirect( admin_url( 'themes.php?page=bbq-setup&done=1' ) );
		exit;
	}
);
