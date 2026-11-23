<?php
/**
 * Section "Page header" (careers page) · ACF layout: careers_page_header
 */
defined( 'ABSPATH' ) || exit;
include __DIR__ . '/_shared.php';
?>
<!-- 1. Page header -->
<?php bbq_section( 'Page header' ); ?>
<section class="section page-hero page-hero--short" aria-labelledby="careers-title">
  <div class="page-hero__text">
    <span class="eyebrow eyebrow--glass"><?php bbq_text( 'hero_eyebrow', 'Careers', 'Label' ); ?></span>
    <h1 class="h-display" id="careers-title"><?php bbq_html( 'hero_title', 'Grow with bb.q<br> in Europe', 'Heading' ); ?></h1>
    <p class="lead"><?php bbq_textarea( 'hero_lead', "We're building bb.q across Europe from the ground up. That means new restaurants, new markets and plenty of room to grow, for cooks, managers and the people behind the scenes.", 'Intro text' ); ?></p>
  </div>
</section>
