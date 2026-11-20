<?php
/**
 * Page not found.
 */
defined( 'ABSPATH' ) || exit;
get_header();
?>
<header class="section page-hero page-hero--short">
  <div class="page-hero__text">
    <span class="eyebrow eyebrow--glass">404</span>
    <h1 class="h-display">This page has gone missing.</h1>
    <p class="lead">The link may be old, or the page has moved. Try the home page or the menu above.</p>
    <div class="btn-row">
      <a class="btn btn--cream" href="<?php echo esc_url( home_url( '/' ) ); ?>">Back to the home page <span class="btn__chip"><?php bbq_icon( 'arrow' ); ?></span></a>
    </div>
  </div>
</header>
<?php
get_footer();
