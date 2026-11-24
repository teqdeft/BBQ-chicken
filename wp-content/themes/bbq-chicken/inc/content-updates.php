<?php
/**
 * One-off content updates for sites whose content is already in ACF (page sections, card posts).
 * Each update runs once, in order (option bbq_content_version), right after the card posts are set up, and only
 * changes what still holds the old design text or image, so anything edited in the admin stays as it is.
 *
 *   1  Menu follows the updated Figma menu: new sections "Meals and boxes" and "Something to drink", the sides
 *      before the sauces, burger and wrap as separate chicken cards, new card and side texts, British spelling
 *      in two sauces; Discover's ChiBBoQ text ends with "tenders" (no wings on the menu).
 *   2  Figma "Design v5": no "More brands coming soon" card; a "Real Korean Fried Chicken" food card; the three
 *      Madrid kitchens on the home map; the Madrid and London press releases as short news posts; BLT's restaurant
 *      renders for the franchise formats (Shop-in-shop second); new Discover food cut-outs; square meal photos
 *      (Felix's Choice and the Family Meal Box for real); the glazed Korean fried chicken on the Menu; confirmed
 *      spice levels for the sauces ("Not spicy"); the Monster drinks as their own group; a new portrait of
 *      Emma Heckel; the new inauguration photo on the Spain story.
 *   3  The cookie policy shows Cookiebot's list of cookies ([cookie_declaration]) at the end of section 4.
 */
defined( 'ABSPATH' ) || exit;

/**
 * Re-number a page's stored sections. $order lists, per new position, an old section index (int) or the name
 * of a new layout (string, added without content: it shows its design defaults). Unlisted sections are removed.
 */
function bbq_sections_reorder( $post_id, $order ) {
	global $wpdb;
	$old = bbq_stored_sections( $post_id );
	if ( null === $old ) {
		return false;
	}
	$map     = array();
	$layouts = array();
	foreach ( array_values( $order ) as $pos => $item ) {
		if ( is_int( $item ) ) {
			if ( ! isset( $old[ $item ] ) ) {
				return false;
			}
			$map[ $item ] = $pos;
			$layouts[]    = $old[ $item ];
		} else {
			$layouts[] = (string) $item;
		}
	}
	// rename the meta keys in place (by meta id), so every value stays exactly as stored
	$rows = $wpdb->get_results( $wpdb->prepare( "SELECT meta_id, meta_key FROM {$wpdb->postmeta} WHERE post_id = %d AND meta_key REGEXP %s", $post_id, '^_?sections_[0-9]+_' ) ); // phpcs:ignore WordPress.DB.DirectDatabaseQuery
	foreach ( $rows as $r ) {
		if ( ! preg_match( '/^(_?)sections_(\d+)_(.+)$/', $r->meta_key, $m ) ) {
			continue;
		}
		$i = (int) $m[2];
		if ( ! isset( $map[ $i ] ) ) {
			$wpdb->delete( $wpdb->postmeta, array( 'meta_id' => $r->meta_id ) ); // phpcs:ignore WordPress.DB.DirectDatabaseQuery
		} elseif ( $map[ $i ] !== $i ) {
			$wpdb->update( $wpdb->postmeta, array( 'meta_key' => $m[1] . 'sections_' . $map[ $i ] . '_' . $m[3] ), array( 'meta_id' => $r->meta_id ) ); // phpcs:ignore WordPress.DB.DirectDatabaseQuery, WordPress.DB.SlowDBQuery
		}
	}
	wp_cache_delete( $post_id, 'post_meta' );
	update_post_meta( $post_id, 'sections', $layouts );
	return true;
}

/** Re-order the rows of a stored repeater ($name, e.g. sections_3_sides): $order lists the old row indexes. */
function bbq_rows_reorder( $post_id, $name, $order ) {
	global $wpdb;
	$to   = array_flip( array_map( 'intval', array_values( $order ) ) );
	$like = $wpdb->esc_like( $name . '_' ) . '%';
	$rows = $wpdb->get_results( $wpdb->prepare( "SELECT meta_id, meta_key FROM {$wpdb->postmeta} WHERE post_id = %d AND ( meta_key LIKE %s OR meta_key LIKE %s )", $post_id, $like, '\_' . $like ) ); // phpcs:ignore WordPress.DB.DirectDatabaseQuery
	foreach ( $rows as $r ) {
		if ( ! preg_match( '/^(_?)' . preg_quote( $name, '/' ) . '_(\d+)_(.+)$/', $r->meta_key, $m ) || ! isset( $to[ (int) $m[2] ] ) || $to[ (int) $m[2] ] === (int) $m[2] ) {
			continue;
		}
		$wpdb->update( $wpdb->postmeta, array( 'meta_key' => $m[1] . $name . '_' . $to[ (int) $m[2] ] . '_' . $m[3] ), array( 'meta_id' => $r->meta_id ) ); // phpcs:ignore WordPress.DB.DirectDatabaseQuery, WordPress.DB.SlowDBQuery
	}
	wp_cache_delete( $post_id, 'post_meta' );
}

