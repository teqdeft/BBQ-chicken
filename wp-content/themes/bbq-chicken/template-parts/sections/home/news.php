<?php
/**
 * Section "News (cards: the 5 latest posts that aren't placeholder cards)" (home page) · ACF layout: home_news
 */
defined( 'ABSPATH' ) || exit;
include __DIR__ . '/_shared.php';
?>
<!-- 12. News (the latest posts; edit them under Posts) -->
<?php bbq_section( 'News (cards: the 5 latest posts that aren\'t placeholder cards)' ); ?>
<section class="section news news--home" aria-labelledby="news-title">
  <div class="news__head">
    <div class="news__head-text">
      <span class="eyebrow"><?php bbq_text( 'news_eyebrow', 'News', 'Label' ); ?></span>
      <h2 class="h2" id="news-title"><?php bbq_text( 'news_title', 'What\'s new', 'Heading' ); ?></h2>
    </div>
    <?php $all = bbq_link( 'news_all', array( 'label' => 'All news', 'url' => 'page:news' ), '"All news" button' ); ?>
    <a class="btn btn--outline-dark"<?php bbq_link_attrs( $all ); ?>><?php bbq_e( $all['label'] ); ?> <span class="btn__chip"><?php bbq_icon( 'arrow' ); ?></span></a>
    <a class="news__all-link"<?php bbq_link_attrs( $all ); ?>><?php bbq_text( 'news_all_short', 'All news →', '"All news" link text on phones' ); ?></a>
  </div>
  <div class="carousel" data-carousel>
    <div class="news__track" data-carousel-viewport>
      <?php
      foreach ( bbq_schema_mode() ? array() : bbq_home_news_ids( 5 ) as $news_id ) :
          $news_link = bbq_news_card_link( $news_id );
          $news_tag  = $news_link ? 'a' : 'div';
          $news_img  = get_post_thumbnail_id( $news_id );
          ?>
      <<?php echo $news_tag; // phpcs:ignore WordPress.Security.EscapeOutput -- 'a' or 'div' ?> class="news-card<?php echo $news_link ? '' : ' news-card--static'; ?>"<?php if ( $news_link ) { bbq_link_attrs( $news_link ); } ?>>
        <?php if ( $news_img ) : ?>
        <div class="news-card__img"><?php bbq_img( $news_img, array( 'size' => 'bbq-card', 'loading' => 'lazy' ) ); ?></div>
        <?php else : ?>
        <div class="news-card__img news-card__img--placeholder" aria-hidden="true"></div>
        <?php endif; ?>
        <div class="news-card__meta"><span class="news-card__date"><?php bbq_e( bbq_news_card_meta( $news_id ) ); ?></span><h3 class="news-card__title"><?php bbq_e( get_post_field( 'post_title', $news_id, 'raw' ) ); ?><?php if ( $news_link && $news_link['new_tab'] ) : ?><span class="sr-only"> (opens in a new tab)</span><?php endif; ?></h3></div>
      </<?php echo $news_tag; // phpcs:ignore WordPress.Security.EscapeOutput ?>>
      <?php endforeach; ?>
    </div>
    <div class="slider__nav" data-carousel-nav>
      <button class="slider__arrow" type="button" aria-label="Previous articles" data-carousel-prev><?php bbq_icon( 'left' ); ?></button>
      <div class="slider__dots" data-carousel-dots></div>
      <button class="slider__arrow" type="button" aria-label="Next articles" data-carousel-next><?php bbq_icon( 'right' ); ?></button>
    </div>
  </div>
</section>
