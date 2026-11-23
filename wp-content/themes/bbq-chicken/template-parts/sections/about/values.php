<?php
/**
 * Section "Values" (about page) · ACF layout: about_values
 */
defined( 'ABSPATH' ) || exit;
include __DIR__ . '/_shared.php';
?>
<!-- 3. Values (bento grid on desktop, swipe row on mobile) -->
<?php bbq_section( 'Values' ); ?>
<section class="section values" aria-labelledby="values-title">
  <div class="section-head">
    <span class="eyebrow"><?php bbq_text( 'values_eyebrow', 'BLT Global Brands', 'Label' ); ?></span>
    <h2 class="h2" id="values-title"><?php bbq_text( 'values_title', 'Our core values', 'Heading' ); ?></h2>
    <p class="values__lead"><?php bbq_textarea( 'values_lead', 'At BLT Global Brands, our culture and daily operations are driven by a steadfast commitment to excellence, integrity, and people.', 'Intro text' ); ?></p>
  </div>
  <?php
  bbq_section( 'Values: grid tiles' );
  $chibboq_img = bbq_get( 'val_chibboq_img', 'chibboq-glasses.png', 'ChiBBoQ tile (desktop: tall tile, top row; phones: above the swipe row): image', 'image' );
  ?>
  <div class="value-tile value-tile--chibboq value-tile--mobile" aria-hidden="true"><?php bbq_img( $chibboq_img, array( 'alt' => '', 'width' => 714, 'height' => 906, 'loading' => 'lazy' ) ); ?></div>
  <div class="row-slider" data-slider>
    <div class="value-grid" data-slider-viewport>
      <?php
      foreach ( $value_tiles as $tile ) :
          $k = 'val_' . $tile['key'];
          ?>
      <article class="value <?php echo esc_attr( $tile['class'] ); ?>">
        <?php if ( 'photo' === $tile['kind'] ) : ?>
        <?php bbq_image( $k . '_img', $tile['img'], $tile['label'] . ': photo', array( 'class' => 'value__photo', 'alt' => '', 'width' => $tile['w'], 'height' => $tile['h'], 'loading' => 'lazy' ) ); ?>
        <?php else : ?>
        <span class="value__icon" aria-hidden="true"><?php echo $value_icons[ $tile['icon'] ]; // phpcs:ignore WordPress.Security.EscapeOutput -- fixed SVGs above ?></span>
        <?php endif; ?>
        <h3 class="value__title"><?php bbq_text( $k . '_title', $tile['title'], $tile['label'] . ': title' ); ?></h3>
        <p class="value__text"><?php bbq_textarea( $k . '_text', $tile['text'], $tile['label'] . ': text' ); ?></p>
      </article>
      <?php endforeach; ?>
      <div class="value-tile value-tile--chibboq value-tile--desktop" aria-hidden="true"><?php bbq_img( $chibboq_img, array( 'alt' => '', 'width' => 714, 'height' => 906, 'loading' => 'lazy' ) ); ?></div>
      <div class="value-tile value-tile--product value-tile--desktop" aria-hidden="true"><?php bbq_image( 'val_product_img', 'cut-8pcs-fried-bucket.png', 'Product tile (desktop only: bottom right): image', array( 'alt' => '', 'width' => 660, 'height' => 838, 'loading' => 'lazy' ) ); ?></div>
    </div>
    <div class="row-nav">
      <button class="row-nav__arrow" type="button" aria-label="Previous" data-slider-prev><?php bbq_icon( 'left' ); ?></button>
      <div class="row-nav__dots" data-slider-dots></div>
      <button class="row-nav__arrow" type="button" aria-label="Next" data-slider-next><?php bbq_icon( 'right' ); ?></button>
    </div>
  </div>
</section>
