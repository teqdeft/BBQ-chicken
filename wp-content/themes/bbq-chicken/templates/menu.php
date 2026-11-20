<?php
/**
 * The menu page.
 * Static source: html-backup/src/pages/menu.html
 * Helpers: inc/parts/menu.php (chilli rating of the sauce cards).
 */
defined( 'ABSPATH' ) || exit;

// Size attributes of the design's card images (media-library images bring their own).
$img_dims = array(
	'cut-2pcs-fried.png'        => array( 880, 463 ),
	'cut-tenders-3pcs.png'      => array( 880, 573 ),
	'cut-burger.png'            => array( 848, 674 ),
	'cut-wrap.png'              => array( 848, 608 ),
	'cut-bowl.png'              => array( 848, 734 ),
	'cut-8pcs-fried-bucket.png' => array( 660, 838 ),
);
?>

<!-- 1. Hero (Hero pattern) -->
<?php bbq_section( 'Hero' ); ?>
<section class="section page-hero" aria-labelledby="menu-title">
  <?php $hero_img = bbq_get( 'hero_img', 'cut-8pcs-fried-bucket.png', 'Image', 'image' ); ?>
  <div class="page-hero__media"><?php bbq_img( $hero_img, array( 'alt' => bbq_get( 'hero_img_alt', 'A bucket of golden fried chicken', 'Image description (alt text)' ), 'width' => 660, 'height' => 838 ) ); ?></div>
  <div class="page-hero__text">
    <span class="eyebrow eyebrow--glass"><?php bbq_text( 'hero_eyebrow', 'The menu', 'Label' ); ?></span>
    <h1 class="h-display" id="menu-title"><?php bbq_text( 'hero_title', 'Golden, crispy and sauced your way.', 'Heading' ); ?></h1>
    <p class="lead"><?php bbq_textarea( 'hero_lead', 'Our European menu is built around quick-service favourites: boneless, tenders, burgers, wraps and bowls, with a few Korean sides for the curious.', 'Intro text' ); ?></p>
    <?php $hero_cta = bbq_link( 'hero_cta', array( 'label' => 'Order now', 'url' => 'page:home#find' ), 'Button' ); ?>
    <?php if ( $hero_cta['label'] ) : ?>
    <div class="btn-row">
      <a class="btn btn--cream"<?php bbq_link_attrs( $hero_cta ); ?>><?php bbq_e( $hero_cta['label'] ); ?> <span class="btn__chip"><?php bbq_icon( 'arrow' ); ?></span></a>
    </div>
    <?php endif; ?>
  </div>
  <div class="stamp"><?php bbq_stamp(); ?></div>
</section>

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
              array( 'style' => 'dark', 'img' => 'cut-2pcs-fried.png', 'title' => 'Real Korean Fried Chicken', 'text' => 'Golden Original, double-fried. 2, 4 or 8 pieces.', 'alt' => 'Two pieces of golden fried chicken' ),
              array( 'style' => 'red', 'img' => 'cut-tenders-3pcs.png', 'title' => 'Real Crispy Tenders', 'text' => 'Crispy chicken strips. 3, 6 or 12 pieces.', 'alt' => 'Three crispy chicken tenders' ),
              array( 'style' => 'wine', 'img' => 'cut-burger.png', 'title' => 'Crispy Chicken Burger', 'text' => 'Crispy chicken in a soft bun.', 'alt' => 'A crispy chicken burger' ),
              array( 'style' => 'wine', 'img' => 'cut-wrap.png', 'title' => 'Wraps', 'text' => 'Crispy or grilled chicken, wrapped to go.', 'alt' => 'A chicken wrap' ),
              array( 'style' => 'dark', 'img' => 'cut-bowl.png', 'title' => 'Rice and salad bowls', 'text' => 'Crispy or grilled chicken on rice or salad.', 'alt' => 'A chicken rice bowl' ),
              array( 'style' => 'red', 'img' => 'cut-8pcs-fried-bucket.png', 'title' => 'Mega Party Bucket', 'text' => 'Our biggest box of Real Korean Fried Chicken, made for sharing.', 'alt' => 'A bucket of fried chicken' ),
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
              'note'  => array( 'text', 'Note after the chillies, e.g. "(draft)" (optional)' ),
              'alt'   => array( 'text', 'Photo description (alt text)' ),
          ),
          array(
              array( 'img' => 'sauce-secret-sauce.jpg', 'title' => 'Secret Sauce', 'text' => 'Sweet and chilli, the bb.q classic.', 'spice' => '1', 'note' => '(draft)', 'alt' => 'A bowl of Secret Sauce' ),
              array( 'img' => 'sauce-galbi.jpg', 'title' => 'Galbi', 'text' => 'Sweet and sour, smoky Korean barbecue sauce.', 'spice' => '0', 'note' => '(draft)', 'alt' => 'A bowl of Galbi sauce' ),
              array( 'img' => 'sauce-gangjeong.jpg', 'title' => 'Gangjeong', 'text' => 'Sweet, crunchy and slightly spicy.', 'spice' => '1', 'note' => '(draft)', 'alt' => 'A bowl of Gangjeong sauce' ),
              array( 'img' => 'sauce-jasoman.jpg', 'title' => 'Jasoman', 'text' => '[Description to follow from BLT]', 'spice' => '2', 'note' => '(draft)', 'alt' => 'A bowl of Jasoman sauce' ),
              array( 'img' => 'sauce-cheesling.jpg', 'title' => 'Cheesling', 'text' => '[Description to follow from BLT]', 'spice' => '0', 'note' => '(draft)', 'alt' => 'A bowl of Cheesling seasoning' ),
              array( 'img' => 'sauce-red-chak-chak-mayo.jpg', 'title' => 'Red Chak Chak Mayo', 'text' => '[Description to follow from BLT]', 'spice' => 'tbc', 'note' => '(to be confirmed)', 'alt' => 'A bowl of Red Chak Chak Mayo' ),
              array( 'img' => 'sauce-galbi-mayo.jpg', 'title' => 'Galbi Mayo', 'text' => 'Creamy mayonnaise with the sweet and sour touch of Galbi.', 'spice' => '0', 'note' => '(draft)', 'alt' => 'A bowl of Galbi Mayo' ),
              array( 'img' => 'sauce-garlic-mayo.jpg', 'title' => 'Garlic Mayo', 'text' => '[Description to follow from BLT]', 'spice' => 'tbc', 'note' => '(to be confirmed)', 'alt' => 'A bowl of Garlic Mayo' ),
              array( 'img' => 'sauce-jamaica-mayo.jpg', 'title' => 'Jamaica Mayo', 'text' => '[Description to follow from BLT]', 'spice' => 'tbc', 'note' => '(to be confirmed)', 'alt' => 'A bowl of Jamaica Mayo' ),
          )
      );
      foreach ( $sauces as $sauce ) :
          ?>
      <article class="sauce">
        <div class="sauce__img"><?php bbq_img( $sauce['img'], array( 'alt' => $sauce['alt'], 'width' => 900, 'height' => 422, 'loading' => 'lazy' ) ); ?></div>
        <h3 class="sauce__title"><?php bbq_e( $sauce['title'] ); ?></h3>
        <p class="sauce__text"><?php bbq_e( $sauce['text'] ); ?></p>
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

