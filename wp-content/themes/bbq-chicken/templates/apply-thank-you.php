<?php
/**
 * Apply – Thank you (shown after a successful application on the Franchise or Apply page).
 * Static source: html-backup/src/pages/apply-thank-you.html
 */
defined( 'ABSPATH' ) || exit;
?>
<!-- 1. Confirmation -->
<?php bbq_section( 'Confirmation' ); ?>
<section class="section closing thanks" aria-labelledby="thanks-title">
  <div class="stamp"><?php bbq_stamp(); ?></div>
  <span class="sparkle-lg" aria-hidden="true"><?php bbq_icon( 'sparkleplain' ); ?></span>
  <span class="sparkle-sm" aria-hidden="true"><?php bbq_icon( 'sparkleplain' ); ?></span>
  <div class="cta-card">
    <h1 class="h2" id="thanks-title"><?php bbq_text( 'title', 'Thanks, we\'ve got it.', 'Heading' ); ?></h1>
    <p class="lead"><?php bbq_textarea( 'lead', 'Thank you for your interest in bb.q Chicken. Our European team reviews every enquiry personally and will contact you within 5 working days. A confirmation is on its way to your inbox.', 'Text' ); ?></p>
    <?php
    $btn1 = bbq_link( 'btn_primary', array( 'label' => 'Read the franchise FAQ', 'url' => 'page:franchise#faq' ), 'Primary button' );
    $btn2 = bbq_link( 'btn_secondary', array( 'label' => 'Discover bb.q', 'url' => 'page:discover' ), 'Secondary button' );
    if ( $btn1['label'] || $btn2['label'] ) :
        ?>
    <div class="btn-row">
      <?php if ( $btn1['label'] ) : ?>
      <a class="btn btn--red"<?php bbq_link_attrs( $btn1 ); ?>><?php bbq_e( $btn1['label'] ); ?> <span class="btn__chip"><?php bbq_icon( 'arrow' ); ?></span></a>
      <?php endif; ?>
      <?php if ( $btn2['label'] ) : ?>
      <a class="btn btn--outline-dark"<?php bbq_link_attrs( $btn2 ); ?>><?php bbq_e( $btn2['label'] ); ?> <span class="btn__chip"><?php bbq_icon( 'arrow' ); ?></span></a>
      <?php endif; ?>
    </div>
    <?php endif; ?>
  </div>
  <div class="cutout cutout--shadow-dark cutout--fried"><?php bbq_image( 'cutout_img', 'cut-2pcs-fried.png', 'Cut-out image', array( 'alt' => '', 'width' => 880, 'height' => 463 ) ); ?></div>
</section>