/** Save a stored section's fields with the design defaults (section $i of the page, 0-based). */
function bbq_section_fill( $post_id, $i, $layout ) {
	if ( false === $i || ! function_exists( 'update_sub_field' ) ) {
		return;
	}
	$schema = array_filter(
		bbq_layout_schema( $layout, $post_id ),
		function ( $f ) {
			return 'message' !== $f['type']; // notes for editors store nothing
		}
	);
	foreach ( bbq_acf_values( $schema, array(), 'field_' . $layout . '_' ) as $key => $value ) {
		update_sub_field( array( 'field_bbq_page_sections', $i + 1, $key ), $value, $post_id );
	}
}

/** The index of a page's first stored section with this layout, or false. */
function bbq_section_index( $post_id, $layout ) {
	$i = array_search( $layout, (array) bbq_stored_sections( $post_id ), true );
	return false === $i ? false : (int) $i;
}

/** Set a stored field (meta key) to $new if it still holds $old. Returns 1 when changed. */
function bbq_meta_swap( $post_id, $key, $old, $new ) {
	if ( ! metadata_exists( 'post', $post_id, $key ) || (string) get_post_meta( $post_id, $key, true ) !== (string) $old ) {
		return 0;
	}
	update_post_meta( $post_id, $key, $new );
	return 1;
}

/**
 * Update the card post titled $title: each field => array( old, new ) changes only while it holds the old value
 * (images: theme file names, matched through the Media Library imports). $new_title renames the post.
 */
function bbq_card_update( $type, $title, $fields, $new_title = '' ) {
	$t     = bbq_card_types()[ $type ];
	$posts = get_posts( array( 'post_type' => $type, 'post_status' => 'any', 'title' => $title, 'numberposts' => 1 ) );
	if ( ! $posts ) {
		return 0;
	}
	$id = $posts[0]->ID;
	$n  = 0;
	foreach ( $fields as $field => $pair ) {
		list( $old, $new ) = $pair;
		$cur = get_post_meta( $id, $t['prefix'] . '_' . $field, true );
		if ( 'image' === $t['fields'][ $field ][0] ) {
			$media = (array) get_option( 'bbq_asset_media', array() );
			if ( empty( $media[ $old ] ) || (int) $cur !== (int) $media[ $old ] ) {
				continue;
			}
			$new = bbq_acf_import_asset( $new );
			if ( ! $new ) {
				continue;
			}
		} elseif ( (string) $cur !== (string) $old ) {
			continue;
		}
		update_field( 'field_' . $t['prefix'] . '_' . $field, $new, $id );
		$n++;
	}
	if ( '' !== $new_title && $new_title !== $title ) {
		wp_update_post( array( 'ID' => $id, 'post_title' => $new_title ) );
		$n++;
	}
	return $n;
}

