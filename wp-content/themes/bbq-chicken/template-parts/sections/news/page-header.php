<?php
/**
 * Section "Page header" (news page) · ACF layout: news_page_header
 */
defined( 'ABSPATH' ) || exit;
include __DIR__ . '/_shared.php';
?>
<!-- 1. Page header -->
<?php bbq_section( 'Page header' ); ?>
<section class="section page-hero page-hero--short" aria-labelledby="news-title">
  <div class="page-hero__text">
    <span class="eyebrow eyebrow--glass"><?php bbq_text( 'hero_eyebrow', 'News', 'Label' ); ?></span>
    <h1 class="h-display" id="news-title"><?php bbq_html( 'hero_title', 'What\'s new<br>at bb.q', 'Heading' ); ?></h1>
    <p class="lead"><?php bbq_textarea( 'hero_lead', 'Openings, campaigns and news from bb.q in Europe and around the world.', 'Intro text' ); ?></p>
  </div>
</section>
