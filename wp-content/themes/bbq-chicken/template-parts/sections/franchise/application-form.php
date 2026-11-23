<?php
/**
 * Section "Application form" (franchise page) · ACF layout: franchise_application_form
 */
defined( 'ABSPATH' ) || exit;
include __DIR__ . '/_shared.php';
?>
<!-- 11. Submit your application (form) — the same form is on the Apply page and in the pop-up (assets/js/apply.js) -->
<?php bbq_section( 'Application form' ); ?>
<section class="section form-section app-section" id="apply" aria-labelledby="apply-title" data-hides-floating>
  <div class="form-card form-card--app">
    <div class="form-card__intro">
      <span class="eyebrow"><?php bbq_text( 'apply_eyebrow', 'Apply', 'Label' ); ?></span>
      <h2 class="h2" id="apply-title"><?php bbq_text( 'apply_title', 'Submit your application', 'Heading' ); ?></h2>
      <p class="lead"><?php bbq_html( 'apply_lead', 'Ready to join the bb.q Chicken franchise network? Tell us who you are and where you\'d like to grow. Our expansion team reads every application<span class="only-desktop"> personally</span>.', 'Intro text', array( 'help' => 'Text inside <span class="only-desktop">…</span> is hidden on phones.' ) ); ?></p>
      <div class="info-box">
        <p class="info-box__title"><?php bbq_text( 'apply_info_title', 'What happens next', 'Info box: title' ); ?></p>
        <?php
        $apply_steps = bbq_rows(
            'apply_info_steps',
            'Info box: steps',
            array( 'text' => array( 'text', 'Text' ) ),
            array(
                array( 'text' => 'We reply within 5 working days.' ),
                array( 'text' => 'We schedule an introductory meeting.' ),
                array( 'text' => 'Together we look at your territory and the right site.' ),
            )
        );
        foreach ( $apply_steps as $item ) :
            ?>
        <p class="info-box__step"><?php bbq_e( $item['text'] ); ?></p>
        <?php endforeach; ?>
      </div>
    </div>

    <?php bbq_franchise_application_form(); ?>
  </div>
</section>
