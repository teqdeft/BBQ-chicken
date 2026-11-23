<?php
/**
 * Section "On this page" (legal page) · ACF layout: legal_on_this_page
 */
defined( 'ABSPATH' ) || exit;
include __DIR__ . '/_shared.php';
?>
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
