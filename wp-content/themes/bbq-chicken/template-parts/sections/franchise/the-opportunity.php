<?php
/**
 * Section "The opportunity" (franchise page) · ACF layout: franchise_the_opportunity
 */
defined( 'ABSPATH' ) || exit;
include __DIR__ . '/_shared.php';
?>
<!-- 4. Opportunity -->
<?php bbq_section( 'The opportunity' ); ?>
<section class="section opportunity" aria-labelledby="opportunity-title">
  <div class="opportunity__box">
    <span class="opportunity__icon" aria-hidden="true">↗</span>
    <div class="opportunity__text">
      <span class="eyebrow"><?php bbq_text( 'opp_eyebrow', 'The opportunity', 'Label' ); ?></span>
      <h2 class="opportunity__title" id="opportunity-title"><?php bbq_text( 'opp_title', 'Korean fried chicken is one of Europe\'s fastest-growing food categories.', 'Heading' ); ?></h2>
    </div>
    <p class="opportunity__figure"><strong><?php bbq_text( 'opp_figure', '+24.5%', 'Key figure' ); ?></strong> <span><?php bbq_text( 'opp_figure_label', 'Annual K-food growth in Europe', 'Key figure: caption' ); ?></span></p>
  </div>
</section>
