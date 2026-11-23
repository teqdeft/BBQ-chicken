<?php
/**
 * Section "Moving band: benefits" (franchise page) · ACF layout: franchise_moving_band_benefits
 */
defined( 'ABSPATH' ) || exit;
include __DIR__ . '/_shared.php';
?>
<!-- 7. Marquee: benefits -->
<?php bbq_section( 'Moving band: benefits' ); ?>
<div class="marquee marquee--yellow marquee--ltr" aria-hidden="true">
  <div class="marquee__track" data-marquee>
<?php
foreach ( bbq_rows(
	'marquee2',
	'Words',
	$marquee_fields,
	array(
		array( 'text' => 'What you get as a bb.q partner', 'strong' => 1 ),
		array( 'text' => 'Operational support', 'strong' => 0 ),
		array( 'text' => 'Training<span class="only-desktop"> at Chicken University</span>', 'strong' => 0 ),
		array( 'text' => 'Supply chain', 'strong' => 0 ),
		array( 'text' => 'Launch marketing', 'strong' => 0 ),
	)
) as $item ) :
	?>
    <span class="marquee__item<?php echo $item['strong'] ? ' marquee__item--strong' : ''; ?>"><?php bbq_k( $item['text'] ); ?></span><?php bbq_icon( 'sparkle' ); ?>

<?php endforeach; ?>
  </div>
</div>