/** 1 · The menu as in the updated Figma design (see the top of this file). */
function bbq_content_update_1() {
	$log  = array();
	$menu = bbq_find_page( 'menu' );
	if ( $menu && null !== bbq_stored_sections( $menu->ID ) ) {
		$id  = $menu->ID;
		$old = bbq_stored_sections( $id );
		if ( ! in_array( 'menu_meals', $old, true ) && ! in_array( 'menu_drinks', $old, true ) ) {
			$order = array_keys( $old );
			$pos   = function ( $layout ) use ( &$order, $old ) {
				foreach ( $order as $k => $v ) {
					if ( is_int( $v ) && $old[ $v ] === $layout ) {
						return $k;
					}
				}
				return false;
			};
			// the sides move up, before the sauces
			$s = $pos( 'menu_sides' );
			$c = $pos( 'menu_sauces' );
			if ( false !== $s && false !== $c && $s > $c ) {
				$item = $order[ $s ];
				array_splice( $order, $s, 1 );
				array_splice( $order, $c, 0, array( $item ) );
			}
			// meals and boxes before the chicken (else after the hero)
			$k = $pos( 'menu_the_chicken' );
			if ( false === $k ) {
				$h = $pos( 'menu_hero' );
				$k = false === $h ? 0 : $h + 1;
			}
			array_splice( $order, $k, 0, array( 'menu_meals' ) );
			// something to drink after the sauces (else before the closing call to action)
			$c = $pos( 'menu_sauces' );
			if ( false === $c ) {
				$z = $pos( 'menu_closing_call_to_action' );
				$k = false === $z ? count( $order ) : $z;
			} else {
				$k = $c + 1;
			}
			array_splice( $order, $k, 0, array( 'menu_drinks' ) );
			if ( bbq_sections_reorder( $id, $order ) ) {
				// fill the new sections with the design content, as the move into ACF did for every section
				foreach ( array( 'menu_meals', 'menu_drinks' ) as $layout ) {
					bbq_section_fill( $id, bbq_section_index( $id, $layout ), $layout );
				}
				$log[] = 'Menu: sections "Meals and boxes" and "Something to drink" added, the sides now come before the sauces.';
			}
		}
		// the sides: coleslaw before tteokbokki, shorter texts, no drinks line in the intro
		$i = bbq_section_index( $id, 'menu_sides' );
		if ( false !== $i ) {
			$rows   = 'sections_' . $i . '_sides';
			$count  = (int) get_post_meta( $id, $rows, true );
			$titles = array();
			for ( $r = 0; $r < $count; $r++ ) {
				$titles[] = (string) get_post_meta( $id, $rows . '_' . $r . '_title', true );
			}
			$t = array_search( 'Tteokbokki', $titles, true );
			if ( false !== $t && isset( $titles[ $t + 1 ] ) && 'Coleslaw' === $titles[ $t + 1 ] ) {
				$order = range( 0, $count - 1 );
				$order[ $t ] = $t + 1;
				$order[ $t + 1 ] = $t;
				bbq_rows_reorder( $id, $rows, $order );
			}
			$n = bbq_meta_swap( $id, 'sections_' . $i . '_sides_lead', 'To drink: water, Coca-Cola, Fanta, Sprite, Fuze Tea, Aquarius and Monster. Allergen and nutrition information per market will be published here.', 'Allergen and nutrition information per market will be published here.' );
			for ( $r = 0; $r < $count; $r++ ) {
				$n += bbq_meta_swap( $id, $rows . '_' . $r . '_text', 'Golden, crispy fries with our signature spiced cheese seasoning.', 'Golden, crispy fries with our signature spiced cheese touch.' );
				$n += bbq_meta_swap( $id, $rows . '_' . $r . '_text', 'Korean rice cakes slow-cooked in our traditional spicy sauce (Classic Spicy), or the creamier Rose, with cream and a touch of heat.', 'Korean rice cakes, Classic Spicy or creamy Rose.' );
			}
			if ( $n || false !== $t ) {
				$log[] = 'Menu: sides updated.';
			}
		}
	}
	// chicken cards: the burger and the wrap get their own cards, shorter texts
	$n  = bbq_card_update( 'chicken_card', 'Real Korean Fried Chicken', array( 'text' => array( '2, 4 or 8 crispy, juicy pieces of our authentic Korean fried chicken, made to the original recipe.', 'Crispy, juicy pieces made to the original recipe. 2, 4 or 8 pieces.' ) ) );
	$n += bbq_card_update( 'chicken_card', 'Real Crispy Tenders', array( 'text' => array( '3, 6 or 12 original crispy chicken strips, with 1, 2 or 4 sauces.', 'Original crispy chicken strips. 3, 6 or 12 pieces, with 1, 2 or 4 sauces.' ) ) );
	$n += bbq_card_update(
		'chicken_card',
		'Meals and meal boxes',
		array(
			'text'  => array( 'Any favourite with fries and a drink: tenders, Korean fried chicken, a burger, a wrap or a bowl. Also as a Meal Box for 2 or a Family Meal Box.', 'Crispy golden chicken with fresh vegetables and sauce in a soft bun.' ),
			'image' => array( 'cut-fries.png', 'cut-burger.png' ),
			'alt'   => array( 'Fries in a bb.q fries box', 'A crispy chicken burger' ),
		),
		'Crispy Chicken Burger'
	);
	$n += bbq_card_update(
		'chicken_card',
		'Burgers and wraps',
		array(
			'text'  => array( 'A crispy chicken burger with fresh vegetables and sauce in a soft bun, or crispy chicken strips in a wrap with fresh vegetables.', 'Crispy, juicy chicken strips in a wrap with fresh vegetables.' ),
			'image' => array( 'cut-burger.png', 'cut-wrap.png' ),
			'alt'   => array( 'A crispy chicken burger', 'A crispy chicken wrap' ),
		),
		'Crispy Chicken Wrap'
	);
	$n += bbq_card_update( 'chicken_card', 'Rice and salad bowls', array( 'text' => array( 'Crispy chicken strips on white rice or on lettuce and mixed vegetables, with fresh vegetables and our special sauce.', 'Crispy chicken strips with fresh vegetables and our special sauce, on rice or salad.' ) ) );
	$n += bbq_card_update( 'chicken_card', 'Mega Party Bucket', array( 'text' => array( '24 crispy tenders, 16 pieces of Korean fried chicken or a combo of both, each with a 1.25 kg bucket of fries.', '24 tenders, 16 pieces, or 12 tenders with 8 pieces, each with 1.25 kg of fries.' ) ) );
	if ( $n ) {
		$log[] = 'Chicken cards updated (' . $n . ' changes).';
	}
	// sauces: British spelling
	$n  = bbq_card_update( 'menu_sauce', 'Galbi Mayo Sauce', array( 'text' => array( 'Creamy mayonnaise infused with sweet and savory Galbi BBQ flavor.', 'Creamy mayonnaise infused with sweet and savoury Galbi BBQ flavour.' ) ) );
	$n += bbq_card_update( 'menu_sauce', 'Cheesling Sauce', array( 'text' => array( 'Irresistible cheddar cheese seasoning with a sweet and savory twist.', 'Irresistible cheddar cheese seasoning with a sweet and savoury twist.' ) ) );
	if ( $n ) {
		$log[] = 'Sauces updated (' . $n . ' changes).';
	}
	// Discover: no wings on the menu
	$discover = bbq_find_page( 'discover' );
	$i        = $discover ? bbq_section_index( $discover->ID, 'discover_chibboq' ) : false;
	if ( false !== $i ) {
		$text = 'ChiBBoQ, Ollie and Chiky are the softest residents of Genesis Village. They live on our boxes and bags, pop up in restaurants now and then, and keep the youngest guests busy while the grown-ups finish the ';
		if ( bbq_meta_swap( $discover->ID, 'sections_' . $i . '_mascot_text', $text . 'wings.', $text . 'tenders.' ) ) {
			$log[] = 'Discover: ChiBBoQ text ends with "tenders".';
		}
	}
	return $log;
}

