<?php
/**
 * Card post types: lists of cards that each fill one section, one post per card (like the Sokkies custom
 * post types). The post title is the card's title; the ACF group named after the type holds the other fields
 * (inc/acf-fields.php, generated from bbq_card_types()); "Order" (Page attributes) sets the order.
 *
 *   team_member   menu "Team"            About · Leadership team   (picker: Team members)
 *   food_card     menu "Food cards"      Home · The food           (picker: Food cards)
 *   chicken_card  menu "Chicken cards"   Menu · The chicken        (picker: Chicken cards)
 *   menu_sauce    menu "Sauces"          Menu · Sauces             (picker: Sauces)
 *
 * Each section has a picker (ACF relationship, bbq_posts()): the picked cards in the picked order, empty =
 * all published cards in their Order. Until a type has posts, its section shows the design's cards
 * ('defaults'). The first time ACF is ready, the section's current cards are created as posts
 * (bbq_cards_setup(): from the content move, bb.q setup, or the first admin visit after the move).
 */

defined( 'ABSPATH' ) || exit;

/** Colours of the home page's food cards (food-card--<value>). */
function bbq_food_styles() {
	return array( 'dark' => 'Dark', 'yellow' => 'Yellow', 'red' => 'Red', 'sand' => 'Sand' );
}

/**
 * The card post types. Per type:
 *   prefix     ACF field keys field_<prefix>_<field>, post meta <prefix>_<field>
 *   fields     field => array( type, label, default, args )  (types: text, textarea, select, toggle, image)
 *   title_row  the row key that holds the post title; row_map: other row keys => field
 *   alt        alt text when the card has none of its own (alt field) and the photo has none in the Media Library ('%s' = the title)
 *   section    where the cards come from when the posts are first created (page, layout, rows field)
 */
