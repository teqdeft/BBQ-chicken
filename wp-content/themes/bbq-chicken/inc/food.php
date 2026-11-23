<?php
/**
 * Food cards (custom post type "food_card", menu "Food cards"): the cards of the home page's "The food"
 * slider (Combo meals, Real Crispy Tenders …), one post per card. The title is the card title; the ACF
 * "Food card" group (inc/acf-fields.php) holds the text, the tag on the photo, the colour, the photo and
 * "Desktop only"; "Order" (Page attributes) sets the order.
 *
 * Until there are food cards, the slider shows the design's cards (bbq_food_defaults()). The first time ACF
 * is ready, the home page's cards are created as food cards (bbq_food_setup()).
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'init',
	function () {
		register_post_type(
			'food_card',
			array(
				'labels'             => array(
					'name'               => 'Food cards',
					'singular_name'      => 'Food card',
					'menu_name'          => 'Food cards',
					'all_items'          => 'All food cards',
					'add_new'            => 'Add food card',
					'add_new_item'       => 'Add food card',
					'edit_item'          => 'Edit food card',
					'new_item'           => 'New food card',
					'view_item'          => 'View food card',
					'search_items'       => 'Search food cards',
					'not_found'          => 'No food cards found',
					'not_found_in_trash' => 'No food cards in the trash',
				),
				'public'             => false,
				'show_ui'            => true,
				'show_in_menu'       => true,
				'show_in_rest'       => false,
				'menu_position'      => 22,
				'menu_icon'          => 'dashicons-food',
				'supports'           => array( 'title', 'page-attributes' ),
				'hierarchical'       => false,
				'has_archive'        => false,
				'rewrite'            => false,
				'publicly_queryable' => false,
			)
		);
	}
);

/** Card colours (food-card--<value>). */
function bbq_food_styles() {
	return array( 'dark' => 'Dark', 'yellow' => 'Yellow', 'red' => 'Red', 'sand' => 'Sand' );
}

/** Fields of the "Food card" group (ACF): post meta food_<key>. */
function bbq_food_schema() {
	$f = function ( $key, $type, $label, $default = '', $args = array() ) {
		return array( 'key' => $key, 'name' => 'food_' . $key, 'type' => $type, 'label' => $label, 'default' => $default, 'args' => $args, 'section' => 'Food card' );
	};
	return array(
		'text'         => $f( 'text', 'textarea', 'Text' ),
		'tag'          => $f( 'tag', 'text', 'Tag on the photo', '', array( 'placeholder' => 'e.g. For sharing (empty = no tag)' ) ),
		'style'        => $f( 'style', 'select', 'Colour', 'dark', array( 'choices' => bbq_food_styles() ) ),
		'photo'        => $f( 'photo', 'image', 'Photo', '', array( 'help' => 'Landscape, at least 960 × 720 px, on a light background. The photo\'s alt text comes from the Media Library (empty = the card title).' ) ),
		'desktop_only' => $f( 'desktop_only', 'toggle', 'Desktop only (hidden on phones)', 0 ),
	);
}

/** The design's cards (shown until there are food cards; also used to create them). */
function bbq_food_defaults() {
	return array(
		array( 'style' => 'yellow', 'desktop_only' => 0, 'img' => 'food-combo-meal.jpg', 'alt' => 'A meal of two pieces of Korean fried chicken with fries and a drink', 'tag' => 'Meals', 'title' => 'Combo meals', 'text' => 'Pieces, tenders, a burger, wrap or bowl, with fries and a drink. Lunch, sorted.' ),
		array( 'style' => 'red', 'desktop_only' => 0, 'img' => 'food-3pcs-strips.jpg', 'alt' => 'Three crispy chicken tenders', 'tag' => 'On the go', 'title' => 'Real Crispy Tenders', 'text' => 'Crispy chicken strips in 3, 6 or 12 pieces, easy to share and easier to eat on the go.' ),
		array( 'style' => 'sand', 'desktop_only' => 0, 'img' => 'food-party-bucket.jpg', 'alt' => 'A bucket of crispy tenders next to a bucket of fries', 'tag' => 'For sharing', 'title' => 'Mega Party Bucket', 'text' => '24 crispy tenders or 16 pieces of Korean fried chicken, with a bucket of fries for the table.' ),
		array( 'style' => 'dark', 'desktop_only' => 0, 'img' => 'sauce-secret-sauce.jpg', 'alt' => 'A bowl of Secret Sauce', 'tag' => '9 sauces', 'title' => 'Signature sauces', 'text' => 'Nine sauces, from the sweet and mildly spicy Secret Sauce to the fiery Jasoman.' ),
	);
}

