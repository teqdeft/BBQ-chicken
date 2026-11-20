<?php
/**
 * Editable fields.
 *
 * Templates print content through these functions, giving each piece a key, the design's
 * content as the default and a label for the editor:
 *
 *   bbq_section( 'Hero' );
 *   <h1><?php bbq_text( 'hero_title', 'Korea\'s favourite fried chicken', 'Heading' ); ?></h1>
 *   <p><?php bbq_html( 'hero_lead', 'Double-fried for <strong>real crunch</strong>.', 'Intro text' ); ?></p>
 *   <?php bbq_image( 'hero_img', 'cut-bucket-09.png', 'Image', array( 'alt' => '', 'loading' => 'lazy' ) ); ?>
 *   <?php $cta = bbq_link( 'hero_cta', array( 'label' => 'Order now', 'url' => 'page:home#find' ), 'Button' ); ?>
 *   <a class="btn"<?php bbq_link_attrs( $cta ); ?>><?php bbq_e( $cta['label'] ); ?></a>
 *   <?php foreach ( bbq_rows( 'cards', 'Cards', array( 'title' => array( 'text', 'Title' ) ), array( array( 'title' => 'One' ) ) ) as $row ) : ?>
 *     <h3><?php bbq_e( $row['title'] ); ?></h3>
 *   <?php endforeach; ?>
 *
 * Front end: each call returns/prints the saved value, or the default if it was never changed.
 * Admin: the page's template is run once in "schema mode"; every call registers its field, and
 * the edit screen builds the form from that list (inc/fields-admin.php). Only values that differ
 * from the default are stored, so design defaults keep following theme updates.
 *
 * Storage: post meta "_bbq_fields" for pages, the option "bbq_site" for header/footer fields.
 */

defined( 'ABSPATH' ) || exit;

const BBQ_META   = '_bbq_fields';
const BBQ_OPTION = 'bbq_site';

$GLOBALS['bbq_ctx'] = null;

/** Start a field context: values of a post (int id) or of the site options ('options'). */
function bbq_ctx_start( $store, $schema_mode = false ) {
	if ( 'options' === $store ) {
		$values = get_option( BBQ_OPTION, array() );
	} else {
		$values = $store ? get_post_meta( (int) $store, BBQ_META, true ) : array();
	}
	$GLOBALS['bbq_ctx'] = array(
		'store'       => $store,
		'values'      => is_array( $values ) ? $values : array(),
		'schema_mode' => (bool) $schema_mode,
		'schema'      => array(),
		'section'     => 'Content',
	);
}

function &bbq_ctx() {
	if ( null === $GLOBALS['bbq_ctx'] ) {
		bbq_ctx_start( get_queried_object_id() );
	}
	return $GLOBALS['bbq_ctx'];
}

function bbq_schema_mode() {
	return ! empty( $GLOBALS['bbq_ctx']['schema_mode'] );
}

/** Group the following fields under a heading in the editor. */
function bbq_section( $label ) {
	$c            = &bbq_ctx();
	$c['section'] = $label;
}

/** Register a field (schema mode) and return its value (saved, else default). */
function bbq_field( $key, $type, $label, $default, $args = array() ) {
	$c = &bbq_ctx();
	if ( $c['schema_mode'] && ! isset( $c['schema'][ $key ] ) ) {
		$c['schema'][ $key ] = array(
			'key'     => $key,
			'type'    => $type,
			'label'   => $label ? $label : $key,
			'default' => $default,
			'args'    => $args,
			'section' => $c['section'],
		);
	}
	if ( array_key_exists( $key, $c['values'] ) ) {
		$value = $c['values'][ $key ];
		if ( 'link' === $type && is_array( $value ) ) {
			return array_merge( array( 'label' => '', 'url' => '', 'new_tab' => false ), (array) $default, $value );
		}
		return $value;
	}
	return $default;
}

/* ---------- Typed helpers ---------- */

/** Plain text (one line). Prints escaped. */
function bbq_text( $key, $default, $label = '', $args = array() ) {
	echo esc_html( bbq_field( $key, 'text', $label, $default, $args ) );
}

/** Plain text (several lines). Prints escaped; line breaks are kept by the page's CSS where needed. */
function bbq_textarea( $key, $default, $label = '', $args = array() ) {
	echo esc_html( bbq_field( $key, 'textarea', $label, $default, $args ) );
}

/** Text with simple markup (strong, em, br, a, span). Prints through wp_kses_post. */
function bbq_html( $key, $default, $label = '', $args = array() ) {
	echo wp_kses_post( bbq_field( $key, 'html', $label, $default, $args ) );
}

/** Return a text value without printing (for attributes, conditions …). */
function bbq_get( $key, $default = '', $label = '', $type = 'text', $args = array() ) {
	return bbq_field( $key, $type, $label, $default, $args );
}

/** Image: prints <img>. $default is a file in assets/img (or assets/svg/…); editors pick from the media library. */
function bbq_image( $key, $default, $label = '', $attrs = array() ) {
	echo bbq_image_tag( bbq_field( $key, 'image', $label, $default ), $attrs ); // phpcs:ignore WordPress.Security.EscapeOutput -- built with esc_* in bbq_image_tag
}

