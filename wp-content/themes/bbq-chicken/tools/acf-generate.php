<?php
/**
 * Regenerates inc/acf-fields.php from the theme's field lists (section files, header/footer/settings
 * templates, news-article template, News card schema). Not loaded by the theme; run it after adding or
 * changing fields in a section file:
 *
 *   wp eval-file wp-content/themes/bbq-chicken/tools/acf-generate.php
 */
defined( 'ABSPATH' ) || exit;


$pages = array(
	'home' => 'Home', 'franchise' => 'Franchise', 'apply' => 'Apply', 'apply-thank-you' => 'Application thank-you',
	'discover' => 'Discover', 'menu' => 'Menu', 'about' => 'About', 'real-estate' => 'Real estate', 'careers' => 'Careers',
	'contact' => 'Contact', 'legal' => 'Legal', 'news' => 'News',
);
$keys_seen = array();

/** One ACF field from one of our schema entries. */
$acf_field = function ( $prefix, $f ) use ( &$acf_field, &$keys_seen ) {
	$key  = 'field_' . $prefix . '_' . $f['key'];
	if ( isset( $keys_seen[ $key ] ) ) {
		throw new Exception( 'duplicate field key ' . $key );
	}
	$keys_seen[ $key ] = 1;
	$args = (array) $f['args'];
	$help = isset( $args['help'] ) ? $args['help'] : '';
	$out  = array( 'key' => $key, 'label' => $f['label'], 'name' => $f['name'] ?? $f['key'] );
	switch ( $f['type'] ) {
		case 'text':
			$out += array( 'type' => 'text', 'default_value' => (string) $f['default'] );
			break;
		case 'textarea':
			$out += array( 'type' => 'textarea', 'default_value' => (string) $f['default'], 'rows' => 3, 'new_lines' => '' );
			break;
		case 'html':
			$out += array( 'type' => 'textarea', 'default_value' => (string) $f['default'], 'rows' => 3, 'new_lines' => '' );
			$help = trim( $help . ' Simple formatting allowed: <strong>, <em>, <br>, links.' );
			break;
		case 'image':
			$out += array( 'type' => 'image', 'return_format' => 'id', 'preview_size' => 'medium', 'library' => 'all' );
			$help = trim( $help . ' Empty = the design\'s image.' );
			break;
		case 'link':
			$out += array( 'type' => 'link', 'return_format' => 'array' );
			break;
		case 'select':
			$out += array( 'type' => 'select', 'choices' => (array) $args['choices'], 'default_value' => (string) $f['default'], 'return_format' => 'value', 'ui' => 0 );
			break;
		case 'posts':
			$out += array(
				'type'          => 'relationship',
				'post_type'     => array( $args['post_type'] ),
				'post_status'   => array( 'publish' ),
				'filters'       => array( 'search' ),
				'elements'      => array(),
				'return_format' => 'id',
				'min'           => '',
				'max'           => '',
			);
			break;
		case 'message':
			$out['name'] = '';
			$out        += array( 'type' => 'message', 'message' => (string) $f['default'], 'new_lines' => 'wpautop', 'esc_html' => 0 );
			break;
		case 'toggle':
			$out += array( 'type' => 'true_false', 'default_value' => (int) $f['default'], 'ui' => 1 );
			break;
		case 'rows':
			$subs = array();
			$first_text = '';
			foreach ( (array) $args['fields'] as $sub => $def ) {
				$sf = array( 'key' => $f['key'] . '__' . $sub, 'name' => $sub, 'label' => $def[1], 'type' => $def[0], 'default' => '', 'args' => isset( $def[2] ) ? array( 'choices' => $def[2] ) : array() );
				$acf = $acf_field( $prefix, $sf );
				$acf['name'] = $sub;
				$subs[] = $acf;
				if ( ! $first_text && in_array( $def[0], array( 'text', 'textarea', 'html' ), true ) ) {
					$first_text = $acf['key'];
				}
			}
			$out += array( 'type' => 'repeater', 'layout' => count( $subs ) > 2 ? 'block' : 'table', 'button_label' => 'Add row', 'collapsed' => $first_text, 'sub_fields' => $subs );
			$help = trim( $help . ' Empty = the design\'s items.' );
			break;
		default:
			throw new Exception( 'unknown type ' . $f['type'] );
	}
	if ( isset( $args['placeholder'] ) && in_array( $out['type'], array( 'text', 'textarea' ), true ) ) {
		$out['placeholder'] = $args['placeholder'];
	}
	if ( $help ) {
		$out['instructions'] = $help;
	}
	return $out;
};