function bbq_card_types() {
	static $types = null;
	if ( null !== $types ) {
		return $types;
	}
	$types = array(
		'team_member'  => array(
			'singular'     => 'Team member',
			'plural'       => 'Team members',
			'menu'         => 'Team',
			'icon'         => 'dashicons-groups',
			'position'     => 26,
			'placeholder'  => 'Full name',
			'prefix'       => 'team',
			'fields'       => array(
				'role'  => array( 'text', 'Role', '', array( 'placeholder' => 'e.g. Marketing' ) ),
				'photo' => array( 'image', 'Portrait photo', '', array( 'help' => 'Portrait, 720 × 900 px (4:5). The photo\'s alt text comes from the Media Library (empty = "Portrait of" + the name).' ) ),
			),
			'title_row'    => 'name',
			'row_map'      => array( 'role' => 'role', 'img' => 'photo' ),
			'alt'          => 'Portrait of %s',
			'columns'      => array( 'photo', 'role' ),
			'section'      => array( 'page' => 'about', 'layout' => 'about_leadership_team', 'rows' => 'leaders' ),
			'setup_option' => 'bbq_team_setup',
			'defaults'     => array(
					array( 'img' => 'team-thomas-talarico.jpg', 'name' => 'Thomas C. Talarico', 'role' => 'CEO and Partner', 'alt' => 'Portrait of Thomas C. Talarico' ),
					array( 'img' => 'team-maria-de-los-reyes-barrenengoa.jpg', 'name' => 'María de los Reyes Barrenengoa', 'role' => 'Marketing', 'alt' => 'Portrait of María de los Reyes Barrenengoa' ),
					array( 'img' => 'team-daniela-haack.jpg', 'name' => 'Daniela Haack', 'role' => 'Marketing', 'alt' => 'Portrait of Daniela Haack' ),
					array( 'img' => 'team-patricia-rader.jpg', 'name' => 'Patricia Rader', 'role' => 'Human Resources', 'alt' => 'Portrait of Patricia Rader' ),
					array( 'img' => 'team-julian-de-miguel.jpg', 'name' => 'Julián de Miguel', 'role' => 'IT', 'alt' => 'Portrait of Julián de Miguel' ),
					array( 'img' => 'team-julieta-cruz.jpg', 'name' => 'Julieta Cruz', 'role' => 'Staff Accountant', 'alt' => 'Portrait of Julieta Cruz' ),
					array( 'img' => 'team-emma-heckel.jpg', 'name' => 'Emma Heckel', 'role' => 'Procurement', 'alt' => 'Portrait of Emma Heckel' ),
			),
		),
		'food_card'    => array(
			'singular'     => 'Food card',
			'plural'       => 'Food cards',
			'menu'         => 'Food cards',
			'icon'         => 'dashicons-food',
			'position'     => 21,
			'placeholder'  => 'Card title',
			'prefix'       => 'food',
			'fields'       => array(
				'text'         => array( 'textarea', 'Text', '' ),
				'tag'          => array( 'text', 'Tag on the photo', '', array( 'placeholder' => 'e.g. For sharing (empty = no tag)' ) ),
				'style'        => array( 'select', 'Colour', 'dark', array( 'choices' => bbq_food_styles() ) ),
				'photo'        => array( 'image', 'Photo', '', array( 'help' => 'Landscape, at least 960 × 720 px, on a light background. The photo\'s alt text comes from the Media Library (empty = the card title).' ) ),
				'desktop_only' => array( 'toggle', 'Desktop only (hidden on phones)', 0 ),
			),
			'title_row'    => 'title',
			'row_map'      => array( 'text' => 'text', 'tag' => 'tag', 'style' => 'style', 'desktop_only' => 'desktop_only', 'img' => 'photo' ),
			'alt'          => '%s',
			'columns'      => array( 'photo', 'tag', 'style', 'desktop_only' ),
			'section'      => array( 'page' => 'home', 'layout' => 'home_the_food', 'rows' => 'food_cards' ),
			'setup_option' => 'bbq_food_setup',
			'defaults'     => array(
					array( 'style' => 'yellow', 'desktop_only' => 0, 'img' => 'food-combo-meal.jpg', 'alt' => 'A meal of two pieces of Korean fried chicken with fries and a drink', 'tag' => 'Meals', 'title' => 'Combo meals', 'text' => 'Pieces, tenders, a burger, wrap or bowl, with fries and a drink. Lunch, sorted.' ),
					array( 'style' => 'red', 'desktop_only' => 0, 'img' => 'food-3pcs-strips.jpg', 'alt' => 'Three crispy chicken tenders', 'tag' => 'On the go', 'title' => 'Real Crispy Tenders', 'text' => 'Crispy chicken strips in 3, 6 or 12 pieces, easy to share and easier to eat on the go.' ),
					array( 'style' => 'sand', 'desktop_only' => 0, 'img' => 'food-party-bucket.jpg', 'alt' => 'A bucket of crispy tenders next to a bucket of fries', 'tag' => 'For sharing', 'title' => 'Mega Party Bucket', 'text' => '24 crispy tenders or 16 pieces of Korean fried chicken, with a bucket of fries for the table.' ),
					array( 'style' => 'dark', 'desktop_only' => 0, 'img' => 'sauce-secret-sauce.jpg', 'alt' => 'A bowl of Secret Sauce', 'tag' => '9 sauces', 'title' => 'Signature sauces', 'text' => 'Nine sauces, from the sweet and mildly spicy Secret Sauce to the fiery Jasoman.' ),
			),
		),
		'meal_card'    => array(
			'singular'     => 'Meal',
			'plural'       => 'Meals',
			'menu'         => 'Meals',
			'icon'         => 'dashicons-store',
			'position'     => 22,
			'placeholder'  => 'Meal name',
			'prefix'       => 'meal',
			'fields'       => array(
				'text'  => array( 'textarea', 'Text', '' ),
				'style' => array( 'select', 'Colour', 'dark', array( 'choices' => array( 'dark' => 'Dark', 'red' => 'Red', 'wine' => 'Wine red' ) ) ),
				'photo' => array( 'image', 'Photo', '', array( 'help' => 'A photo of the meal on a light background, at least 604 × 480 px (5:4). The alt text comes from the Media Library (empty = the meal name).' ) ),
			),
			'title_row'    => 'title',
			'row_map'      => array( 'text' => 'text', 'style' => 'style', 'img' => 'photo' ),
			'alt'          => '%s',
			'columns'      => array( 'photo', 'style' ),
			'section'      => array( 'page' => 'menu', 'layout' => 'menu_meals', 'rows' => 'meals' ),
			'setup_option' => 'bbq_meal_setup',
			'defaults'     => array(
					array( 'style' => 'dark', 'img' => 'food-3pcs-strips.jpg', 'title' => "Felix's Choice", 'text' => '3 or 6 Real Crispy Tenders with fries, a drink and a photo of Felix.', 'alt' => 'Three crispy chicken tenders' ),
					array( 'style' => 'red', 'img' => 'food-combo-meal.jpg', 'title' => 'Best Sellers', 'text' => '3 tenders, 2 pieces of chicken, a burger, a wrap or a bowl, with fries and a drink.', 'alt' => 'A meal of two pieces of Korean fried chicken with fries and a drink' ),
					array( 'style' => 'wine', 'img' => 'meal-box-for-2.jpg', 'title' => 'Meal Box for 2', 'text' => '6 tenders with 2 sauces, or 4 pieces of chicken, with fries and a drink.', 'alt' => 'Crispy tenders with fries, two drinks, two dips and sweet rice bites' ),
					array( 'style' => 'wine', 'img' => 'food-party-bucket.jpg', 'title' => 'Family Meal Box', 'text' => '12 tenders with 4 sauces, or 8 pieces of chicken, with fries and a drink.', 'alt' => 'A bucket of crispy tenders next to a bucket of fries' ),
			),
		),
		'chicken_card' => array(
			'singular'     => 'Chicken card',
			'plural'       => 'Chicken cards',
			'menu'         => 'Chicken cards',
			'icon'         => 'dashicons-carrot',
			'position'     => 23,
			'placeholder'  => 'Card title',
			'prefix'       => 'chicken',
			'fields'       => array(
				'text'  => array( 'textarea', 'Text', '' ),
				'style' => array( 'select', 'Colour', 'dark', array( 'choices' => array( 'dark' => 'Dark', 'red' => 'Red', 'wine' => 'Wine red' ) ) ),
				'image' => array( 'image', 'Cut-out image', '', array( 'help' => 'A cut-out on a transparent background (PNG), about 880 × 580 px.' ) ),
				'alt'   => array( 'text', 'Image alt text', '', array( 'help' => 'What the image shows, read out by screen readers. Empty = the alt text of the image in the Media Library, else the card title. (The cut-outs are also used as decoration elsewhere on the site, so their alt text is set here.)' ) ),
			),
			'title_row'    => 'title',
			'row_map'      => array( 'text' => 'text', 'style' => 'style', 'img' => 'image', 'alt' => 'alt' ),
			'alt'          => '%s',
			'columns'      => array( 'image', 'style' ),
			'section'      => array( 'page' => 'menu', 'layout' => 'menu_the_chicken', 'rows' => 'chicken' ),
			'setup_option' => 'bbq_chicken_setup',
			'defaults'     => array(
					array( 'style' => 'dark', 'img' => 'cut-2pcs-fried.png', 'title' => 'Real Korean Fried Chicken', 'text' => 'Crispy, juicy pieces made to the original recipe. 2, 4 or 8 pieces.', 'alt' => 'Two pieces of golden fried chicken' ),
					array( 'style' => 'red', 'img' => 'cut-tenders-3pcs.png', 'title' => 'Real Crispy Tenders', 'text' => 'Original crispy chicken strips. 3, 6 or 12 pieces, with 1, 2 or 4 sauces.', 'alt' => 'Three crispy chicken tenders' ),
					array( 'style' => 'wine', 'img' => 'cut-burger.png', 'title' => 'Crispy Chicken Burger', 'text' => 'Crispy golden chicken with fresh vegetables and sauce in a soft bun.', 'alt' => 'A crispy chicken burger' ),
					array( 'style' => 'wine', 'img' => 'cut-wrap.png', 'title' => 'Crispy Chicken Wrap', 'text' => 'Crispy, juicy chicken strips in a wrap with fresh vegetables.', 'alt' => 'A crispy chicken wrap' ),
					array( 'style' => 'dark', 'img' => 'cut-bowl.png', 'title' => 'Rice and salad bowls', 'text' => 'Crispy chicken strips with fresh vegetables and our special sauce, on rice or salad.', 'alt' => 'A chicken rice bowl' ),
					array( 'style' => 'red', 'img' => 'cut-8pcs-fried-bucket.png', 'title' => 'Mega Party Bucket', 'text' => '24 tenders, 16 pieces, or 12 tenders with 8 pieces, each with 1.25 kg of fries.', 'alt' => 'A bucket of fried chicken' ),
			),
		),
		'menu_sauce'   => array(
			'singular'     => 'Sauce',
			'plural'       => 'Sauces',
			'menu'         => 'Sauces',
			'icon'         => 'dashicons-admin-site-alt3',
			'position'     => 24,
			'placeholder'  => 'Sauce name',
			'prefix'       => 'sauce',
			'fields'       => array(
				'text'  => array( 'textarea', 'Description', '' ),
				'spice' => array( 'select', 'Spice level (chilli icons)', 'tbc', array( 'choices' => bbq_menu_spice_levels() ) ),
				'note'  => array( 'text', 'Note after the chillies (optional)', '' ),
				'photo' => array( 'image', 'Photo', '', array( 'help' => 'A bowl of the sauce on black, 900 × 422 px. The alt text comes from the Media Library (empty = "A bowl of" + the name).' ) ),
			),
			'title_row'    => 'title',
			'row_map'      => array( 'text' => 'text', 'spice' => 'spice', 'note' => 'note', 'img' => 'photo' ),
			'alt'          => 'A bowl of %s',
			'columns'      => array( 'photo', 'spice' ),
			'section'      => array( 'page' => 'menu', 'layout' => 'menu_sauces', 'rows' => 'sauces' ),
			'setup_option' => 'bbq_sauce_setup',
			'defaults'     => array(
					array( 'img' => 'sauce-secret-sauce.jpg', 'title' => 'Secret Sauce', 'text' => 'Signature sweet and mildly spicy sauce.', 'spice' => '1', 'note' => '', 'alt' => 'A bowl of Secret Sauce' ),
					array( 'img' => 'sauce-garlic-mayo.jpg', 'title' => 'Garlic Mayo Sauce', 'text' => 'Smooth and creamy mayonnaise with a bold garlic kick.', 'spice' => 'tbc', 'note' => '', 'alt' => 'A bowl of Garlic Mayo Sauce' ),
					array( 'img' => 'sauce-galbi.jpg', 'title' => 'Galbi Sauce', 'text' => 'Sweet, tangy, and smoky Korean BBQ sauce.', 'spice' => '0', 'note' => '', 'alt' => 'A bowl of Galbi Sauce' ),
					array( 'img' => 'sauce-galbi-mayo.jpg', 'title' => 'Galbi Mayo Sauce', 'text' => 'Creamy mayonnaise infused with sweet and savoury Galbi BBQ flavour.', 'spice' => '0', 'note' => '', 'alt' => 'A bowl of Galbi Mayo Sauce' ),
					array( 'img' => 'sauce-gangjeong.jpg', 'title' => 'Gangjeong Sauce', 'text' => 'Sweet, crunchy, and mildly spicy sauce.', 'spice' => '1', 'note' => '', 'alt' => 'A bowl of Gangjeong Sauce' ),
					array( 'img' => 'sauce-jasoman.jpg', 'title' => 'Jasoman Sauce', 'text' => 'Bold and fiery hot sauce with garlic and black pepper.', 'spice' => '2', 'note' => '', 'alt' => 'A bowl of Jasoman Sauce' ),
					array( 'img' => 'sauce-jamaica-mayo.jpg', 'title' => 'Jamaica Mayo Sauce', 'text' => 'Creamy mayonnaise with a smoky and spicy kick.', 'spice' => 'tbc', 'note' => '', 'alt' => 'A bowl of Jamaica Mayo Sauce' ),
					array( 'img' => 'sauce-red-chak-chak-mayo.jpg', 'title' => 'Red Chak Chak Sauce', 'text' => 'Our Korean take on the classic brava sauce, creamier and extra spicy.', 'spice' => 'tbc', 'note' => '', 'alt' => 'A bowl of Red Chak Chak Sauce' ),
					array( 'img' => 'sauce-cheesling.jpg', 'title' => 'Cheesling Sauce', 'text' => 'Irresistible cheddar cheese seasoning with a sweet and savoury twist.', 'spice' => '0', 'note' => '', 'alt' => 'A bowl of Cheesling seasoning' ),
			),
		),
	);
	return $types;
}