/**
 * The cards to show: the picked food cards in the picked order ($ids, from the section's "Food cards" field),
 * else all published food cards in their order, else the design's cards when there are none.
 */
function bbq_food_cards( $ids = array() ) {
	$all   = array(
		'post_type'   => 'food_card',
		'post_status' => 'publish',
		'numberposts' => -1,
		'orderby'     => array( 'menu_order' => 'ASC', 'title' => 'ASC' ),
	);
	$posts = $ids ? get_posts( array( 'post__in' => array_map( 'intval', (array) $ids ), 'orderby' => 'post__in' ) + $all ) : array();
	if ( ! $posts ) {
		$posts = get_posts( $all ); // nothing picked (or the picked cards are gone): all of them
	}
	if ( ! $posts ) {
		return bbq_food_defaults();
	}
	$cards = array();
	foreach ( $posts as $post ) {
		$title   = get_post_field( 'post_title', $post->ID, 'raw' );
		$photo   = (int) get_post_meta( $post->ID, 'food_photo', true );
		$alt     = $photo ? trim( (string) get_post_meta( $photo, '_wp_attachment_image_alt', true ) ) : '';
		$style   = (string) get_post_meta( $post->ID, 'food_style', true );
		$cards[] = array(
			'title'        => $title,
			'text'         => (string) get_post_meta( $post->ID, 'food_text', true ),
			'tag'          => (string) get_post_meta( $post->ID, 'food_tag', true ),
			'style'        => isset( bbq_food_styles()[ $style ] ) ? $style : 'dark',
			'desktop_only' => (int) get_post_meta( $post->ID, 'food_desktop_only', true ),
			'img'          => $photo ? $photo : '',
			'alt'          => '' !== $alt ? $alt : $title,
		);
	}
	return $cards;
}

/**
 * Create the food cards once, from the home page's "The food" section (its saved cards, else the design's).
 * Does nothing when food cards exist. Returns a log line.
 */
function bbq_food_setup() {
	// Only once the "Food card" fields exist (inc/acf-fields.php), and only when there are no food cards yet.
	if ( ! function_exists( 'acf_get_field' ) || ! acf_get_field( 'field_food_text' ) || get_posts( array( 'post_type' => 'food_card', 'post_status' => 'any', 'numberposts' => 1, 'fields' => 'ids' ) ) ) {
		return '';
	}
	$cards = bbq_food_defaults();
	$home  = (int) get_option( 'page_on_front' );
	if ( $home ) {
		$sub = array( 'title' => array( 'text' ), 'text' => array( 'textarea' ), 'tag' => array( 'text' ), 'style' => array( 'select' ), 'desktop_only' => array( 'toggle' ), 'img' => array( 'image' ), 'alt' => array( 'text' ) );
		foreach ( (array) bbq_stored_sections( $home ) as $i => $layout ) {
			if ( 'home_the_food' !== $layout ) {
				continue;
			}
			$found = false;
			$rows  = bbq_acf_value( $home, 'sections_' . $i . '_food_cards', 'rows', array( 'fields' => $sub ), $found );
			if ( $found && $rows ) {
				$cards = $rows;
			}
			break;
		}
		// Cards edited in the old "Page content" box (before ACF)
		$legacy = get_post_meta( $home, BBQ_META, true );
		if ( bbq_food_defaults() === $cards && is_array( $legacy ) && ! empty( $legacy['food_cards'] ) && is_array( $legacy['food_cards'] ) ) {
			$cards = $legacy['food_cards'];
		}
	}
	$made = 0;
	foreach ( array_values( $cards ) as $n => $card ) {
		$card = array_merge( array( 'title' => '', 'text' => '', 'tag' => '', 'style' => 'dark', 'desktop_only' => 0, 'img' => '', 'alt' => '' ), (array) $card );
		if ( '' === trim( (string) $card['title'] ) ) {
			continue;
		}
		$id = wp_insert_post(
			array(
				'post_type'   => 'food_card',
				'post_status' => 'publish',
				'post_title'  => $card['title'],
				'menu_order'  => $n,
			)
		);
		if ( ! $id || is_wp_error( $id ) ) {
			continue;
		}
		update_field( 'field_food_text', (string) $card['text'], $id );
		update_field( 'field_food_tag', (string) $card['tag'], $id );
		update_field( 'field_food_style', isset( bbq_food_styles()[ $card['style'] ] ) ? $card['style'] : 'dark', $id );
		update_field( 'field_food_desktop_only', (int) $card['desktop_only'], $id );
		$photo = bbq_acf_import_asset( $card['img'] );
		if ( $photo ) {
			update_field( 'field_food_photo', $photo, $id );
			if ( '' !== trim( (string) $card['alt'] ) && '' === (string) get_post_meta( $photo, '_wp_attachment_image_alt', true ) ) {
				update_post_meta( $photo, '_wp_attachment_image_alt', $card['alt'] );
			}
		}
		$made++;
	}
	update_option( 'bbq_food_setup', time(), false );
	return 'Food cards created: ' . $made . '.';
}

