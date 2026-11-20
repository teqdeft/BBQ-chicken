<?php
/**
 * Small helpers: asset URLs, page links, icons, the "since 1995" stamp, images.
 */

defined( 'ABSPATH' ) || exit;

/** Version for an asset: the file time while debugging (no stale browser caches), else the theme version. */
function bbq_ver( $path ) {
	$file = BBQ_DIR . '/assets/' . ltrim( $path, '/' );
	return ( defined( 'WP_DEBUG' ) && WP_DEBUG && file_exists( $file ) ) ? (string) filemtime( $file ) : BBQ_VERSION;
}

/** URL of a file in the theme's assets folder, e.g. bbq_asset( 'img/hero.jpg' ). */
function bbq_asset( $path ) {
	return BBQ_URI . '/assets/' . ltrim( $path, '/' );
}

/**
 * Permalink of the page that uses a theme template, plus an optional #hash.
 * Keys: home, news, and every key in bbq_templates() (franchise, apply, careers …).
 */
function bbq_page_url( $key, $hash = '' ) {
	static $cache = array();
	if ( ! isset( $cache[ $key ] ) ) {
		$url = '';
		if ( 'home' === $key ) {
			$url = home_url( '/' );
		} elseif ( 'news' === $key ) {
			$posts_page = (int) get_option( 'page_for_posts' );
			$url        = $posts_page ? get_permalink( $posts_page ) : home_url( '/news/' );
		} else {
			$page = bbq_find_page( $key );
			$url  = $page ? get_permalink( $page ) : home_url( '/' . $key . '/' );
		}
		$cache[ $key ] = $url;
	}
	return $cache[ $key ] . ( $hash ? '#' . ltrim( $hash, '#' ) : '' );
}

/** The page (post object) that uses page-templates/<key>.php, or null. */
function bbq_find_page( $key ) {
	$pages = get_posts(
		array(
			'post_type'      => 'page',
			'post_status'    => array( 'publish', 'private', 'draft' ),
			'meta_key'       => '_wp_page_template',
			'meta_value'     => 'page-templates/' . $key . '.php',
			'posts_per_page' => 1,
			'no_found_rows'  => true,
		)
	);
	return $pages ? $pages[0] : null;
}

/**
 * Resolve link values. "page:franchise#apply" → the Franchise page's permalink + #apply.
 * Anything else (https://…, mailto:, #find) is returned unchanged.
 */
function bbq_url( $value ) {
	$value = (string) $value;
	if ( 0 === strpos( $value, 'page:' ) ) {
		$rest = substr( $value, 5 );
		$hash = '';
		if ( false !== strpos( $rest, '#' ) ) {
			list( $rest, $hash ) = explode( '#', $rest, 2 );
		}
		return bbq_page_url( $rest, $hash );
	}
	return $value;
}

/**
 * The reverse of bbq_url(): a URL of one of the theme's pages becomes "page:<key>#hash".
 * Other URLs are returned unchanged.
 */
function bbq_url_to_ref( $url ) {
	$url = (string) $url;
	if ( '' === $url ) {
		return $url;
	}
	$hash = '';
	if ( false !== strpos( $url, '#' ) ) {
		list( $url, $hash ) = explode( '#', $url, 2 );
	}
	$path = untrailingslashit( $url );
	$keys = array_merge( array( 'home', 'news' ), bbq_page_template_keys() );
	foreach ( $keys as $key ) {
		if ( untrailingslashit( bbq_page_url( $key ) ) === $path ) {
			return 'page:' . $key . ( '' !== $hash ? '#' . $hash : '' );
		}
	}
	return $url . ( '' !== $hash ? '#' . $hash : '' );
}

