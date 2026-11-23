<?php
/**
 * Section "Hero" (real-estate page) · ACF layout: real_estate_hero
 */
defined( 'ABSPATH' ) || exit;
include __DIR__ . '/_shared.php';
?>
<!-- 1. Hero: red glow with two food cut-outs on desktop (Figma v4); mobile keeps the photo hero -->
<?php bbq_section( 'Hero' ); ?>
<section class="hero re-hero" aria-labelledby="re-hero-title">
  <div class="re-hero__cutout re-hero__cutout--sauce" aria-hidden="true"><?php bbq_image( 'hero_cutout_left', 'cut-2pcs-secret-sauce.png', 'Cut-out, bottom left (desktop)', array( 'alt' => '', 'width' => 760, 'height' => 412 ) ); ?></div>
  <div class="re-hero__cutout re-hero__cutout--fried" aria-hidden="true"><?php bbq_image( 'hero_cutout_right', 'cut-2pcs-fried.png', 'Cut-out, bottom right (desktop)', array( 'alt' => '', 'width' => 880, 'height' => 463 ) ); ?></div>
  <?php bbq_image( 'hero_mobile_img', 'hero-mobile.jpg', 'Background photo (phones)', array( 'class' => 'hero__mobile-bg', 'alt' => '', 'width' => 800, 'height' => 1000, 'style' => 'display:none' ) ); ?>
  <div class="hero__content">
    <h1 class="h-display hero__title" id="re-hero-title"><?php bbq_text( 'hero_title', 'Got premises that suit bb.q?', 'Heading' ); ?></h1>
    <p class="hero__lead"><?php bbq_textarea( 'hero_lead', "We're looking for busy, visible locations for bb.q restaurants across Europe. Landlords, agents and developers: tell us about your premises, and we'll tell you quickly whether it fits.", 'Intro text' ); ?></p>
    <?php $hero_cta = bbq_link( 'hero_cta', array( 'label' => 'Offer your premises', 'url' => '#offer' ), 'Button' ); ?>
    <?php if ( $hero_cta['label'] ) : ?>
    <div class="btn-row">
      <a class="btn btn--cream"<?php bbq_link_attrs( $hero_cta ); ?>><?php bbq_e( $hero_cta['label'] ); ?> <span class="btn__chip"><?php bbq_icon( 'arrow' ); ?></span></a>
    </div>
    <?php endif; ?>
  </div>
  <div class="stamp"><?php bbq_stamp(); ?></div>
</section>
