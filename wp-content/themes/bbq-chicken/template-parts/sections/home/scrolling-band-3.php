<?php
/**
 * Section "Scrolling band 3 (red)" (home page) · ACF layout: home_scrolling_band_3
 */
defined( 'ABSPATH' ) || exit;
include __DIR__ . '/_shared.php';
?>
<!-- 13. Marquee: since 1995 -->
<?php bbq_section( 'Scrolling band 3 (red)' ); ?>
<div class="marquee marquee--red" aria-hidden="true">
  <div class="marquee__track" data-marquee><?php
    bbq_home_marquee(
        'band3',
        'Band texts',
        array(
            array( 'text' => 'Since 1995', 'strong' => 1 ),
            array( 'text' => '+3,500 restaurants worldwide', 'strong' => 0 ),
            array( 'text' => 'Now opening across Europe', 'strong' => 0 ),
            array( 'text' => 'Korean fried chicken', 'strong' => 0 ),
        )
    );
    ?></div>
</div>
