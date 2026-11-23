<?php
/**
 * News = WordPress posts. The article text is the post content (block editor, photos with
 * captions included); the featured image is the card/hero photo. A "News card" box adds the
 * extras the design needs (card date line, outside link, placeholder/no-link cards, sources …).
 *
 * Card types (see bbq_news_card_type()):
 *   internal     links to the article on this site
 *   external     links to an outside article (new tab)        – "Link to an outside article"
 *   static       not clickable, keeps its photo                – "No link yet"
 *   placeholder  not clickable, grey image                     – "Placeholder card"
 */

defined( 'ABSPATH' ) || exit;

/** Fields of the "News card" box on posts. */
function bbq_news_schema() {
	$f = function ( $key, $type, $label, $default = '', $args = array(), $section = 'News card' ) {
		return array(
			'key'     => $key,
			'type'    => $type,
			'label'   => $label,
			'default' => $default,
			'args'    => $args,
			'section' => $section,
		);
	};
	$article = 'Article page';
	return array(
		'card_meta'    => $f( 'card_meta', 'text', 'Date line on cards', '', array( 'placeholder' => 'e.g. 8 Dec 2025 · Europe (empty = the post date)' ) ),
		'external_url' => $f( 'external_url', 'text', 'Link to an outside article (https://…)', '', array( 'help' => 'If set, the news cards open this link in a new tab instead of the article on this site.' ) ),
		'no_link'      => $f( 'no_link', 'toggle', 'No link yet (card keeps its photo but is not clickable)', 0 ),
		'placeholder'  => $f( 'placeholder', 'toggle', 'Placeholder card (not clickable, grey image)', 0 ),
		'date_line'    => $f( 'date_line', 'text', 'Date line on the featured story and the article page', '', array( 'placeholder' => 'e.g. 8 December 2025 · Europe (empty = the post date)' ), $article ),
		'label'        => $f( 'label', 'text', 'Label above the title (article page)', '', array( 'placeholder' => 'e.g. Press / Europe (empty = the default label set on the News page)' ), $article ),
		'sources'      => $f( 'sources', 'html', 'Sources line (below the article)', '', array(), $article ),
		'full_article' => $f( 'full_article', 'link', '"Read the full article" button (below the article)', array( 'label' => '', 'url' => '', 'new_tab' => true ), array( 'help' => 'Shown when the URL is set. Photos and their captions go into the article text (Image block).' ), $article ),
	);
}

/** A news field of a post (with the schema default). */
function bbq_news_field( $post_id, $key ) {
	$schema = bbq_news_schema();
	// ACF "News card" fields (post meta news_<key>), else the old box's values
	if ( isset( $schema[ $key ] ) ) {
		$found = false;
		$value = bbq_acf_value( (int) $post_id, 'news_' . $key, $schema[ $key ]['type'], (array) $schema[ $key ]['args'], $found );
		if ( $found ) {
			return $value;
		}
	}
	$values = get_post_meta( (int) $post_id, BBQ_META, true );
	if ( is_array( $values ) && array_key_exists( $key, $values ) ) {
		$value = $values[ $key ];
		if ( 'link' === $schema[ $key ]['type'] && is_array( $value ) ) {
			$value = array_merge( $schema[ $key ]['default'], $value );
		}
		return $value;
	}
	return isset( $schema[ $key ] ) ? $schema[ $key ]['default'] : '';
}

/** Card date line: the field, else the post date. */
function bbq_news_card_meta( $post_id ) {
	$meta = trim( (string) bbq_news_field( $post_id, 'card_meta' ) );
	return '' !== $meta ? $meta : get_the_date( 'j M Y', $post_id );
}

/** Long date line (featured story, article header): the field, else the post date. */
function bbq_news_date_line( $post_id ) {
	$line = trim( (string) bbq_news_field( $post_id, 'date_line' ) );
	return '' !== $line ? $line : get_the_date( 'j F Y', $post_id );
}

