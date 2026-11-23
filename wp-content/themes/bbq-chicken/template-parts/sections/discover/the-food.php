<?php
/**
 * Section "The food" (discover page) · ACF layout: discover_the_food
 */
defined( 'ABSPATH' ) || exit;
include __DIR__ . '/_shared.php';
?>
<!-- 3. What makes it Korean (Express format pattern) -->
<?php bbq_section( 'The food' ); ?>
<section class="section formats" aria-labelledby="formats-title">
  <div class="section-head formats__head">
    <span class="eyebrow"><?php bbq_text( 'formats_eyebrow', 'The food', 'Label' ); ?></span>
    <h2 class="h2" id="formats-title"><?php bbq_text( 'formats_title', 'What makes it Korean fried chicken', 'Heading' ); ?></h2>
    <p class="formats__lead"><?php bbq_textarea( 'formats_lead', 'Korean fried chicken is fried twice. The first fry cooks it, the second makes it shatter. Then comes the sauce.', 'Intro text' ); ?></p>
  </div>
  <div class="row-slider" data-slider>
    <div class="format-grid" data-slider-viewport>
      <?php
      $formats = bbq_rows(
          'formats',
          'Cards',
          array(
              'style' => array( 'select', 'Colour', array( 'dark' => 'Dark', 'red' => 'Red', 'wine' => 'Wine red' ) ),
              'img'   => array( 'image', 'Image' ),
              'title' => array( 'text', 'Title' ),
              'text'  => array( 'textarea', 'Text' ),
              'alt'   => array( 'text', 'Image description (alt text)' ),
          ),
          array(
              array( 'style' => 'dark', 'img' => 'cut-tenders-3pcs.png', 'title' => 'Double-fried', 'text' => 'Fried twice, so the coating stays crisp even under a glaze.', 'alt' => 'Three crispy chicken tenders' ),
              array( 'style' => 'red', 'img' => 'cut-4pcs-cheesling.png', 'title' => 'Sauced, not smothered', 'text' => 'Secret Sauce, Galbi, Gangjeong or Jasoman, brushed on right after frying.', 'alt' => 'Four pieces of Cheesling chicken' ),
              array( 'style' => 'wine', 'img' => 'cut-8pcs-secret-sauce-bucket.png', 'title' => 'Made for sharing', 'text' => 'Buckets, boxes and sides meant for the middle of the table.', 'alt' => 'A sharing bucket of chicken glazed in Secret Sauce' ),
          )
      );
      foreach ( $formats as $card ) :
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
