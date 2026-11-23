<?php
/**
 * Shared setup for the news sections (included by each of them).
 */
defined( 'ABSPATH' ) || exit;
global $wp_query;
$live     = ! bbq_schema_mode();
$paged    = max( 1, (int) get_query_var( 'paged' ) );
$featured = $live && 1 === $paged ? get_post( bbq_news_featured_id() ) : null;
?>
