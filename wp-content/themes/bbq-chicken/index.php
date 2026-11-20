<?php
/**
 * Fallback for anything without its own template (other pages, search, archives).
 * Uses the short dark page header and a plain text column.
 */
defined( 'ABSPATH' ) || exit;
get_header();
?>
<header class="section page-hero page-hero--short">
  <div class="page-hero__text">
    <h1 class="h-display"><?php
      if ( is_singular() ) {
          single_post_title();
      } elseif ( is_search() ) {
          printf( 'Search: %s', esc_html( get_search_query() ) );
      } else {
          the_archive_title();
      }
    ?></h1>
  </div>
</header>
<section class="section wp-content-section">
  <div class="wp-content">
    <?php
    if ( have_posts() ) {
        while ( have_posts() ) {
            the_post();
            if ( is_singular() ) {
                the_content();
            } else {
                echo '<h2><a href="' . esc_url( get_permalink() ) . '">' . esc_html( get_the_title() ) . '</a></h2>';
                the_excerpt();
            }
        }
        the_posts_pagination();
    } else {
        echo '<p>Nothing found.</p>';
    }
    ?>
  </div>
</section>
<?php
get_footer();
