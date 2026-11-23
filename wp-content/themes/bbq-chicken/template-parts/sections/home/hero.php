<?php
/**
 * Section "Hero" (home page) · ACF layout: home_hero
 */
defined( 'ABSPATH' ) || exit;
include __DIR__ . '/_shared.php';
?>
<!-- 2. Hero -->
<?php bbq_section( 'Hero' ); ?>
<section class="hero hero--home" aria-labelledby="hero-title">
  <div class="hero__cutouts" aria-hidden="true">
    <div class="cutout hero__cut hero__cut--left"><?php bbq_image( 'hero_cut_left', 'cut-bucket-09.png', 'Cut-out image, left', array( 'alt' => '', 'width' => 832, 'height' => 671, 'loading' => 'lazy' ) ); ?></div>
    <div class="cutout hero__cut hero__cut--right"><?php bbq_image( 'hero_cut_right', 'cut-8pcs-fried-bucket.png', 'Cut-out image, right', array( 'alt' => '', 'width' => 660, 'height' => 838, 'loading' => 'lazy' ) ); ?></div>
  </div>
  <?php bbq_image( 'hero_mobile_bg', 'hero-mobile.jpg', 'Background photo on phones', array( 'class' => 'hero__mobile-bg', 'alt' => '', 'width' => 800, 'height' => 1000, 'loading' => 'lazy', 'style' => 'display:none' ) ); ?>
  <div class="hero__content">
    <h2 class="h-display hero__title" id="hero-title"><?php bbq_text( 'hero_title', 'Korea\'s favourite fried chicken is now in Europe.', 'Heading' ); ?></h2>
    <p class="hero__lead"><?php bbq_textarea( 'hero_lead', 'Double-fried for real crunch, with sauces from Secret Sauce to Jasoman, and made for sharing. More than 3,500 restaurants worldwide since 1995. Now delivering in Europe.', 'Intro text' ); ?></p>
    <div class="btn-row">
      <?php $l = bbq_link( 'hero_btn1', array( 'label' => 'Order now', 'url' => '#find' ), 'First button' ); ?>
      <a class="btn btn--cream"<?php bbq_link_attrs( $l ); ?>><?php bbq_e( $l['label'] ); ?> <span class="btn__chip"><?php bbq_icon( 'arrow' ); ?></span></a>
      <?php $l = bbq_link( 'hero_btn2', array( 'label' => 'Find a restaurant', 'url' => '#find' ), 'Second button' ); ?>
      <a class="btn btn--outline-light"<?php bbq_link_attrs( $l ); ?>><?php bbq_e( $l['label'] ); ?> <span class="btn__chip"><?php bbq_icon( 'arrow' ); ?></span></a>
    </div>
  </div>
  <div class="stamp"><?php bbq_stamp(); ?></div>
</section>
