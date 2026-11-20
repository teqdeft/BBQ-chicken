<?php
/**
 * Admin UI for the editable fields: the "Page content" box on pages, saving, and the
 * shared renderer/sanitizer also used by the site settings screen (inc/options.php)
 * and the news fields (inc/news.php).
 */

defined( 'ABSPATH' ) || exit;

/** Template keys whose content is edited through fields (and not the block editor). */
function bbq_field_keys_for( $post_id ) {
	$key = bbq_template_key_for( $post_id );
	if ( ! $key ) {
		return array();
	}
	if ( 'news' === $key ) {
		return array( 'news', 'news-article' ); // the posts page also holds the article layout texts
	}
	if ( 'news-article' === $key ) {
		return array(); // posts use inc/news.php fields
	}
	return file_exists( BBQ_DIR . '/templates/' . $key . '.php' ) ? array( $key ) : array();
}

/** SEO fields added to every page that has theme fields. */
function bbq_seo_schema( $post_id ) {
	$key  = bbq_template_key_for( $post_id );
	$list = bbq_templates();
	$t    = isset( $list[ $key ] ) ? $list[ $key ] : array( 'seo' => '', 'desc' => '' );
	return array(
		'seo_title'       => array(
			'key'     => 'seo_title',
			'type'    => 'text',
			'label'   => 'SEO title',
			'default' => '',
			'args'    => array( 'placeholder' => $t['seo'], 'help' => 'Shown in search results and the browser tab. Leave empty for the default.' ),
			'section' => 'SEO',
		),
		'seo_description' => array(
			'key'     => 'seo_description',
			'type'    => 'textarea',
			'label'   => 'Meta description',
			'default' => '',
			'args'    => array( 'placeholder' => $t['desc'] ),
			'section' => 'SEO',
		),
	);
}

function bbq_post_schema( $post_id ) {
	$keys = bbq_field_keys_for( $post_id );
	if ( ! $keys ) {
		return array();
	}
	return array_merge( bbq_collect_schema( $keys, $post_id ), bbq_seo_schema( $post_id ) );
}

/* ---------- Edit screen: classic editor + "Page content" box for field pages ---------- */

/** Pages built from fields use the classic edit screen (title + our box); the legal page keeps the block editor. */
add_filter(
	'use_block_editor_for_post',
	function ( $use, $post ) {
		if ( 'page' !== $post->post_type ) {
			return $use;
		}
		$key  = bbq_template_key_for( $post->ID );
		$list = bbq_templates();
		if ( $key && isset( $list[ $key ] ) && empty( $list[ $key ]['editor'] ) ) {
			return false;
		}
		return $use;
	},
	10,
	2
);

add_action(
	'load-post.php',
	function () {
		$post_id = isset( $_GET['post'] ) ? absint( $_GET['post'] ) : 0; // phpcs:ignore WordPress.Security.NonceVerification
		if ( ! $post_id || 'page' !== get_post_type( $post_id ) ) {
			return;
		}
		$key  = bbq_template_key_for( $post_id );
		$list = bbq_templates();
		if ( $key && isset( $list[ $key ] ) && empty( $list[ $key ]['editor'] ) ) {
			remove_post_type_support( 'page', 'editor' );
		}
	}
);

add_action(
	'add_meta_boxes_page',
	function ( $post ) {
		if ( ! bbq_field_keys_for( $post->ID ) ) {
			return;
		}
		add_meta_box( 'bbq-fields', 'Page content', 'bbq_page_box', 'page', 'normal', 'high' );
	}
);

function bbq_page_box( $post ) {
	$schema = bbq_post_schema( $post->ID );
	$values = get_post_meta( $post->ID, BBQ_META, true );
	wp_nonce_field( 'bbq_fields_save', 'bbq_fields_nonce' );
	echo '<p class="bbq-intro">Every text, image and button on this page. Fields start with the design\'s content; change what you need and click <strong>Update</strong>. "Use default" puts the original back.</p>';
	bbq_render_schema( $schema, is_array( $values ) ? $values : array() );
}

