<?php
/**
 * Section "The chicken" (menu page) · ACF layout: menu_the_chicken
 */
defined( 'ABSPATH' ) || exit;
include __DIR__ . '/_shared.php';
?>
<!-- 2. The chicken -->
<?php bbq_section( 'The chicken' ); ?>
<section class="section chicken" aria-labelledby="chicken-title">
  <div class="section-head">
    <span class="eyebrow"><?php bbq_text( 'chicken_eyebrow', 'Chicken', 'Label' ); ?></span>
    <h2 class="h2" id="chicken-title"><?php bbq_text( 'chicken_title', 'The chicken', 'Heading' ); ?></h2>
  </div>
  <div class="row-slider" data-slider>
    <div class="format-grid" data-slider-viewport>
      <?php
      $chicken = bbq_rows(
          'chicken',
          'Cards',
          array(
              'style' => array( 'select', 'Colour', array( 'dark' => 'Dark', 'red' => 'Red', 'wine' => 'Wine red' ) ),
              'img'   => array( 'image', 'Image' ),
              'title' => array( 'text', 'Title' ),
              'text'  => array( 'textarea', 'Text' ),
              'alt'   => array( 'text', 'Image description (alt text)' ),
          ),
          array(
              array( 'style' => 'dark', 'img' => 'cut-2pcs-fried.png', 'title' => 'Real Korean Fried Chicken', 'text' => '2, 4 or 8 crispy, juicy pieces of our authentic Korean fried chicken, made to the original recipe.', 'alt' => 'Two pieces of golden fried chicken' ),
              array( 'style' => 'red', 'img' => 'cut-tenders-3pcs.png', 'title' => 'Real Crispy Tenders', 'text' => '3, 6 or 12 original crispy chicken strips, with 1, 2 or 4 sauces.', 'alt' => 'Three crispy chicken tenders' ),
              array( 'style' => 'wine', 'img' => 'cut-fries.png', 'title' => 'Meals and meal boxes', 'text' => 'Any favourite with fries and a drink: tenders, Korean fried chicken, a burger, a wrap or a bowl. Also as a Meal Box for 2 or a Family Meal Box.', 'alt' => 'Fries in a bb.q fries box' ),
              array( 'style' => 'wine', 'img' => 'cut-burger.png', 'title' => 'Burgers and wraps', 'text' => 'A crispy chicken burger with fresh vegetables and sauce in a soft bun, or crispy chicken strips in a wrap with fresh vegetables.', 'alt' => 'A crispy chicken burger' ),
              array( 'style' => 'dark', 'img' => 'cut-bowl.png', 'title' => 'Rice and salad bowls', 'text' => 'Crispy chicken strips on white rice or on lettuce and mixed vegetables, with fresh vegetables and our special sauce.', 'alt' => 'A chicken rice bowl' ),
              array( 'style' => 'red', 'img' => 'cut-8pcs-fried-bucket.png', 'title' => 'Mega Party Bucket', 'text' => '24 crispy tenders, 16 pieces of Korean fried chicken or a combo of both, each with a 1.25 kg bucket of fries.', 'alt' => 'A bucket of fried chicken' ),
          )
      );
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
