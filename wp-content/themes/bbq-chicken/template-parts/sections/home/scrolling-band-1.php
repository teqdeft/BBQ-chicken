<?php
/**
 * Section "Scrolling band 1 (dark)" (home page) · ACF layout: home_scrolling_band_1
 */
defined( 'ABSPATH' ) || exit;
include __DIR__ . '/_shared.php';
?>
<!-- 3. Marquee: open for partners -->
<?php bbq_section( 'Scrolling band 1 (dark)' ); ?>
<div class="marquee marquee--dark" aria-hidden="true">
  <div class="marquee__track" data-marquee><?php
    bbq_home_marquee(
        'band1',
        'Band texts',
        array(
            array( 'text' => 'Open for partners', 'strong' => 1 ),
            array( 'text' => 'Europe', 'strong' => 0 ),
            array( 'text' => 'Submit your application →', 'strong' => 1 ),
        )
    );
    ?></div>
</div>
