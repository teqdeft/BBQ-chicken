<?php
/**
 * Appearance → bb.q setup: creates everything the theme needs on a fresh WordPress, in one click.
 *   - one page per template (Home, Franchise, Apply + Thank you, Discover, The menu, About,
 *     Real estate, Careers, Contact, Privacy policy, News) with the right template
 *   - Settings → Reading: Home as the front page, News as the posts page
 *   - the legal pages with their text (inc/import/legal.html, inc/import/legal/*.html), see bbq_setup_legal_pages()
 *   - the Header and Footer menus
 *   - the news posts with their photos (inc/import/news.php)
 *   - the Contact Form 7 forms (inc/forms/*.php)
 * Running it again only adds what is missing (pages, menus and posts are matched by template/slug).
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'admin_menu',
	function () {
		add_theme_page( 'bb.q setup', 'bb.q setup', 'manage_options', 'bbq-setup', 'bbq_setup_screen' );
	}
);

/** Remind admins to run the setup after activating the theme. */
add_action(
	'admin_notices',
	function () {
		if ( get_option( 'bbq_setup_done' ) || ! current_user_can( 'manage_options' ) ) {
			return;
		}
		$screen = get_current_screen();
		if ( $screen && 'appearance_page_bbq-setup' === $screen->id ) {
			return;
		}
		echo '<div class="notice notice-info"><p><strong>bb.q theme:</strong> create the pages, menus, news and forms in one step: <a class="button button-primary" href="' . esc_url( admin_url( 'themes.php?page=bbq-setup' ) ) . '">Run bb.q setup</a></p></div>';
	}
);

