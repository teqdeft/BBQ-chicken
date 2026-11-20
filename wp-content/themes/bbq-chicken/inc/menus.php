<?php
/**
 * Navigation: two WordPress menus (Appearance → Menus).
 *   Header menu  – top-level items; items with sub-items become dropdowns (and expandable items in the mobile menu).
 *   Footer menu  – top-level items are the column titles, their sub-items the links.
 * Without a menu assigned, the design's links are used (bbq_default_menus()).
 * A menu item's CSS class "data-xyz" becomes the attribute data-xyz (e.g. data-cookie-settings).
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'after_setup_theme',
	function () {
		register_nav_menus(
			array(
				'primary' => 'Header menu',
				'footer'  => 'Footer menu',
			)
		);
	}
);

/** The design's menus. URLs use "page:<template key>" (see bbq_url()). Also used by the importer. */
function bbq_default_menus() {
	$discover  = array(
		array( 'title' => 'Our story', 'url' => 'page:discover' ),
		array( 'title' => 'The menu', 'url' => 'page:menu' ),
		array( 'title' => 'ChiBBoQ and friends', 'url' => 'page:discover#chibboq' ),
		array( 'title' => 'News', 'url' => 'page:news' ),
	);
	$franchise = array(
		array( 'title' => 'Franchise opportunity', 'url' => 'page:franchise' ),
		array( 'title' => 'Markets', 'url' => 'page:home#markets' ),
		array( 'title' => 'FAQ', 'url' => 'page:franchise#faq' ),
		array( 'title' => 'Submit your application', 'url' => 'page:apply' ),
	);
	return array(
		'primary' => array(
			array( 'title' => 'Discover bb.q', 'url' => 'page:discover', 'children' => $discover ),
			array( 'title' => 'Franchise', 'url' => 'page:franchise', 'children' => $franchise ),
			array( 'title' => 'Markets', 'url' => 'page:home#markets' ),
			array( 'title' => 'Real estate', 'url' => 'page:real-estate' ),
			array( 'title' => 'Careers', 'url' => 'page:careers' ),
		),
		'footer'  => array(
			array( 'title' => 'Discover', 'url' => '#', 'children' => $discover ),
			array(
				'title'    => 'Franchise',
				'url'      => '#',
				'children' => array(
					array( 'title' => 'Franchise opportunity', 'url' => 'page:franchise' ),
					array( 'title' => 'Markets', 'url' => 'page:home#markets' ),
					array( 'title' => 'Real estate', 'url' => 'page:real-estate' ),
					array( 'title' => 'FAQ', 'url' => 'page:franchise#faq' ),
					array( 'title' => 'Submit your application', 'url' => 'page:apply' ),
				),
			),
			array(
				'title'    => 'Company',
				'url'      => '#',
				'children' => array(
					array( 'title' => 'About BLT Global Brands', 'url' => 'page:about' ),
					array( 'title' => 'Our team', 'url' => 'page:about#team' ),
					array( 'title' => 'Careers', 'url' => 'page:careers' ),
					array( 'title' => 'Contact', 'url' => 'page:contact' ),
				),
			),
			array(
				'title'    => 'Legal',
				'url'      => '#',
				'children' => array(
					array( 'title' => 'Privacy policy', 'url' => 'page:legal' ),
					array( 'title' => 'Cookie policy', 'url' => 'page:legal' ),
					array( 'title' => 'Cookie settings', 'url' => '#', 'classes' => array( 'data-cookie-settings' ) ),
					array( 'title' => 'Website terms', 'url' => 'page:legal' ),
					array( 'title' => 'Franchise disclaimer', 'url' => 'page:legal' ),
					array( 'title' => 'Accessibility', 'url' => 'page:legal' ),
				),
			),
		),
	);
}

/** Menu tree for a location: array of array( title, url, classes, target, children ). */
function bbq_menu_tree( $location ) {
	$locations = get_nav_menu_locations();
	if ( empty( $locations[ $location ] ) ) {
		$defaults = bbq_default_menus();
		return bbq_menu_resolve( isset( $defaults[ $location ] ) ? $defaults[ $location ] : array() );
	}
	$items = wp_get_nav_menu_items( $locations[ $location ] );
	if ( ! $items ) {
		return array();
	}
	$by_parent = array();
	foreach ( $items as $item ) {
		$by_parent[ (int) $item->menu_item_parent ][] = $item;
	}
	$build = function ( $parent ) use ( &$build, $by_parent ) {
		$out = array();
		foreach ( isset( $by_parent[ $parent ] ) ? $by_parent[ $parent ] : array() as $item ) {
			$out[] = array(
				'title'    => $item->title,
				'url'      => $item->url,
				'classes'  => array_filter( (array) $item->classes ),
				'target'   => $item->target,
				'children' => $build( (int) $item->ID ),
			);
		}
		return $out;
	};
	return $build( 0 );
}

function bbq_menu_resolve( $items ) {
	foreach ( $items as &$item ) {
		$item['url']      = bbq_url( $item['url'] );
		$item['classes']  = isset( $item['classes'] ) ? $item['classes'] : array();
		$item['target']   = isset( $item['target'] ) ? $item['target'] : '';
		$item['children'] = isset( $item['children'] ) ? bbq_menu_resolve( $item['children'] ) : array();
	}
	return $items;
}

/**
 * URL of the page being viewed, built from what WordPress is showing (not from the request path,
 * which would repeat the folder on sites installed in a subfolder such as /bbq-chicken/).
 */
