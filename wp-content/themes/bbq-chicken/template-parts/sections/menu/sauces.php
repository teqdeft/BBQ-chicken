<?php
/**
 * Section "Sauces" (menu page) · ACF layout: menu_sauces
 */
defined( 'ABSPATH' ) || exit;
include __DIR__ . '/_shared.php';
?>
<!-- 3. Sauces -->
<?php bbq_section( 'Sauces' ); ?>
<section class="section sauces" aria-labelledby="sauces-title">
  <div class="section-head">
    <span class="eyebrow"><?php bbq_text( 'sauces_eyebrow', 'Sauces', 'Label' ); ?></span>
    <h2 class="h2" id="sauces-title"><?php bbq_text( 'sauces_title', 'Pick your sauce', 'Heading' ); ?></h2>
  </div>
  <div class="row-slider" data-slider>
    <div class="sauce-grid" data-slider-viewport>
      <?php
      $spice_sr = bbq_get( 'sauces_spice_sr', 'Spice level', 'Chilli rating: text read out by screen readers ("… 1 of 3" is added)' );
      $sauces   = bbq_rows(
          'sauces',
          'Sauce cards',
          array(
              'img'   => array( 'image', 'Photo' ),
              'title' => array( 'text', 'Name' ),
              'text'  => array( 'textarea', 'Description' ),
              'spice' => array( 'select', 'Spice level (chilli icons)', bbq_menu_spice_levels() ),
              'note'  => array( 'text', 'Note after the chillies (optional)' ),
              'alt'   => array( 'text', 'Photo description (alt text)' ),
          ),
          array(
              array( 'img' => 'sauce-secret-sauce.jpg', 'title' => 'Secret Sauce', 'text' => 'Signature sweet and mildly spicy sauce.', 'spice' => '1', 'note' => '', 'alt' => 'A bowl of Secret Sauce' ),
              array( 'img' => 'sauce-garlic-mayo.jpg', 'title' => 'Garlic Mayo Sauce', 'text' => 'Smooth and creamy mayonnaise with a bold garlic kick.', 'spice' => 'tbc', 'note' => '', 'alt' => 'A bowl of Garlic Mayo Sauce' ),
              array( 'img' => 'sauce-galbi.jpg', 'title' => 'Galbi Sauce', 'text' => 'Sweet, tangy, and smoky Korean BBQ sauce.', 'spice' => '0', 'note' => '', 'alt' => 'A bowl of Galbi Sauce' ),
              array( 'img' => 'sauce-galbi-mayo.jpg', 'title' => 'Galbi Mayo Sauce', 'text' => 'Creamy mayonnaise infused with sweet and savory Galbi BBQ flavor.', 'spice' => '0', 'note' => '', 'alt' => 'A bowl of Galbi Mayo Sauce' ),
              array( 'img' => 'sauce-gangjeong.jpg', 'title' => 'Gangjeong Sauce', 'text' => 'Sweet, crunchy, and mildly spicy sauce.', 'spice' => '1', 'note' => '', 'alt' => 'A bowl of Gangjeong Sauce' ),
              array( 'img' => 'sauce-jasoman.jpg', 'title' => 'Jasoman Sauce', 'text' => 'Bold and fiery hot sauce with garlic and black pepper.', 'spice' => '2', 'note' => '', 'alt' => 'A bowl of Jasoman Sauce' ),
              array( 'img' => 'sauce-jamaica-mayo.jpg', 'title' => 'Jamaica Mayo Sauce', 'text' => 'Creamy mayonnaise with a smoky and spicy kick.', 'spice' => 'tbc', 'note' => '', 'alt' => 'A bowl of Jamaica Mayo Sauce' ),
              array( 'img' => 'sauce-red-chak-chak-mayo.jpg', 'title' => 'Red Chak Chak Sauce', 'text' => 'Our Korean take on the classic brava sauce, creamier and extra spicy.', 'spice' => 'tbc', 'note' => '', 'alt' => 'A bowl of Red Chak Chak Sauce' ),
              array( 'img' => 'sauce-cheesling.jpg', 'title' => 'Cheesling Sauce', 'text' => 'Irresistible cheddar cheese seasoning with a sweet and savory twist.', 'spice' => '0', 'note' => '', 'alt' => 'A bowl of Cheesling seasoning' ),
          )
      );
      foreach ( $sauces as $sauce ) :
          ?>
      <article class="sauce">
        <div class="sauce__img"><?php bbq_img( $sauce['img'], array( 'alt' => $sauce['alt'], 'width' => 900, 'height' => 422, 'loading' => 'lazy' ) ); ?></div>
        <h3 class="sauce__title"><?php bbq_e( $sauce['title'] ); ?></h3>
        <?php if ( '' !== trim( (string) $sauce['text'] ) ) : ?>
        <p class="sauce__text"><?php bbq_e( $sauce['text'] ); ?></p>
        <?php endif; ?>
        <?php echo bbq_menu_spice( $sauce['spice'], $sauce['note'], $spice_sr ); // phpcs:ignore WordPress.Security.EscapeOutput -- escaped in the helper ?>
      </article>
      <?php endforeach; ?>
    </div>
    <div class="row-nav">
      <button class="row-nav__arrow" type="button" aria-label="Previous" data-slider-prev><?php bbq_icon( 'left' ); ?></button>
      <div class="row-nav__dots" data-slider-dots></div>
      <button class="row-nav__arrow" type="button" aria-label="Next" data-slider-next><?php bbq_icon( 'right' ); ?></button>
    </div>
  </div>
  <div class="sauces__cta">
    <p class="sauces__cta-text"><?php bbq_text( 'sauces_cta_text', 'Brushed on straight after frying, so the crunch survives.', 'Text next to the button' ); ?></p>
    <?php $sauces_cta = bbq_link( 'sauces_cta', array( 'label' => 'Order now', 'url' => 'page:home#find' ), 'Button' ); ?>
    <?php if ( $sauces_cta['label'] ) : ?>
    <a class="btn btn--cream"<?php bbq_link_attrs( $sauces_cta ); ?>><?php bbq_e( $sauces_cta['label'] ); ?> <span class="btn__chip"><?php bbq_icon( 'arrow' ); ?></span></a>
    <?php endif; ?>
  </div>
  <?php bbq_image( 'sauces_peek', 'chibboq-glasses.png', 'ChiBBoQ image', array( 'class' => 'sauces__peek', 'alt' => '', 'width' => 714, 'height' => 906, 'loading' => 'lazy' ) ); ?>
</section>