/** Fields of one schema, with a tab per sub-group when there is more than one. */
$fields_of = function ( $prefix, $schema, $tabs_always = false ) use ( $acf_field ) {
	$groups = array();
	foreach ( $schema as $f ) {
		$groups[ $f['section'] ][] = $f;
	}
	$out = array();
	$n   = 0;
	foreach ( $groups as $label => $list ) {
		if ( $tabs_always || count( $groups ) > 1 ) {
			$out[] = array( 'key' => 'field_' . $prefix . '_tab' . ( ++$n ), 'label' => $label, 'name' => '', 'type' => 'tab', 'placement' => 'top' );
		}
		foreach ( $list as $f ) {
			$out[] = $acf_field( $prefix, $f );
		}
	}
	return $out;
};

// ---------- Page "Sections" builder ----------
$layouts = array();
foreach ( bbq_layouts() as $name => $l ) {
	$schema = bbq_layout_schema( $name );
	$layouts[ 'layout_' . $name ] = array(
		'key'        => 'layout_' . $name,
		'name'       => $name,
		'label'      => $pages[ $l['page'] ] . ' · ' . $l['label'],
		'display'    => 'block',
		'sub_fields' => $fields_of( $name, $schema ),
	);
}
$page_group = array(
	'key'      => 'group_bbq_page',
	'title'    => 'Page content',
	'fields'   => array(
		array( 'key' => 'field_bbq_page_tab_sections', 'label' => 'Sections', 'name' => '', 'type' => 'tab', 'placement' => 'top' ),
		array(
			'key'          => 'field_bbq_page_sections',
			'label'        => 'Sections',
			'name'         => 'sections',
			'type'         => 'flexible_content',
			'instructions' => 'The page is built from these sections, top to bottom. Add, drag to reorder or remove sections; each one is a part of the design with its own texts, images and buttons.',
			'button_label' => 'Add section',
			'layouts'      => $layouts,
		),
		array( 'key' => 'field_bbq_page_tab_seo', 'label' => 'SEO', 'name' => '', 'type' => 'tab', 'placement' => 'top' ),
		array( 'key' => 'field_bbq_page_seo_title', 'label' => 'SEO title', 'name' => 'seo_title', 'type' => 'text', 'instructions' => 'Shown in search results and the browser tab. Empty = the default title.' ),
		array( 'key' => 'field_bbq_page_seo_description', 'label' => 'Meta description', 'name' => 'seo_description', 'type' => 'textarea', 'rows' => 3, 'new_lines' => '', 'instructions' => 'Shown in search results. Empty = the default description.' ),
	),
	'location' => array( array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'page' ) ) ),
	'position' => 'acf_after_title',
	'style'    => 'seamless',
	'menu_order' => 0,
);

// ---------- Options page "Website settings" ----------
$site_schema = bbq_site_schema();
$news_schema = bbq_collect_schema( 'news-article', 0 );
foreach ( $news_schema as &$f ) {
	$f['section'] = 'News articles: ' . preg_replace( '/^Article page:\s*/', '', $f['section'] );
}
unset( $f );
$names = array();
foreach ( array_merge( $site_schema, $news_schema ) as $f ) {
	if ( isset( $names[ $f['key'] ] ) ) {
		throw new Exception( 'duplicate options field name ' . $f['key'] );
	}
	$names[ $f['key'] ] = 1;
}
$site_group = array(
	'key'      => 'group_bbq_site',
	'title'    => 'Website settings',
	'fields'   => $fields_of( 'site', array_merge( $site_schema, $news_schema ), true ),
	'location' => array( array( array( 'param' => 'options_page', 'operator' => '==', 'value' => 'bbq-website-settings' ) ) ),
	'style'    => 'seamless',
	'menu_order' => 0,
);

// ---------- News posts: "News card" ----------
$card_schema = array();
foreach ( bbq_news_schema() as $f ) {
	$f['name']     = 'news_' . $f['key'];
	$card_schema[] = $f;
}
$news_group = array(
	'key'      => 'group_bbq_news_card',
	'title'    => 'News card',
	'fields'   => $fields_of( 'news', $card_schema, true ),
	'location' => array( array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'post' ) ) ),
	'position' => 'normal',
	'menu_order' => 0,
);

// ---------- Team members (post type team_member, inc/team.php) ----------
$team_group = array(
	'key'      => 'group_bbq_team_member',
	'title'    => 'Team member',
	'fields'   => $fields_of( 'team', array_values( bbq_team_schema() ) ),
	'location' => array( array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'team_member' ) ) ),
	'position' => 'acf_after_title',
	'menu_order' => 0,
);