/** internal | external | static | placeholder */
function bbq_news_card_type( $post_id ) {
	if ( bbq_news_field( $post_id, 'placeholder' ) ) {
		return 'placeholder';
	}
	if ( bbq_news_field( $post_id, 'no_link' ) ) {
		return 'static';
	}
	return trim( (string) bbq_news_field( $post_id, 'external_url' ) ) ? 'external' : 'internal';
}

/** Where a news card links to: array( url, new_tab ) — or null for cards without a link (placeholder / no link yet). */
function bbq_news_card_link( $post_id ) {
	$type = bbq_news_card_type( $post_id );
	if ( 'placeholder' === $type || 'static' === $type ) {
		return null;
	}
	if ( 'external' === $type ) {
		return array( 'url' => trim( (string) bbq_news_field( $post_id, 'external_url' ) ), 'new_tab' => true );
	}
	return array( 'url' => get_permalink( $post_id ), 'new_tab' => false );
}

/** Post title without texturize (the design uses the characters as typed), escaped. */
function bbq_news_title( $post ) {
	$post = get_post( $post );
	return $post ? esc_html( $post->post_title ) : '';
}

/**
 * Print a news card (the static site's .news-card markup; used on Home, News and the article page).
 * $args: 'new_tab_text' – screen-reader text after the titles of outside links ("(opens in a new tab)").
 */
function bbq_news_card( $post, $args = array() ) {
	$post = get_post( $post );
	if ( ! $post ) {
		return;
	}
	$args  = array_merge( array( 'new_tab_text' => '(opens in a new tab)' ), $args );
	$type  = bbq_news_card_type( $post->ID );
	$link  = bbq_news_card_link( $post->ID );
	$thumb = 'placeholder' === $type ? 0 : (int) get_post_thumbnail_id( $post );
	$title = bbq_news_title( $post );
	if ( $link && $link['new_tab'] && '' !== trim( (string) $args['new_tab_text'] ) ) {
		$title .= '<span class="sr-only"> ' . esc_html( trim( (string) $args['new_tab_text'] ) ) . '</span>';
	}

	if ( $link ) {
		echo '<a class="news-card" href="' . esc_url( $link['url'] ) . '"' . ( $link['new_tab'] ? ' target="_blank" rel="noopener"' : '' ) . ">\n";
	} else {
		echo "<div class=\"news-card news-card--static\">\n";
	}
	if ( $thumb ) {
		echo '  <div class="news-card__img">' . wp_get_attachment_image( $thumb, 'bbq-card', false, array( 'loading' => 'lazy' ) ) . "</div>\n";
	} else {
		echo "  <div class=\"news-card__img news-card__img--placeholder\" aria-hidden=\"true\"></div>\n";
	}
	echo '  <div class="news-card__meta"><span class="news-card__date">' . esc_html( bbq_news_card_meta( $post->ID ) ) . '</span><h3 class="news-card__title">' . $title . "</h3></div>\n"; // phpcs:ignore WordPress.Security.EscapeOutput -- escaped above
	echo $link ? "</a>\n" : "</div>\n";
}

/**
 * The featured story on the News page: the latest sticky post, else the latest post that is
 * not a placeholder. 0 if there is none.
 */
function bbq_news_featured_id() {
	static $id = null;
	if ( null !== $id ) {
		return $id;
	}
	$id     = 0;
	$args   = array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'ignore_sticky_posts' => true,
		'numberposts'         => 20,
		'orderby'             => 'date',
		'order'               => 'DESC',
	);
	$sticky = array_filter( array_map( 'intval', (array) get_option( 'sticky_posts', array() ) ) );
	$tries  = $sticky ? array( array( 'post__in' => $sticky ), array() ) : array( array() );
	foreach ( $tries as $extra ) {
		foreach ( get_posts( $args + $extra ) as $p ) {
			if ( 'placeholder' !== bbq_news_card_type( $p->ID ) ) {
				$id = (int) $p->ID;
				return $id;
			}
		}
	}
	return $id;
}

