<?php
/**
 * Team members (custom post type "team_member", menu "Team"): one post per person. The title is the name;
 * the ACF "Team member" group (inc/acf-fields.php) holds the role and the portrait photo; "Order" (Page
 * attributes) sets the order. The About page's "Leadership team" section lists them.
 *
 * Until there are team members, the section shows the design's people (bbq_team_defaults()). The first
 * time ACF is ready, the people from the About page are created as team members (bbq_team_setup()).
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'init',
	function () {
		register_post_type(
			'team_member',
			array(
				'labels'             => array(
					'name'               => 'Team',
					'singular_name'      => 'Team member',
					'menu_name'          => 'Team',
					'all_items'          => 'All team members',
					'add_new'            => 'Add team member',
					'add_new_item'       => 'Add team member',
					'edit_item'          => 'Edit team member',
					'new_item'           => 'New team member',
					'view_item'          => 'View team member',
					'search_items'       => 'Search team members',
					'not_found'          => 'No team members found',
					'not_found_in_trash' => 'No team members in the trash',
				),
				'public'             => false,
				'show_ui'            => true,
				'show_in_menu'       => true,
				'show_in_rest'       => false,
				'menu_position'      => 21,
				'menu_icon'          => 'dashicons-groups',
				'supports'           => array( 'title', 'page-attributes' ),
				'hierarchical'       => false,
				'has_archive'        => false,
				'rewrite'            => false,
				'publicly_queryable' => false,
			)
		);
	}
);

/** Fields of the "Team member" group (ACF): post meta team_<key>. */
function bbq_team_schema() {
	return array(
		'role'  => array( 'key' => 'role', 'name' => 'team_role', 'type' => 'text', 'label' => 'Role', 'default' => '', 'args' => array( 'placeholder' => 'e.g. Marketing' ), 'section' => 'Team member' ),
		'photo' => array( 'key' => 'photo', 'name' => 'team_photo', 'type' => 'image', 'label' => 'Portrait photo', 'default' => '', 'args' => array( 'help' => 'Portrait, 720 × 900 px (4:5). The photo\'s alt text comes from the Media Library (empty = "Portrait of" + the name).' ), 'section' => 'Team member' ),
	);
}

/** The design's people (shown until there are team members; also used to create them). */
function bbq_team_defaults() {
	return array(
		array( 'img' => 'team-thomas-talarico.jpg', 'name' => 'Thomas C. Talarico', 'role' => 'CEO and Partner', 'alt' => 'Portrait of Thomas C. Talarico' ),
		array( 'img' => 'team-maria-de-los-reyes-barrenengoa.jpg', 'name' => 'María de los Reyes Barrenengoa', 'role' => 'Marketing', 'alt' => 'Portrait of María de los Reyes Barrenengoa' ),
		array( 'img' => 'team-daniela-haack.jpg', 'name' => 'Daniela Haack', 'role' => 'Marketing', 'alt' => 'Portrait of Daniela Haack' ),
		array( 'img' => 'team-patricia-rader.jpg', 'name' => 'Patricia Rader', 'role' => 'Human Resources', 'alt' => 'Portrait of Patricia Rader' ),
		array( 'img' => 'team-julian-de-miguel.jpg', 'name' => 'Julián de Miguel', 'role' => 'IT', 'alt' => 'Portrait of Julián de Miguel' ),
		array( 'img' => 'team-julieta-cruz.jpg', 'name' => 'Julieta Cruz', 'role' => 'Staff Accountant', 'alt' => 'Portrait of Julieta Cruz' ),
		array( 'img' => 'team-emma-heckel.jpg', 'name' => 'Emma Heckel', 'role' => 'Procurement', 'alt' => 'Portrait of Emma Heckel' ),
	);
}

/**
 * The people to show: the picked team members in the picked order ($ids, from the section's "Team members"
 * field), else all published team members in their order, else the design's people when there are none.
 */
function bbq_team_people( $ids = array() ) {
	$all   = array(
		'post_type'   => 'team_member',
		'post_status' => 'publish',
		'numberposts' => -1,
		'orderby'     => array( 'menu_order' => 'ASC', 'title' => 'ASC' ),
	);
	$posts = $ids ? get_posts( array( 'post__in' => array_map( 'intval', (array) $ids ), 'orderby' => 'post__in' ) + $all ) : array();
	if ( ! $posts ) {
		$posts = get_posts( $all ); // nothing picked (or the picked members are gone): all of them
	}
	if ( ! $posts ) {
		return bbq_team_defaults();
	}
	$people = array();
	foreach ( $posts as $post ) {
		$name     = get_post_field( 'post_title', $post->ID, 'raw' );
		$photo    = (int) get_post_meta( $post->ID, 'team_photo', true );
		$alt      = $photo ? trim( (string) get_post_meta( $photo, '_wp_attachment_image_alt', true ) ) : '';
		$people[] = array(
			'img'  => $photo ? $photo : '',
			'name' => $name,
			'role' => (string) get_post_meta( $post->ID, 'team_role', true ),
			'alt'  => '' !== $alt ? $alt : 'Portrait of ' . $name,
		);
	}
	return $people;
}