// ---------- Food cards (post type food_card, inc/food.php) ----------
$food_group = array(
	'key'      => 'group_bbq_food_card',
	'title'    => 'Food card',
	'fields'   => $fields_of( 'food', array_values( bbq_food_schema() ) ),
	'location' => array( array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'food_card' ) ) ),
	'position' => 'acf_after_title',
	'menu_order' => 0,
);

// ---------- Write the PHP file ----------
$export = function ( $v, $ind = 1 ) use ( &$export ) {
	$pad = str_repeat( "\t", $ind );
	if ( ! is_array( $v ) ) {
		return is_int( $v ) ? (string) $v : ( is_bool( $v ) ? ( $v ? 'true' : 'false' ) : "'" . str_replace( array( '\\', "'" ), array( '\\\\', "\\'" ), (string) $v ) . "'" );
	}
	$list = array_keys( $v ) === range( 0, count( $v ) - 1 );
	$simple = true;
	foreach ( $v as $x ) { if ( is_array( $x ) ) { $simple = false; break; } }
	if ( $simple && count( $v ) <= 8 ) {
		$parts = array();
		foreach ( $v as $k => $x ) { $parts[] = ( $list ? '' : $export( $k ) . ' => ' ) . $export( $x ); }
		$one = 'array( ' . implode( ', ', $parts ) . ' )';
		if ( strlen( $one ) < 150 || ! $v ) { return $v ? $one : 'array()'; }
	}
	$out = "array(\n";
	foreach ( $v as $k => $x ) {
		$out .= $pad . "\t" . ( $list ? '' : $export( $k ) . ' => ' ) . $export( $x, $ind + 1 ) . ",\n";
	}
	return $out . $pad . ')';
};
$php  = "<?php\n/**\n * ACF field groups (ACF Pro), defined in code like the Sokkies theme: no acf-json, nothing to sync, and the\n * field setup can't be changed (or broken) from the admin. Labels are in English.\n *\n *   Page content       every page: \"Sections\" (Flexible Content, one layout per section file in\n *                      template-parts/sections/, see inc/layouts.php) and SEO\n *   Website settings   options page: header, footer, ordering links, map, news article texts\n *   News card          posts: card date line, links, placeholder and the article extras\n *   Team member        team members (menu: Team, inc/team.php): role and portrait photo\n *   Food card          home \"The food\" slider cards (menu: Food cards, inc/food.php)\n *\n * Generated from the theme's field lists (the bbq_text()/bbq_rows()… calls in the section files and\n * templates): field names are those keys, defaults the design's content. After adding or changing a field in\n * a section file, regenerate it: wp eval-file wp-content/themes/bbq-chicken/tools/acf-generate.php\n */\n\ndefined( 'ABSPATH' ) || exit;\n\nadd_action(\n\t'acf/init',\n\tfunction () {\n\t\tif ( ! function_exists( 'acf_add_local_field_group' ) ) {\n\t\t\treturn;\n\t\t}\n\n";
$php .= "\t\tacf_add_options_page(\n\t\t\tarray(\n\t\t\t\t'page_title'      => 'Website settings',\n\t\t\t\t'menu_title'      => 'Website settings',\n\t\t\t\t'menu_slug'       => 'bbq-website-settings',\n\t\t\t\t'capability'      => 'edit_theme_options',\n\t\t\t\t'position'        => 25,\n\t\t\t\t'icon_url'        => 'dashicons-admin-settings',\n\t\t\t\t'redirect'        => false,\n\t\t\t\t'update_button'   => 'Save settings',\n\t\t\t\t'updated_message' => 'Settings saved.',\n\t\t\t)\n\t\t);\n\n";
foreach ( array( $page_group, $site_group, $news_group, $team_group, $food_group ) as $g ) {
	$php .= "\t\tacf_add_local_field_group( " . $export( $g, 2 ) . " );\n\n";
}
$php = rtrim( $php ) . "\n\t}\n);\n";
file_put_contents( BBQ_DIR . '/inc/acf-fields.php', $php );
$count = substr_count( $php, "'key' => 'field_" );
echo 'written inc/acf-fields.php: ', strlen( $php ), ' bytes, ', substr_count( $php, "\n" ), ' lines, ', $count, ' fields, ', count( $layouts ), " layouts\n";
echo 'site fields: ', count( $site_schema ), ' + news-article: ', count( $news_schema ), ', news card: ', count( $card_schema ), "\n";
