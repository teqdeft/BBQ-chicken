<?php
/**
 * Section "Page header" (legal page) · ACF layout: legal_page_header
 */
defined( 'ABSPATH' ) || exit;
include __DIR__ . '/_shared.php';
?>
<!-- 1. Page header -->
<?php bbq_section( 'Page header' ); ?>
<section class="section page-hero page-hero--short" aria-labelledby="legal-title">
  <div class="page-hero__text">
    <span class="eyebrow eyebrow--glass"><?php bbq_text( 'hero_eyebrow', 'Legal', 'Label' ); ?></span>
    <h1 class="h-display" id="legal-title"><?php $heading = bbq_get( 'hero_title', '', 'Heading', 'text', array( 'help' => 'Empty = the page title.' ) ); bbq_e( '' !== trim( (string) $heading ) ? $heading : $title ); ?></h1>
    <?php
    $hero_lead = bbq_get( 'hero_lead', '', 'Text below the heading', 'text', array( 'help' => 'e.g. Last updated: 1 January 2026' ) );
    if ( '' !== trim( (string) $hero_lead ) ) :
        ?>
    <p class="lead"><?php bbq_e( $hero_lead ); ?></p>
    <?php endif; ?>
  </div>
</section>
