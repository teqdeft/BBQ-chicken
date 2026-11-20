<?php
/**
 * News list (the posts page). Content: templates/news.php; the texts are edited on the News page.
 */
defined( 'ABSPATH' ) || exit;
get_header();
bbq_render_fields( 'news' );
get_footer();
