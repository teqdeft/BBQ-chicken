<?php
/**
 * Page registry: which theme template each page uses, its body class, its page stylesheet,
 * the nav item it highlights and its default SEO title/description (from the static site).
 */

defined( 'ABSPATH' ) || exit;

function bbq_templates() {
	return array(
		'home'            => array(
			'title'  => 'Home',
			'slug'   => '',
			'body'   => 'page-home',
			'css'    => '',
			'active' => '',
			'seo'    => 'bb.q Chicken Europe – Korean fried chicken, now in Europe',
			'desc'   => 'BLT Global Brands brings bb.q Chicken, Korea\'s favourite fried chicken, to Europe. Order now, find a restaurant or apply to become a franchise partner.',
		),
		'franchise'       => array(
			'title'  => 'Franchise',
			'slug'   => 'franchise',
			'body'   => 'page-franchise',
			'css'    => 'franchise',
			'active' => 'franchise',
			'seo'    => 'Franchise – bring bb.q Chicken to your market | bb.q Chicken Europe',
			'desc'   => 'Join the bb.q Chicken franchise network in Europe. We\'re looking for experienced operators to open bb.q restaurants across the continent. Submit your application.',
		),
		'apply'           => array(
			'title'  => 'Submit your application',
			'slug'   => 'apply',
			'body'   => 'page-apply',
			'css'    => 'apply',
			'active' => '',
			'seo'    => 'Submit your application – bb.q Chicken franchise | bb.q Chicken Europe',
			'desc'   => 'Apply to become a bb.q Chicken franchise partner in Europe. Tell us who you are and where you\'d like to grow. Our expansion team reads every application personally.',
		),
		'apply-thank-you' => array(
			'title'   => 'Thank you',
			'slug'    => 'thank-you',
			'parent'  => 'apply',
			'body'    => 'page-apply-thanks',
			'css'     => 'apply',
			'active'  => '',
			'noindex' => true,
			'seo'     => 'Thank you – application received | bb.q Chicken Europe',
			'desc'    => 'Thank you for your interest in bb.q Chicken. Our European team reviews every enquiry personally and will contact you within 5 working days.',
		),
		'discover'        => array(
			'title'  => 'Discover bb.q',
			'slug'   => 'discover',
			'body'   => 'page-discover',
			'css'    => 'discover',
			'active' => 'discover',
			'seo'    => 'Discover bb.q – Best of the Best Quality, since 1995 – bb.q Chicken Europe',
			'desc'   => 'bb.q stands for Best of the Best Quality. From one small restaurant in Korea in 1995 to 3,500+ restaurants worldwide, and soon across Europe.',
		),
		'menu'            => array(
			'title'  => 'The menu',
			'slug'   => 'menu',
			'body'   => 'page-menu',
			'css'    => 'menu',
			'active' => 'discover',
			'seo'    => 'The menu – bb.q Chicken Europe',
			'desc'   => 'Golden, crispy and sauced your way: Real Korean Fried Chicken, tenders, burgers, wraps and bowls, nine sauces and Korean sides.',
		),
		'about'           => array(
			'title'  => 'About BLT Global Brands',
			'slug'   => 'about',
			'body'   => 'page-about',
			'css'    => 'about',
			'active' => '',
			'seo'    => 'About BLT Global Brands – bb.q Chicken Europe',
			'desc'   => 'BLT Global Brands is the strategic master partner and operating force bringing bb.q Chicken to European markets. Meet our values and our team.',
		),
		'real-estate'     => array(
			'title'  => 'Real estate',
			'slug'   => 'real-estate',
			'body'   => 'page-realestate',
			'css'    => 'real-estate',
			'active' => 'realestate',
			'seo'    => 'Real estate – bb.q Chicken Europe',
			'desc'   => 'Got premises that suit bb.q? Landlords, agents and developers: tell us about your site for a bb.q Express restaurant or dark kitchen in Europe.',
		),
		'careers'         => array(
			'title'  => 'Careers',
			'slug'   => 'careers',
			'body'   => 'page-careers',
			'css'    => 'careers',
			'active' => 'careers',
			'seo'    => 'Careers – bb.q Chicken Europe',
			'desc'   => 'Grow with bb.q in Europe. New restaurants, new markets and plenty of room to grow, for cooks, managers and the people behind the scenes.',
		),
		'contact'         => array(
			'title'  => 'Contact',
			'slug'   => 'contact',
			'body'   => 'page-contact',
			'css'    => 'contact',
			'active' => '',
			'seo'    => 'Contact – bb.q Chicken Europe',
			'desc'   => 'Get in touch with BLT Global Brands, the team bringing bb.q Chicken to Europe. Franchise, real estate, press or any other question.',
		),
		'legal'           => array(
			'title'  => 'Privacy policy',
			'slug'   => 'privacy-policy',
			'body'   => 'page-legal',
			'css'    => 'legal',
			'active' => '',
			'editor' => true, // the policy text is the page content (block editor)
			'seo'    => 'Privacy policy – bb.q Chicken Europe',
			'desc'   => 'Privacy policy for the bb.q Chicken Europe website, operated by BLT Global Brands.',
		),
		// Not page templates: the posts page (News) and single posts (news articles).
		'news'            => array(
			'title'  => 'News',
			'slug'   => 'news',
			'body'   => 'page-news',
			'css'    => 'news',
			'active' => 'discover',
			'seo'    => 'News – bb.q Chicken Europe',
			'desc'   => 'Openings, campaigns and news from bb.q Chicken in Europe and around the world.',
		),
		'news-article'    => array(
			'title'  => 'News article',
			'body'   => 'page-news-article',
			'css'    => 'news-article',
			'active' => 'discover',
			'seo'    => '',
			'desc'   => '',
		),
	);
}

