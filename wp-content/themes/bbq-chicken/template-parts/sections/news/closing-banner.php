<?php
/**
 * Section "Closing banner" (news page) · ACF layout: news_closing_banner
 */
defined( 'ABSPATH' ) || exit;
include __DIR__ . '/_shared.php';
?>
<!-- 4. Closing CTA -->
<?php bbq_section( 'Closing banner' ); ?>
<section class="section closing" aria-labelledby="closing-title">
  <div class="stamp"><?php bbq_stamp(); ?></div>
  <span class="sparkle-lg" aria-hidden="true"><?php bbq_icon( 'sparkleplain' ); ?></span>
  <span class="sparkle-sm" aria-hidden="true"><?php bbq_icon( 'sparkleplain' ); ?></span>
  <div class="cta-card">
    <h2 class="h2" id="closing-title"><?php bbq_text( 'closing_title', 'Ready to bring bb.q to your market?', 'Heading' ); ?></h2>
    <p class="lead"><?php bbq_textarea( 'closing_lead', 'Tell us who you are and where you\'d like to grow. It takes two minutes. Our European team reads every enquiry and gets back to you personally.', 'Text' ); ?></p>
    <?php $closing_cta = bbq_link( 'closing_cta', array( 'label' => 'Submit your application', 'url' => 'page:apply' ), 'Button' ); ?>
    <a class="btn btn--red"<?php bbq_link_attrs( $closing_cta, ' data-hides-floating' ); ?>><?php bbq_e( $closing_cta['label'] ); ?> <span class="btn__chip"><?php bbq_icon( 'arrow' ); ?></span></a>
  </div>
  <div class="cutout cutout--shadow-dark cutout--fried"><?php bbq_image( 'closing_img', 'cut-2pcs-fried.png', 'Image', array( 'alt' => '', 'width' => 880, 'height' => 463, 'loading' => 'lazy' ) ); ?></div>
</section>