/* Once ACF is ready and the content has been moved, create the food cards (once). */
add_action(
	'admin_init',
	function () {
		if ( get_option( 'bbq_food_setup' ) || ! current_user_can( 'edit_posts' ) || ! bbq_acf_ready() || ! bbq_acf_migrated() ) {
			return;
		}
		bbq_food_setup();
	}
);

/* ---------- Admin list: photo, tag, colour, order; "Card title" as the title placeholder ---------- */

add_filter(
	'enter_title_here',
	function ( $text, $post ) {
		return 'food_card' === $post->post_type ? 'Card title' : $text;
	},
	10,
	2
);

add_filter(
	'manage_food_card_posts_columns',
	function ( $cols ) {
		$new = array();
		foreach ( $cols as $key => $label ) {
			if ( 'title' === $key ) {
				$new['bbq_photo'] = 'Photo';
				$new['title']     = 'Title';
				$new['bbq_tag']   = 'Tag';
				$new['bbq_style'] = 'Colour';
				$new['bbq_order'] = 'Order';
				continue;
			}
			$new[ $key ] = $label;
		}
		return $new;
	}
);

add_action(
	'manage_food_card_posts_custom_column',
	function ( $col, $post_id ) {
		if ( 'bbq_photo' === $col ) {
			$photo = (int) get_post_meta( $post_id, 'food_photo', true );
			echo $photo ? wp_get_attachment_image( $photo, array( 64, 48 ), false, array( 'style' => 'width:64px;height:48px;object-fit:cover;border-radius:4px' ) ) : '—'; // phpcs:ignore WordPress.Security.EscapeOutput
		} elseif ( 'bbq_tag' === $col ) {
			echo esc_html( (string) get_post_meta( $post_id, 'food_tag', true ) );
		} elseif ( 'bbq_style' === $col ) {
			$style = (string) get_post_meta( $post_id, 'food_style', true );
			echo esc_html( isset( bbq_food_styles()[ $style ] ) ? bbq_food_styles()[ $style ] : '' );
			if ( get_post_meta( $post_id, 'food_desktop_only', true ) ) {
				echo ' · desktop only';
			}
		} elseif ( 'bbq_order' === $col ) {
			echo (int) get_post_field( 'menu_order', $post_id );
		}
	},
	10,
	2
);

/* The admin list follows the order shown on the site. */
add_action(
	'pre_get_posts',
	function ( $query ) {
		if ( is_admin() && $query->is_main_query() && 'food_card' === $query->get( 'post_type' ) && ! $query->get( 'orderby' ) ) {
			$query->set( 'orderby', array( 'menu_order' => 'ASC', 'title' => 'ASC' ) );
		}
	}
);