/** A type's fields as schema entries (for tools/acf-generate.php). */
function bbq_card_schema( $type ) {
	$t   = bbq_card_types()[ $type ];
	$out = array();
	foreach ( $t['fields'] as $key => $f ) {
		$out[] = array(
			'key'     => $key,
			'name'    => $t['prefix'] . '_' . $key,
			'type'    => $f[0],
			'label'   => $f[1],
			'default' => $f[2],
			'args'    => isset( $f[3] ) ? $f[3] : array(),
			'section' => $t['singular'],
		);
	}
	return $out;
}

/** A field value of a card post, in its row shape. */
function bbq_card_value( $type, $post_id, $field ) {
	$t   = bbq_card_types()[ $type ];
	$def = $t['fields'][ $field ];
	$raw = get_post_meta( $post_id, $t['prefix'] . '_' . $field, true );
	switch ( $def[0] ) {
		case 'image':
			return (int) $raw ? (int) $raw : '';
		case 'toggle':
			return (int) $raw;
		case 'select':
			return isset( $def[3]['choices'][ (string) $raw ] ) ? (string) $raw : (string) $def[2];
		default:
			return (string) $raw;
	}
}

/**
 * The cards to show, as rows (the keys the section's markup uses): the picked posts in the picked order
 * ($ids), else all published posts in their Order, else the design's cards when the type has no posts.
 */