/** Image URL (for CSS backgrounds, data attributes …). */
function bbq_image_url( $key, $default, $label = '', $size = 'full' ) {
	return bbq_image_src( bbq_field( $key, 'image', $label, $default ), $size );
}

/**
 * Link / button: returns array( 'label' => …, 'url' => …, 'new_tab' => bool ).
 * Print with bbq_link_attrs( $link ) (href + target) and bbq_e( $link['label'] ).
 * Default URLs can point at theme pages: "page:franchise#apply", "page:home#find".
 */
function bbq_link( $key, $default, $label = '' ) {
	$default = array_merge( array( 'label' => '', 'url' => '', 'new_tab' => false ), (array) $default );
	return bbq_field( $key, 'link', $label, $default );
}

/** Choice from a list. $choices: array( value => label ). */
function bbq_select( $key, $default, $label, $choices ) {
	$value = bbq_field( $key, 'select', $label, $default, array( 'choices' => $choices ) );
	return array_key_exists( $value, $choices ) ? $value : $default;
}

/** On/off switch (e.g. "Show this section"). */
function bbq_toggle( $key, $default, $label = '' ) {
	return (bool) bbq_field( $key, 'toggle', $label, $default ? 1 : 0 );
}

/**
 * Repeatable rows (cards, list items, FAQ …). Editors can add, remove and reorder rows.
 * $subfields: array( 'title' => array( 'text', 'Title' ), 'img' => array( 'image', 'Photo' ),
 *                    'style' => array( 'select', 'Colour', array( 'red' => 'Red', … ) ), 'cta' => array( 'link', 'Button' ) )
 * Sub-field types: text, textarea, html, image, link, select, toggle.
 * Returns the rows; every row has every sub-field key.
 */
function bbq_rows( $key, $label, $subfields, $defaults ) {
	$rows = bbq_field( $key, 'rows', $label, $defaults, array( 'fields' => $subfields ) );
	if ( ! is_array( $rows ) ) {
		return array();
	}
	$blank = array();
	foreach ( $subfields as $sub => $def ) {
		$blank[ $sub ] = 'link' === $def[0] ? array( 'label' => '', 'url' => '', 'new_tab' => false ) : '';
	}
	$out = array();
	foreach ( $rows as $row ) {
		$row = array_merge( $blank, (array) $row );
		foreach ( $subfields as $sub => $def ) {
			if ( 'link' === $def[0] ) {
				$row[ $sub ] = array_merge( $blank[ $sub ], (array) $row[ $sub ] );
			}
		}
		$out[] = $row;
	}
	return $out;
}

/* ---------- Printing helpers for row values ---------- */

/** Print escaped text. */
function bbq_e( $value ) {
	echo esc_html( (string) $value );
}

/** Print text with simple markup. */
function bbq_k( $value ) {
	echo wp_kses_post( (string) $value );
}

/** Print an image from a row value. */
function bbq_img( $value, $attrs = array() ) {
	echo bbq_image_tag( $value, $attrs ); // phpcs:ignore WordPress.Security.EscapeOutput
}

/* ---------- Reading stored values outside templates ---------- */

/** A stored value of a page (no default handling), e.g. the SEO fields. */
function bbq_meta_value( $post_id, $key ) {
	$values = get_post_meta( (int) $post_id, BBQ_META, true );
	return is_array( $values ) && isset( $values[ $key ] ) ? $values[ $key ] : '';
}

/* ---------- Running templates ---------- */

/**
 * Render templates/<key>.php with the fields of $post_id (defaults to the current page).
 * News articles share one set of layout fields, stored on the posts page.
 */
function bbq_render_fields( $key, $post_id = null ) {
	if ( null === $post_id ) {
		$post_id = 'news-article' === $key ? (int) get_option( 'page_for_posts' ) : get_queried_object_id();
		if ( 'home' === $key ) {
			$post_id = (int) get_option( 'page_on_front' );
		}
	}
	bbq_ctx_start( $post_id );
	bbq_render( $key );
}

/** Render a site-wide part (header/footer) with the site options as its field store. */
function bbq_render_site_part( $part ) {
	$saved = $GLOBALS['bbq_ctx'];
	bbq_ctx_start( 'options' );
	bbq_render( $part );
	$GLOBALS['bbq_ctx'] = $saved;
}

/**
 * Run templates in schema mode and return their fields (in order, grouped by section).
 * $keys: one template key or several (e.g. the posts page edits 'news' and 'news-article').
 */
function bbq_collect_schema( $keys, $store ) {
	$saved  = $GLOBALS['bbq_ctx'];
	$schema = array();
	foreach ( (array) $keys as $key ) {
		$file = BBQ_DIR . '/templates/' . $key . '.php';
		if ( ! file_exists( $file ) ) {
			continue;
		}
		bbq_ctx_start( $store, true );
		ob_start();
		try {
			include $file;
		} catch ( \Throwable $e ) {
			// A template that can't fully run in the admin still yields the fields it reached.
			error_log( 'bbq schema: ' . $key . ': ' . $e->getMessage() ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions
		}
		ob_end_clean();
		$schema = array_merge( $schema, $GLOBALS['bbq_ctx']['schema'] );
	}
	$GLOBALS['bbq_ctx'] = $saved;
	return $schema;
}
