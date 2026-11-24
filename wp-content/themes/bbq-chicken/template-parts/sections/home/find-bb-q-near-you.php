<?php
/**
 * Section "Find bb.q near you" (home page) · ACF layout: home_find_bb_q_near_you
 */
defined( 'ABSPATH' ) || exit;
include __DIR__ . '/_shared.php';
?>
<!-- 6. Find bb.q near you -->
<?php bbq_section( 'Find bb.q near you' ); ?>
<section class="section find" id="find" aria-labelledby="find-title">
  <div class="cutout cutout--bucket"><?php bbq_image( 'find_cut', 'cut-bucket-spill.png', 'Cut-out image', array( 'alt' => '', 'width' => 840, 'height' => 599, 'loading' => 'lazy' ) ); ?></div>
  <div class="find__text">
    <span class="eyebrow"><?php bbq_text( 'find_eyebrow', 'Order now', 'Label' ); ?></span>
    <h2 class="h2" id="find-title"><?php bbq_text( 'find_title', 'Find bb.q near you', 'Heading' ); ?></h2>
    <p class="lead"><?php bbq_textarea( 'find_lead', 'Our first kitchens are in Madrid. Enter your postcode to see if we deliver to you, or order straight from your favourite app.', 'Intro text' ); ?></p>
    <form class="postcode" action="#" data-postcode>
      <?php $placeholder = bbq_get( 'postcode_placeholder', 'Your postcode', 'Postcode field: placeholder and label' ); ?>
      <label class="sr-only" for="postcode"><?php bbq_e( $placeholder ); ?></label>
      <input id="postcode" name="postcode" type="text" inputmode="text" autocomplete="postal-code" placeholder="<?php echo esc_attr( $placeholder ); ?>">
      <button class="btn btn--dark" type="submit"><?php bbq_text( 'postcode_button', 'Check delivery', 'Postcode button' ); ?> <span class="btn__chip"><?php bbq_icon( 'arrow' ); ?></span></button>
    </form>
    <span class="label-caps find__or"><?php bbq_text( 'platforms_label', 'Or order on', 'Label above the ordering links' ); ?></span>
    <div class="platforms">
      <?php
      $platforms = bbq_rows(
          'platforms',
          'Ordering links (delivery apps; a link without an address is hidden)',
          array( 'link' => array( 'link', 'Link' ) ),
          array(
              array( 'link' => array( 'label' => 'Glovo', 'url' => 'https://glovo.go.link/open?link_type=store&store_id=617208&adjust_t=s321jkn', 'new_tab' => true ) ),
              array( 'link' => array( 'label' => 'Uber Eats', 'url' => 'https://www.ubereats.com/store-browse-uuid/7a2ca0a0-0ec2-5a74-997a-08690eed5876?diningMode=DELIVERY', 'new_tab' => true ) ),
              array( 'link' => array( 'label' => 'Just Eat', 'url' => 'https://www.just-eat.es/restaurants-bbq-chicken-madrid/menu', 'new_tab' => true ) ),
              array( 'link' => array( 'label' => 'Deliveroo', 'url' => '', 'new_tab' => true ) ),
          )
      );
      foreach ( $platforms as $platform ) :
          if ( '' === (string) $platform['link']['label'] || in_array( trim( (string) $platform['link']['url'] ), array( '', '#' ), true ) ) {
              continue; // no store link yet
          }
          ?>
      <a class="platform"<?php bbq_link_attrs( $platform['link'] ); ?>><?php bbq_e( $platform['link']['label'] ); ?> <span aria-hidden="true">↗</span></a>
      <?php endforeach; ?>
    </div>
    <?php $note = bbq_get( 'find_note', 'Spain: Glovo, Uber Eats, Just Eat. UK: Uber Eats, Just Eat, Deliveroo.', 'Note under the links (desktop only, empty = hidden)', 'textarea' ); ?>
    <?php if ( '' !== trim( (string) $note ) ) : ?>
    <p class="find__note only-desktop"><?php bbq_e( $note ); ?></p>
    <?php endif; ?>
  </div>

  <?php
  bbq_section( 'Delivery map' );
  $map_label = bbq_get( 'map_label', 'Map of kitchens and delivery areas in Madrid', 'Map description (screen readers)' );
  $map_img   = bbq_get( 'map_img', 'map-madrid.jpg', 'Map picture (shown until the live map has loaded; centre and radius: Website settings → Delivery map)', 'image' );
  $map_img_m = bbq_get( 'map_img_m', 'map-madrid-m.jpg', 'Map picture on phones', 'image' );
  ?>
  <?php
  // one pin per kitchen ("latitude, longitude" per line, Website settings → Delivery map)
  $pins = array();
  foreach ( preg_split( '/\R/', (string) bbq_opt( 'map_pins', "40.4409, -3.6753\n40.3971, -3.6660\n40.4577, -3.7080" ) ) as $line ) {
      if ( preg_match( '/^\s*(-?\d+(?:\.\d+)?)\s*[,;\s]\s*(-?\d+(?:\.\d+)?)\s*$/', $line, $m ) ) {
          $pins[] = $m[1] . ',' . $m[2];
      }
  }
  ?>
  <div class="map-card" role="img" aria-label="<?php echo esc_attr( $map_label ); ?>" data-lat="<?php echo esc_attr( bbq_opt( 'map_lat', '40.4319' ) ); ?>" data-lng="<?php echo esc_attr( bbq_opt( 'map_lng', '-3.6831' ) ); ?>" data-zoom="<?php echo esc_attr( bbq_opt( 'map_zoom', '12' ) ); ?>" data-radius="<?php echo esc_attr( bbq_opt( 'map_radius', '4600' ) ); ?>" data-pins="<?php echo esc_attr( implode( ';', $pins ) ); ?>" data-gmaps-key="<?php echo esc_attr( bbq_opt( 'map_gmaps_key', '' ) ); ?>">
    <picture class="map-card__tiles" aria-hidden="true">
      <source media="(max-width: 767px)" srcset="<?php echo esc_url( bbq_image_src( $map_img_m ) ); ?>" width="700" height="600">
      <?php bbq_img( $map_img, array( 'alt' => '', 'width' => 1480, 'height' => 1200, 'loading' => 'lazy' ) ); ?>
    </picture>
    <div class="map-card__area"></div>
    <?php // static preview: up to three pins where the design puts them; the live map places every kitchen ?>
    <?php for ( $p = 1; $p <= max( 1, min( 3, count( $pins ) ) ); $p++ ) : ?>
    <img class="map-card__pin map-card__pin--<?php echo (int) $p; ?><?php echo count( $pins ) > 1 ? '' : ' map-card__pin--single'; ?>" src="<?php echo esc_url( bbq_asset( 'svg/pin.svg' ) ); ?>" alt="" width="56" height="70">
    <?php endfor; ?>
    <?php $map_caption = bbq_get( 'map_caption', '', 'Caption (empty = hidden)' ); ?>
    <?php if ( '' !== trim( (string) $map_caption ) ) : ?>
    <p class="map-card__caption"><?php bbq_e( $map_caption ); ?></p>
    <?php endif; ?>
    <?php
    // Card on the map: the kitchens and their opening hours (title empty = no card)
    $kitchen_name = bbq_get( 'kitchen_name', 'bb.q Madrid · 3 kitchens', 'Map card: title (empty = no card)' );
    $kitchen_info = bbq_get( 'kitchen_info', "Calle Zabaleta 1, Calle Felipe Fraile 5 and Calle José Calvo 10\nDelivery only\nSunday to Thursday: 12:00 to 23:00\nFriday and Saturday: 12:00 to midnight", 'Map card: text (one line per row)', 'textarea' );
    $l            = bbq_link( 'kitchen_btn', array( 'label' => 'Order now', 'url' => '' ), 'Kitchen card: button (without a link it opens the ordering links above)' );
    // the ordering links that have a store link (for the button's list)
    $order_links = array_filter(
        $platforms,
        function ( $platform ) {
            return '' !== (string) $platform['link']['label'] && ! in_array( trim( (string) $platform['link']['url'] ), array( '', '#' ), true );
        }
    );
    if ( '' !== trim( (string) $kitchen_name ) ) :
        ?>
    <div class="kitchen-card">
      <strong><?php bbq_e( $kitchen_name ); ?></strong>
      <?php if ( '' !== trim( (string) $kitchen_info ) ) : ?>
      <p><?php echo nl2br( esc_html( trim( (string) $kitchen_info ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput -- escaped ?></p>
      <?php endif; ?>
      <?php if ( '' !== $l['label'] && ! in_array( (string) $l['url'], array( '', '#' ), true ) ) : ?>
      <a class="btn btn--red"<?php bbq_link_attrs( $l ); ?>><?php bbq_e( $l['label'] ); ?> <span class="btn__chip"><?php bbq_icon( 'arrow' ); ?></span></a>
      <?php elseif ( '' !== $l['label'] && $order_links ) : ?>
      <div class="kitchen-card__order" data-dropdown>
        <button class="btn btn--red" type="button" aria-expanded="false" aria-controls="dd-kitchen-order"><?php bbq_e( $l['label'] ); ?> <span class="btn__chip"><?php bbq_icon( 'chevdown' ); ?></span></button>
        <div class="dropdown" id="dd-kitchen-order">
          <?php foreach ( $order_links as $platform ) : ?>
          <a class="dropdown__link"<?php bbq_link_attrs( $platform['link'] ); ?>><?php bbq_e( $platform['link']['label'] ); ?> <span aria-hidden="true">↗</span></a>
          <?php endforeach; ?>
        </div>
      </div>
      <?php endif; ?>
    </div>
    <?php endif; ?>
  </div>
</section>