function bbq_cards( $type, $ids = array() ) {
	$t     = bbq_card_types()[ $type ];
	$all   = array(
		'post_type'   => $type,
		'post_status' => 'publish',
		'numberposts' => -1,
		'orderby'     => array( 'menu_order' => 'ASC', 'title' => 'ASC' ),
	);
	$posts = $ids ? get_posts( array( 'post__in' => array_map( 'intval', (array) $ids ), 'orderby' => 'post__in' ) + $all ) : array();
	if ( ! $posts ) {
		$posts = get_posts( $all ); // nothing picked (or the picked cards are gone): all of them
	}
	if ( ! $posts ) {
		return $t['defaults'];
	}
	$rows = array();
	foreach ( $posts as $post ) {
		$title = get_post_field( 'post_title', $post->ID, 'raw' );
		$row   = array( $t['title_row'] => $title );
		foreach ( $t['row_map'] as $row_key => $field ) {
			$row[ $row_key ] = bbq_card_value( $type, $post->ID, $field );
		}
		// Alt text: the card's own (types with an alt field), else the image's in the Media Library, else from the title.
		$alt = isset( $row['alt'] ) ? trim( (string) $row['alt'] ) : '';
		if ( '' === $alt && ! empty( $row['img'] ) ) {
			$alt = trim( (string) get_post_meta( (int) $row['img'], '_wp_attachment_image_alt', true ) );
		}
		$row['alt'] = '' !== $alt ? $alt : sprintf( $t['alt'], $title );
		$rows[]     = $row;
	}
	return $rows;
}

