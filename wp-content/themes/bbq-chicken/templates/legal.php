<?php
/**
 * Legal page (privacy policy; the same layout serves cookie policy, terms …).
 * Static source: html-backup/src/pages/legal.html
 *
 * The page header texts are fields; the policy text is the page content (block editor). Each h2 of
 * the content starts a section and an "On this page" link (inc/parts/legal.php).
 */
defined( 'ABSPATH' ) || exit;

$live     = ! bbq_schema_mode();
$ctx      = bbq_ctx();
$the_page = is_numeric( $ctx['store'] ) ? get_post( (int) $ctx['store'] ) : null;
$title    = $the_page && '' !== trim( $the_page->post_title ) ? $the_page->post_title : 'Privacy policy';

$legal = array( 'html' => '', 'toc' => array() );
if ( $live && have_posts() ) {
	the_post();
	$legal = bbq_legal_sections( str_replace( ']]>', ']]&gt;', apply_filters( 'the_content', get_the_content() ) ) );
}
?>

<!-- 1. Page header -->
<?php bbq_section( 'Page header' ); ?>
<section class="section page-hero page-hero--short" aria-labelledby="legal-title">
  <div class="page-hero__text">
    <span class="eyebrow eyebrow--glass"><?php bbq_text( 'hero_eyebrow', 'Legal', 'Label' ); ?></span>
    <h1 class="h-display" id="legal-title"><?php bbq_text( 'hero_title', $title, 'Heading', array( 'help' => 'Starts as the page title.' ) ); ?></h1>
    <?php
    $hero_lead = bbq_get( 'hero_lead', '', 'Text below the heading', 'text', array( 'help' => 'e.g. Last updated: 1 January 2026' ) );
    if ( '' !== trim( (string) $hero_lead ) ) :
        ?>
    <p class="lead"><?php bbq_e( $hero_lead ); ?></p>
    <?php endif; ?>
  </div>
</section>

<!-- 2. Legal body -->
<?php
bbq_section( 'On this page' );
$toc_title = bbq_get( 'toc_title', 'On this page', 'Heading of the list of sections', 'text', array( 'help' => 'The list is made from the h2 headings of the page text (block editor).' ) );
?>
<div class="section legal">
  <?php if ( $legal['toc'] ) : ?>
  <nav class="legal-toc" aria-labelledby="toc-title">
    <p class="legal-toc__title" id="toc-title"><?php bbq_e( $toc_title ); ?></p>
    <ul class="legal-toc__list">
      <?php foreach ( $legal['toc'] as $item ) : ?>
      <li><a href="#<?php echo esc_attr( $item['id'] ); ?>"><?php bbq_e( $item['text'] ); ?></a></li>
      <?php endforeach; ?>
    </ul>
  </nav>
  <?php endif; ?>

  <div class="legal-content">
    <?php echo $legal['html']; // phpcs:ignore WordPress.Security.EscapeOutput -- the page content (the_content filters) ?>
  </div>
</div>
