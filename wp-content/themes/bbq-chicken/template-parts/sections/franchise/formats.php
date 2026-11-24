<?php
/**
 * Section "Formats" (franchise page) · ACF layout: franchise_formats
 */
defined( 'ABSPATH' ) || exit;
include __DIR__ . '/_shared.php';
?>
<!-- 5. Formats -->
<?php bbq_section( 'Formats' ); ?>
<section class="section formats" aria-labelledby="formats-title">
  <div class="section-head formats__head">
    <span class="eyebrow"><?php bbq_text( 'formats_eyebrow', 'The formats', 'Label' ); ?></span>
    <h2 class="h2" id="formats-title"><?php bbq_text( 'formats_title', 'Compact, fast and built for delivery', 'Heading' ); ?></h2>
  </div>
  <p class="formats__sub"><?php bbq_text( 'formats_sub', 'One bb.q QSR design, in the format that fits your site.', 'Subheading' ); ?></p>

  <div class="fslider" data-slider>
    <ul class="format-blocks" data-slider-viewport>
      <?php
      $formats = bbq_rows(
          'formats',
          'Formats',
          array(
              'style' => array( 'select', 'Colour', array( 'dark' => 'Dark', 'red' => 'Red', 'yellow' => 'Yellow' ) ),
              'img'   => array( 'image', 'Image' ),
              'title' => array( 'text', 'Title' ),
              'text'  => array( 'textarea', 'Text' ),
          ),
          array(
              array( 'style' => 'dark', 'img' => 'format-flagship-render.jpg', 'title' => 'Flagship', 'text' => 'A full-size bb.q restaurant for prime locations. 300 to 500 m².' ),
              array( 'style' => 'yellow', 'img' => 'format-shop-in-shop-render.jpg', 'title' => 'Shop-in-shop', 'text' => 'A bb.q counter inside an existing venue. 60 to 120 m².' ),
              array( 'style' => 'red', 'img' => 'format-traditional-render.jpg', 'title' => 'Traditional restaurant', 'text' => 'The classic quick-service restaurant, for dine-in and takeaway. 120 to 200 m².' ),
          )
      );
      foreach ( $formats as $item ) :
          ?>
      <li class="format-block format-block--<?php echo esc_attr( $item['style'] ? $item['style'] : 'dark' ); ?>">
        <div class="format-block__img<?php echo bbq_franchise_is_cutout( $item['img'] ) ? '' : ' format-block__img--photo'; ?>"><?php bbq_img( $item['img'], array( 'alt' => '' ) + bbq_franchise_img_size( $item['img'] ) + array( 'loading' => 'lazy' ) ); ?></div>
        <h3 class="format-block__title"><?php bbq_e( $item['title'] ); ?></h3>
        <p class="format-block__text"><?php bbq_e( $item['text'] ); ?></p>
      </li>
      <?php endforeach; ?>
    </ul>
    <div class="slider__nav fslider__nav">
      <button class="slider__arrow" type="button" aria-label="Previous format" data-slider-prev><?php bbq_icon( 'left' ); ?></button>
      <div class="slider__dots" data-slider-dots></div>
      <button class="slider__arrow" type="button" aria-label="Next format" data-slider-next><?php bbq_icon( 'right' ); ?></button>
    </div>
  </div>
</section>