/** Inline SVG icons (same set as the static site's build.js). */
function bbq_icon_svg( $name ) {
	$icons = array(
		'arrow'        => '<svg viewBox="0 0 10 10" fill="none" aria-hidden="true"><path d="M3.5 1.5 7 5 3.5 8.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>',
		'chevdown'     => '<svg class="chev" viewBox="0 0 10 10" fill="none" aria-hidden="true"><path d="M2 3.5 5 6.5 8 3.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>',
		'left'         => '<svg viewBox="0 0 16 16" fill="none" aria-hidden="true"><path d="M13 8H3m4-4L3 8l4 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
		'right'        => '<svg viewBox="0 0 16 16" fill="none" aria-hidden="true"><path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
		'sparkle'      => '<svg class="marquee__spark" viewBox="0 0 10 10" aria-hidden="true"><path d="M5 0C5.375 3 7 4.625 10 5C7 5.375 5.375 7 5 10C4.625 7 3 5.375 0 5C3 4.625 4.625 3 5 0Z" fill="currentColor"/></svg>',
		'sparkleplain' => '<svg viewBox="0 0 10 10" aria-hidden="true"><path d="M5 0C5.375 3 7 4.625 10 5C7 5.375 5.375 7 5 10C4.625 7 3 5.375 0 5C3 4.625 4.625 3 5 0Z" fill="currentColor"/></svg>',
		'instagram'    => '<svg viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="M6.667 2.083h6.666a4.583 4.583 0 0 1 4.584 4.584v6.666a4.583 4.583 0 0 1-4.584 4.584H6.667a4.583 4.583 0 0 1-4.584-4.584V6.667a4.583 4.583 0 0 1 4.584-4.584Z" stroke="currentColor" stroke-width="1.667"/><path d="M13.583 10a3.583 3.583 0 1 1-7.166 0 3.583 3.583 0 0 1 7.166 0Z" stroke="currentColor" stroke-width="1.667"/><circle cx="14.5" cy="5.5" r="1.083" fill="currentColor"/></svg>',
		'facebook'     => '<svg viewBox="0 0 20 20" aria-hidden="true"><path d="M11.25 17.5v-6.25h2.167l.333-2.5h-2.5V7.167c0-.75.25-1.25 1.333-1.25h1.334v-2.25c-.25 0-1-.084-1.917-.084-1.917 0-3.25 1.167-3.25 3.334V8.75H6.667v2.5H8.75v6.25h2.5Z" fill="currentColor"/></svg>',
		'linkedin'     => '<svg viewBox="0 0 20 20" aria-hidden="true"><path d="M5.917 7.5h-3v9.583h3V7.5ZM4.417 6.167a1.75 1.75 0 1 0 0-3.5 1.75 1.75 0 0 0 0 3.5ZM8.333 7.5h2.834v1.333c.416-.75 1.416-1.583 3-1.583 3 0 3.583 2 3.583 4.5v5.333h-3v-4.75c0-1.166 0-2.583-1.583-2.583s-1.834 1.25-1.834 2.5v4.833h-3V7.5Z" fill="currentColor"/></svg>',
		'heart'        => '<svg viewBox="0 0 14 13" aria-hidden="true"><path d="M7 12.683 6.008 11.75C2.45 8.541 0 6.325 0 3.641 0 1.6 1.575.083 3.558.083c1.109 0 2.217.525 2.975 1.342h.934C8.225.608 9.333.083 10.442.083 12.425.083 14 1.6 14 3.641c0 2.684-2.45 4.9-6.008 8.109L7 12.683Z" fill="#E31937"/></svg>',
	);
	return isset( $icons[ $name ] ) ? $icons[ $name ] : '';
}

/** Echo an icon. */
function bbq_icon( $name ) {
	echo bbq_icon_svg( $name ); // phpcs:ignore WordPress.Security.EscapeOutput -- fixed SVG markup above
}