/**
 * Create the team members once, from the About page's "Leadership team" section (its saved rows, else the
 * design's people). Does nothing when team members exist. Returns a log line.
 */
function bbq_team_setup() {
	// Only once the "Team member" fields exist (inc/acf-fields.php), and only when there are no team members yet.
	if ( ! function_exists( 'acf_get_field' ) || ! acf_get_field( 'field_team_role' ) || get_posts( array( 'post_type' => 'team_member', 'post_status' => 'any', 'numberposts' => 1, 'fields' => 'ids' ) ) ) {
		return '';
	}
	$people = bbq_team_defaults();
	$about  = bbq_find_page( 'about' );
	if ( $about ) {
		foreach ( (array) bbq_stored_sections( $about->ID ) as $i => $layout ) {
			if ( 'about_leadership_team' !== $layout ) {
				continue;
			}
			$found = false;
			$rows  = bbq_acf_value( $about->ID, 'sections_' . $i . '_leaders', 'rows', array( 'fields' => array( 'img' => array( 'image' ), 'name' => array( 'text' ), 'role' => array( 'text' ), 'alt' => array( 'text' ) ) ), $found );
			if ( $found && $rows ) {
				$people = $rows;
			}
			break;
		}
		// People edited in the old "Page content" box (before ACF)
		$legacy = get_post_meta( $about->ID, BBQ_META, true );
		if ( bbq_team_defaults() === $people && is_array( $legacy ) && ! empty( $legacy['leaders'] ) && is_array( $legacy['leaders'] ) ) {
			$people = $legacy['leaders'];
		}
	}
	foreach ( array_values( $people ) as $n => $person ) {
		if ( '' === trim( (string) $person['name'] ) ) {
			continue;
		}
		$id = wp_insert_post(
			array(
				'post_type'   => 'team_member',
				'post_status' => 'publish',
				'post_title'  => $person['name'],
				'menu_order'  => $n,
			)
		);
		if ( ! $id || is_wp_error( $id ) ) {
			continue;
		}
		update_field( 'field_team_role', (string) $person['role'], $id );
		$photo = bbq_acf_import_asset( $person['img'] );
		if ( $photo ) {
			update_field( 'field_team_photo', $photo, $id );
			if ( '' !== trim( (string) $person['alt'] ) && '' === (string) get_post_meta( $photo, '_wp_attachment_image_alt', true ) ) {
				update_post_meta( $photo, '_wp_attachment_image_alt', $person['alt'] );
			}
		}
	}
	update_option( 'bbq_team_setup', time(), false );
	return 'Team members created: ' . count( $people ) . '.';
}

/* Once ACF is ready and the content has been moved, create the team members (once). */
add_action(
	'admin_init',
	function () {
		if ( get_option( 'bbq_team_setup' ) || ! current_user_can( 'edit_posts' ) || ! bbq_acf_ready() || ! bbq_acf_migrated() ) {
			return;
		}
		bbq_team_setup();
	}
);

/* ---------- Admin list: photo, role, order; "Full name" as the title placeholder ---------- */

add_filter(
	'enter_title_here',
	function ( $text, $post ) {
		return 'team_member' === $post->post_type ? 'Full name' : $text;
	},
	10,
	2
);

add_filter(
	'manage_team_member_posts_columns',
	function ( $cols ) {
		$new = array();
		foreach ( $cols as $key => $label ) {
			if ( 'title' === $key ) {
				$new['bbq_photo'] = 'Photo';
				$new['title']     = 'Name';
				$new['bbq_role']  = 'Role';
				$new['bbq_order'] = 'Order';
				continue;
			}
			$new[ $key ] = $label;
		}
		return $new;
	}
);

add_action(
	'manage_team_member_posts_custom_column',
	function ( $col, $post_id ) {
		if ( 'bbq_photo' === $col ) {
			$photo = (int) get_post_meta( $post_id, 'team_photo', true );
			echo $photo ? wp_get_attachment_image( $photo, array( 48, 60 ), false, array( 'style' => 'width:48px;height:60px;object-fit:cover;border-radius:4px' ) ) : '—'; // phpcs:ignore WordPress.Security.EscapeOutput
		} elseif ( 'bbq_role' === $col ) {
			echo esc_html( (string) get_post_meta( $post_id, 'team_role', true ) );
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
		if ( is_admin() && $query->is_main_query() && 'team_member' === $query->get( 'post_type' ) && ! $query->get( 'orderby' ) ) {
			$query->set( 'orderby', array( 'menu_order' => 'ASC', 'title' => 'ASC' ) );
		}
	}
);
