<?php
/**
 * Section "Mascot (ChiBBoQ)" (home page) · ACF layout: home_mascot
 */
defined( 'ABSPATH' ) || exit;
include __DIR__ . '/_shared.php';
?>
<!-- 10. Mascot -->
<?php bbq_section( 'Mascot (ChiBBoQ)' ); ?>
<section class="section mascot" aria-labelledby="mascot-title">
  <?php $mascot = bbq_get( 'mascot_img', 'chibboq-sitting-cutout.png', 'Image', 'image' ); ?>
  <div class="mascot__img"><?php bbq_img( $mascot, array( 'alt' => bbq_get( 'mascot_alt', 'ChiBBoQ, the bb.q mascot, sitting', 'Image description (alt text)' ), 'width' => 582, 'height' => 991, 'loading' => 'lazy' ) ); ?></div>
  <div class="mascot__text">
    <span class="eyebrow"><?php bbq_text( 'mascot_eyebrow', 'For the whole family', 'Label' ); ?></span>
    <h2 class="h2" id="mascot-title"><?php bbq_text( 'mascot_title', 'Meet ChiBBoQ', 'Heading' ); ?></h2>
    <p><?php bbq_textarea( 'mascot_text', 'ChiBBoQ is the softest member of the bb.q family. You\'ll find them on our boxes and bags, peeking in at the counter and now and then dressed for the occasion. Kids tend to remember them long after the last tender is gone.', 'Text' ); ?></p>
    <?php $l = bbq_link( 'mascot_btn', array( 'label' => 'Follow ChiBBoQ on Instagram', 'url' => '#', 'new_tab' => true ), 'Button (Instagram link)' ); ?>
    <div class="btn-row"><a class="btn btn--outline-light"<?php bbq_link_attrs( $l ); ?>><?php bbq_e( $l['label'] ); ?> <span class="btn__chip"><?php bbq_icon( 'arrow' ); ?></span></a></div>
  </div>
</section>
