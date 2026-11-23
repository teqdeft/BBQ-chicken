<?php
/**
 * Section "Sides" (menu page) · ACF layout: menu_sides
 */
defined( 'ABSPATH' ) || exit;
include __DIR__ . '/_shared.php';
?>
<!-- 4. Sides -->
<?php bbq_section( 'Sides' ); ?>
<section class="section sides" aria-labelledby="sides-title">
  <div class="section-head">
    <span class="eyebrow eyebrow--glass"><?php bbq_text( 'sides_eyebrow', 'Sides and desserts', 'Label' ); ?></span>
    <h2 class="h2" id="sides-title"><?php bbq_text( 'sides_title', 'On the side', 'Heading' ); ?></h2>
    <p class="lead"><?php bbq_textarea( 'sides_lead', 'Allergen and nutrition information per market will be published here.', 'Intro text' ); ?></p>
  </div>
  <div class="row-slider" data-slider>
    <div class="side-grid" data-slider-viewport>
      <?php
      $sides = bbq_rows(
          'sides',
          'Side cards',
          array(
              'img'   => array( 'image', 'Photo' ),
              'title' => array( 'text', 'Name' ),
              'text'  => array( 'textarea', 'Description' ),
              'alt'   => array( 'text', 'Photo description (alt text)' ),
          ),
          array(
              array( 'img' => 'side-fries.jpg', 'title' => 'Fries', 'text' => 'Golden, crispy fries.', 'alt' => 'Fries in a bb.q fries box' ),
              array( 'img' => 'side-shaken-galaxy-fries.jpg', 'title' => 'Shaken Galaxy Fries', 'text' => 'Golden, crispy fries with our signature spiced cheese touch.', 'alt' => 'Shaken Galaxy Fries spilling out of their bag' ),
              array( 'img' => 'side-coleslaw.jpg', 'title' => 'Coleslaw', 'text' => 'Our classic, refreshing coleslaw with a creamy touch.', 'alt' => 'A bowl of coleslaw' ),
              array( 'img' => 'side-tteokbokki.jpg', 'title' => 'Tteokbokki', 'text' => 'Korean rice cakes, Classic Spicy or creamy Rose.', 'alt' => 'A cup of tteokbokki rice cakes' ),
              array( 'img' => 'side-chibboq-sweet-bites.jpg', 'title' => 'ChiBBoQ Sweet Bites', 'text' => 'Crispy, sweet rice bites. 3 or 5 pieces.', 'alt' => 'ChiBBoQ Sweet Bites' ),
          )
      );
      foreach ( $sides as $side ) :
          ?>
      <article class="side-card">
        <div class="side-card__img"><?php bbq_img( $side['img'], array( 'alt' => $side['alt'], 'width' => 560, 'height' => 420, 'loading' => 'lazy' ) ); ?></div>
        <h3 class="side-card__title"><?php bbq_e( $side['title'] ); ?></h3>
        <p class="side-card__text"><?php bbq_e( $side['text'] ); ?></p>
      </article>
      <?php endforeach; ?>
    </div>
    <div class="row-nav row-nav--light">
      <button class="row-nav__arrow" type="button" aria-label="Previous" data-slider-prev><?php bbq_icon( 'left' ); ?></button>
      <div class="row-nav__dots" data-slider-dots></div>
      <button class="row-nav__arrow" type="button" aria-label="Next" data-slider-next><?php bbq_icon( 'right' ); ?></button>
    </div>
  </div>
  <?php $sides_cta = bbq_link( 'sides_cta', array( 'label' => 'Order now', 'url' => 'page:home#find' ), 'Button' ); ?>
  <?php if ( $sides_cta['label'] ) : ?>
  <div class="btn-row sides__cta">
    <a class="btn btn--cream"<?php bbq_link_attrs( $sides_cta ); ?>><?php bbq_e( $sides_cta['label'] ); ?> <span class="btn__chip"><?php bbq_icon( 'arrow' ); ?></span></a>
  </div>
  <?php endif; ?>
</section>
