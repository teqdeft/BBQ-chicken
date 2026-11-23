<?php
/**
 * Section "Hero" (discover page) · ACF layout: discover_hero
 */
defined( 'ABSPATH' ) || exit;
include __DIR__ . '/_shared.php';
?>
<!-- 1. Hero (Hero pattern) -->
<?php bbq_section( 'Hero' ); ?>
<section class="section page-hero" aria-labelledby="discover-title">
  <?php $hero_img = bbq_get( 'hero_img', 'cut-8pcs-secret-sauce-bucket.png', 'Image', 'image' ); ?>
  <div class="page-hero__media"><?php bbq_img( $hero_img, array( 'alt' => bbq_get( 'hero_img_alt', 'A bucket of chicken glazed in Secret Sauce', 'Image description (alt text)' ), 'width' => 760, 'height' => 962 ) ); ?></div>
  <div class="page-hero__text">
    <span class="eyebrow eyebrow--glass"><?php bbq_text( 'hero_eyebrow', 'Discover bb.q', 'Label' ); ?></span>
    <h1 class="h-display" id="discover-title"><?php bbq_text( 'hero_title', 'Best of the Best Quality, since 1995.', 'Heading' ); ?></h1>
    <p class="lead"><?php bbq_textarea( 'hero_lead', 'bb.q stands for Best of the Best Quality. It started with one small restaurant in Korea in 1995 and grew into the country\'s best-known fried chicken brand. Today you\'ll find it from Seoul to New York, and soon across Europe.', 'Intro text' ); ?></p>
    <?php
    $hero_cta1 = bbq_link( 'hero_cta1', array( 'label' => 'See the menu', 'url' => 'page:menu' ), 'Primary button' );
    $hero_cta2 = bbq_link( 'hero_cta2', array( 'label' => 'Submit your application', 'url' => 'page:apply' ), 'Secondary button' );
    ?>
    <?php if ( $hero_cta1['label'] || $hero_cta2['label'] ) : ?>
    <div class="btn-row">
      <?php if ( $hero_cta1['label'] ) : ?>
      <a class="btn btn--cream"<?php bbq_link_attrs( $hero_cta1 ); ?>><?php bbq_e( $hero_cta1['label'] ); ?> <span class="btn__chip"><?php bbq_icon( 'arrow' ); ?></span></a>
      <?php endif; ?>
      <?php if ( $hero_cta2['label'] ) : ?>
      <a class="btn btn--outline-light"<?php bbq_link_attrs( $hero_cta2 ); ?>><?php bbq_e( $hero_cta2['label'] ); ?> <span class="btn__chip"><?php bbq_icon( 'arrow' ); ?></span></a>
      <?php endif; ?>
    </div>
    <?php endif; ?>
  </div>
  <div class="stamp"><?php bbq_stamp(); ?></div>
</section>
