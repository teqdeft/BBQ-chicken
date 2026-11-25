<?php
/**
 * Section "ChiBBoQ (mascot)" (discover page) · ACF layout: discover_chibboq
 */
defined( 'ABSPATH' ) || exit;
include __DIR__ . '/_shared.php';
?>
<!-- 6. Mascot (Mascot pattern) -->
<?php bbq_section( 'ChiBBoQ (mascot)' ); ?>
<section class="section mascot" id="chibboq" aria-labelledby="mascot-title">
  <?php $mascot_img = bbq_get( 'mascot_img', 'chibboq-sitting-cutout.png', 'Image', 'image' ); ?>
  <div class="mascot__img"><?php bbq_img( $mascot_img, array( 'alt' => bbq_get( 'mascot_img_alt', 'ChiBBoQ, the bb.q mascot, sitting', 'Image description (alt text)' ), 'width' => 582, 'height' => 991, 'loading' => 'lazy' ) ); ?></div>
  <div class="mascot__text">
    <span class="eyebrow eyebrow--dark"><?php bbq_text( 'mascot_eyebrow', 'For the whole family', 'Label' ); ?></span>
    <h2 class="h2" id="mascot-title"><?php bbq_text( 'mascot_title', 'ChiBBoQ and friends', 'Heading' ); ?></h2>
    <p><?php bbq_textarea( 'mascot_text', 'ChiBBoQ, Ollie and Chiky are the softest residents of Genesis Village. They live on our boxes and bags, pop up in restaurants now and then, and keep the youngest guests busy while the grown-ups finish the tenders.', 'Text' ); ?></p>
    <?php $mascot_cta = bbq_link( 'mascot_cta', array( 'label' => 'Follow ChiBBoQ on Instagram', 'url' => 'https://www.instagram.com/chibboq_official/', 'new_tab' => true ), 'Button (Instagram link)' ); ?>
    <?php if ( $mascot_cta['label'] ) : ?>
    <div class="btn-row"><a class="btn btn--outline-light"<?php bbq_link_attrs( $mascot_cta ); ?>><?php bbq_e( $mascot_cta['label'] ); ?> <span class="btn__chip"><?php bbq_icon( 'arrow' ); ?></span></a></div>
    <?php endif; ?>
  </div>
</section>
