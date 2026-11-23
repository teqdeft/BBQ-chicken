<?php
/**
 * Section "Contact form" (contact page) · ACF layout: contact_contact_form
 */
defined( 'ABSPATH' ) || exit;
include __DIR__ . '/_shared.php';
?>
<!-- 3. Contact form -->
<?php bbq_section( 'Contact form' ); ?>
<section class="section form-section" id="message" aria-labelledby="message-title">
  <div class="form-card">
    <div class="form-card__intro">
      <span class="eyebrow"><?php bbq_text( 'form_eyebrow', 'Other questions', 'Label' ); ?></span>
      <h2 class="h2" id="message-title"><?php bbq_text( 'form_title', 'Send us a message', 'Heading' ); ?></h2>
      <address class="lead contact-address"><?php bbq_html( 'form_address', 'BLT Global Brands<br>Calle Fernando el Santo, 25, 4º D<br>28010 Madrid, Spain', 'Address' ); ?></address>
      <div class="info-box">
        <p class="info-box__title"><?php bbq_text( 'info_title', 'Good to know', 'Info box: title' ); ?></p>
        <?php foreach ( bbq_rows( 'info_steps', 'Info box: lines', array( 'text' => array( 'text', 'Text' ) ), array( array( 'text' => 'We reply within 5 working days.' ) ) ) as $step ) : ?>
        <p class="info-box__step"><?php bbq_e( $step['text'] ); ?></p>
        <?php endforeach; ?>
      </div>
    </div>

    <?php bbq_form( 'contact' ); ?>
  </div>
</section>