/** The page a section of a type lives on. */
function bbq_card_section_page( $type ) {
	$page = bbq_card_types()[ $type ]['section']['page'];
	if ( 'home' === $page ) {
		return (int) get_option( 'page_on_front' );
	}
	$found = bbq_find_page( $page );
	return $found ? (int) $found->ID : 0;
}

/**
 * Create a type's posts once, from its section's current cards (saved in ACF, else in the old "Page content"
 * box, else the design's). Only when the type's ACF fields exist and it has no posts yet. Returns a log line.
 */
function bbq_cards_setup( $type ) {
	$t     = bbq_card_types()[ $type ];
	$first = key( $t['fields'] );
	if ( ! function_exists( 'acf_get_field' ) || ! acf_get_field( 'field_' . $t['prefix'] . '_' . $first ) || get_posts( array( 'post_type' => $type, 'post_status' => 'any', 'numberposts' => 1, 'fields' => 'ids' ) ) ) {
		return '';
	}
	$rows    = $t['defaults'];
	$page_id = bbq_card_section_page( $type );
	if ( $page_id ) {
		$sub = array( $t['title_row'] => array( 'text' ), 'alt' => array( 'text' ) );
		foreach ( $t['row_map'] as $row_key => $field ) {
			$sub[ $row_key ] = array( $t['fields'][ $field ][0] );
		}
		foreach ( (array) bbq_stored_sections( $page_id ) as $i => $layout ) {
			if ( $t['section']['layout'] !== $layout ) {
				continue;
			}
			$found = false;
			$saved = bbq_acf_value( $page_id, 'sections_' . $i . '_' . $t['section']['rows'], 'rows', array( 'fields' => $sub ), $found );
			if ( $found && $saved ) {
				$rows = $saved;
			}
			break;
		}
		$legacy = get_post_meta( $page_id, BBQ_META, true );
		if ( $t['defaults'] === $rows && is_array( $legacy ) && ! empty( $legacy[ $t['section']['rows'] ] ) && is_array( $legacy[ $t['section']['rows'] ] ) ) {
			$rows = $legacy[ $t['section']['rows'] ];
		}
	}
	$made = 0;
	foreach ( array_values( $rows ) as $n => $row ) {
		$row   = (array) $row;
		$title = isset( $row[ $t['title_row'] ] ) ? trim( (string) $row[ $t['title_row'] ] ) : '';
		if ( '' === $title ) {
			continue;
		}
		$id = wp_insert_post( array( 'post_type' => $type, 'post_status' => 'publish', 'post_title' => $title, 'menu_order' => $n ) );
		if ( ! $id || is_wp_error( $id ) ) {
			continue;
		}
		foreach ( $t['row_map'] as $row_key => $field ) {
			$def   = $t['fields'][ $field ];
			$value = isset( $row[ $row_key ] ) ? $row[ $row_key ] : $def[2];
			if ( 'image' === $def[0] ) {
				$value = bbq_acf_import_asset( $value );
				if ( ! $value ) {
					continue;
				}
				// The design's alt text goes to the Media Library, unless the type keeps its own (alt field).
				if ( ! isset( $t['fields']['alt'] ) && ! empty( $row['alt'] ) && '' === (string) get_post_meta( $value, '_wp_attachment_image_alt', true ) ) {
					update_post_meta( $value, '_wp_attachment_image_alt', $row['alt'] );
				}
			} elseif ( 'toggle' === $def[0] ) {
				$value = (int) $value;
			} elseif ( 'select' === $def[0] && ! isset( $def[3]['choices'][ (string) $value ] ) ) {
				$value = $def[2];
			}
			update_field( 'field_' . $t['prefix'] . '_' . $field, $value, $id );
		}
		$made++;
	}
	update_option( $t['setup_option'], time(), false );
	return $t['plural'] . ' created: ' . $made . '.';
}

