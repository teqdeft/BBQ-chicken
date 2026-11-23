<?php
/**
 * Section "Closing call to action" (menu page) · ACF layout: menu_closing_call_to_action
 */
defined( 'ABSPATH' ) || exit;
include __DIR__ . '/_shared.php';
?>
<!-- 5. Closing CTA (Closing CTA pattern) -->
<?php bbq_section( 'Closing call to action' ); ?>
<section class="section closing" aria-labelledby="closing-title">
  <div class="stamp"><?php bbq_stamp(); ?></div>
  <span class="sparkle-lg" aria-hidden="true"><?php bbq_icon( 'sparkleplain' ); ?></span>
  <span class="sparkle-sm" aria-hidden="true"><?php bbq_icon( 'sparkleplain' ); ?></span>
  <div class="cta-card">
    <h2 class="h2" id="closing-title"><?php bbq_text( 'closing_title', 'Hungry already?', 'Heading' ); ?></h2>
    <p class="lead"><?php bbq_textarea( 'closing_lead', 'Order from our first kitchens in Madrid, or find the bb.q nearest to you.', 'Text' ); ?></p>
    <?php $closing_cta = bbq_link( 'closing_cta', array( 'label' => 'Order now', 'url' => 'page:home#find' ), 'Button' ); ?>
    <?php if ( $closing_cta['label'] ) : ?>
    <a class="btn btn--red"<?php bbq_link_attrs( $closing_cta, ' data-hides-floating' ); ?>><?php bbq_e( $closing_cta['label'] ); ?> <span class="btn__chip"><?php bbq_icon( 'arrow' ); ?></span></a>
    <?php endif; ?>
  </div>
  <div class="cutout cutout--shadow-dark cutout--fried"><?php bbq_image( 'closing_img', 'cut-2pcs-fried.png', 'Chicken cut-out', array( 'alt' => '', 'width' => 880, 'height' => 463, 'loading' => 'lazy' ) ); ?></div>
</section>
