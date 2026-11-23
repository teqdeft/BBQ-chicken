<?php
/**
 * Section "The food" (home page) · ACF layout: home_the_food
 */
defined( 'ABSPATH' ) || exit;
include __DIR__ . '/_shared.php';
?>
<!-- 5. Food -->
<?php bbq_section( 'The food' ); ?>
<section class="food" aria-labelledby="food-title">
  <div class="cutout cutout--shadow cutout--fried"><?php bbq_image( 'food_cut_fried', 'cut-2pcs-fried.png', 'Cut-out image, top left', array( 'alt' => '', 'width' => 880, 'height' => 463, 'loading' => 'lazy' ) ); ?></div>
  <div class="cutout cutout--shadow cutout--sauce"><?php bbq_image( 'food_cut_sauce', 'cut-2pcs-secret-sauce.png', 'Cut-out image, top right', array( 'alt' => '', 'width' => 760, 'height' => 412, 'loading' => 'lazy' ) ); ?></div>
  <div class="food__head">
    <span class="eyebrow"><?php bbq_text( 'food_eyebrow', 'The food', 'Label' ); ?></span>
    <h2 class="h2" id="food-title"><?php bbq_text( 'food_title', 'Crispy outside, juicy inside, sauced your way.', 'Heading' ); ?></h2>
    <p class="lead"><?php bbq_textarea( 'food_lead', 'Every piece is double-fried the Korean way, then tossed in one of our signature sauces. Sweet, garlicky or savoury, there\'s a favourite for every table.', 'Intro text' ); ?></p>
  </div>

  <div class="slider" data-slider data-slider-loop data-start="2" data-start-mobile="0">
    <div class="slider__viewport" data-slider-viewport>
      <?php
      $food = bbq_rows(
          'food_cards',
          'Food cards (endless slider; the third card starts in the middle on desktop)',
          array(
              'title'        => array( 'text', 'Title' ),
              'text'         => array( 'textarea', 'Text' ),
              'tag'          => array( 'text', 'Tag on the photo' ),
              'style'        => array( 'select', 'Colour', $food_styles ),
              'desktop_only' => array( 'toggle', 'Desktop only (hidden on phones)' ),
              'img'          => array( 'image', 'Photo' ),
              'alt'          => array( 'text', 'Photo description (alt text)' ),
          ),
          array(
              array( 'style' => 'yellow', 'desktop_only' => 0, 'img' => 'food-combo-meal.jpg', 'alt' => 'A meal of two pieces of Korean fried chicken with fries and a drink', 'tag' => 'Meals', 'title' => 'Combo meals', 'text' => 'Pieces, tenders, a burger, wrap or bowl, with fries and a drink. Lunch, sorted.' ),
              array( 'style' => 'red', 'desktop_only' => 0, 'img' => 'food-3pcs-strips.jpg', 'alt' => 'Three crispy chicken tenders', 'tag' => 'On the go', 'title' => 'Real Crispy Tenders', 'text' => 'Crispy chicken strips in 3, 6 or 12 pieces, easy to share and easier to eat on the go.' ),
              array( 'style' => 'sand', 'desktop_only' => 0, 'img' => 'food-party-bucket.jpg', 'alt' => 'A bucket of crispy tenders next to a bucket of fries', 'tag' => 'For sharing', 'title' => 'Mega Party Bucket', 'text' => '24 crispy tenders or 16 pieces of Korean fried chicken, with a bucket of fries for the table.' ),
              array( 'style' => 'dark', 'desktop_only' => 0, 'img' => 'sauce-secret-sauce.jpg', 'alt' => 'A bowl of Secret Sauce', 'tag' => '9 sauces', 'title' => 'Signature sauces', 'text' => 'Nine sauces, from the sweet and mildly spicy Secret Sauce to the fiery Jasoman.' ),
          )
      );
      foreach ( $food as $card ) :
          $style = isset( $food_styles[ $card['style'] ] ) ? $card['style'] : 'dark';
          ?>
      <article class="food-card food-card--<?php echo esc_attr( $style ); ?><?php echo $card['desktop_only'] ? ' food-card--desktop-only' : ''; ?>">
        <div class="food-card__img"><?php bbq_img( $card['img'], array( 'alt' => $card['alt'], 'width' => 960, 'height' => 720, 'loading' => 'lazy' ) ); ?><?php if ( '' !== (string) $card['tag'] ) : ?><span class="food-card__tag"><?php bbq_e( $card['tag'] ); ?></span><?php endif; ?></div>
        <div class="food-card__body"><h3 class="food-card__title"><?php bbq_e( $card['title'] ); ?></h3><p class="food-card__text"><?php bbq_e( $card['text'] ); ?></p></div>
      </article>
      <?php endforeach; ?>
    </div>
    <div class="slider__nav">
      <button class="slider__arrow" type="button" aria-label="Previous" data-slider-prev><?php bbq_icon( 'left' ); ?></button>
      <div class="slider__dots" data-slider-dots></div>
      <button class="slider__arrow" type="button" aria-label="Next" data-slider-next><?php bbq_icon( 'right' ); ?></button>
    </div>
  </div>

  <div class="food__cta">
    <?php $l = bbq_link( 'food_btn', array( 'label' => 'See the full menu', 'url' => 'page:menu' ), 'Button' ); ?>
    <a class="btn btn--outline-dark"<?php bbq_link_attrs( $l ); ?>><?php bbq_e( $l['label'] ); ?> <span class="btn__chip"><?php bbq_icon( 'arrow' ); ?></span></a>
  </div>
</section>
