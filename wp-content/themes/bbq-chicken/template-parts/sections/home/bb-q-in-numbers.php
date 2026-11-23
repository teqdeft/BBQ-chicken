<?php
/**
 * Section "bb.q in numbers" (home page) · ACF layout: home_bb_q_in_numbers
 */
defined( 'ABSPATH' ) || exit;
include __DIR__ . '/_shared.php';
?>
<!-- 4. Proof band -->
<?php bbq_section( 'bb.q in numbers' ); ?>
<section class="section proof" aria-label="<?php echo esc_attr( bbq_get( 'proof_aria', 'bb.q in numbers', 'Section name (screen readers)' ) ); ?>">
  <div class="proof__items">
    <?php
    $proof = bbq_rows(
        'proof',
        'Numbers',
        array(
            'num'   => array( 'text', 'Number (e.g. +3,500; it counts up when scrolled into view)' ),
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
    <div class="proof__item"><span class="proof__num"><?php bbq_e( trim( (string) $item['num'] ) ); ?></span><span class="proof__label"><?php bbq_e( $item['label'] ); ?></span></div>
    <?php endforeach; ?>
  </div>
  <p class="proof__note"><?php bbq_text( 'proof_note', 'Ranked 7th on Yelp\'s Fastest Growing Brands in the US, 2025.', 'Note under the numbers' ); ?></p>
</section>
