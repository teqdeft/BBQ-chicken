<?php
/**
 * News article (single post). Layout: templates/news-article.php; the article itself is the post content.
 */
defined( 'ABSPATH' ) || exit;
get_header();
bbq_render_fields( 'news-article' );
get_footer();