/** Page templates offered in the page editor's "Template" list (everything except news + home). */
function bbq_page_template_keys() {
	return array( 'franchise', 'apply', 'apply-thank-you', 'discover', 'menu', 'about', 'real-estate', 'careers', 'contact', 'legal' );
}

/** Template key for a page/post id (used in the admin as well as on the front end). */
function bbq_template_key_for( $post_id ) {
	$post_id = (int) $post_id;
	if ( ! $post_id ) {
		return '';
	}
	if ( $post_id === (int) get_option( 'page_on_front' ) ) {
		return 'home';
	}
	if ( $post_id === (int) get_option( 'page_for_posts' ) ) {
		return 'news';
	}
	if ( 'post' === get_post_type( $post_id ) ) {
		return 'news-article';
	}
	$tpl = (string) get_page_template_slug( $post_id );
	if ( preg_match( '#^page-templates/([a-z0-9-]+)\.php$#', $tpl, $m ) ) {
		return $m[1];
	}
	return '';
}

/** Template key of the current front-end view. */
function bbq_current_key() {
	if ( is_front_page() ) {
		return 'home';
	}
	if ( is_home() ) {
		return 'news';
	}
	if ( is_singular( 'post' ) ) {
		return 'news-article';
	}
	if ( is_page() ) {
		return bbq_template_key_for( get_queried_object_id() );
	}
	return '';
}

/** Settings for the current view (empty array if the view isn't one of ours). */
function bbq_current_template() {
	$key  = bbq_current_key();
	$list = bbq_templates();
	return $key && isset( $list[ $key ] ) ? $list[ $key ] + array( 'key' => $key ) : array();
}

/** Load templates/<key>.php (the page content). Used by the thin page templates. */
function bbq_render( $key ) {
	$file = BBQ_DIR . '/templates/' . $key . '.php';
	if ( file_exists( $file ) ) {
		include $file;
	}
}

/* ---------- Theme setup ---------- */

add_action(
	'after_setup_theme',
	function () {
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
		add_theme_support( 'responsive-embeds' );
		add_image_size( 'bbq-card', 960, 0, false );
	}
);

/** Body classes from the registry (page-home, page-franchise …). */
add_filter(
	'body_class',
	function ( $classes ) {
		$t = bbq_current_template();
		if ( $t && ! empty( $t['body'] ) ) {
			$classes[] = $t['body'];
		}
		return $classes;
	}
);

/* ---------- Styles and scripts (the static site's files, unchanged) ---------- */

