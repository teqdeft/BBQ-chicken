<?php
/**
 * Section "The chicken" (menu page) · ACF layout: menu_the_chicken
 */
defined( 'ABSPATH' ) || exit;
include __DIR__ . '/_shared.php';
?>
<!-- 3. The chicken -->
<?php bbq_section( 'The chicken' ); ?>
<section class="section chicken" aria-labelledby="chicken-title">
  <div class="section-head">
    <span class="eyebrow"><?php bbq_text( 'chicken_eyebrow', 'Chicken', 'Label' ); ?></span>
    <h2 class="h2" id="chicken-title"><?php bbq_text( 'chicken_title', 'The chicken', 'Heading' ); ?></h2>
  </div>
  <div class="row-slider" data-slider>
    <div class="format-grid" data-slider-viewport>
      <?php
      // The cards are Chicken cards posts (menu: Chicken cards): the picked ones in the picked order, else all in their order.
      $picked  = bbq_posts( 'chicken_pick', 'Chicken cards', 'chicken_card', array( 'help' => 'Pick the cards for this section and drag them into order. Empty = all chicken cards, in their Order. Cards are added and edited under Chicken cards in the admin menu.' ) );
      $chicken = bbq_cards( 'chicken_card', $picked ); // inc/card-types.php
      foreach ( $chicken as $card ) :
          $dims = isset( $img_dims[ $card['img'] ] ) ? $img_dims[ $card['img'] ] : array( null, null );
          ?>
      <article class="format-card format-card--<?php echo esc_attr( $card['style'] ? $card['style'] : 'dark' ); ?>">
        <div class="format-card__img"><?php bbq_img( $card['img'], array( 'alt' => $card['alt'], 'width' => $dims[0], 'height' => $dims[1], 'loading' => 'lazy' ) ); ?></div>
        <h3 class="format-card__title"><?php bbq_e( $card['title'] ); ?></h3>
        <p class="format-card__text"><?php bbq_e( $card['text'] ); ?></p>
      </article>
      <?php endforeach; ?>
    </div>
    <div class="row-nav">
      <button class="row-nav__arrow" type="button" aria-label="Previous" data-slider-prev><?php bbq_icon( 'left' ); ?></button>
      <div class="row-nav__dots" data-slider-dots></div>
      <button class="row-nav__arrow" type="button" aria-label="Next" data-slider-next><?php bbq_icon( 'right' ); ?></button>
    </div>
  </div>
</section>
