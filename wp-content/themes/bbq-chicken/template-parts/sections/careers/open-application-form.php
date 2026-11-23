<?php
/**
 * Section "Open application form" (careers page) · ACF layout: careers_open_application_form
 */
defined( 'ABSPATH' ) || exit;
include __DIR__ . '/_shared.php';
?>
<!-- 4. Open application (form) -->
<?php bbq_section( 'Open application form' ); ?>
<section class="section form-section" id="open-application" aria-labelledby="application-title">
  <div class="form-card">
    <div class="form-card__intro">
      <span class="eyebrow"><?php bbq_text( 'form_eyebrow', 'Open application', 'Label' ); ?></span>
      <h2 class="h2" id="application-title"><?php bbq_text( 'form_title', "Tell us what you'd like to do", 'Heading' ); ?></h2>
      <p class="lead"><?php bbq_textarea( 'form_lead', 'Kitchen, restaurant management, operations or head office. A short note and your CV are enough.', 'Intro text' ); ?></p>
    </div>

    <?php bbq_form( 'careers' ); ?>
  </div>
</section>