function bbq_current_url() {
	static $url = null;
	if ( null === $url ) {
		if ( is_front_page() ) {
			$url = home_url( '/' );
		} elseif ( is_home() ) {
			$url = bbq_page_url( 'news' );
		} elseif ( is_singular() ) {
			$url = get_permalink( get_queried_object_id() );
		} else {
			global $wp;
			$url = home_url( trailingslashit( isset( $wp->request ) ? $wp->request : '' ) );
		}
		$url = untrailingslashit( strtok( (string) $url, '?' ) );
	}
	return $url;
}

/** Is this URL the page being viewed? (Links with a #section don't count, like in the design.) */
function bbq_menu_is_current( $url ) {
	if ( ! $url || false !== strpos( $url, '#' ) ) {
		return false;
	}
	$here = bbq_current_url();
	$url  = untrailingslashit( strtok( $url, '?' ) );
	if ( $url === $here ) {
		return true;
	}
	// News articles highlight the News link.
	return is_singular( 'post' ) && $url === untrailingslashit( bbq_page_url( 'news' ) );
}

function bbq_menu_item_current( $item ) {
	if ( bbq_menu_is_current( $item['url'] ) ) {
		return true;
	}
	foreach ( $item['children'] as $child ) {
		if ( bbq_menu_is_current( $child['url'] ) ) {
			return true;
		}
	}
	return false;
}

/** Extra attributes for a link: target, data-apply for the application page, data-* classes. */
function bbq_menu_attrs( $item ) {
	$out = '';
	if ( '_blank' === $item['target'] ) {
		$out .= ' target="_blank" rel="noopener"';
	}
	if ( untrailingslashit( strtok( $item['url'], '#' ) ) === untrailingslashit( bbq_page_url( 'apply' ) ) ) {
		$out .= ' data-apply';
	}
	foreach ( $item['classes'] as $class ) {
		if ( 0 === strpos( $class, 'data-' ) && 'data-apply' !== $class ) {
			$out .= ' ' . esc_attr( $class );
		}
	}
	return $out;
}

/** Header navigation (desktop). */
function bbq_nav_primary() {
	echo '<nav class="main-nav" aria-label="Main">';
	foreach ( bbq_menu_tree( 'primary' ) as $i => $item ) {
		$current = bbq_menu_item_current( $item ) ? ' aria-current="page"' : '';
		if ( $item['children'] ) {
			$id = 'dd-' . sanitize_title( $item['title'] );
			echo '<div class="main-nav__item" data-dropdown>';
			echo '<button class="main-nav__link" type="button" aria-expanded="false" aria-controls="' . esc_attr( $id ) . '"' . $current . '>' . esc_html( $item['title'] ) . ' ' . bbq_icon_svg( 'chevdown' ) . '</button>'; // phpcs:ignore WordPress.Security.EscapeOutput
			echo '<div class="dropdown" id="' . esc_attr( $id ) . '">';
			foreach ( $item['children'] as $child ) {
				echo '<a class="dropdown__link" href="' . esc_url( $child['url'] ) . '"' . bbq_menu_attrs( $child ) . '>' . esc_html( $child['title'] ) . '</a>'; // phpcs:ignore WordPress.Security.EscapeOutput
			}
			echo '</div></div>';
		} else {
			echo '<div class="main-nav__item"><a class="main-nav__link" href="' . esc_url( $item['url'] ) . '"' . bbq_menu_attrs( $item ) . $current . '>' . esc_html( $item['title'] ) . '</a></div>'; // phpcs:ignore WordPress.Security.EscapeOutput
		}
	}
	echo '</nav>';
}

/** Mobile menu navigation. */
function bbq_nav_mobile() {
	echo '<nav class="mobile-nav" aria-label="Mobile">';
	foreach ( bbq_menu_tree( 'primary' ) as $item ) {
		if ( $item['children'] ) {
			echo '<div class="mobile-nav__item" data-mnav>';
			echo '<button class="mobile-nav__link" type="button" aria-expanded="false">' . esc_html( $item['title'] ) . ' <span class="mobile-nav__mark" aria-hidden="true"></span></button>';
			echo '<div class="mobile-nav__sub">';
			foreach ( $item['children'] as $child ) {
				echo '<a href="' . esc_url( $child['url'] ) . '"' . bbq_menu_attrs( $child ) . '>' . esc_html( $child['title'] ) . '</a>'; // phpcs:ignore WordPress.Security.EscapeOutput
			}
			echo '</div></div>';
		} else {
			echo '<div class="mobile-nav__item"><a class="mobile-nav__link" href="' . esc_url( $item['url'] ) . '"' . bbq_menu_attrs( $item ) . '>' . esc_html( $item['title'] ) . ' <span class="mobile-nav__mark mobile-nav__mark--arrow" aria-hidden="true">→</span></a></div>'; // phpcs:ignore WordPress.Security.EscapeOutput
		}
	}
	echo '</nav>';
}

/** Footer link columns (accordions on mobile; the first one starts open). */
function bbq_nav_footer() {
	echo '<nav class="footer-links" aria-label="Footer">';
	foreach ( bbq_menu_tree( 'footer' ) as $i => $col ) {
		$open = 0 === $i;
		echo '<div class="footer-col' . ( $open ? ' is-open' : '' ) . '" data-accordion>';
		echo '<button class="footer-col__head" type="button" aria-expanded="' . ( $open ? 'true' : 'false' ) . '"><span class="footer-col__title">' . esc_html( $col['title'] ) . '</span><span class="footer-col__toggle" aria-hidden="true"></span></button>';
		echo '<div class="footer-col__list">';
		foreach ( $col['children'] as $link ) {
			echo '<a href="' . esc_url( $link['url'] ) . '"' . bbq_menu_attrs( $link ) . '>' . esc_html( $link['title'] ) . '</a>'; // phpcs:ignore WordPress.Security.EscapeOutput
		}
		echo '</div></div>';
	}
	echo '</nav>';
}