add_action(
	'wp_enqueue_scripts',
	function () {
		$css = function ( $handle, $path, $deps ) {
			wp_enqueue_style( $handle, bbq_asset( $path ), $deps, bbq_ver( $path ) );
		};
		$js  = function ( $handle, $path ) {
			wp_enqueue_script( $handle, bbq_asset( $path ), array(), bbq_ver( $path ), array( 'strategy' => 'defer', 'in_footer' => true ) );
		};
		wp_enqueue_style( 'pretendard', 'https://cdn.jsdelivr.net/npm/pretendard@1.3.9/dist/web/static/pretendard.min.css', array(), null );
		$css( 'bbq-styles', 'css/styles.css', array( 'pretendard' ) );
		$css( 'bbq-apply-modal', 'css/apply-modal.css', array( 'bbq-styles' ) );
		$css( 'bbq-motion', 'css/motion.css', array( 'bbq-styles' ) );
		$t = bbq_current_template();
		if ( $t && ! empty( $t['css'] ) ) {
			$css( 'bbq-page', 'css/pages/' . $t['css'] . '.css', array( 'bbq-motion' ) );
		}
		// WordPress-only adjustments (Contact Form 7 output, admin bar, editor content).
		$css( 'bbq-wp', 'css/wp.css', array( 'bbq-motion' ) );

		$js( 'bbq-main', 'js/main.js' );
		$js( 'bbq-apply', 'js/apply.js' );
		$js( 'bbq-motion', 'js/motion.js' );
		$js( 'bbq-map', 'js/map.js' );
		wp_localize_script(
			'bbq-apply',
			'bbqSite',
			array(
				'applyUrl'    => bbq_page_url( 'apply' ),
				'thankYouUrl' => bbq_page_url( 'apply-thank-you' ),
			)
		);
	}
);

/* ---------- SEO title, description, noindex ---------- */

/** SEO title: the page's "SEO title" field, else the registry default, else WordPress's own. */
add_filter(
	'pre_get_document_title',
	function ( $title ) {
		$t = bbq_current_template();
		if ( ! $t ) {
			return $title;
		}
		$id     = get_queried_object_id();
		$custom = $id ? bbq_meta_value( $id, 'seo_title' ) : '';
		if ( $custom ) {
			return $custom;
		}
		if ( 'news-article' === $t['key'] ) {
			// The raw title keeps the design's straight apostrophes ("bb.q's").
			return get_post_field( 'post_title', $id, 'raw' ) . ' – News – ' . get_bloginfo( 'name' );
		}
		return $t['seo'] ? $t['seo'] : $title;
	}
);

add_action(
	'wp_head',
	function () {
		$t = bbq_current_template();
		if ( ! $t ) {
			return;
		}
		$id   = get_queried_object_id();
		$desc = $id ? bbq_meta_value( $id, 'seo_description' ) : '';
		if ( ! $desc && 'news-article' === $t['key'] && $id ) {
			$desc = get_the_excerpt( $id );
		}
		if ( ! $desc ) {
			$desc = $t['desc'];
		}
		if ( $desc ) {
			echo '<meta name="description" content="' . esc_attr( wp_strip_all_tags( $desc ) ) . '">' . "\n";
		}
		echo '<meta name="theme-color" content="#221E1F">' . "\n";
	},
	1
);

add_filter(
	'wp_robots',
	function ( $robots ) {
		$t = bbq_current_template();
		if ( $t && ! empty( $t['noindex'] ) ) {
			$robots['noindex'] = true;
		}
		return $robots;
	}
);

/** Favicon from the theme when no Site Icon is set in the Customizer. */
add_action(
	'wp_head',
	function () {
		if ( ! has_site_icon() ) {
			echo '<link rel="icon" href="' . esc_url( bbq_asset( 'svg/favicon.svg' ) ) . '" type="image/svg+xml">' . "\n";
		}
	},
	2
);

/* Keep the front end lean: no emoji script, no block library CSS on pages built from fields. */
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
add_action(
	'wp_enqueue_scripts',
	function () {
		$t = bbq_current_template();
		if ( $t && ! in_array( $t['key'], array( 'legal', 'news-article' ), true ) ) {
			wp_dequeue_style( 'wp-block-library' );
			wp_dequeue_style( 'global-styles' );
			wp_dequeue_style( 'classic-theme-styles' );
		}
	},
	100
);