/** A theme image in the Media Library (imported once), with an alt text when it has none yet. 0 if missing. */
function bbq_media_with_alt( $file, $alt ) {
	$id = bbq_acf_import_asset( $file );
	if ( $id && '' !== $alt && '' === (string) get_post_meta( $id, '_wp_attachment_image_alt', true ) ) {
		update_post_meta( $id, '_wp_attachment_image_alt', $alt );
	}
	return $id;
}

/** Point a stored image field (meta key) at theme image $new while it still holds theme image $old. Returns 1 when changed. */
function bbq_image_swap( $post_id, $key, $old, $new, $alt = '' ) {
	$media = (array) get_option( 'bbq_asset_media', array() );
	if ( empty( $media[ $old ] ) || (int) get_post_meta( $post_id, $key, true ) !== (int) $media[ $old ] ) {
		return 0;
	}
	$id = bbq_media_with_alt( $new, $alt );
	if ( ! $id ) {
		return 0;
	}
	update_post_meta( $post_id, $key, $id );
	return 1;
}

/** Set a stored option (ACF "Website settings") to $new if it still holds $old. Returns 1 when changed. */
function bbq_option_swap( $name, $old, $new ) {
	if ( (string) get_option( 'options_' . $name, '' ) !== (string) $old ) {
		return 0;
	}
	update_option( 'options_' . $name, $new );
	return 1;
}

