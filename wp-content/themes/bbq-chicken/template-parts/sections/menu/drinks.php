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
  // two groups, each under its own heading: soft drinks (and water), then the Monster energy drinks
  $groups = array(
      'soft'    => bbq_get( 'drinks_soft_label', 'Soft drinks', 'Heading above the soft drinks' ),
      'monster' => bbq_get( 'drinks_monster_label', 'Monster', 'Heading above the Monster drinks' ),
  );
  $drinks = bbq_rows(
      'drinks',
      'Drinks',
      array(
          'name'  => array( 'text', 'Drink' ),
          'size'  => array( 'text', 'Size (e.g. 500 ml bottle)' ),
          'group' => array( 'select', 'Group', array( 'soft' => 'Soft drinks', 'monster' => 'Monster' ) ),
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
          array( 'name' => 'Monster Energy', 'size' => '500 ml can', 'group' => 'monster' ),
          array( 'name' => 'Monster Juiced Mango Loco', 'size' => '500 ml can', 'group' => 'monster' ),
          array( 'name' => 'Monster Ultra White', 'size' => '500 ml can', 'group' => 'monster' ),
      )
  );
  $by_group = array_fill_keys( array_keys( $groups ), array() );
  foreach ( $drinks as $drink ) {
      if ( '' === trim( (string) $drink['name'] ) ) {
          continue;
      }
      $by_group[ isset( $groups[ (string) $drink['group'] ] ) ? (string) $drink['group'] : 'soft' ][] = $drink; // no group = soft drinks
  }
  ?>
  <div class="drink-groups">
    <?php foreach ( array_filter( $by_group ) as $group => $items ) : ?>
    <div class="drink-group">
      <?php if ( '' !== trim( (string) $groups[ $group ] ) ) : ?>
      <h3 class="label-caps drink-group__title"><?php bbq_e( $groups[ $group ] ); ?></h3>
      <?php endif; ?>
      <ul class="drink-list">
        <?php foreach ( $items as $drink ) : ?>
        <li class="drink"><span class="drink__name"><?php bbq_e( $drink['name'] ); ?></span><?php if ( '' !== trim( (string) $drink['size'] ) ) : ?> <span class="drink__size"><?php bbq_e( $drink['size'] ); ?></span><?php endif; ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
    <?php endforeach; ?>
  </div>
</section>