/** The "Since 1995" stamp (yellow disc, ring of text, emblem). Each copy gets its own path id. */
function bbq_stamp_svg() {
	static $n = 0;
	$n++;
	$id = 'stampPath' . $n;
	return '<svg viewBox="0 0 184 184" aria-hidden="true"><defs><path id="' . $id . '" d="M92 32a60 60 0 1 1 0 120a60 60 0 1 1 0-120"/></defs>'
		. '<circle cx="92" cy="92" r="92" fill="#F2B33D"/><circle cx="92" cy="92" r="83" fill="none" stroke="#221E1F" stroke-width="1.5"/>'
		. '<g class="stamp__ring"><text font-family="Pretendard, sans-serif" font-weight="800" font-size="15" fill="#221E1F" letter-spacing="1.6"><textPath href="#' . $id . '" startOffset="0" textLength="372" lengthAdjust="spacing">SINCE 1995 • KOREAN FRIED CHICKEN •</textPath></text></g>'
		. '<image href="' . esc_url( bbq_asset( 'svg/stamp-emblem.svg' ) ) . '" x="63" y="62.7" width="58" height="58.7"/></svg>';
}

function bbq_stamp() {
	echo bbq_stamp_svg(); // phpcs:ignore WordPress.Security.EscapeOutput -- fixed SVG markup
}

/**
 * Image source for a field value: an attachment id (chosen in the media library) or a
 * file name / path inside assets/ (the design's default image). Returns a URL.
 */
function bbq_image_src( $value, $size = 'full' ) {
	if ( is_numeric( $value ) && (int) $value > 0 ) {
		$src = wp_get_attachment_image_url( (int) $value, $size );
		return $src ? $src : '';
	}
	$value = (string) $value;
	if ( '' === $value ) {
		return '';
	}
	if ( preg_match( '#^(https?:)?//#', $value ) ) {
		return $value;
	}
	// "hero.jpg" → assets/img/hero.jpg ; "svg/logo.svg" or "img/x.png" stay relative to assets/
	if ( false === strpos( $value, '/' ) ) {
		$value = 'img/' . $value;
	}
	return bbq_asset( $value );
}

/**
 * <img> markup for a field value. $attrs: class, alt, width, height, loading, sizes, decoding, style …
 * For media-library images WordPress adds srcset; the width/height attributes come from the file.
 */
function bbq_image_tag( $value, $attrs = array() ) {
	$attrs = array_merge( array( 'alt' => '' ), $attrs );
	if ( is_numeric( $value ) && (int) $value > 0 ) {
		$id  = (int) $value;
		$alt = trim( (string) get_post_meta( $id, '_wp_attachment_image_alt', true ) );
		if ( '' !== $alt && '' === $attrs['alt'] ) {
			$attrs['alt'] = $alt;
		}
		unset( $attrs['width'], $attrs['height'] );
		return wp_get_attachment_image( $id, isset( $attrs['size'] ) ? $attrs['size'] : 'full', false, array_diff_key( $attrs, array( 'size' => 1 ) ) );
	}
	$src = bbq_image_src( $value );
	if ( '' === $src ) {
		return '';
	}
	unset( $attrs['size'] );
	$html = '<img src="' . esc_url( $src ) . '"';
	foreach ( $attrs as $name => $val ) {
		if ( null === $val || false === $val ) {
			continue;
		}
		$html .= ' ' . esc_attr( $name ) . '="' . esc_attr( $val ) . '"';
	}
	return $html . '>';
}

/** href="…" plus target/rel for a link value from bbq_link() / a repeater link. */
function bbq_link_attrs( $link, $extra = '' ) {
	$url = isset( $link['url'] ) ? bbq_url( $link['url'] ) : '';
	$out = ' href="' . esc_url( $url ) . '"';
	if ( ! empty( $link['new_tab'] ) ) {
		$out .= ' target="_blank" rel="noopener"';
	}
	// Links to the application page open the application pop-up (assets/js/apply.js).
	if ( $url && untrailingslashit( strtok( $url, '#' ) ) === untrailingslashit( bbq_page_url( 'apply' ) ) ) {
		$out .= ' data-apply';
	}
	echo $out . $extra; // phpcs:ignore WordPress.Security.EscapeOutput -- escaped above
}
