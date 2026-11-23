<?php
/**
 * Section "Featured story" (news page) · ACF layout: news_featured_story
 */
defined( 'ABSPATH' ) || exit;
include __DIR__ . '/_shared.php';
?>
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