/** Create the posts of every type that has none yet. Returns log lines. */
function bbq_cards_setup_all() {
	$log = array();
	foreach ( array_keys( bbq_card_types() ) as $type ) {
		$line = bbq_cards_setup( $type );
		if ( $line ) {
			$log[] = $line;
		}
	}
	return $log;
}

/* ---------- Post types ---------- */

add_action(
	'init',
	function () {
		foreach ( bbq_card_types() as $type => $t ) {
			$one  = $t['singular'];
			$low  = strtolower( $one );
			$many = strtolower( $t['plural'] );
			register_post_type(
				$type,
				array(
					'labels'             => array(
						'name'               => $t['menu'],
						'singular_name'      => $one,
						'menu_name'          => $t['menu'],
						'all_items'          => 'All ' . $many,
						'add_new'            => 'Add ' . $low,
						'add_new_item'       => 'Add ' . $low,
						'edit_item'          => 'Edit ' . $low,
						'new_item'           => 'New ' . $low,
						'view_item'          => 'View ' . $low,
						'search_items'       => 'Search ' . $many,
						'not_found'          => 'No ' . $many . ' found',
						'not_found_in_trash' => 'No ' . $many . ' in the trash',
					),
					'public'             => false,
					'show_ui'            => true,
					'show_in_menu'       => true,
					'show_in_rest'       => false,
					'menu_position'      => $t['position'],
					'menu_icon'          => $t['icon'],
					'supports'           => array( 'title', 'page-attributes' ),
					'hierarchical'       => false,
					'has_archive'        => false,
					'rewrite'            => false,
					'publicly_queryable' => false,
				)
			);
		}
	}
);