add_action(
	'save_post_page',
	function ( $post_id ) {
		if ( ! isset( $_POST['bbq_fields_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['bbq_fields_nonce'] ), 'bbq_fields_save' ) ) {
			return;
		}
		if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || ! current_user_can( 'edit_page', $post_id ) || wp_is_post_revision( $post_id ) ) {
			return;
		}
		$schema = bbq_post_schema( $post_id );
		$input  = isset( $_POST['bbq'] ) && is_array( $_POST['bbq'] ) ? wp_unslash( $_POST['bbq'] ) : array(); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput -- sanitized per field below
		$values = bbq_sanitize_schema( $schema, $input );
		if ( $values ) {
			update_post_meta( $post_id, BBQ_META, $values );
		} else {
			delete_post_meta( $post_id, BBQ_META );
		}
	}
);

/* ---------- Renderer ---------- */

function bbq_render_schema( $schema, $values, $name = 'bbq' ) {
	$sections = array();
	foreach ( $schema as $field ) {
		$sections[ $field['section'] ][] = $field;
	}
	if ( ! $sections ) {
		echo '<p>This template has no editable fields.</p>';
		return;
	}
	echo '<div class="bbq-fields">';
	echo '<p class="bbq-toolbar"><button type="button" class="button-link" data-bbq-expand>Open all sections</button> · <button type="button" class="button-link" data-bbq-collapse>Close all</button></p>';
	$first = true;
	foreach ( $sections as $label => $fields ) {
		$changed = 0;
		foreach ( $fields as $f ) {
			if ( array_key_exists( $f['key'], $values ) ) {
				$changed++;
			}
		}
		echo '<details class="bbq-section"' . ( $first ? ' open' : '' ) . '><summary>' . esc_html( $label );
		if ( $changed ) {
			echo ' <span class="bbq-badge">' . esc_html( $changed ) . ' changed</span>';
		}
		echo '</summary><div class="bbq-section__body">';
		foreach ( $fields as $f ) {
			$has   = array_key_exists( $f['key'], $values );
			$value = $has ? $values[ $f['key'] ] : $f['default'];
			bbq_render_field( $f, $value, $name . '[' . $f['key'] . ']', $has );
		}
		echo '</div></details>';
		$first = false;
	}
	echo '</div>';
}

function bbq_render_field( $f, $value, $name, $changed ) {
	$type = $f['type'];
	$args = isset( $f['args'] ) ? (array) $f['args'] : array();
	echo '<div class="bbq-field bbq-field--' . esc_attr( $type ) . ( $changed ? ' is-changed' : '' ) . '">';
	echo '<div class="bbq-field__head"><label class="bbq-field__label">' . esc_html( $f['label'] ) . '</label>';
	if ( 'rows' !== $type ) {
		echo ' <button type="button" class="button-link bbq-reset" data-default="' . esc_attr( wp_json_encode( bbq_admin_display_default( $f ) ) ) . '">Use default</button>';
	}
	echo '</div>';
	bbq_render_control( $type, $value, $name, $f['default'], $args );
	if ( ! empty( $args['help'] ) ) {
		echo '<p class="description">' . esc_html( $args['help'] ) . '</p>';
	}
	echo '</div>';
}

/** Default value as shown in the form (page links resolved to real URLs, images as preview URLs). */
function bbq_admin_display_default( $f ) {
	$d = $f['default'];
	if ( 'link' === $f['type'] ) {
		$d        = array_merge( array( 'label' => '', 'url' => '', 'new_tab' => false ), (array) $d );
		$d['url'] = bbq_url( $d['url'] );
	}
	if ( 'image' === $f['type'] ) {
		return array( 'id' => '', 'src' => bbq_image_src( $d ) );
	}
	return $d;
}

function bbq_render_control( $type, $value, $name, $default, $args = array() ) {
	$ph = isset( $args['placeholder'] ) ? ' placeholder="' . esc_attr( $args['placeholder'] ) . '"' : '';
	switch ( $type ) {
		case 'textarea':
		case 'html':
			$rows = isset( $args['rows'] ) ? (int) $args['rows'] : ( strlen( (string) $value ) > 160 ? 4 : 2 );
			echo '<textarea class="widefat" rows="' . esc_attr( $rows ) . '" name="' . esc_attr( $name ) . '"' . $ph . '>' . esc_textarea( (string) $value ) . '</textarea>'; // phpcs:ignore WordPress.Security.EscapeOutput
			if ( 'html' === $type ) {
				echo '<p class="description">Simple formatting allowed: &lt;strong&gt;, &lt;em&gt;, &lt;br&gt;, &lt;a href=""&gt;.</p>';
			}
			break;
		case 'image':
			// The hidden input holds an attachment id, or the design's file name (kept as is when saving rows).
			$src = bbq_image_src( $value, 'medium' );
			echo '<div class="bbq-image" data-bbq-image>';
			echo '<img class="bbq-image__preview" src="' . esc_url( $src ) . '" alt="">';
			echo '<input type="hidden" name="' . esc_attr( $name ) . '" value="' . esc_attr( (string) $value ) . '">';
			echo '<button type="button" class="button" data-bbq-pick>Choose image</button>';
			echo '</div>';
			break;
		case 'link':
			$v = array_merge( array( 'label' => '', 'url' => '', 'new_tab' => false ), (array) $value );
			echo '<div class="bbq-link">';
			echo '<input type="text" class="regular-text" name="' . esc_attr( $name ) . '[label]" value="' . esc_attr( $v['label'] ) . '" placeholder="Button text">';
			echo '<input type="text" class="regular-text code" name="' . esc_attr( $name ) . '[url]" value="' . esc_attr( bbq_url( $v['url'] ) ) . '" placeholder="https://… or #section">';
			echo '<label><input type="checkbox" name="' . esc_attr( $name ) . '[new_tab]" value="1"' . checked( ! empty( $v['new_tab'] ), true, false ) . '> New tab</label>';
			echo '</div>';
			break;
		case 'select':
			echo '<select name="' . esc_attr( $name ) . '">';
			foreach ( (array) $args['choices'] as $k => $label ) {
				echo '<option value="' . esc_attr( $k ) . '"' . selected( (string) $value, (string) $k, false ) . '>' . esc_html( $label ) . '</option>';
			}
			echo '</select>';
			break;
		case 'toggle':
			echo '<input type="hidden" name="' . esc_attr( $name ) . '" value="0"><label><input type="checkbox" name="' . esc_attr( $name ) . '" value="1"' . checked( (bool) $value, true, false ) . '> On</label>';
			break;
		case 'rows':
			bbq_render_rows( $value, $name, (array) $args['fields'], $default );
			break;
		default:
			echo '<input type="text" class="widefat" name="' . esc_attr( $name ) . '" value="' . esc_attr( (string) $value ) . '"' . $ph . '>'; // phpcs:ignore WordPress.Security.EscapeOutput
	}
}

function bbq_render_rows( $rows, $name, $subfields, $default ) {
	$rows = is_array( $rows ) ? array_values( $rows ) : array();
	echo '<div class="bbq-rows" data-bbq-rows data-name="' . esc_attr( $name ) . '">';
	echo '<input type="hidden" name="' . esc_attr( $name ) . '[__present]" value="1">';
	echo '<div class="bbq-rows__list">';
	foreach ( $rows as $i => $row ) {
		bbq_render_row( (array) $row, $name . '[r' . $i . ']', $subfields, $i + 1 );
	}
	echo '</div>';
	// Blank row used by "Add row".
	echo '<template data-bbq-row-template>';
	bbq_render_row( array(), $name . '[__ROW__]', $subfields, '' );
	echo '</template>';
	echo '<p class="bbq-rows__actions"><button type="button" class="button" data-bbq-add>Add row</button> ';
	echo '<button type="button" class="button-link bbq-reset-rows" data-confirm="Put back the original rows? Your changes to this list will be lost when you update the page.">Use default rows</button>';
	echo '<input type="hidden" name="' . esc_attr( $name ) . '[__reset]" value="0" data-bbq-rows-reset></p>';
	echo '</div>';
}

function bbq_render_row( $row, $name, $subfields, $number ) {
	$title = '';
	foreach ( $subfields as $sub => $def ) {
		if ( in_array( $def[0], array( 'text', 'textarea' ), true ) && ! empty( $row[ $sub ] ) ) {
			$title = wp_strip_all_tags( (string) $row[ $sub ] );
			break;
		}
	}
	echo '<div class="bbq-row" data-bbq-row>';
	echo '<div class="bbq-row__bar"><span class="bbq-row__num">' . esc_html( $number ) . '</span> <span class="bbq-row__title">' . esc_html( wp_trim_words( $title, 8 ) ) . '</span>';
	echo '<span class="bbq-row__tools"><button type="button" class="button-link" data-bbq-up aria-label="Move up">↑</button> <button type="button" class="button-link" data-bbq-down aria-label="Move down">↓</button> <button type="button" class="button-link bbq-danger" data-bbq-remove>Remove</button></span></div>';
	echo '<div class="bbq-row__fields">';
	foreach ( $subfields as $sub => $def ) {
		$type  = $def[0];
		$label = isset( $def[1] ) ? $def[1] : $sub;
		$args  = 'select' === $type ? array( 'choices' => isset( $def[2] ) ? $def[2] : array() ) : array();
		$value = isset( $row[ $sub ] ) ? $row[ $sub ] : ( 'link' === $type ? array() : '' );
		echo '<div class="bbq-field bbq-field--' . esc_attr( $type ) . '"><div class="bbq-field__head"><label class="bbq-field__label">' . esc_html( $label ) . '</label></div>';
		bbq_render_control( $type, $value, $name . '[' . $sub . ']', '', $args );
		echo '</div>';
	}
	echo '</div></div>';
}

/* ---------- Sanitizing (only values that differ from the defaults are kept) ---------- */

function bbq_sanitize_schema( $schema, $input ) {
	$out = array();
	foreach ( $schema as $key => $f ) {
		$raw = array_key_exists( $key, $input ) ? $input[ $key ] : null;
		if ( 'rows' === $f['type'] ) {
			if ( ! is_array( $raw ) || empty( $raw['__present'] ) || ! empty( $raw['__reset'] ) ) {
				continue;
			}
			unset( $raw['__present'], $raw['__reset'], $raw['__ROW__'] );
			$rows = array();
			foreach ( $raw as $row ) {
				$clean = array();
				foreach ( (array) $f['args']['fields'] as $sub => $def ) {
					$args          = 'select' === $def[0] ? array( 'choices' => isset( $def[2] ) ? $def[2] : array() ) : array();
					$clean[ $sub ] = bbq_sanitize_value( $def[0], isset( $row[ $sub ] ) ? $row[ $sub ] : null, '', $args );
				}
				$rows[] = $clean;
			}
			if ( bbq_normalize_for_compare( $rows, $f ) !== bbq_normalize_for_compare( $f['default'], $f ) ) {
				$out[ $key ] = $rows;
			}
			continue;
		}
		if ( null === $raw ) {
			continue; // field not in the form (e.g. the template changed) – keep nothing
		}
		$value = bbq_sanitize_value( $f['type'], $raw, $f['default'], isset( $f['args'] ) ? (array) $f['args'] : array() );
		if ( 'image' === $f['type'] && ! $value ) {
			continue; // no image picked = design default
		}
		if ( bbq_normalize_for_compare( $value, $f ) !== bbq_normalize_for_compare( $f['default'], $f ) ) {
			$out[ $key ] = $value;
		}
	}
	return $out;
}

function bbq_sanitize_value( $type, $raw, $default, $args = array() ) {
	switch ( $type ) {
		case 'textarea':
			return str_replace( "\r\n", "\n", sanitize_textarea_field( (string) $raw ) );
		case 'html':
			return str_replace( "\r\n", "\n", wp_kses_post( (string) $raw ) );
		case 'image':
			if ( is_numeric( $raw ) ) {
				return absint( $raw );
			}
			// a design image from the theme's assets folder (file name or img/…, svg/… path)
			return str_replace( '..', '', preg_replace( '#[^A-Za-z0-9._/-]#', '', (string) $raw ) );
		case 'link':
			$raw = is_array( $raw ) ? $raw : array();
			$url = isset( $raw['url'] ) ? trim( (string) $raw['url'] ) : '';
			if ( is_array( $default ) && isset( $default['url'] ) && $url === bbq_url( $default['url'] ) ) {
				$url = $default['url']; // unchanged page link: keep the page reference, not the URL
			} elseif ( 0 !== strpos( $url, 'page:' ) && 0 !== strpos( $url, '#' ) ) {
				// A link to one of the theme's pages is stored as "page:<key>#hash", so it survives slug and domain changes.
				$url = bbq_url_to_ref( esc_url_raw( $url ) );
			} else {
				$url = sanitize_text_field( $url );
			}
			return array(
				'label'   => isset( $raw['label'] ) ? sanitize_text_field( $raw['label'] ) : '',
				'url'     => $url,
				'new_tab' => ! empty( $raw['new_tab'] ),
			);
		case 'select':
			$raw = (string) $raw;
			return isset( $args['choices'] ) && array_key_exists( $raw, $args['choices'] ) ? $raw : $default;
		case 'toggle':
			return empty( $raw ) ? 0 : 1;
		default:
			return sanitize_text_field( (string) $raw );
	}
}

/** Canonical form for "is this still the default?" checks. */
function bbq_normalize_for_compare( $value, $f ) {
	switch ( $f['type'] ) {
		case 'link':
			$v = array_merge( array( 'label' => '', 'url' => '', 'new_tab' => false ), (array) $value );
			return array( trim( $v['label'] ), bbq_url( $v['url'] ), (bool) $v['new_tab'] );
		case 'html':
			return trim( str_replace( "\r\n", "\n", wp_kses_post( (string) $value ) ) );
		case 'textarea':
			return trim( str_replace( "\r\n", "\n", (string) $value ) );
		case 'toggle':
			return (bool) $value;
		case 'rows':
			$rows = array();
			foreach ( (array) $value as $row ) {
				$r = array();
				foreach ( (array) $f['args']['fields'] as $sub => $def ) {
					$v = isset( $row[ $sub ] ) ? $row[ $sub ] : '';
					$r[ $sub ] = bbq_normalize_for_compare( $v, array( 'type' => $def[0] ) );
				}
				$rows[] = $r;
			}
			return $rows;
		default:
			return trim( (string) $value );
	}
}

/* ---------- Admin assets ---------- */

add_action(
	'admin_enqueue_scripts',
	function ( $hook ) {
		$screens = array( 'post.php', 'post-new.php', 'appearance_page_bbq-settings' );
		if ( ! in_array( $hook, $screens, true ) ) {
			return;
		}
		wp_enqueue_media();
		wp_enqueue_style( 'bbq-fields', bbq_asset( 'admin/fields.css' ), array(), bbq_ver( 'admin/fields.css' ) );
		wp_enqueue_script( 'bbq-fields', bbq_asset( 'admin/fields.js' ), array( 'jquery' ), bbq_ver( 'admin/fields.js' ), true );
	}
);
