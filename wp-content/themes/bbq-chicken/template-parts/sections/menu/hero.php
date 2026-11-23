<?php
/**
 * Section "Hero" (menu page) · ACF layout: menu_hero
 */
defined( 'ABSPATH' ) || exit;
include __DIR__ . '/_shared.php';
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
