<?php
/**
 * Section "Chicken University" (discover page) · ACF layout: discover_chicken_university
 */
defined( 'ABSPATH' ) || exit;
include __DIR__ . '/_shared.php';
?>
<!-- 5. Chicken University (Our team pattern) -->
<?php bbq_section( 'Chicken University' ); ?>
<section class="section team university" aria-labelledby="university-title">
  <?php $uni_img = bbq_get( 'uni_img', 'chicken-university.jpg', 'Photo', 'image' ); ?>
  <div class="team__img"><?php bbq_img( $uni_img, array( 'alt' => bbq_get( 'uni_img_alt', 'Chicken University, bb.q\'s training and R&D campus in Korea', 'Photo description (alt text)' ), 'width' => 1520, 'height' => 776, 'loading' => 'lazy' ) ); ?></div>
  <div class="team__text">
    <span class="eyebrow"><?php bbq_text( 'uni_eyebrow', 'Chicken University', 'Label' ); ?></span>
    <h2 class="h2" id="university-title"><?php bbq_text( 'uni_title', 'Where every bb.q cook learns the recipe', 'Heading' ); ?></h2>
    <p class="lead"><?php bbq_textarea( 'uni_lead', 'Since 1999, bb.q has trained owners, managers and kitchen teams at its own campus in Korea. It\'s also where the R&D team develops new flavours. European partners and their teams train on the same programme.', 'Text' ); ?></p>
  </div>
</section>
