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
	'cut-fries.png'             => array( 480, 624 ),
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

<!-- 4. Sides -->
<?php bbq_section( 'Sides' ); ?>
<section class="section sides" aria-labelledby="sides-title">
  <div class="section-head">
    <span class="eyebrow eyebrow--glass"><?php bbq_text( 'sides_eyebrow', 'Sides and desserts', 'Label' ); ?></span>
    <h2 class="h2" id="sides-title"><?php bbq_text( 'sides_title', 'On the side', 'Heading' ); ?></h2>
    <p class="lead"><?php bbq_textarea( 'sides_lead', 'To drink: water, Coca-Cola, Fanta, Sprite, Fuze Tea, Aquarius and Monster. Allergen and nutrition information per market will be published here.', 'Intro text' ); ?></p>
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
              array( 'img' => 'side-shaken-galaxy-fries.jpg', 'title' => 'Shaken Galaxy Fries', 'text' => 'Golden, crispy fries with our signature spiced cheese seasoning.', 'alt' => 'Shaken Galaxy Fries spilling out of their bag' ),
              array( 'img' => 'side-tteokbokki.jpg', 'title' => 'Tteokbokki', 'text' => 'Korean rice cakes slow-cooked in our traditional spicy sauce (Classic Spicy), or the creamier Rose, with cream and a touch of heat.', 'alt' => 'A cup of tteokbokki rice cakes' ),
              array( 'img' => 'side-coleslaw.jpg', 'title' => 'Coleslaw', 'text' => 'Our classic, refreshing coleslaw with a creamy touch.', 'alt' => 'A bowl of coleslaw' ),
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

<!-- 5. Closing CTA (Closing CTA pattern) -->
<?php bbq_section( 'Closing call to action' ); ?>
<section class="section closing" aria-labelledby="closing-title">
  <div class="stamp"><?php bbq_stamp(); ?></div>
  <span class="sparkle-lg" aria-hidden="true"><?php bbq_icon( 'sparkleplain' ); ?></span>
  <span class="sparkle-sm" aria-hidden="true"><?php bbq_icon( 'sparkleplain' ); ?></span>
  <div class="cta-card">
    <h2 class="h2" id="closing-title"><?php bbq_text( 'closing_title', 'Hungry already?', 'Heading' ); ?></h2>
    <p class="lead"><?php bbq_textarea( 'closing_lead', 'Order from our first kitchens in Madrid, or find the bb.q nearest to you.', 'Text' ); ?></p>
    <?php $closing_cta = bbq_link( 'closing_cta', array( 'label' => 'Order now', 'url' => 'page:home#find' ), 'Button' ); ?>
    <?php if ( $closing_cta['label'] ) : ?>
    <a class="btn btn--red"<?php bbq_link_attrs( $closing_cta, ' data-hides-floating' ); ?>><?php bbq_e( $closing_cta['label'] ); ?> <span class="btn__chip"><?php bbq_icon( 'arrow' ); ?></span></a>
    <?php endif; ?>
  </div>
  <div class="cutout cutout--shadow-dark cutout--fried"><?php bbq_image( 'closing_img', 'cut-2pcs-fried.png', 'Chicken cut-out', array( 'alt' => '', 'width' => 880, 'height' => 463, 'loading' => 'lazy' ) ); ?></div>
</section>
