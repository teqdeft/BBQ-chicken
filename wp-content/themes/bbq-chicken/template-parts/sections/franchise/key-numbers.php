<?php
/**
 * Section "Key numbers" (franchise page) · ACF layout: franchise_key_numbers
 */
defined( 'ABSPATH' ) || exit;
include __DIR__ . '/_shared.php';
?>
<!-- 3. Key metrics -->
<?php bbq_section( 'Key numbers' ); ?>
<section class="section proof" aria-label="<?php echo esc_attr( bbq_get( 'proof_aria', 'bb.q in numbers', 'Name for screen readers' ) ); ?>">
  <div class="proof__items">
    <?php
    $proof = bbq_rows(
        'proof',
        'Numbers (they count up on screen: write them like +3,500, 57 or 1995)',
        array(
            'num'   => array( 'text', 'Number' ),
            'label' => array( 'text', 'Label' ),
        ),
        array(
            array( 'num' => '1995', 'label' => 'Founded in Korea' ),
            array( 'num' => '+3,500', 'label' => 'Restaurants worldwide' ),
            array( 'num' => '57', 'label' => 'Countries' ),
            array( 'num' => '+250', 'label' => 'Restaurants in the US' ),
        )
    );
    foreach ( $proof as $item ) :
        ?>
    <div class="proof__item"><span class="proof__num"><?php bbq_e( $item['num'] ); ?></span><span class="proof__label"><?php bbq_e( $item['label'] ); ?></span></div>
    <?php endforeach; ?>
  </div>
  <?php $proof_note = bbq_get( 'proof_note', 'Ranked 7th on Yelp\'s Fastest Growing Brands in the US, 2025.', 'Note below the numbers' ); ?>
  <?php if ( '' !== trim( $proof_note ) ) : ?>
  <p class="proof__note"><?php bbq_e( $proof_note ); ?></p>
  <?php endif; ?>
</section>
