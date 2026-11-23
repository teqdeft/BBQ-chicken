<?php
/**
 * Section "Genesis BBQ" (about page) · ACF layout: about_genesis_bbq
 */
defined( 'ABSPATH' ) || exit;
include __DIR__ . '/_shared.php';
?>
<!-- 5. Relationship (Our team pattern) -->
<?php bbq_section( 'Genesis BBQ' ); ?>
<section class="section team relation" aria-labelledby="relation-title">
  <div class="team__text">
    <span class="eyebrow"><?php bbq_text( 'relation_eyebrow', 'Part of the bb.q family', 'Label' ); ?></span>
    <h2 class="h2" id="relation-title"><?php bbq_text( 'relation_title', 'Backed by Genesis BBQ in Seoul', 'Heading' ); ?></h2>
    <p class="lead"><?php bbq_textarea( 'relation_lead', 'bb.q Chicken is part of Genesis BBQ Group, Korea\'s largest foodservice franchise company. BLT Global Brands develops the brand in Europe as its franchisor.', 'Text' ); ?></p>
    <?php $relation_cta = bbq_link( 'relation_cta', array( 'label' => 'Discover bb.q', 'url' => 'page:discover' ), 'Button' ); ?>
    <?php if ( $relation_cta['label'] ) : ?>
    <div class="btn-row"><a class="btn btn--outline-dark"<?php bbq_link_attrs( $relation_cta ); ?>><?php bbq_e( $relation_cta['label'] ); ?> <span class="btn__chip"><?php bbq_icon( 'arrow' ); ?></span></a></div>
    <?php endif; ?>
  </div>
  <?php $relation_img = bbq_get( 'relation_img', 'genesis-bbq-hq.jpg', 'Photo', 'image' ); ?>
  <div class="team__img"><?php bbq_img( $relation_img, array( 'alt' => bbq_get( 'relation_img_alt', 'The Genesis BBQ headquarters in Seoul', 'Photo description (alt text)' ), 'width' => 1520, 'height' => 1140, 'loading' => 'lazy' ) ); ?></div>
</section>
