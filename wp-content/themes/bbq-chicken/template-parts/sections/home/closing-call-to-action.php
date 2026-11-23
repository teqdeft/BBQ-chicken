<?php
/**
 * Section "Closing call to action" (home page) · ACF layout: home_closing_call_to_action
 */
defined( 'ABSPATH' ) || exit;
include __DIR__ . '/_shared.php';
?>
<!-- 14. Closing CTA -->
<?php bbq_section( 'Closing call to action' ); ?>
<section class="section closing" aria-labelledby="closing-title">
  <div class="stamp"><?php bbq_stamp(); ?></div>
  <span class="sparkle-lg" aria-hidden="true"><?php bbq_icon( 'sparkleplain' ); ?></span>
  <span class="sparkle-sm" aria-hidden="true"><?php bbq_icon( 'sparkleplain' ); ?></span>
  <div class="cta-card">
    <h2 class="h2" id="closing-title"><?php bbq_text( 'closing_title', 'Ready to bring bb.q to your market?', 'Heading' ); ?></h2>
    <p class="lead"><?php bbq_textarea( 'closing_lead', 'Tell us who you are and where you\'d like to grow. It takes two minutes. Our European team reads every enquiry and gets back to you personally.', 'Text' ); ?></p>
    <?php $l = bbq_link( 'closing_btn', array( 'label' => 'Submit your application', 'url' => 'page:apply' ), 'Button' ); ?>
    <a class="btn btn--red"<?php bbq_link_attrs( $l, ' data-hides-floating' ); ?>><?php bbq_e( $l['label'] ); ?> <span class="btn__chip"><?php bbq_icon( 'arrow' ); ?></span></a>
  </div>
  <div class="cutout cutout--shadow-dark cutout--fried"><?php bbq_image( 'closing_cut', 'cut-2pcs-fried.png', 'Cut-out image', array( 'alt' => '', 'width' => 880, 'height' => 463, 'loading' => 'lazy' ) ); ?></div>
</section>
