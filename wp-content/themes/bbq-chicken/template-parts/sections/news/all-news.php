<?php
/**
 * Section "All news" (news page) · ACF layout: news_all_news
 */
defined( 'ABSPATH' ) || exit;
include __DIR__ . '/_shared.php';
?>
<!-- 3. Article grid -->
<?php
bbq_section( 'All news' );
$grid_title   = bbq_get( 'grid_title', 'All news', 'Heading (screen readers only)', 'text', array( 'help' => 'The cards are the news posts, newest first. Card texts, links and placeholders are set in each post\'s "News card" box.' ) );
$new_tab_text = bbq_get( 'card_new_tab', '(opens in a new tab)', 'Cards: screen-reader note on outside links' );
$prev_label   = bbq_get( 'pagination_prev', 'Previous', 'Pagination: previous' );
$prev_short   = bbq_get( 'pagination_prev_short', 'Prev', 'Pagination: previous (phone)' );
$next_label   = bbq_get( 'pagination_next', 'Next', 'Pagination: next' );
$max_pages    = $live ? (int) $wp_query->max_num_pages : 1;
?>
<section class="section articles" aria-labelledby="articles-title">
  <h2 class="sr-only" id="articles-title"><?php bbq_e( $grid_title ); ?></h2>
  <div class="news-grid">
    <?php
    if ( $live ) {
        while ( have_posts() ) {
            the_post();
            bbq_news_card( get_post(), array( 'new_tab_text' => $new_tab_text ) );
        }
        wp_reset_postdata();
    }
    ?>
  </div>

  <!-- Pagination: hidden while everything fits on one page -->
  <nav class="pagination" aria-label="Pagination"<?php echo $max_pages > 1 ? '' : ' hidden'; ?>>
    <?php if ( $paged > 1 ) : ?>
    <a class="pagination__link" href="<?php echo esc_url( get_pagenum_link( $paged - 1 ) ); ?>" aria-label="Previous page">← <span class="only-desktop"><?php bbq_e( $prev_label ); ?></span><span class="only-mobile"><?php bbq_e( $prev_short ); ?></span></a>
    <?php else : ?>
    <span class="pagination__link" aria-disabled="true">← <span class="only-desktop"><?php bbq_e( $prev_label ); ?></span><span class="only-mobile"><?php bbq_e( $prev_short ); ?></span></span>
    <?php endif; ?>
    <?php for ( $n = 1; $n <= max( 1, $max_pages ); $n++ ) : ?>
    <a class="pagination__link" href="<?php echo esc_url( get_pagenum_link( $n ) ); ?>"<?php echo $n === $paged ? ' aria-current="page"' : ''; ?> aria-label="Page <?php echo (int) $n; ?>"><?php echo (int) $n; ?></a>
    <?php endfor; ?>
    <?php if ( $paged < $max_pages ) : ?>
    <a class="pagination__link" href="<?php echo esc_url( get_pagenum_link( $paged + 1 ) ); ?>" aria-label="Next page"><?php bbq_e( $next_label ); ?> →</a>
    <?php else : ?>
    <span class="pagination__link" aria-disabled="true"><?php bbq_e( $next_label ); ?> →</span>
    <?php endif; ?>
  </nav>
</section>