/* Once ACF is ready and the content has been moved, create the posts (once per type). */
add_action(
	'admin_init',
	function () {
		if ( ! current_user_can( 'edit_posts' ) || ! bbq_acf_ready() || ! bbq_acf_migrated() ) {
			return;
		}
		foreach ( bbq_card_types() as $type => $t ) {
			if ( ! get_option( $t['setup_option'] ) ) {
				bbq_cards_setup( $type );
			}
		}
	}
);

/* ---------- Admin: title placeholder, list columns, order ---------- */

add_filter(
	'enter_title_here',
	function ( $text, $post ) {
		$types = bbq_card_types();
		return isset( $types[ $post->post_type ] ) ? $types[ $post->post_type ]['placeholder'] : $text;
	},
	10,
	2
);

foreach ( array_keys( bbq_card_types() ) as $bbq_card_type ) {
	add_filter(
		'manage_' . $bbq_card_type . '_posts_columns',
		function ( $cols ) use ( $bbq_card_type ) {
			$t   = bbq_card_types()[ $bbq_card_type ];
			$new = array();
			foreach ( $cols as $key => $label ) {
				if ( 'title' !== $key ) {
					$new[ $key ] = $label;
					continue;
				}
				foreach ( $t['columns'] as $field ) {
					if ( 'image' === $t['fields'][ $field ][0] ) {
						$new[ 'bbq_' . $field ] = $t['fields'][ $field ][1];
					}
				}
				$new['title'] = $t['singular'] === 'Team member' ? 'Name' : 'Title';
				foreach ( $t['columns'] as $field ) {
					if ( 'image' !== $t['fields'][ $field ][0] ) {
						$new[ 'bbq_' . $field ] = $t['fields'][ $field ][1];
					}
				}
				$new['bbq_order'] = 'Order';
			}
			return $new;
		}
	);
	add_action(
		'manage_' . $bbq_card_type . '_posts_custom_column',
		function ( $col, $post_id ) use ( $bbq_card_type ) {
			$t = bbq_card_types()[ $bbq_card_type ];
			if ( 'bbq_order' === $col ) {
				echo (int) get_post_field( 'menu_order', $post_id );
				return;
			}
			$field = substr( $col, 4 );
			if ( 0 !== strpos( $col, 'bbq_' ) || ! isset( $t['fields'][ $field ] ) ) {
				return;
			}
			$def   = $t['fields'][ $field ];
			$value = bbq_card_value( $bbq_card_type, $post_id, $field );
			if ( 'image' === $def[0] ) {
				echo $value ? wp_get_attachment_image( $value, array( 64, 64 ), false, array( 'style' => 'width:56px;height:56px;object-fit:cover;border-radius:4px' ) ) : '—'; // phpcs:ignore WordPress.Security.EscapeOutput
			} elseif ( 'select' === $def[0] ) {
				echo esc_html( isset( $def[3]['choices'][ $value ] ) ? $def[3]['choices'][ $value ] : $value );
			} elseif ( 'toggle' === $def[0] ) {
				echo $value ? 'Yes' : '—';
			} else {
				echo esc_html( $value );
			}
		},
		10,
		2
	);
}
unset( $bbq_card_type );

/* The admin lists follow the order shown on the site. */
add_action(
	'pre_get_posts',
	function ( $query ) {
		if ( is_admin() && $query->is_main_query() && isset( bbq_card_types()[ (string) $query->get( 'post_type' ) ] ) && ! $query->get( 'orderby' ) ) {
			$query->set( 'orderby', array( 'menu_order' => 'ASC', 'title' => 'ASC' ) );
		}
	}
);