/** 2 · Figma "Design v5" (see the top of this file). */
function bbq_content_update_2() {
	$log  = array();
	$home = (int) get_option( 'page_on_front' );
	$nl   = function ( $s ) {
		return str_replace( "\r\n", "\n", (string) $s );
	};

	if ( $home && null !== bbq_stored_sections( $home ) ) {
		// intro: one brand card, no "More brands coming soon"
		$i = bbq_section_index( $home, 'home_intro' );
		if ( false !== $i && bbq_meta_swap( $home, 'sections_' . $i . '_brands_soon_show', '1', '0' ) ) {
			$log[] = 'Home: the "More brands coming soon" card is switched off.';
		}
		// find bb.q near you: the card on the map lists the three kitchens
		$i = bbq_section_index( $home, 'home_find_bb_q_near_you' );
		if ( false !== $i ) {
			$n   = bbq_meta_swap( $home, 'sections_' . $i . '_kitchen_name', 'Opening hours', 'bb.q Madrid · 3 kitchens' );
			$key = 'sections_' . $i . '_kitchen_info';
			if ( metadata_exists( 'post', $home, $key ) && "Sunday to Thursday: 12:00 to 23:00\nFriday and Saturday: 12:00 to midnight" === $nl( get_post_meta( $home, $key, true ) ) ) {
				update_post_meta( $home, $key, "Calle Zabaleta 1, Calle Felipe Fraile 5 and Calle José Calvo 10\nDelivery only\nSunday to Thursday: 12:00 to 23:00\nFriday and Saturday: 12:00 to midnight" );
				$n++;
			}
			if ( $n ) {
				$log[] = 'Home: the map card lists the three Madrid kitchens.';
			}
		}
	}

	// the map: centred between the three kitchens, one delivery area around them
	$old = array( 'map_lat' => '40.4168', 'map_lng' => '-3.7038', 'map_zoom' => '13', 'map_radius' => '2400' );
	$new = array( 'map_lat' => '40.4319', 'map_lng' => '-3.6831', 'map_zoom' => '12', 'map_radius' => '4600' );
	$same = true;
	foreach ( $old as $k => $v ) {
		$same = $same && (string) get_option( 'options_' . $k, $v ) === $v;
	}
	if ( $same ) {
		$n = 0;
		foreach ( $new as $k => $v ) {
			$n += bbq_option_swap( $k, $old[ $k ], $v );
		}
		if ( $n ) {
			$log[] = 'Delivery map: centred on the three Madrid kitchens.';
		}
	}

	// food card "Real Korean Fried Chicken", after the tenders
	if ( post_type_exists( 'food_card' ) && get_posts( array( 'post_type' => 'food_card', 'post_status' => 'any', 'numberposts' => 1, 'fields' => 'ids' ) )
		&& ! get_posts( array( 'post_type' => 'food_card', 'post_status' => 'any', 'title' => 'Real Korean Fried Chicken', 'numberposts' => 1, 'fields' => 'ids' ) ) ) {
		$cards   = get_posts( array( 'post_type' => 'food_card', 'post_status' => 'any', 'numberposts' => -1, 'orderby' => 'menu_order', 'order' => 'ASC' ) );
		$tenders = 0;
		$order   = count( $cards );
		foreach ( $cards as $c ) {
			if ( 'Real Crispy Tenders' === $c->post_title ) {
				$tenders = $c->ID;
				$order   = (int) $c->menu_order + 1;
			}
		}
		foreach ( $cards as $c ) {
			if ( (int) $c->menu_order >= $order ) {
				wp_update_post( array( 'ID' => $c->ID, 'menu_order' => (int) $c->menu_order + 1 ) );
			}
		}
		$id = wp_insert_post( array( 'post_type' => 'food_card', 'post_status' => 'publish', 'post_title' => 'Real Korean Fried Chicken', 'menu_order' => $order ) );
		if ( $id && ! is_wp_error( $id ) ) {
			update_field( 'field_food_text', 'Crispy, juicy pieces made to the original recipe. 2, 4 or 8 pieces.', $id );
			update_field( 'field_food_tag', '3 sizes', $id );
			update_field( 'field_food_style', 'dark', $id );
			update_field( 'field_food_desktop_only', 0, $id );
			$img = bbq_media_with_alt( 'cut-korean-fried-chicken.png', 'Korean fried chicken glazed in Secret Sauce, on a plate' );
			if ( $img ) {
				update_field( 'field_food_photo', $img, $id );
			}
			// a slider with picked cards gets it after the tenders too
			$i = $home ? bbq_section_index( $home, 'home_the_food' ) : false;
			if ( false !== $i ) {
				$key  = 'sections_' . $i . '_food_cards_pick';
				$pick = array_map( 'strval', (array) get_post_meta( $home, $key, true ) );
				$at   = array_search( (string) $tenders, $pick, true );
				if ( $pick && false !== $at ) {
					array_splice( $pick, $at + 1, 0, array( (string) $id ) );
					update_post_meta( $home, $key, $pick );
				}
			}
			$log[] = 'Food cards: "Real Korean Fried Chicken" added after the tenders.';
		}
	}

	// news: the Madrid and London press releases (23 Nov 2026) replace the two placeholder posts, as short
	// articles (the photos follow; until then the cards show the grey placeholder)
	$p_ = function ( $text ) {
		return "<!-- wp:paragraph -->\n<p>" . $text . "</p>\n<!-- /wp:paragraph -->";
	};
	$madrid = 'bb.q Chicken now delivers across Madrid from three kitchens, at Calle Zabaleta, Calle Felipe Fraile and Calle José Calvo. Order through Uber Eats, Glovo or Just Eat.';
	$london = 'bb.q Chicken opens in London in early December.';
	$news   = array(
		array(
			'old'     => '[Madrid openings article, supplied by BLT]',
			'title'   => 'Three bb.q kitchens now open in Madrid',
			'date'    => '2026-11-23 09:00:00',
			'card'    => '23 Nov 2026 · Madrid',
			'line'    => '23 November 2026 · Madrid',
			'label'   => 'Press / Madrid',
			'stub'    => '[Article on the three Madrid kitchens, supplied by BLT.]',
			'excerpt' => $madrid,
			'content' => $p_( $madrid ) . "\n\n" . $p_( 'The kitchens are delivery only and open Sunday to Thursday from 12:00 to 23:00, and Friday and Saturday from 12:00 to midnight. <a href="' . esc_url( home_url( '/#find' ) ) . '">Enter your postcode</a> to see if we deliver to you.' ),
		),
		array(
			'old'     => '[UK openings article, supplied by BLT]',
			'title'   => 'bb.q Chicken opens in London in early December',
			'date'    => '2026-11-23 08:00:00',
			'card'    => '23 Nov 2026 · United Kingdom',
			'line'    => '23 November 2026 · United Kingdom',
			'label'   => 'Press / United Kingdom',
			'stub'    => '[Article on the UK openings, supplied by BLT.]',
			'excerpt' => $london,
			'content' => $p_( $london ) . "\n\n" . $p_( 'We will share the details and how to order here as soon as it opens.' ),
		),
	);
	foreach ( $news as $n ) {
		$posts = get_posts( array( 'post_type' => 'post', 'post_status' => 'any', 'title' => $n['old'], 'numberposts' => 1 ) );
		if ( ! $posts ) {
			$posts = get_posts( array( 'post_type' => 'post', 'post_status' => 'any', 'title' => $n['title'], 'numberposts' => 1 ) );
		}
		if ( ! $posts ) {
			continue;
		}
		$p    = $posts[0];
		$data = array( 'ID' => $p->ID );
		if ( $n['old'] === $p->post_title ) {
			$data += array( 'post_title' => $n['title'], 'post_date' => $n['date'], 'post_date_gmt' => get_gmt_from_date( $n['date'] ) );
		}
		if ( '' === trim( (string) $p->post_excerpt ) ) {
			$data['post_excerpt'] = $n['excerpt'];
		}
		// the article text replaces the placeholder text only; the card stops being a placeholder with it
		$stub = $n['stub'] === trim( wp_strip_all_tags( (string) $p->post_content ) );
		if ( $stub ) {
			$data['post_content'] = $n['content'];
		}
		if ( count( $data ) > 1 ) {
			wp_update_post( wp_slash( $data ) );
		}
		bbq_meta_swap( $p->ID, 'news_card_meta', '[Date]' . strstr( $n['card'], ' · ' ), $n['card'] ); // "[Date] · Madrid" → "23 Nov 2026 · Madrid"
		bbq_meta_swap( $p->ID, 'news_date_line', '', $n['line'] );
		bbq_meta_swap( $p->ID, 'news_label', '', $n['label'] );
		if ( $stub ) {
			bbq_meta_swap( $p->ID, 'news_placeholder', '1', '0' );
		}
		if ( count( $data ) > 1 ) {
			$log[] = 'News: "' . $n['title'] . '" (23 Nov 2026) published.';
		}
	}
	// the Spain story: the new inauguration photo (card, featured image and the photo in the article)
	$spain_story = get_posts( array( 'post_type' => 'post', 'post_status' => 'any', 'title' => "Spain is bb.q's door to Europe", 'numberposts' => 1 ) );
	if ( $spain_story ) {
		$sp    = $spain_story[0];
		$media = (array) get_option( 'bbq_asset_media', array() );
		$old   = ! empty( $media['news-europe-hq.jpg'] ) ? (int) $media['news-europe-hq.jpg'] : 0;
		$thumb = (int) get_post_thumbnail_id( $sp );
		if ( ! $old && $thumb && 'news-europe-hq.jpg' === basename( (string) get_post_meta( $thumb, '_wp_attached_file', true ) ) ) {
			$old = $thumb; // imported with the news posts, not through the theme's image list
		}
		if ( $old && ( $thumb === $old || false !== strpos( $sp->post_content, 'wp-image-' . $old . '"' ) ) ) {
			$new = bbq_media_with_alt( 'news-europe-hq-ceremony.jpg', 'Officials from Genesis BBQ Group and BLT Global Brands at the inauguration of the bb.q Europe headquarters' );
			if ( $new ) {
				if ( $thumb === $old ) {
					set_post_thumbnail( $sp->ID, $new );
				}
				$content = str_replace(
					array( '"id":' . $old . ',', 'wp-image-' . $old . '"', (string) wp_get_attachment_url( $old ) ),
					array( '"id":' . $new . ',', 'wp-image-' . $new . '"', (string) wp_get_attachment_url( $new ) ),
					$sp->post_content
				);
				if ( $content !== $sp->post_content ) {
					wp_update_post( wp_slash( array( 'ID' => $sp->ID, 'post_content' => $content ) ) );
				}
				$log[] = 'News: new inauguration photo on "Spain is bb.q\'s door to Europe".';
			}
		}
	}

	// the setup pinned the Spain story while the newer posts were placeholders; with the Madrid story
	// published, the latest story is featured again (as in Figma v5)
	$madrid_post = get_posts( array( 'post_type' => 'post', 'post_status' => 'publish', 'title' => 'Three bb.q kitchens now open in Madrid', 'numberposts' => 1, 'fields' => 'ids' ) );
	$spain_post  = get_posts( array( 'post_type' => 'post', 'post_status' => 'any', 'title' => "Spain is bb.q's door to Europe", 'numberposts' => 1, 'fields' => 'ids' ) );
	if ( $madrid_post && $spain_post && 'placeholder' !== bbq_news_card_type( $madrid_post[0] )
		&& array( (int) $spain_post[0] ) === array_values( array_map( 'intval', (array) get_option( 'sticky_posts', array() ) ) ) ) {
		unstick_post( $spain_post[0] );
		$log[] = 'News: the latest story is featured again (Spain no longer pinned).';
	}

	// franchise formats: BLT's restaurant renders, Shop-in-shop before the traditional restaurant
	$franchise = bbq_find_page( 'franchise' );
	$i         = $franchise ? bbq_section_index( $franchise->ID, 'franchise_formats' ) : false;
	if ( false !== $i ) {
		$id    = $franchise->ID;
		$rows  = 'sections_' . $i . '_formats';
		$count = (int) get_post_meta( $id, $rows, true );
		$n     = 0;
		$files = array( 'format-flagship.jpg' => 'format-flagship-render.jpg', 'format-traditional.jpg' => 'format-traditional-render.jpg', 'format-shop-in-shop.jpg' => 'format-shop-in-shop-render.jpg' );
		for ( $r = 0; $r < $count; $r++ ) {
			foreach ( $files as $old_file => $new_file ) {
				$n += bbq_image_swap( $id, $rows . '_' . $r . '_img', $old_file, $new_file );
			}
		}
		$titles = array();
		for ( $r = 0; $r < $count; $r++ ) {
			$titles[] = (string) get_post_meta( $id, $rows . '_' . $r . '_title', true );
		}
		if ( array( 'Flagship', 'Traditional restaurant', 'Shop-in-shop' ) === $titles ) {
			bbq_rows_reorder( $id, $rows, array( 0, 2, 1 ) );
			$n++;
		}
		if ( $n ) {
			$log[] = 'Franchise: the formats show BLT\'s restaurant designs (Flagship, Shop-in-shop, Traditional restaurant).';
		}
	}

	// discover: the food cards' cut-outs
	$discover = bbq_find_page( 'discover' );
	$i        = $discover ? bbq_section_index( $discover->ID, 'discover_the_food' ) : false;
	if ( false !== $i ) {
		$id    = $discover->ID;
		$rows  = 'sections_' . $i . '_formats';
		$count = (int) get_post_meta( $id, $rows, true );
		$n     = 0;
		for ( $r = 0; $r < $count; $r++ ) {
			if ( bbq_image_swap( $id, $rows . '_' . $r . '_img', 'cut-4pcs-cheesling.png', 'cut-2pcs-secret-sauce.png' ) ) {
				bbq_meta_swap( $id, $rows . '_' . $r . '_alt', 'Four pieces of Cheesling chicken', 'Two pieces of chicken glazed in Secret Sauce' );
				$n++;
			}
			if ( bbq_image_swap( $id, $rows . '_' . $r . '_img', 'cut-8pcs-secret-sauce-bucket.png', 'cut-8pcs-fried-bucket.png' ) ) {
				bbq_meta_swap( $id, $rows . '_' . $r . '_alt', 'A sharing bucket of chicken glazed in Secret Sauce', 'A sharing bucket of fried chicken' );
				$n++;
			}
		}
		if ( $n ) {
			$log[] = 'Discover: new cut-outs in the food cards.';
		}
	}

	// menu: square meal photos, the glazed Korean fried chicken
	$meals = array(
		"Felix's Choice"  => array( 'food-3pcs-strips.jpg', 'meal-felixs-choice.jpg', 'Crispy tenders with fries, a drink and a dip, with a photo of Felix' ),
		'Best Sellers'    => array( 'food-combo-meal.jpg', 'meal-best-sellers.jpg', 'Two pieces of fried chicken with fries and a drink' ),
		'Meal Box for 2'  => array( 'meal-box-for-2.jpg', 'meal-box-for-2-square.jpg', 'Crispy tenders with fries, two drinks, two dips and sweet rice bites' ),
		'Family Meal Box' => array( 'food-party-bucket.jpg', 'meal-family-meal-box.jpg', 'Tenders spilling from a bucket, with fries, drinks, sweet rice bites and four dips' ),
	);
	$n = 0;
	foreach ( $meals as $title => $m ) {
		bbq_media_with_alt( $m[1], $m[2] );
		$n += bbq_card_update( 'meal_card', $title, array( 'photo' => array( $m[0], $m[1] ) ) );
	}
	if ( $n ) {
		$log[] = 'Meals: new square photos (' . $n . ').';
	}
	bbq_media_with_alt( 'cut-korean-fried-chicken.png', 'Korean fried chicken glazed in Secret Sauce, on a plate' );
	if ( bbq_card_update(
		'chicken_card',
		'Real Korean Fried Chicken',
		array(
			'image' => array( 'cut-2pcs-fried.png', 'cut-korean-fried-chicken.png' ),
			'alt'   => array( 'Two pieces of golden fried chicken', 'Korean fried chicken glazed in Secret Sauce, on a plate' ),
		)
	) ) {
		$log[] = 'Chicken cards: the glazed Korean fried chicken.';
	}

	// drinks: the Monster drinks get their own group (rows without a group are soft drinks)
	$menu = bbq_find_page( 'menu' );
	$i    = $menu ? bbq_section_index( $menu->ID, 'menu_drinks' ) : false;
	if ( false !== $i ) {
		$rows  = 'sections_' . $i . '_drinks';
		$count = (int) get_post_meta( $menu->ID, $rows, true );
		$n     = 0;
		for ( $r = 0; $r < $count; $r++ ) {
			$key = $rows . '_' . $r . '_group';
			if ( 0 === stripos( (string) get_post_meta( $menu->ID, $rows . '_' . $r . '_name', true ), 'Monster' ) && '' === (string) get_post_meta( $menu->ID, $key, true ) ) {
				update_post_meta( $menu->ID, $key, 'monster' );
				update_post_meta( $menu->ID, '_' . $key, 'field_menu_drinks_drinks__group' );
				$n++;
			}
		}
		if ( $n ) {
			$log[] = 'Menu: the Monster drinks are a group of their own (' . $n . ').';
		}
	}

	// sauces: confirmed spice levels (BLT sauce sheet, 23 Nov); no chillies = "Not spicy"
	$levels = array( 'Garlic Mayo Sauce' => '0', 'Jamaica Mayo Sauce' => '1', 'Red Chak Chak Sauce' => '2' );
	$n      = 0;
	foreach ( get_posts( array( 'post_type' => 'menu_sauce', 'post_status' => 'any', 'numberposts' => -1 ) ) as $s ) {
		if ( isset( $levels[ $s->post_title ] ) ) {
			$n += bbq_card_update( 'menu_sauce', $s->post_title, array( 'spice' => array( 'tbc', $levels[ $s->post_title ] ) ) );
		}
		if ( '0' === (string) get_post_meta( $s->ID, 'sauce_spice', true ) && '' === trim( (string) get_post_meta( $s->ID, 'sauce_note', true ) ) ) {
			update_field( 'field_sauce_note', 'Not spicy', $s->ID );
			$n++;
		}
	}
	if ( $n ) {
		$log[] = 'Sauces: confirmed spice levels (' . $n . ' changes).';
	}

	// about: Emma Heckel's new portrait
	bbq_media_with_alt( 'team-emma-heckel-portrait.jpg', 'Portrait of Emma Heckel' );
	if ( bbq_card_update( 'team_member', 'Emma Heckel', array( 'photo' => array( 'team-emma-heckel.jpg', 'team-emma-heckel-portrait.jpg' ) ) ) ) {
		$log[] = 'Team: new portrait of Emma Heckel.';
	}
	return $log;
}

