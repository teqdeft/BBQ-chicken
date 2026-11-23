<?php
/**
 * Section "Scrolling band 2 (yellow)" (home page) · ACF layout: home_scrolling_band_2
 */
defined( 'ABSPATH' ) || exit;
include __DIR__ . '/_shared.php';
?>
<!-- 7. Marquee: sauces -->
<?php bbq_section( 'Scrolling band 2 (yellow)' ); ?>
<div class="marquee marquee--yellow marquee--ltr" aria-hidden="true">
  <div class="marquee__track" data-marquee><?php
    bbq_home_marquee(
        'band2',
        'Band texts',
        array(
            array( 'text' => 'Our signature sauces', 'strong' => 1 ),
            array( 'text' => 'Secret Sauce', 'strong' => 0 ),
            array( 'text' => 'Galbi', 'strong' => 0 ),
            array( 'text' => 'Gangjeong', 'strong' => 0 ),
            array( 'text' => 'Jasoman', 'strong' => 0 ),
            array( 'text' => 'Cheesling', 'strong' => 0 ),
            array( 'text' => 'Red Chak Chak', 'strong' => 0 ),
        )
    );
    ?></div>
</div>