function bbq_setup_screen() {
	echo '<div class="wrap"><h1>bb.q setup</h1>';
	if ( isset( $_GET['done'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
		$log = get_transient( 'bbq_setup_log' );
		echo '<div class="notice notice-success"><p>Setup finished.</p>' . ( $log ? '<ul style="list-style:disc;margin-left:20px">' . wp_kses_post( $log ) . '</ul>' : '' ) . '</div>';
	}
	if ( ! class_exists( 'WPCF7_ContactForm' ) ) {
		echo '<div class="notice notice-warning"><p>Contact Form 7 is not active. Install and activate it first, or the forms will be skipped (you can run the setup again later).</p></div>';
	}
	echo '<p>Creates the pages (with their templates), sets the home and news pages, adds the legal pages (privacy policy, cookie policy, legal notice), builds the header and footer menus, adds the news posts with their photos and creates the Contact Form 7 forms. Anything that already exists is left alone.</p>';
	echo '<form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '">';
	echo '<input type="hidden" name="action" value="bbq_run_setup">';
	wp_nonce_field( 'bbq_run_setup' );
	echo '<p><label><input type="checkbox" name="overwrite_forms" value="1"> Also reset the forms to the theme\'s version (overwrites changes made under Contact → Contact Forms)</label></p>';
	submit_button( 'Run setup' );
	echo '</form></div>';
}

add_action(
	'admin_post_bbq_run_setup',
	function () {
		if ( ! current_user_can( 'manage_options' ) || ! check_admin_referer( 'bbq_run_setup' ) ) {
			wp_die( 'Not allowed.' );
		}
		$log = bbq_run_setup( ! empty( $_POST['overwrite_forms'] ) );
		set_transient( 'bbq_setup_log', '<li>' . implode( '</li><li>', array_map( 'esc_html', $log ) ) . '</li>', 300 );
		wp_safe_redirect( admin_url( 'themes.php?page=bbq-setup&done=1' ) );
		exit;
	}
);

/** Run every step. Returns a log of what was done. */
function bbq_run_setup( $overwrite_forms = false ) {
	$log = array();
	$log = array_merge( $log, bbq_setup_pages() );
	$log = array_merge( $log, bbq_setup_reading() );
	$log = array_merge( $log, bbq_setup_legal_pages() );
	$log = array_merge( $log, bbq_setup_menus() );
	$log = array_merge( $log, bbq_setup_news() );
	$ids = bbq_install_forms( $overwrite_forms );
	$log[] = $ids ? 'Forms ready: ' . implode( ', ', array_keys( $ids ) ) : 'Forms skipped (Contact Form 7 not active).';
	update_option( 'bbq_setup_done', 1 );
	flush_rewrite_rules();
	return $log;
}

/* ---------- Pages ---------- */

function bbq_setup_pages() {
	$log  = array();
	$list = bbq_templates();
	// Home and News are plain pages (front page / posts page); the rest use page templates.
	foreach ( array( 'home', 'news' ) as $key ) {
		$slug = 'home' === $key ? 'home' : 'news';
		if ( ! get_page_by_path( $slug ) ) {
			wp_insert_post( array( 'post_type' => 'page', 'post_status' => 'publish', 'post_title' => $list[ $key ]['title'], 'post_name' => $slug ) );
			$log[] = 'Page created: ' . $list[ $key ]['title'];
		}
	}
	foreach ( bbq_page_template_keys() as $key ) {
		if ( bbq_find_page( $key ) ) {
			continue;
		}
		$t      = $list[ $key ];
		$parent = 0;
		if ( ! empty( $t['parent'] ) ) {
			$p      = bbq_find_page( $t['parent'] );
			$parent = $p ? $p->ID : 0;
		}
		$content = '';
		$file    = BBQ_DIR . '/inc/import/' . $key . '.html';
		if ( file_exists( $file ) ) {
			$content = file_get_contents( $file ); // phpcs:ignore WordPress.WP.AlternativeFunctions
		}
		$id = wp_insert_post(
			array(
				'post_type'    => 'page',
				'post_status'  => 'publish',
				'post_title'   => $t['title'],
				'post_name'    => $t['slug'],
				'post_parent'  => $parent,
				'post_content' => $content,
				'meta_input'   => array( '_wp_page_template' => 'page-templates/' . $key . '.php' ),
			)
		);
		if ( 'legal' === $key && $id && ! is_wp_error( $id ) ) {
			update_option( 'wp_page_for_privacy_policy', $id );
		}
		$log[] = 'Page created: ' . $t['title'];
	}
	return $log;
}

/* ---------- Legal pages ---------- */

/** The legal pages besides the privacy policy (the "legal" template page): slug => title, text file. */
function bbq_legal_pages() {
	return array(
		'cookie-policy' => array( 'title' => 'Cookie policy', 'file' => 'legal/cookie-policy.html' ),
		'legal-notice'  => array( 'title' => 'Legal notice', 'file' => 'legal/legal-notice.html' ),
	);
}

/** A legal text file with its {{url:<slug>}} links filled in for this site. */
function bbq_legal_text( $file ) {
	$path = BBQ_DIR . '/inc/import/' . $file;
	$html = file_exists( $path ) ? file_get_contents( $path ) : ''; // phpcs:ignore WordPress.WP.AlternativeFunctions
	return preg_replace_callback(
		'/\{\{url:([a-z0-9-]+)\}\}/',
		function ( $m ) {
			return esc_url( bbq_url( 'privacy-policy' === $m[1] ? 'page:legal' : 'slug:' . $m[1] ) );
		},
		$html
	);
}

/**
 * Legal pages (texts from BLT's lawyers, PLL 13.11.2026):
 *   - the privacy policy gets its text if it still has the theme's placeholder text ("[Legal text");
 *   - the cookie policy and legal notice are created when missing (legal template);
 *   - footer menu items "Cookie policy" and "Website terms" that still link to the privacy policy
 *     are pointed at their own pages ("Website terms" becomes "Legal notice").
 * Pages or menu items that were edited by hand are left alone.
 */
function bbq_setup_legal_pages() {
	$log     = array();
	$privacy = bbq_find_page( 'legal' );
	if ( $privacy && false !== strpos( $privacy->post_content, '[Legal text' ) ) {
		wp_update_post( array( 'ID' => $privacy->ID, 'post_content' => wp_slash( bbq_legal_text( 'legal.html' ) ) ) );
		$log[] = 'Page text added: ' . $privacy->post_title;
	}
	// In this order the cookie policy exists before the legal notice, whose text links to it.
	$pages = array();
	foreach ( bbq_legal_pages() as $slug => $page ) {
		$existing = get_page_by_path( $slug );
		if ( $existing ) {
			$pages[ $slug ] = $existing->ID;
			continue;
		}
		$id = wp_insert_post(
			array(
				'post_type'    => 'page',
				'post_status'  => 'publish',
				'post_title'   => $page['title'],
				'post_name'    => $slug,
				'post_content' => wp_slash( bbq_legal_text( $page['file'] ) ),
				'meta_input'   => array( '_wp_page_template' => 'page-templates/legal.php' ),
			)
		);
		if ( $id && ! is_wp_error( $id ) ) {
			$pages[ $slug ] = $id;
			$log[]          = 'Page created: ' . $page['title'];
		}
	}
	// Footer menu: items still pointing at the privacy policy
	$locations = get_nav_menu_locations();
	if ( $privacy && ! empty( $locations['footer'] ) ) {
		$targets = array(
			'Cookie policy' => array( 'cookie-policy', 'Cookie policy' ),
			'Website terms' => array( 'legal-notice', 'Legal notice' ),
		);
		foreach ( (array) wp_get_nav_menu_items( $locations['footer'] ) as $item ) {
			if ( ! isset( $targets[ $item->title ] ) || 'post_type' !== $item->type || (int) $item->object_id !== (int) $privacy->ID ) {
				continue;
			}
			list( $slug, $title ) = $targets[ $item->title ];
			if ( empty( $pages[ $slug ] ) ) {
				continue;
			}
			update_post_meta( $item->ID, '_menu_item_object_id', (int) $pages[ $slug ] );
			wp_update_post( array( 'ID' => $item->ID, 'post_title' => $title ) );
			$log[] = 'Footer menu: "' . $title . '" links to its page';
		}
	}
	return $log;
}

function bbq_setup_reading() {
	$home = get_page_by_path( 'home' );
	$news = get_page_by_path( 'news' );
	if ( $home ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $home->ID );
	}
	if ( $news ) {
		update_option( 'page_for_posts', $news->ID );
	}
	update_option( 'posts_per_page', 12 );
	return array( 'Reading settings: Home is the front page, News the posts page.' );
}

/* ---------- Menus ---------- */

function bbq_setup_menus() {
	$log       = array();
	$locations = get_theme_mod( 'nav_menu_locations', array() );
	$names     = array( 'primary' => 'Header menu', 'footer' => 'Footer menu' );
	foreach ( bbq_default_menus() as $location => $items ) {
		if ( ! empty( $locations[ $location ] ) && wp_get_nav_menu_object( $locations[ $location ] ) ) {
			continue;
		}
		$menu = wp_get_nav_menu_object( $names[ $location ] );
		$id   = $menu ? $menu->term_id : wp_create_nav_menu( $names[ $location ] );
		if ( is_wp_error( $id ) ) {
			continue;
		}
		if ( ! $menu ) {
			bbq_setup_menu_items( $id, $items, 0 );
		}
		$locations[ $location ] = $id;
		$log[]                  = 'Menu ready: ' . $names[ $location ];
	}
	set_theme_mod( 'nav_menu_locations', $locations );
	return $log;
}

function bbq_setup_menu_items( $menu_id, $items, $parent ) {
	foreach ( $items as $item ) {
		$url  = $item['url'];
		$args = array(
			'menu-item-title'     => $item['title'],
			'menu-item-status'    => 'publish',
			'menu-item-parent-id' => $parent,
			'menu-item-classes'   => isset( $item['classes'] ) ? implode( ' ', $item['classes'] ) : '',
		);
		// Links to a whole page become page items (they follow slug changes); #section links stay custom links.
		$page = null;
		if ( 0 === strpos( $url, 'page:' ) && false === strpos( $url, '#' ) ) {
			$key  = substr( $url, 5 );
			$page = 'home' === $key ? get_post( (int) get_option( 'page_on_front' ) ) : ( 'news' === $key ? get_post( (int) get_option( 'page_for_posts' ) ) : bbq_find_page( $key ) );
		} elseif ( 0 === strpos( $url, 'slug:' ) && false === strpos( $url, '#' ) ) {
			$page = get_page_by_path( substr( $url, 5 ) );
		}
		if ( $page ) {
			$args['menu-item-type']      = 'post_type';
			$args['menu-item-object']    = 'page';
			$args['menu-item-object-id'] = $page->ID;
		} else {
			$args['menu-item-type'] = 'custom';
			$args['menu-item-url']  = bbq_url( $url );
		}
		$id = wp_update_nav_menu_item( $menu_id, 0, $args );
		if ( ! empty( $item['children'] ) && ! is_wp_error( $id ) ) {
			bbq_setup_menu_items( $menu_id, $item['children'], $id );
		}
	}
}

/* ---------- News posts ---------- */

/**
 * inc/import/news.php returns a list of posts:
 *   array( 'slug', 'title', 'date' (Y-m-d), 'excerpt', 'content' (HTML), 'image' (file in assets/img),
 *          'sticky' => bool, 'fields' => array( card_meta, external_url, no_link, placeholder, date_line, label, sources, full_article ) )
 *   (see bbq_news_schema() in inc/news.php)
 */
function bbq_setup_news() {
	$file = BBQ_DIR . '/inc/import/news.php';
	if ( ! file_exists( $file ) ) {
		return array();
	}
	$log   = array();
	$posts = include $file;
	foreach ( (array) $posts as $p ) {
		if ( get_page_by_path( $p['slug'], OBJECT, 'post' ) ) {
			continue;
		}
		$id = wp_insert_post(
			array(
				'post_type'    => 'post',
				'post_status'  => 'publish',
				'post_title'   => $p['title'],
				'post_name'    => $p['slug'],
				'post_date'    => $p['date'] . ' 09:00:00',
				'post_excerpt' => isset( $p['excerpt'] ) ? $p['excerpt'] : '',
				'post_content' => isset( $p['content'] ) ? $p['content'] : '',
			)
		);
		if ( is_wp_error( $id ) ) {
			continue;
		}
		if ( ! empty( $p['image'] ) ) {
			$att = bbq_setup_media( $p['image'], $id, $p['title'] );
			if ( $att ) {
				set_post_thumbnail( $id, $att );
				// Images added to the media library before the post existed are attached to it now.
				if ( ! wp_get_post_parent_id( $att ) ) {
					wp_update_post( array( 'ID' => $att, 'post_parent' => $id ) );
				}
			}
		}
		if ( ! empty( $p['fields'] ) ) {
			update_post_meta( $id, BBQ_META, $p['fields'] );
		}
		if ( ! empty( $p['sticky'] ) ) {
			stick_post( $id );
		}
		$log[] = 'News post created: ' . $p['title'];
	}
	return $log;
}

/** Copy a theme image into the media library (once) and return its attachment id. */
function bbq_setup_media( $file, $parent = 0, $alt = '' ) {
	$existing = get_posts(
		array(
			'post_type'   => 'attachment',
			'meta_key'    => '_bbq_source',
			'meta_value'  => $file,
			'numberposts' => 1,
			'fields'      => 'ids',
		)
	);
	if ( $existing ) {
		return (int) $existing[0];
	}
	$src = BBQ_DIR . '/assets/' . ( false === strpos( $file, '/' ) ? 'img/' . $file : $file );
	if ( ! file_exists( $src ) ) {
		return 0;
	}
	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';
	$tmp = wp_tempnam( basename( $src ) );
	copy( $src, $tmp );
	$id = media_handle_sideload( array( 'name' => basename( $src ), 'tmp_name' => $tmp ), $parent );
	if ( is_wp_error( $id ) ) {
		wp_delete_file( $tmp );
		return 0;
	}
	update_post_meta( $id, '_bbq_source', $file );
	if ( $alt ) {
		update_post_meta( $id, '_wp_attachment_image_alt', $alt );
	}
	return (int) $id;
}
