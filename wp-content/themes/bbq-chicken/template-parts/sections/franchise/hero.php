<?php
/**
 * Section "Hero" (franchise page) · ACF layout: franchise_hero
 */
defined( 'ABSPATH' ) || exit;
include __DIR__ . '/_shared.php';
?>
<!-- 1. Hero -->
<?php bbq_section( 'Hero' ); ?>
<section class="section page-hero franchise-hero" aria-labelledby="franchise-title">
  <div class="page-hero__text">
    <span class="eyebrow eyebrow--glass"><?php bbq_text( 'hero_eyebrow', 'Franchise', 'Label' ); ?></span>
    <h1 class="h-display" id="franchise-title"><?php bbq_text( 'hero_title', 'Bring bb.q Chicken to your market.', 'Heading' ); ?></h1>
    <p class="lead"><?php bbq_textarea( 'hero_lead', 'Ready to join the bb.q Chicken franchise network in Europe? We\'re looking for experienced operators to open bb.q restaurants across the continent.', 'Intro text' ); ?></p>
    <?php $hero_cta = bbq_link( 'hero_cta', array( 'label' => 'Submit your application', 'url' => 'page:apply' ), 'Button' ); ?>
    <?php if ( $hero_cta['label'] ) : ?>
    <div class="btn-row">
      <a class="btn btn--cream"<?php bbq_link_attrs( $hero_cta ); ?>><?php bbq_e( $hero_cta['label'] ); ?> <span class="btn__chip"><?php bbq_icon( 'arrow' ); ?></span></a>
    </div>
    <?php endif; ?>
  </div>
  <div class="page-hero__media"><?php bbq_image( 'hero_img', 'cut-bucket-spill.png', 'Image', array( 'alt' => '', 'width' => 840, 'height' => 599, 'fetchpriority' => 'high' ) ); ?></div>
  <div class="stamp"><?php bbq_stamp(); ?></div>
</section>
