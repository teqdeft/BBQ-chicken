<?php
/**
 * Section "Markets" (home page) · ACF layout: home_markets
 */
defined( 'ABSPATH' ) || exit;
include __DIR__ . '/_shared.php';
?>
<!-- 8. Markets -->
<?php bbq_section( 'Markets' ); ?>
<section class="section markets" id="markets" aria-labelledby="markets-title">
  <div class="section-head">
    <span class="eyebrow eyebrow--glass"><?php bbq_text( 'markets_eyebrow', 'Markets', 'Label' ); ?></span>
    <h2 class="h2" id="markets-title"><?php bbq_text( 'markets_title', 'Where we\'re growing', 'Heading' ); ?></h2>
    <p class="lead"><?php bbq_textarea( 'markets_lead', 'We\'re building bb.q Chicken right across Europe, one market at a time, with the right local partners beside us. Wherever you are on the continent, if you can see the opportunity we\'d like to hear from you.', 'Intro text' ); ?></p>
  </div>
  <?php
  $pill_active = bbq_get( 'pill_active', 'Active presence', 'Badge text: active presence' );
  $pill_open   = bbq_get( 'pill_open', 'Open for enquiries', 'Badge text: open for enquiries' );
  ?>
  <div class="markets__body">
    <div class="markets__text">
      <ul class="market-list">
        <?php
        $markets = bbq_rows(
            'markets',
            'Markets',
            array(
                'name'       => array( 'text', 'Country / region' ),
                'name_short' => array( 'text', 'Shorter name on phones (optional)' ),
                'active'     => array( 'toggle', 'Badge: active presence' ),
                'open'       => array( 'toggle', 'Badge: open for enquiries' ),
            ),
            array(
                array( 'name' => 'Spain', 'name_short' => '', 'active' => 1, 'open' => 1 ),
                array( 'name' => 'United Kingdom', 'name_short' => 'UK', 'active' => 1, 'open' => 1 ),
                array( 'name' => 'All other European countries', 'name_short' => 'Rest of Europe', 'active' => 0, 'open' => 1 ),
            )
        );
        foreach ( $markets as $market ) :
            $short = trim( (string) $market['name_short'] );
            ?>
        <li class="market-row"><span class="market-row__name"><?php if ( '' !== $short && $short !== $market['name'] ) : ?><span class="only-desktop"><?php bbq_e( $market['name'] ); ?></span><span class="only-mobile"><?php bbq_e( $short ); ?></span><?php else : ?><?php bbq_e( $market['name'] ); ?><?php endif; ?></span><span class="market-row__pills"><?php if ( $market['active'] ) : ?><span class="pill pill--active"><?php bbq_e( $pill_active ); ?></span><?php endif; ?><?php if ( $market['open'] ) : ?><span class="pill pill--open"><?php bbq_e( $pill_open ); ?></span><?php endif; ?></span></li>
        <?php endforeach; ?>
      </ul>
      <p class="markets__note"><?php bbq_text( 'markets_note', 'Every market is open for enquiries. Active presence means bb.q is already operating there.', 'Note under the list' ); ?></p>
      <div class="btn-row">
        <?php $l = bbq_link( 'markets_btn1', array( 'label' => 'Submit your application', 'url' => 'page:apply' ), 'First button' ); ?>
        <a class="btn btn--cream"<?php bbq_link_attrs( $l ); ?>><?php bbq_e( $l['label'] ); ?> <span class="btn__chip"><?php bbq_icon( 'arrow' ); ?></span></a>
        <?php $l = bbq_link( 'markets_btn2', array( 'label' => 'See all markets', 'url' => 'page:discover' ), 'Second button' ); ?>
        <a class="btn btn--outline-light"<?php bbq_link_attrs( $l ); ?>><?php bbq_e( $l['label'] ); ?> <span class="btn__chip"><?php bbq_icon( 'arrow' ); ?></span></a>
      </div>
    </div>
    <figure class="europe-card">
      <?php
      $europe = bbq_get( 'europe_img', 'svg/europe-map.svg', 'Map of Europe', 'image' );
      bbq_img( $europe, array( 'class' => 'europe-card__map', 'alt' => bbq_get( 'europe_alt', 'Map of Europe: Spain and the United Kingdom have an active presence, every other European country is open for enquiries', 'Map of Europe: description (alt text)', 'textarea' ), 'width' => 720, 'height' => 540, 'loading' => 'lazy' ) );
      ?>
      <div class="europe-card__legend" aria-hidden="true"><span class="pill pill--open"><?php bbq_e( $pill_open ); ?></span><span class="pill pill--active"><?php bbq_e( $pill_active ); ?></span></div>
      <figcaption class="europe-card__caption"><?php bbq_text( 'europe_caption', 'Open to partners across Europe.', 'Map caption' ); ?></figcaption>
    </figure>
  </div>
</section>
