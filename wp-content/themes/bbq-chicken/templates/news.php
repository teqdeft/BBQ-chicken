<?php
/**
 * News page (the posts page, home.php). Static source: html-backup/src/pages/news.html
 *
 * Featured story = the sticky post (bbq_news_featured_id()); the grid = the main query (every other
 * post, newest first, Settings → Reading sets how many per page). Cards: inc/news.php bbq_news_card().
 * The texts are fields of the News page (which also holds the article page texts, templates/news-article.php).
 */
defined( 'ABSPATH' ) || exit;

global $wp_query;
$live     = ! bbq_schema_mode();
$paged    = max( 1, (int) get_query_var( 'paged' ) );
$featured = $live && 1 === $paged ? get_post( bbq_news_featured_id() ) : null;
?>

<!-- 1. Page header -->
<?php bbq_section( 'Page header' ); ?>
<section class="section page-hero page-hero--short" aria-labelledby="news-title">
  <div class="page-hero__text">
    <span class="eyebrow eyebrow--glass"><?php bbq_text( 'hero_eyebrow', 'News', 'Label' ); ?></span>
    <h1 class="h-display" id="news-title"><?php bbq_html( 'hero_title', 'What\'s new<br>at bb.q', 'Heading' ); ?></h1>
    <p class="lead"><?php bbq_textarea( 'hero_lead', 'Openings, campaigns and news from bb.q in Europe and around the world.', 'Intro text' ); ?></p>
  </div>
</section>

<!-- 2. Featured article -->
<?php
bbq_section( 'Featured story' );
$more_label = bbq_get( 'featured_more', 'Read more', 'Button text', 'text', array( 'help' => 'The featured story is the sticky post ("Stick to the top of the blog" in the post editor); its date line is the post\'s "Date line on the featured story", the text its excerpt.' ) );
$more_sr    = bbq_get( 'featured_more_sr', 'about', 'Button: screen-reader text before the title' );
if ( $featured ) :
	$f_link  = bbq_news_card_link( $featured->ID );
	$f_attrs = $f_link ? ' href="' . esc_url( $f_link['url'] ) . '"' . ( $f_link['new_tab'] ? ' target="_blank" rel="noopener"' : '' ) : '';
	$f_thumb = (int) get_post_thumbnail_id( $featured );
	$f_lead  = '' !== trim( $featured->post_excerpt ) ? $featured->post_excerpt : wp_trim_words( wp_strip_all_tags( strip_shortcodes( $featured->post_content ) ), 30 );
	?>
<section class="section featured" aria-labelledby="featured-title">
  <?php if ( $f_link ) : ?>
  <a class="featured__img"<?php echo $f_attrs; // phpcs:ignore WordPress.Security.EscapeOutput -- escaped above ?> tabindex="-1" aria-hidden="true">
    <?php echo $f_thumb ? wp_get_attachment_image( $f_thumb, 'full', false, array( 'alt' => '', 'loading' => false ) ) : ''; // phpcs:ignore WordPress.Security.EscapeOutput ?>
  </a>
  <?php else : ?>
  <div class="featured__img">
    <?php echo $f_thumb ? wp_get_attachment_image( $f_thumb, 'full', false, array( 'alt' => '', 'loading' => false ) ) : ''; // phpcs:ignore WordPress.Security.EscapeOutput ?>
  </div>
  <?php endif; ?>
  <div class="featured__text">
    <span class="eyebrow"><?php bbq_e( bbq_news_date_line( $featured->ID ) ); ?></span>
    <h2 class="h2" id="featured-title"><?php echo bbq_news_title( $featured ); // phpcs:ignore WordPress.Security.EscapeOutput -- escaped ?></h2>
    <p class="lead"><?php bbq_e( $f_lead ); ?></p>
    <?php if ( $f_link ) : ?>
    <a class="btn btn--outline-dark"<?php echo $f_attrs; // phpcs:ignore WordPress.Security.EscapeOutput ?>><?php bbq_e( $more_label ); ?> <span class="sr-only"><?php bbq_e( trim( $more_sr . ' ' . $featured->post_title ) ); ?></span><span class="btn__chip"><?php bbq_icon( 'arrow' ); ?></span></a>
    <?php endif; ?>
  </div>
</section>
<?php endif; ?>

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

<!-- 4. Closing CTA -->
<?php bbq_section( 'Closing banner' ); ?>
<section class="section closing" aria-labelledby="closing-title">
  <div class="stamp"><?php bbq_stamp(); ?></div>
  <span class="sparkle-lg" aria-hidden="true"><?php bbq_icon( 'sparkleplain' ); ?></span>
  <span class="sparkle-sm" aria-hidden="true"><?php bbq_icon( 'sparkleplain' ); ?></span>
  <div class="cta-card">
    <h2 class="h2" id="closing-title"><?php bbq_text( 'closing_title', 'Ready to bring bb.q to your market?', 'Heading' ); ?></h2>
    <p class="lead"><?php bbq_textarea( 'closing_lead', 'Tell us who you are and where you\'d like to grow. It takes two minutes. Our European team reads every enquiry and gets back to you personally.', 'Text' ); ?></p>
    <?php $closing_cta = bbq_link( 'closing_cta', array( 'label' => 'Submit your application', 'url' => 'page:apply' ), 'Button' ); ?>
    <a class="btn btn--red"<?php bbq_link_attrs( $closing_cta, ' data-hides-floating' ); ?>><?php bbq_e( $closing_cta['label'] ); ?> <span class="btn__chip"><?php bbq_icon( 'arrow' ); ?></span></a>
  </div>
  <div class="cutout cutout--shadow-dark cutout--fried"><?php bbq_image( 'closing_img', 'cut-2pcs-fried.png', 'Image', array( 'alt' => '', 'width' => 880, 'height' => 463, 'loading' => 'lazy' ) ); ?></div>
</section>
