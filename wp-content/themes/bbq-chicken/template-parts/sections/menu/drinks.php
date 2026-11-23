<?php
/**
 * Section "Something to drink" (menu page) · ACF layout: menu_drinks
 */
defined( 'ABSPATH' ) || exit;
?>
<!-- 6. Something to drink -->
<?php bbq_section( 'Something to drink' ); ?>
<section class="section drinks" aria-labelledby="drinks-title">
  <div class="section-head">
    <span class="eyebrow"><?php bbq_text( 'drinks_eyebrow', 'Drinks', 'Label' ); ?></span>
    <h2 class="h2" id="drinks-title"><?php bbq_text( 'drinks_title', 'Something to drink', 'Heading' ); ?></h2>
  </div>
  <?php
  $drinks = bbq_rows(
      'drinks',
      'Drinks',
      array(
          'name' => array( 'text', 'Drink' ),
          'size' => array( 'text', 'Size (e.g. 500 ml bottle)' ),
      ),
      array(
          array( 'name' => 'Water', 'size' => '500 ml bottle' ),
          array( 'name' => 'Coke Original Taste', 'size' => '500 ml bottle' ),
          array( 'name' => 'Coke Zero Sugar', 'size' => '500 ml bottle' ),
          array( 'name' => 'Coke Zero Sugar Zero Caffeine', 'size' => '500 ml bottle' ),
          array( 'name' => 'Fanta Orange', 'size' => '500 ml bottle' ),
          array( 'name' => 'Fanta Lemon', 'size' => '500 ml bottle' ),
          array( 'name' => 'Sprite', 'size' => '500 ml bottle' ),
          array( 'name' => 'Fuze Tea Lemon', 'size' => '500 ml bottle' ),
          array( 'name' => 'Aquarius Original', 'size' => '500 ml bottle' ),
          array( 'name' => 'Aquarius Orange', 'size' => '500 ml bottle' ),
          array( 'name' => 'Monster Energy', 'size' => '500 ml can' ),
          array( 'name' => 'Monster Juiced Mango Loco', 'size' => '500 ml can' ),
          array( 'name' => 'Monster Ultra White', 'size' => '500 ml can' ),
      )
  );
  ?>
  <ul class="drink-list">
    <?php foreach ( $drinks as $drink ) : ?>
      <?php
      if ( '' === trim( (string) $drink['name'] ) ) {
          continue;
      }
      ?>
    <li class="drink"><span class="drink__name"><?php bbq_e( $drink['name'] ); ?></span><?php if ( '' !== trim( (string) $drink['size'] ) ) : ?> <span class="drink__size"><?php bbq_e( $drink['size'] ); ?></span><?php endif; ?></li>
    <?php endforeach; ?>
  </ul>
</section>
