<?php
/**
 * One-off content updates for sites whose content is already in ACF (page sections, card posts).
 * Each update runs once, in order (option bbq_content_version), right after the card posts are set up, and only
 * changes what still holds the old design text or image, so anything edited in the admin stays as it is.
 *
 *   1  Menu follows the updated Figma menu: new sections "Meals and boxes" and "Something to drink", the sides
 *      before the sauces, burger and wrap as separate chicken cards, new card and side texts, British spelling
 *      in two sauces; Discover's ChiBBoQ text ends with "tenders" (no wings on the menu).
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

/** Run the updates this site has not had yet. */
function bbq_content_updates() {
	$done    = (int) get_option( 'bbq_content_version', 0 );
	$updates = array( 1 => 'bbq_content_update_1' );
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
