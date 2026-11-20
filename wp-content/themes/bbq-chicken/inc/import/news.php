<?php
/**
 * News posts created by the bb.q setup (inc/importer.php → bbq_setup_news()): every story of the
 * static News page (html-backup/src/pages/news.html), the Spain story with the full article of
 * news-article.html.
 *
 * Dates: the News page lists the posts newest first, so the dates follow the static page's order
 * (Madrid, UK, FC Barcelona, afternoon tea, Times Square, Yelp); the Spain story is the sticky
 * (featured) post. The latest three real articles (Home page) are Spain, FC Barcelona and afternoon tea.
 *
 * Photos are added to the media library first, with the design's alt texts (the importer then
 * reuses them as featured images), so the Spain article can show its photo as an Image block.
 */

defined( 'ABSPATH' ) || exit;

return ( function () {
	$exists = function ( $slug ) {
		return (bool) get_page_by_path( $slug, OBJECT, 'post' );
	};
	// Media library copy of a theme image (once), with its alt text; 0 if the post already exists.
	$media = function ( $slug, $file, $alt ) use ( $exists ) {
		return $exists( $slug ) || ! function_exists( 'bbq_setup_media' ) ? 0 : (int) bbq_setup_media( $file, 0, $alt );
	};

	$spain = 'spain-is-bbqs-door-to-europe';

	// The article photo as an Image block (media library image, or the theme file as a fallback).
	$hq     = $media( $spain, 'news-europe-hq.jpg', 'Guests at the inauguration of the bb.q Europe headquarters' );
	$hq_url = $hq ? wp_get_attachment_url( $hq ) : bbq_asset( 'img/news-europe-hq.jpg' );
	$figure = '<!-- wp:image ' . ( $hq ? '{"id":' . $hq . ',"sizeSlug":"full","linkDestination":"none"}' : '{"sizeSlug":"full","linkDestination":"none"}' ) . ' -->' . "\n"
		. '<figure class="wp-block-image size-full"><img src="' . esc_url( $hq_url ) . '" alt="Officials from Genesis BBQ Group and BLT F&amp;B Group in front of the BBQ Europe HQ Inauguration Ceremony banner"' . ( $hq ? ' class="wp-image-' . $hq . '"' : '' ) . '/>'
		. '<figcaption class="wp-element-caption">Officials from Genesis BBQ Group and BLT F&amp;B Group at the inauguration of the European headquarters, held at Genesis BBQ\'s head office in Seoul. Photo: Genesis BBQ Group.</figcaption></figure>' . "\n"
		. '<!-- /wp:image -->';

	$p = function ( $text, $class = '' ) {
		return $class
			? '<!-- wp:paragraph {"className":"' . $class . '"} -->' . "\n" . '<p class="' . $class . '">' . $text . '</p>' . "\n" . '<!-- /wp:paragraph -->'
			: "<!-- wp:paragraph -->\n<p>" . $text . "</p>\n<!-- /wp:paragraph -->";
	};
	$h2 = function ( $text ) {
		return "<!-- wp:heading -->\n<h2 class=\"wp-block-heading\">" . $text . "</h2>\n<!-- /wp:heading -->";
	};

	$spain_content = implode(
		"\n\n",
		array(
			$p( 'bb.q is coming to Europe. On 8 December 2025, Genesis BBQ Group announced that it has set up bb.q\'s European headquarters in Spain, through a joint venture with BLT F&amp;B Group.', 'article-body__intro' ),
			$h2( 'A launch in Seoul' ),
			$p( 'Officials from both companies marked the start with a launch ceremony at Genesis BBQ\'s headquarters in Seoul. According to The Korea Herald, BLT F&amp;B Group runs food and beverage brands in Spain and the United States, including Domino\'s Pizza, Applebee\'s and IHOP.' ),
			$h2( 'Why Europe' ),
			$p( 'Genesis BBQ sees Europe as the last big step in taking its Korean fried chicken worldwide. The region is one of the world\'s largest tourism markets, with customers who have strong purchasing power and a taste for premium food. According to the company, brands with a real story behind their culture and quality do well there.' ),
			$figure,
			$h2( 'What the Spanish headquarters will do' ),
			$p( 'The headquarters in Spain is the hub for bb.q\'s European supply chain: local production, sourcing of ingredients, regional logistics and distribution. That speeds up the rest: adapting the menu to local tastes, opening flagship restaurants and signing franchise partners.' ),
			$h2( 'Where bb.q opens first' ),
			$p( 'The first flagship restaurants are planned in Spain, the United Kingdom, France, Poland and the Netherlands. From there, bb.q will grow into neighbouring countries step by step.' ),
			$p( 'Genesis BBQ Group chair Yoon Hong-geun called Europe "a strategic gateway to complete K-food\'s globalization". He said the brand will bring the premium value of Korean chicken across Europe, with localised menus and an advanced logistics network.' ),
		)
	);

	$fcb_url = 'https://www.koreajoongangdaily.com/business/genesis-bbq-marks-30th-anniversary-with-fc-barcelona-ticket-giveaway/11941713';
	$tea_url = 'https://www.koreajoongangdaily.com/business/genesis-bbq-spreads-the-love-with-britishinspired-afternoon-tea-experience/10206597';

	$posts = array(
		array(
			'slug'    => $spain,
			'title'   => 'Spain is bb.q\'s door to Europe',
			'date'    => '2025-12-08',
			'excerpt' => 'Genesis BBQ Group and BLT F&B Group set up bb.q\'s European headquarters in Spain, the base for flagship restaurants in Spain, the UK, France, Poland and the Netherlands.',
			'content' => $spain_content,
			'image'   => 'news-europe-hq.jpg',
			'sticky'  => true,
			'fields'  => array(
				'card_meta'    => '8 Dec 2025 · Europe',
				'date_line'    => '8 December 2025 · Europe',
				'label'        => 'Press / Europe',
				'sources'      => 'Sources: The Korea Herald and The Korea Times, both 8 December 2025. Also reported in Spanish by Yonhap.',
				'full_article' => array( 'label' => 'Read the full article', 'url' => 'https://www.koreaherald.com/article/10631888', 'new_tab' => true ),
			),
		),
		// Placeholder: BLT article on the three Madrid kitchens.
		array(
			'slug'    => 'madrid-openings',
			'title'   => '[Madrid openings article, supplied by BLT]',
			'date'    => '2025-12-12',
			'excerpt' => '',
			'content' => $p( '[Article on the three Madrid kitchens, supplied by BLT.]' ),
			'fields'  => array(
				'card_meta'   => '[Date] · Madrid',
				'placeholder' => 1,
			),
		),
		// Placeholder: BLT article on the UK openings.
		array(
			'slug'    => 'uk-openings',
			'title'   => '[UK openings article, supplied by BLT]',
			'date'    => '2025-12-10',
			'excerpt' => '',
			'content' => $p( '[Article on the UK openings, supplied by BLT.]' ),
			'fields'  => array(
				'card_meta'   => '[Date] · United Kingdom',
				'placeholder' => 1,
			),
		),
		array(
			'slug'    => 'genesis-bbq-30th-anniversary-fc-barcelona',
			'title'   => 'Genesis BBQ marks 30th anniversary with FC Barcelona ticket giveaway',
			'date'    => '2025-06-10',
			'excerpt' => 'Genesis BBQ marks its 30th anniversary with an FC Barcelona ticket giveaway.',
			'content' => $p( 'Genesis BBQ marks its 30th anniversary with an FC Barcelona ticket giveaway.' ),
			'image'   => 'news-fcb-30th.jpg',
			'fields'  => array(
				'card_meta'    => '10 Jun 2025 · Korea JoongAng Daily',
				'date_line'    => '10 June 2025 · Korea JoongAng Daily',
				'external_url' => $fcb_url,
				'sources'      => 'Source: Korea JoongAng Daily, 10 June 2025.',
				'full_article' => array( 'label' => 'Read the full article', 'url' => $fcb_url, 'new_tab' => true ),
			),
		),
		array(
			'slug'    => 'genesis-bbq-british-inspired-afternoon-tea',
			'title'   => 'Genesis BBQ spreads the love with British-inspired afternoon tea experience',
			'date'    => '2025-02-05',
			'excerpt' => 'Genesis BBQ spreads the love with a British-inspired afternoon tea experience.',
			'content' => $p( 'Genesis BBQ spreads the love with a British-inspired afternoon tea experience.' ),
			'image'   => 'news-afternoon-tea.jpg',
			'fields'  => array(
				'card_meta'    => '5 Feb 2025 · Korea JoongAng Daily',
				'date_line'    => '5 February 2025 · Korea JoongAng Daily',
				'external_url' => $tea_url,
				'sources'      => 'Source: Korea JoongAng Daily, 5 February 2025.',
				'full_article' => array( 'label' => 'Read the full article', 'url' => $tea_url, 'new_tab' => true ),
			),
		),
		// Will link to the bb.q global media page (URL still to be supplied): no link yet.
		array(
			'slug'    => 'bbq-takes-over-times-square',
			'title'   => 'bb.q takes over Times Square',
			'date'    => '2025-01-20',
			'excerpt' => 'bb.q Chicken takes over the screens of Times Square in New York.',
			'content' => $p( 'bb.q Chicken takes over the screens of Times Square in New York.' ),
			'image'   => 'news-times-square.jpg',
			'fields'  => array(
				'card_meta' => '2025 · Global',
				'date_line' => '2025 · Global',
				'no_link'   => 1,
			),
		),
		// Will link to the bb.q global media page (URL still to be supplied): no link yet.
		array(
			'slug'    => 'yelp-fastest-growing-brands',
			'title'   => 'Ranked 7th on Yelp\'s fastest growing brands',
			'date'    => '2025-01-10',
			'excerpt' => 'bb.q Chicken ranked 7th on Yelp\'s list of the fastest growing brands in the US.',
			'content' => $p( 'bb.q Chicken ranked 7th on Yelp\'s list of the fastest growing brands in the US.' ),
			'image'   => 'news-drumstick.jpg',
			'fields'  => array(
				'card_meta' => '2025 · US',
				'date_line' => '2025 · US',
				'no_link'   => 1,
			),
		),
	);

	// Card photos with the design's alt texts (news.html); the importer picks these up by file name.
	$alts = array(
		'news-fcb-30th.jpg'      => 'Genesis BBQ chair speaking at the FC Barcelona 30th anniversary briefing',
		'news-afternoon-tea.jpg' => 'The Love in London afternoon tea set-up',
		'news-times-square.jpg'  => 'bb.q Chicken advertising in Times Square',
		'news-drumstick.jpg'     => 'Close-up of crispy fried drumsticks',
	);
	foreach ( $posts as $post ) {
		if ( ! empty( $post['image'] ) && isset( $alts[ $post['image'] ] ) ) {
			$media( $post['slug'], $post['image'], $alts[ $post['image'] ] );
		}
	}

	return $posts;
} )();