<!-- 4. Sides -->
<?php bbq_section( 'Sides' ); ?>
<section class="section sides" aria-labelledby="sides-title">
  <div class="section-head">
    <span class="eyebrow eyebrow--glass"><?php bbq_text( 'sides_eyebrow', 'Sides', 'Label' ); ?></span>
    <h2 class="h2" id="sides-title"><?php bbq_text( 'sides_title', 'On the side', 'Heading' ); ?></h2>
    <p class="lead"><?php bbq_textarea( 'sides_lead', 'Allergen and nutrition information per market will be published here. [Content and legal check by BLT per country]', 'Intro text' ); ?></p>
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
              array( 'img' => 'side-fries.jpg', 'title' => 'Fries', 'text' => 'Crispy, salted, the obvious partner.', 'alt' => 'Fries in a bb.q fries box' ),
              array( 'img' => 'side-shaken-galaxy-fries.jpg', 'title' => 'Shaken Galaxy Fries', 'text' => 'Golden and crispy fries with our signature cheese topping.', 'alt' => 'Shaken Galaxy Fries spilling out of their bag' ),
              array( 'img' => 'side-coleslaw.jpg', 'title' => 'Coleslaw', 'text' => 'Cool, creamy and sweet.', 'alt' => 'A bowl of coleslaw' ),
              array( 'img' => 'side-tteokbokki.jpg', 'title' => 'Tteokbokki', 'text' => 'Chewy rice cakes, Classic Spicy or Rose.', 'alt' => 'A cup of tteokbokki rice cakes' ),
              array( 'img' => 'side-chibboq-sweet-bites.jpg', 'title' => 'ChiBBoQ Sweet Bites', 'text' => '3 or 5 pieces, dusted with cinnamon sugar.', 'alt' => 'ChiBBoQ Sweet Bites dusted with cinnamon sugar' ),
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

<!-- 5. Closing CTA (Closing CTA pattern) -->
<?php bbq_section( 'Closing call to action' ); ?>
<section class="section closing" aria-labelledby="closing-title">
  <div class="stamp"><?php bbq_stamp(); ?></div>
  <span class="sparkle-lg" aria-hidden="true"><?php bbq_icon( 'sparkleplain' ); ?></span>
  <span class="sparkle-sm" aria-hidden="true"><?php bbq_icon( 'sparkleplain' ); ?></span>
  <div class="cta-card">
    <h2 class="h2" id="closing-title"><?php bbq_text( 'closing_title', 'Hungry already?', 'Heading' ); ?></h2>
    <p class="lead"><?php bbq_textarea( 'closing_lead', 'Order from our first kitchens in [Madrid], or find the bb.q nearest to you.', 'Text' ); ?></p>
    <?php $closing_cta = bbq_link( 'closing_cta', array( 'label' => 'Order now', 'url' => 'page:home#find' ), 'Button' ); ?>
    <?php if ( $closing_cta['label'] ) : ?>
    <a class="btn btn--red"<?php bbq_link_attrs( $closing_cta, ' data-hides-floating' ); ?>><?php bbq_e( $closing_cta['label'] ); ?> <span class="btn__chip"><?php bbq_icon( 'arrow' ); ?></span></a>
    <?php endif; ?>
  </div>
  <div class="cutout cutout--shadow-dark cutout--fried"><?php bbq_image( 'closing_img', 'cut-2pcs-fried.png', 'Chicken cut-out', array( 'alt' => '', 'width' => 880, 'height' => 463, 'loading' => 'lazy' ) ); ?></div>
</section>
