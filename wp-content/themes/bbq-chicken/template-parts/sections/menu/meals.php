<?php
/**
 * Section "Meals and boxes" (menu page) · ACF layout: menu_meals
 */
defined( 'ABSPATH' ) || exit;
include __DIR__ . '/_shared.php';
?>
<!-- 2. Meals and boxes -->
<?php bbq_section( 'Meals and boxes' ); ?>
<section class="section chicken meals" aria-labelledby="meals-title">
  <div class="section-head">
    <span class="eyebrow"><?php bbq_text( 'meals_eyebrow', 'Meals', 'Label' ); ?></span>
    <h2 class="h2" id="meals-title"><?php bbq_text( 'meals_title', 'Meals and boxes', 'Heading' ); ?></h2>
  </div>
  <div class="row-slider" data-slider>
    <div class="format-grid format-grid--4" data-slider-viewport>
      <?php
      // The cards are Meals posts (menu: Meals): the picked ones in the picked order, else all in their order.
      $picked = bbq_posts( 'meals_pick', 'Meals', 'meal_card', array( 'help' => 'Pick the meals for this section and drag them into order. Empty = all meals, in their Order. Meals are added and edited under Meals in the admin menu.' ) );
      $meals  = bbq_cards( 'meal_card', $picked ); // inc/card-types.php
      foreach ( $meals as $card ) :
          $dims = isset( $img_dims[ $card['img'] ] ) ? $img_dims[ $card['img'] ] : array( null, null );
          ?>
      <article class="format-card format-card--photo format-card--<?php echo esc_attr( $card['style'] ? $card['style'] : 'dark' ); ?>">
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
