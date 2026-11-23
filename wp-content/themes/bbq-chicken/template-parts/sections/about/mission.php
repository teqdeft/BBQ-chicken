<?php
/**
 * Section "Mission" (about page) · ACF layout: about_mission
 */
defined( 'ABSPATH' ) || exit;
include __DIR__ . '/_shared.php';
?>
<!-- 2. Mission (desktop: red glow with two bucket cut-outs; mobile: photo header) -->
<?php bbq_section( 'Mission' ); ?>
<section class="hero mission" aria-labelledby="mission-title">
  <div class="mission__art" aria-hidden="true">
    <?php bbq_image( 'mission_cut_left', 'cut-8pcs-secret-sauce-bucket.png', 'Left cut-out (desktop)', array( 'class' => 'mission__cut mission__cut--left', 'alt' => '', 'width' => 760, 'height' => 962, 'loading' => 'lazy' ) ); ?>
    <?php bbq_image( 'mission_cut_right', 'cut-8pcs-fried-bucket.png', 'Right cut-out (desktop)', array( 'class' => 'mission__cut mission__cut--right', 'alt' => '', 'width' => 660, 'height' => 838, 'loading' => 'lazy' ) ); ?>
  </div>
  <?php bbq_image( 'mission_bg_mobile', 'hero-mobile.jpg', 'Background photo (phones)', array( 'class' => 'hero__mobile-bg', 'alt' => '', 'width' => 800, 'height' => 1000, 'loading' => 'lazy' ) ); ?>
  <div class="hero__content">
    <h2 class="h-display hero__title" id="mission-title"><?php bbq_text( 'mission_title', 'Great Korean fried chicken, on every high street in Europe.', 'Heading' ); ?></h2>
    <p class="hero__lead"><?php bbq_textarea( 'mission_lead', 'We want bb.q to be the chicken Europeans pick on a Friday night, for a family dinner or a quick lunch. We\'ll get there with strong local partners, restaurants that run well and food people come back for.', 'Text' ); ?></p>
  </div>
  <div class="stamp"><?php bbq_stamp(); ?></div>
</section>