/**
 * Update 3: Cookiebot's list of cookies ([cookie_declaration]) in the cookie policy, at the end of section 4
 * "Who uses cookies?" (as in inc/import/legal/cookie-policy.html). Only on a page that has no list yet and
 * still holds section 5's heading; without a Cookiebot ID the shortcode prints nothing.
 */
function bbq_content_update_3() {
	$log  = array();
	$page = get_page_by_path( 'cookie-policy' );
	if ( ! $page || has_shortcode( $page->post_content, 'cookie_declaration' ) ) {
		return $log;
	}
	$text = str_replace( "\r\n", "\n", $page->post_content );
	$at   = strpos( $text, "<!-- wp:heading -->\n<h2 class=\"wp-block-heading\">5. Managing Cookies</h2>" );
	if ( false === $at ) {
		return $log;
	}
	$text = substr_replace( $text, "<!-- wp:shortcode -->\n[cookie_declaration]\n<!-- /wp:shortcode -->\n\n", $at, 0 );
	wp_update_post( wp_slash( array( 'ID' => $page->ID, 'post_content' => $text ) ) );
	$log[] = 'Cookie policy: Cookiebot\'s list of cookies added to section 4.';
	return $log;
}

/** Run the updates this site has not had yet. */
function bbq_content_updates() {
	$done    = (int) get_option( 'bbq_content_version', 0 );
	$updates = array( 1 => 'bbq_content_update_1', 2 => 'bbq_content_update_2', 3 => 'bbq_content_update_3' );
	$log     = array();
	foreach ( $updates as $version => $fn ) {
		if ( $version <= $done ) {
			continue;
		}
		$log = array_merge( $log, (array) call_user_func( $fn ) );
		update_option( 'bbq_content_version', $version, false );
	}
	return $log;
}

/* After the card posts are set up (inc/card-types.php, admin_init priority 10). */
add_action(
	'admin_init',
	function () {
		if ( ! current_user_can( 'edit_posts' ) || ! bbq_acf_ready() || ! bbq_acf_migrated() ) {
			return;
		}
		bbq_content_updates();
	},
	20
);