/**
 * Latest posts for card lists (related articles, home), placeholders left out.
 * $exclude: post ids to leave out.
 */
function bbq_news_latest( $count = 3, $exclude = array() ) {
	$out = array();
	$q   = get_posts(
		array(
			'post_type'           => 'post',
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true,
			'post__not_in'        => array_map( 'intval', (array) $exclude ),
			'numberposts'         => $count + 10,
			'orderby'             => 'date',
			'order'               => 'DESC',
		)
	);
	foreach ( $q as $p ) {
		if ( 'placeholder' === bbq_news_card_type( $p->ID ) ) {
			continue;
		}
		$out[] = $p;
		if ( count( $out ) >= $count ) {
			break;
		}
	}
	return $out;
}

/** Reading time in minutes (≈ 200 words a minute, at least 1). */
function bbq_news_read_minutes( $post ) {
	$post = get_post( $post );
	if ( ! $post ) {
		return 1;
	}
	$words = str_word_count( wp_strip_all_tags( strip_shortcodes( $post->post_content ) ) );
	return max( 1, (int) ceil( $words / 200 ) );
}

/* ---------- Front end ---------- */

/**
 * News page: the featured story sits above the grid, so the grid (main query) leaves it out and
 * does not move sticky posts to the top. Pagination then counts the grid cards only.
 */
add_action(
	'pre_get_posts',
	function ( $q ) {
		if ( is_admin() || ! $q->is_main_query() || ! $q->is_home() || $q->is_feed() ) {
			return;
		}
		$q->set( 'ignore_sticky_posts', true );
		$featured = bbq_news_featured_id();
		if ( $featured ) {
			$q->set( 'post__not_in', array( $featured ) );
		}
	}
);

/** Article text and titles are printed as typed (no curly quotes), like every other text of the design. */
add_action(
	'template_redirect',
	function () {
		if ( is_singular( 'post' ) ) {
			remove_filter( 'the_content', 'wptexturize' );
		}
	}
);

/** Placeholder posts are not real articles yet: keep their pages out of search engines. */
add_filter(
	'wp_robots',
	function ( $robots ) {
		if ( is_singular( 'post' ) && 'placeholder' === bbq_news_card_type( get_queried_object_id() ) ) {
			$robots['noindex'] = true;
		}
		return $robots;
	}
);

/* ---------- Admin: the "News card" box ---------- */

add_action(
	'add_meta_boxes_post',
	function () {
		if ( bbq_acf_ready() ) {
			return; // the ACF "News card" group (inc/acf-fields.php)
		}
		add_meta_box( 'bbq-news', 'News card', 'bbq_news_box', 'post', 'normal', 'high' );
	}
);

function bbq_news_box( $post ) {
	$values = get_post_meta( $post->ID, BBQ_META, true );
	wp_nonce_field( 'bbq_news_save', 'bbq_news_nonce' );
	echo '<p class="bbq-intro">The photo on the cards is the post\'s featured image, the card text the post title. The article text is the post content. The sticky post ("Stick to the top of the blog") is the featured story on the News page.</p>';
	bbq_render_schema( bbq_news_schema(), is_array( $values ) ? $values : array() );
}

add_action(
	'save_post_post',
	function ( $post_id ) {
		if ( ! isset( $_POST['bbq_news_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['bbq_news_nonce'] ), 'bbq_news_save' ) ) {
			return;
		}
		if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || ! current_user_can( 'edit_post', $post_id ) || wp_is_post_revision( $post_id ) ) {
			return;
		}
		$input  = isset( $_POST['bbq'] ) && is_array( $_POST['bbq'] ) ? wp_unslash( $_POST['bbq'] ) : array(); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput -- sanitized per field
		$values = bbq_sanitize_schema( bbq_news_schema(), $input );
		if ( $values ) {
			update_post_meta( $post_id, BBQ_META, $values );
		} else {
			delete_post_meta( $post_id, BBQ_META );
		}
	}
);
