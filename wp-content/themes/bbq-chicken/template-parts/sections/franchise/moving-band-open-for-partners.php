<?php
/**
 * Section "Moving band: open for partners" (franchise page) · ACF layout: franchise_moving_band_open_for_partners
 */
defined( 'ABSPATH' ) || exit;
include __DIR__ . '/_shared.php';
?>
<!-- 2. Marquee: open for partners -->
<?php bbq_section( 'Moving band: open for partners' ); ?>
<div class="marquee marquee--dark" aria-hidden="true">
  <div class="marquee__track" data-marquee>
<?php
foreach ( bbq_rows(
	'marquee1',
	'Words',
	$marquee_fields,
	array(
		array( 'text' => 'Open for partners', 'strong' => 1 ),
		array( 'text' => 'Europe', 'strong' => 0 ),
	)
) as $item ) :
	?>
    <span class="marquee__item<?php echo $item['strong'] ? ' marquee__item--strong' : ''; ?>"><?php bbq_k( $item['text'] ); ?></span><?php bbq_icon( 'sparkle' ); ?>

<?php endforeach; ?>
  </div>
</div>
