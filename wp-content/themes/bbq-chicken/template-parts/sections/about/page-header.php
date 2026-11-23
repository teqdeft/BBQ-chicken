<?php
/**
 * Section "Page header" (about page) · ACF layout: about_page_header
 */
defined( 'ABSPATH' ) || exit;
include __DIR__ . '/_shared.php';
?>
<!-- 1. Hero: BLT Global Brands (Our team pattern) -->
<?php bbq_section( 'Page header' ); ?>
<section class="section team about-hero" aria-labelledby="about-title">
  <?php
  $hero_img   = bbq_get( 'hero_img', 'team.jpg', 'Team photo', 'image' );
  $hero_img_m = bbq_get( 'hero_img_mobile', 'european-team.jpg', 'Team photo on phones', 'image' );
  $hero_alt   = bbq_get( 'hero_img_alt', 'The BLT Global Brands team in Europe', 'Photo description (alt text)' );
  ?>
  <div class="team__img">
    <picture>
      <?php bbq_about_source( $hero_img_m, '(max-width: 767px)', 768, 526 ); ?>
      <?php bbq_img( $hero_img, array( 'alt' => $hero_alt, 'width' => 1600, 'height' => 968 ) ); ?>
    </picture>
  </div>
  <div class="team__text">
    <span class="eyebrow"><?php bbq_text( 'hero_eyebrow', 'BLT Global Brands', 'Label' ); ?></span>
    <h1 class="h2" id="about-title"><?php bbq_text( 'hero_title', 'Global excellence, local expertise', 'Heading' ); ?></h1>
    <div class="lead about-hero__body">
      <?php
      $hero_body = bbq_rows(
          'hero_body',
          'Text paragraphs',
          array( 'text' => array( 'textarea', 'Paragraph' ) ),
          array(
              array( 'text' => 'BLT Global Brands acts as a strategic master partner and operating force across European markets. We bridge the gap between world-class brand heritage and neighbourhood-level execution through agile infrastructure, robust supply chain logistics, and dedicated local marketing support.' ),
              array( 'text' => 'Our core commitment is to bring the most beloved brands to neighbourhoods worldwide while maintaining high ethical standards and improving the quality of life for our communities, customers, and employees.' ),
          )
      );
      foreach ( $hero_body as $para ) :
          ?>
      <p><?php bbq_e( $para['text'] ); ?></p>
      <?php endforeach; ?>
    </div>
  </div>
</section>
