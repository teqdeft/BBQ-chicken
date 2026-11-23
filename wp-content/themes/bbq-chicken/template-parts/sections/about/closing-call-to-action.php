<?php
/**
 * Section "Closing call to action" (about page) · ACF layout: about_closing_call_to_action
 */
defined( 'ABSPATH' ) || exit;
include __DIR__ . '/_shared.php';
?>
<!-- 6. Closing CTA (Closing CTA pattern) -->
<?php bbq_section( 'Closing call to action' ); ?>
<section class="section closing" aria-labelledby="closing-title">
  <div class="stamp"><?php bbq_stamp(); ?></div>
  <span class="sparkle-lg" aria-hidden="true"><?php bbq_icon( 'sparkleplain' ); ?></span>
  <span class="sparkle-sm" aria-hidden="true"><?php bbq_icon( 'sparkleplain' ); ?></span>
  <div class="cta-card">
    <h2 class="h2" id="closing-title"><?php bbq_text( 'closing_title', 'Let\'s build bb.q in your market', 'Heading' ); ?></h2>
    <p class="lead"><?php bbq_textarea( 'closing_lead', 'We\'re looking for partners right across Europe.', 'Text' ); ?></p>
    <?php
    $closing_cta1 = bbq_link( 'closing_cta1', array( 'label' => 'Submit your application', 'url' => 'page:apply' ), 'Primary button' );
    $closing_cta2 = bbq_link( 'closing_cta2', array( 'label' => 'Contact us', 'url' => 'page:contact' ), 'Secondary button' );
    ?>
    <?php if ( $closing_cta1['label'] || $closing_cta2['label'] ) : ?>
    <div class="btn-row">
      <?php if ( $closing_cta1['label'] ) : ?>
      <a class="btn btn--red"<?php bbq_link_attrs( $closing_cta1, ' data-hides-floating' ); ?>><?php bbq_e( $closing_cta1['label'] ); ?> <span class="btn__chip"><?php bbq_icon( 'arrow' ); ?></span></a>
      <?php endif; ?>
      <?php if ( $closing_cta2['label'] ) : ?>
      <a class="btn btn--outline-dark"<?php bbq_link_attrs( $closing_cta2 ); ?>><?php bbq_e( $closing_cta2['label'] ); ?> <span class="btn__chip"><?php bbq_icon( 'arrow' ); ?></span></a>
      <?php endif; ?>
    </div>
    <?php endif; ?>
  </div>
  <div class="cutout cutout--shadow-dark cutout--fried"><?php bbq_image( 'closing_img', 'cut-2pcs-fried.png', 'Chicken cut-out', array( 'alt' => '', 'width' => 880, 'height' => 463, 'loading' => 'lazy' ) ); ?></div>
</section>
