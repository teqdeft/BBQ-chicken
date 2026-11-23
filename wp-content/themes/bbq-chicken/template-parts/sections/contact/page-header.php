<?php
/**
 * Section "Page header" (contact page) · ACF layout: contact_page_header
 */
defined( 'ABSPATH' ) || exit;
include __DIR__ . '/_shared.php';
?>
<!-- 1. Page header -->
<?php bbq_section( 'Page header' ); ?>
<section class="section page-hero page-hero--short" aria-labelledby="contact-title">
  <div class="page-hero__text">
    <span class="eyebrow eyebrow--glass"><?php bbq_text( 'hero_eyebrow', 'Contact', 'Label' ); ?></span>
    <h1 class="h-display" id="contact-title"><?php bbq_text( 'hero_title', 'Get in touch', 'Heading' ); ?></h1>
    <p class="lead"><?php bbq_textarea( 'hero_lead', 'Pick the topic that fits and your message goes straight to the right person.', 'Intro text' ); ?></p>
  </div>
</section>
