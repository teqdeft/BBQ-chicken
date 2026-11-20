<?php
/**
 * Apply page: the franchise application form.
 * Static source: html-backup/src/pages/apply.html
 * Form: inc/forms/application.php. assets/js/apply.js fetches this page and reuses #application-form
 * (and the pop-up texts in <template id="apply-modal-content"> below) in the "Submit your application"
 * pop-up, so the form is defined once.
 */
defined( 'ABSPATH' ) || exit;
?>
<!-- Application form -->
<?php bbq_section( 'Application form' ); ?>
<section class="section form-section app-section app-section--page" aria-labelledby="apply-title">
  <div class="form-card form-card--app">
    <div class="form-card__intro">
      <span class="eyebrow"><?php bbq_text( 'eyebrow', 'Franchise / Apply', 'Label' ); ?></span>
      <h1 class="h2" id="apply-title"><?php bbq_text( 'title', 'Submit your application', 'Heading' ); ?></h1>
      <p class="lead"><?php bbq_textarea( 'lead', 'Tell us who you are and where you\'d like to grow. No investment details or business plans yet, we\'ll get to those together.', 'Intro text' ); ?></p>
      <div class="info-box">
        <p class="info-box__title"><?php bbq_text( 'info_title', 'What happens next', 'Info box: title' ); ?></p>
        <?php
        $info_steps = bbq_rows(
            'info_steps',
            'Info box: steps',
            array( 'text' => array( 'text', 'Text' ) ),
            array(
                array( 'text' => 'We reply within 5 working days.' ),
                array( 'text' => 'We call you to walk through the terms, store costs and support.' ),
                array( 'text' => 'If it\'s a fit on both sides, we meet in person.' ),
            )
        );
        foreach ( $info_steps as $item ) :
            ?>
        <p class="info-box__step"><?php bbq_e( $item['text'] ); ?></p>
        <?php endforeach; ?>
      </div>
      <?php
      $premises_text = bbq_get( 'premises_text', 'Have premises for a restaurant?', 'Premises note: text' );
      $premises_link = bbq_link( 'premises_link', array( 'label' => 'Offer your premises →', 'url' => 'page:real-estate' ), 'Premises note: link' );
      if ( '' !== trim( $premises_text ) || $premises_link['label'] ) :
          ?>
      <p class="app-premises"><?php bbq_e( $premises_text ); ?><?php if ( $premises_link['label'] ) : ?> <a<?php bbq_link_attrs( $premises_link ); ?>><?php bbq_e( $premises_link['label'] ); ?></a><?php endif; ?></p>
      <?php endif; ?>
    </div>

    <?php bbq_form( 'application' ); ?>
  </div>
<?php
/*
 * Texts of the "Submit your application" pop-up (opened by every "Submit your application" button on
 * the other pages). apply.js reads them from this inert <template>; it is never shown on this page.
 */
bbq_section( 'Pop-up (opened by the “Submit your application” buttons on other pages)' );
?>
  <template id="apply-modal-content">
    <span class="apply-modal__bar-title"><?php bbq_text( 'modal_bar', 'Submit your application', 'Phone: title in the top bar' ); ?></span>
    <div class="form-card__intro">
      <span class="eyebrow"><?php bbq_text( 'modal_eyebrow', 'Apply', 'Label' ); ?></span>
      <h2 class="h2" id="apply-modal-title"><?php bbq_text( 'modal_title', 'Submit your application', 'Heading' ); ?></h2>
      <p class="lead"><span class="only-desktop"><?php bbq_textarea( 'modal_lead', 'Ready to join the bb.q Chicken franchise network? You\'ll stay on this page.', 'Intro text (desktop)' ); ?></span><span class="only-mobile"><?php bbq_textarea( 'modal_lead_m', 'Ready to join the bb.q Chicken franchise network? Tell us who you are and where you\'d like to grow. Our expansion team reads every application.', 'Intro text (phone)' ); ?></span></p>
      <div class="info-box">
        <p class="info-box__title"><?php bbq_text( 'modal_info_title', 'What happens next', 'Info box: title' ); ?></p>
        <?php
        $modal_steps = bbq_rows(
            'modal_info_steps',
            'Info box: steps',
            array( 'text' => array( 'text', 'Text' ) ),
            array(
                array( 'text' => 'We reply within 5 working days.' ),
                array( 'text' => 'We schedule an introductory meeting.' ),
                array( 'text' => 'Together we look at your territory and the right site.' ),
            )
        );
        foreach ( $modal_steps as $item ) :
            ?>
        <p class="info-box__step"><?php bbq_e( $item['text'] ); ?></p>
        <?php endforeach; ?>
      </div>
    </div>
    <span data-modal-submit><?php bbq_text( 'modal_submit', 'Submit your application', 'Phone: sticky submit button' ); ?></span>
    <h2 class="apply-modal__done-title" tabindex="-1"><?php bbq_text( 'modal_done_title', 'Thank you for your interest', 'After sending: heading' ); ?></h2>
    <p class="apply-modal__done-text"><?php bbq_textarea( 'modal_done_text', 'Our team will be in touch.', 'After sending: text' ); ?></p>
    <span data-modal-back><?php bbq_text( 'modal_done_btn', 'Back to the page', 'After sending: button' ); ?></span>
  </template>
</section>
