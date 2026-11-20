<?php
/**
 * Home page (front page). See CONVERTING.md.
 * Static source: html-backup/src/pages/index.html
 * Helpers: inc/parts/home.php (scrolling bands, news posts).
 */
defined( 'ABSPATH' ) || exit;

// Food card colours (food-card--<value>).
$food_styles = array( 'dark' => 'Dark', 'yellow' => 'Yellow', 'red' => 'Red', 'sand' => 'Sand' );
?>

<!-- 1. BLT Global Brands intro -->
<?php
bbq_section( 'Intro' );
$peek = bbq_get( 'intro_peek', 'chibboq-peeking.png', 'ChiBBoQ peeking in (image)', 'image' );
?>
<section class="section intro" aria-labelledby="intro-title">
  <div class="intro__text">
    <span class="eyebrow"><?php bbq_text( 'intro_eyebrow', 'BLT Global Brands', 'Label' ); ?></span>
    <h1 class="h-display" id="intro-title"><?php bbq_text( 'intro_title', 'Global excellence, local expertise.', 'Heading' ); ?></h1>
    <p class="lead"><?php bbq_textarea( 'intro_lead', 'BLT Global Brands is the strategic master partner driving bb.q Chicken\'s expansion across Europe. By combining three decades of international culinary heritage with local operational expertise, our mission is to bring the most beloved brands to neighbourhoods worldwide while maintaining high ethical standards and enriching our local communities.', 'Intro text' ); ?></p>
    <div class="btn-row">
      <?php $l = bbq_link( 'intro_btn1', array( 'label' => 'Franchise with us', 'url' => 'page:franchise' ), 'First button' ); ?>
      <a class="btn btn--red"<?php bbq_link_attrs( $l ); ?>><?php bbq_e( $l['label'] ); ?> <span class="btn__chip"><?php bbq_icon( 'arrow' ); ?></span></a>
      <?php $l = bbq_link( 'intro_btn2', array( 'label' => 'About BLT Global Brands', 'url' => 'page:about' ), 'Second button' ); ?>
      <a class="btn btn--outline-dark"<?php bbq_link_attrs( $l ); ?>><?php bbq_e( $l['label'] ); ?> <span class="btn__chip"><?php bbq_icon( 'arrow' ); ?></span></a>
    </div>
  </div>

  <?php bbq_section( 'Intro: our brands' ); ?>
  <div class="intro__brands">
    <span class="label-caps intro__brands-label"><?php bbq_text( 'brands_label', 'Our brands', 'Label above the cards' ); ?></span>
    <div class="carousel carousel--mobile" data-carousel>
      <div class="brand-cards" data-carousel-viewport>
        <?php
        $brands = bbq_rows(
            'brands',
            'Brand cards',
            array(
                'img'      => array( 'image', 'Food cut-out' ),
                'logo'     => array( 'image', 'Logo' ),
                'logo_alt' => array( 'text', 'Brand name (logo alt text)' ),
                'tag'      => array( 'text', 'Tagline' ),
                'link'     => array( 'link', 'Link' ),
            ),
            array(
                array( 'img' => 'cut-2pcs-secret-sauce.png', 'logo' => 'svg/logo-on-dark.svg', 'logo_alt' => 'bb.q Chicken', 'tag' => 'Korean fried chicken, since 1995', 'link' => array( 'label' => 'Discover bb.q →', 'url' => 'page:discover' ) ),
            )
        );
        foreach ( $brands as $brand ) :
            ?>
        <article class="brand-card">
          <div class="cutout"><?php bbq_img( $brand['img'], array( 'alt' => '', 'width' => 760, 'height' => 412 ) ); ?></div>
          <?php bbq_img( $brand['logo'], array( 'class' => 'brand-card__logo', 'alt' => $brand['logo_alt'], 'width' => 250, 'height' => 42 ) ); ?>
          <p class="brand-card__tag"><?php bbq_e( $brand['tag'] ); ?></p>
          <?php if ( $brand['link']['label'] ) : ?>
          <a class="brand-card__link"<?php bbq_link_attrs( $brand['link'] ); ?>><?php bbq_e( $brand['link']['label'] ); ?></a>
          <?php endif; ?>
        </article>
        <?php endforeach; ?>
        <?php if ( bbq_toggle( 'brands_soon_show', true, 'Show the "More brands coming soon" card' ) ) : ?>
        <div class="brand-card brand-card--soon">
          <span class="plus" aria-hidden="true">+</span>
          <strong><?php bbq_html( 'brands_soon_text', 'More brands<br>coming soon', '"Coming soon" card text' ); ?></strong>
        </div>
        <?php endif; ?>
      </div>
      <div class="slider__nav" data-carousel-nav>
        <button class="slider__arrow" type="button" aria-label="Previous brand" data-carousel-prev><?php bbq_icon( 'left' ); ?></button>
        <div class="slider__dots" data-carousel-dots></div>
        <button class="slider__arrow" type="button" aria-label="Next brand" data-carousel-next><?php bbq_icon( 'right' ); ?></button>
      </div>
    </div>
    <?php $note = bbq_get( 'brands_note', 'Built to grow: with more brands, this row becomes a brand switcher (one card per brand).', 'Note under the cards (desktop only, empty = hidden)', 'textarea' ); ?>
    <?php if ( '' !== trim( (string) $note ) ) : ?>
    <p class="intro__note only-desktop"><?php bbq_e( $note ); ?></p>
    <?php endif; ?>
  </div>

  <?php bbq_img( $peek, array( 'class' => 'peek', 'alt' => '', 'width' => 300, 'height' => 537 ) ); ?>
</section>

<!-- 2. Hero -->
<?php bbq_section( 'Hero' ); ?>
<section class="hero hero--home" aria-labelledby="hero-title">
  <div class="hero__cutouts" aria-hidden="true">
    <div class="cutout hero__cut hero__cut--left"><?php bbq_image( 'hero_cut_left', 'cut-bucket-09.png', 'Cut-out image, left', array( 'alt' => '', 'width' => 832, 'height' => 671, 'loading' => 'lazy' ) ); ?></div>
    <div class="cutout hero__cut hero__cut--right"><?php bbq_image( 'hero_cut_right', 'cut-8pcs-fried-bucket.png', 'Cut-out image, right', array( 'alt' => '', 'width' => 660, 'height' => 838, 'loading' => 'lazy' ) ); ?></div>
  </div>
  <?php bbq_image( 'hero_mobile_bg', 'hero-mobile.jpg', 'Background photo on phones', array( 'class' => 'hero__mobile-bg', 'alt' => '', 'width' => 800, 'height' => 1000, 'loading' => 'lazy', 'style' => 'display:none' ) ); ?>
  <div class="hero__content">
    <h2 class="h-display hero__title" id="hero-title"><?php bbq_text( 'hero_title', 'Korea\'s favourite fried chicken is now in Europe.', 'Heading' ); ?></h2>
    <p class="hero__lead"><?php bbq_textarea( 'hero_lead', 'Double-fried for real crunch, glazed in sauces from Secret Sauce to Honey Garlic, and made for sharing. More than 3,500 restaurants worldwide since 1995. Now delivering in Europe.', 'Intro text' ); ?></p>
    <div class="btn-row">
      <?php $l = bbq_link( 'hero_btn1', array( 'label' => 'Order now', 'url' => '#find' ), 'First button' ); ?>
      <a class="btn btn--cream"<?php bbq_link_attrs( $l ); ?>><?php bbq_e( $l['label'] ); ?> <span class="btn__chip"><?php bbq_icon( 'arrow' ); ?></span></a>
      <?php $l = bbq_link( 'hero_btn2', array( 'label' => 'Find a restaurant', 'url' => '#find' ), 'Second button' ); ?>
      <a class="btn btn--outline-light"<?php bbq_link_attrs( $l ); ?>><?php bbq_e( $l['label'] ); ?> <span class="btn__chip"><?php bbq_icon( 'arrow' ); ?></span></a>
    </div>
  </div>
  <div class="stamp"><?php bbq_stamp(); ?></div>
</section>

<!-- 3. Marquee: open for partners -->
<?php bbq_section( 'Scrolling band 1 (dark)' ); ?>
<div class="marquee marquee--dark" aria-hidden="true">
  <div class="marquee__track" data-marquee><?php
    bbq_home_marquee(
        'band1',
        'Band texts',
        array(
            array( 'text' => 'Open for partners', 'strong' => 1 ),
            array( 'text' => 'Europe', 'strong' => 0 ),
            array( 'text' => 'Submit your application →', 'strong' => 1 ),
        )
    );
    ?></div>
</div>

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

<!-- 5. Food -->
<?php bbq_section( 'The food' ); ?>
<section class="food" aria-labelledby="food-title">
  <div class="cutout cutout--shadow cutout--fried"><?php bbq_image( 'food_cut_fried', 'cut-2pcs-fried.png', 'Cut-out image, top left', array( 'alt' => '', 'width' => 880, 'height' => 463, 'loading' => 'lazy' ) ); ?></div>
  <div class="cutout cutout--shadow cutout--sauce"><?php bbq_image( 'food_cut_sauce', 'cut-2pcs-secret-sauce.png', 'Cut-out image, top right', array( 'alt' => '', 'width' => 760, 'height' => 412, 'loading' => 'lazy' ) ); ?></div>
  <div class="food__head">
    <span class="eyebrow"><?php bbq_text( 'food_eyebrow', 'The food', 'Label' ); ?></span>
    <h2 class="h2" id="food-title"><?php bbq_text( 'food_title', 'Crispy outside, juicy inside, sauced your way.', 'Heading' ); ?></h2>
    <p class="lead"><?php bbq_textarea( 'food_lead', 'Every piece is double-fried the Korean way, then tossed in one of our signature sauces. Sweet, garlicky or savoury, there\'s a favourite for every table.', 'Intro text' ); ?></p>
  </div>

  <div class="slider" data-slider data-slider-loop data-start="2" data-start-mobile="0">
    <div class="slider__viewport" data-slider-viewport>
      <?php
      $food = bbq_rows(
          'food_cards',
          'Food cards (endless slider; the third card starts in the middle on desktop)',
          array(
              'title'        => array( 'text', 'Title' ),
              'text'         => array( 'textarea', 'Text' ),
              'tag'          => array( 'text', 'Tag on the photo' ),
              'style'        => array( 'select', 'Colour', $food_styles ),
              'desktop_only' => array( 'toggle', 'Desktop only (hidden on phones)' ),
              'img'          => array( 'image', 'Photo' ),
              'alt'          => array( 'text', 'Photo description (alt text)' ),
          ),
          array(
              array( 'style' => 'dark', 'desktop_only' => 1, 'img' => 'food-2pcs-secret-sauce.jpg', 'alt' => 'Two pieces of chicken glazed in Secret Sauce', 'tag' => '5 sauces', 'title' => 'Signature sauces', 'text' => 'Golden Original, or sauced in Secret Sauce, Honey Garlic, Galbi, Jasoman or Gangjeong.' ),
              array( 'style' => 'yellow', 'desktop_only' => 0, 'img' => 'food-2pcs-fried.jpg', 'alt' => 'Two pieces of golden fried chicken', 'tag' => 'Meals', 'title' => 'Combo meals', 'text' => 'Pieces, tenders, a burger, wrap or bowl, with fries and a drink. Lunch, sorted.' ),
              array( 'style' => 'red', 'desktop_only' => 0, 'img' => 'food-3pcs-strips.jpg', 'alt' => 'Three crispy chicken tenders', 'tag' => 'On the go', 'title' => 'Real Crispy Tenders', 'text' => 'Crispy chicken strips in 3, 6 or 12 pieces, easy to share and easier to eat on the go.' ),
              array( 'style' => 'sand', 'desktop_only' => 0, 'img' => 'food-8pcs-fried.jpg', 'alt' => 'A bucket of eight pieces of fried chicken', 'tag' => '8 pieces', 'title' => 'Mega Party Bucket', 'text' => 'Eight pieces of Real Korean Fried Chicken. Add sides for everyone at the table.' ),
              array( 'style' => 'dark', 'desktop_only' => 0, 'img' => 'food-8pcs-secret-sauce.jpg', 'alt' => 'A bucket of chicken glazed in Secret Sauce', 'tag' => '5 sauces', 'title' => 'Signature sauces', 'text' => 'Golden Original, or sauced in Secret Sauce, Honey Garlic, Galbi, Jasoman or Gangjeong.' ),
          )
      );
      foreach ( $food as $card ) :
          $style = isset( $food_styles[ $card['style'] ] ) ? $card['style'] : 'dark';
          ?>
      <article class="food-card food-card--<?php echo esc_attr( $style ); ?><?php echo $card['desktop_only'] ? ' food-card--desktop-only' : ''; ?>">
        <div class="food-card__img"><?php bbq_img( $card['img'], array( 'alt' => $card['alt'], 'width' => 960, 'height' => 720, 'loading' => 'lazy' ) ); ?><?php if ( '' !== (string) $card['tag'] ) : ?><span class="food-card__tag"><?php bbq_e( $card['tag'] ); ?></span><?php endif; ?></div>
        <div class="food-card__body"><h3 class="food-card__title"><?php bbq_e( $card['title'] ); ?></h3><p class="food-card__text"><?php bbq_e( $card['text'] ); ?></p></div>
      </article>
      <?php endforeach; ?>
    </div>
    <div class="slider__nav">
      <button class="slider__arrow" type="button" aria-label="Previous" data-slider-prev><?php bbq_icon( 'left' ); ?></button>
      <div class="slider__dots" data-slider-dots></div>
      <button class="slider__arrow" type="button" aria-label="Next" data-slider-next><?php bbq_icon( 'right' ); ?></button>
    </div>
  </div>

  <div class="food__cta">
    <?php $l = bbq_link( 'food_btn', array( 'label' => 'See the full menu', 'url' => 'page:menu' ), 'Button' ); ?>
    <a class="btn btn--outline-dark"<?php bbq_link_attrs( $l ); ?>><?php bbq_e( $l['label'] ); ?> <span class="btn__chip"><?php bbq_icon( 'arrow' ); ?></span></a>
  </div>
</section>

<!-- 6. Find bb.q near you -->
<?php bbq_section( 'Find bb.q near you' ); ?>
<section class="section find" id="find" aria-labelledby="find-title">
  <div class="cutout cutout--bucket"><?php bbq_image( 'find_cut', 'cut-bucket-spill.png', 'Cut-out image', array( 'alt' => '', 'width' => 840, 'height' => 599, 'loading' => 'lazy' ) ); ?></div>
  <div class="find__text">
    <span class="eyebrow"><?php bbq_text( 'find_eyebrow', 'Order now', 'Label' ); ?></span>
    <h2 class="h2" id="find-title"><?php bbq_text( 'find_title', 'Find bb.q near you', 'Heading' ); ?></h2>
    <p class="lead"><?php bbq_textarea( 'find_lead', 'Our first kitchens open in [Madrid] from [28 October 2026]. Enter your postcode to see if we deliver to you, or order straight from your favourite app.', 'Intro text' ); ?></p>
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
          'Ordering links (own shop, delivery apps)',
          array( 'link' => array( 'link', 'Link' ) ),
          array(
              array( 'link' => array( 'label' => 'Order direct from bb.q', 'url' => '#', 'new_tab' => false ) ),
              array( 'link' => array( 'label' => 'Glovo', 'url' => '#', 'new_tab' => true ) ),
              array( 'link' => array( 'label' => 'Uber Eats', 'url' => '#', 'new_tab' => true ) ),
              array( 'link' => array( 'label' => 'Just Eat', 'url' => '#', 'new_tab' => true ) ),
              array( 'link' => array( 'label' => 'Deliveroo', 'url' => '#', 'new_tab' => true ) ),
          )
      );
      foreach ( $platforms as $platform ) :
          if ( '' === (string) $platform['link']['label'] ) {
              continue;
          }
          ?>
      <a class="platform"<?php bbq_link_attrs( $platform['link'] ); ?>><?php bbq_e( $platform['link']['label'] ); ?> <span aria-hidden="true">↗</span></a>
      <?php endforeach; ?>
    </div>
    <?php $note = bbq_get( 'find_note', 'Spain: Glovo, Uber Eats, Just Eat. UK: Uber Eats, Just Eat, Deliveroo. Only the platforms for the visitor\'s country are shown. [Links to be supplied by BLT]', 'Note under the links (desktop only, empty = hidden)', 'textarea' ); ?>
    <?php if ( '' !== trim( (string) $note ) ) : ?>
    <p class="find__note only-desktop"><?php bbq_e( $note ); ?></p>
    <?php endif; ?>
  </div>

  <?php
  bbq_section( 'Delivery map' );
  $map_label = bbq_get( 'map_label', 'Map of kitchens and delivery areas in Madrid', 'Map description (screen readers)' );
  $map_img   = bbq_get( 'map_img', 'map-madrid.jpg', 'Map picture (shown until the live map has loaded; centre and radius: Appearance → bb.q settings)', 'image' );
  $map_img_m = bbq_get( 'map_img_m', 'map-madrid-m.jpg', 'Map picture on phones', 'image' );
  ?>
  <div class="map-card" role="img" aria-label="<?php echo esc_attr( $map_label ); ?>" data-lat="<?php echo esc_attr( bbq_opt( 'map_lat', '40.4168' ) ); ?>" data-lng="<?php echo esc_attr( bbq_opt( 'map_lng', '-3.7038' ) ); ?>" data-zoom="<?php echo esc_attr( bbq_opt( 'map_zoom', '13' ) ); ?>" data-radius="<?php echo esc_attr( bbq_opt( 'map_radius', '2400' ) ); ?>" data-gmaps-key="<?php echo esc_attr( bbq_opt( 'map_gmaps_key', '' ) ); ?>">
    <picture class="map-card__tiles" aria-hidden="true">
      <source media="(max-width: 767px)" srcset="<?php echo esc_url( bbq_image_src( $map_img_m ) ); ?>" width="700" height="600">
      <?php bbq_img( $map_img, array( 'alt' => '', 'width' => 1480, 'height' => 1200, 'loading' => 'lazy' ) ); ?>
    </picture>
    <div class="map-card__area"></div>
    <img class="map-card__pin" src="<?php echo esc_url( bbq_asset( 'svg/pin.svg' ) ); ?>" alt="" width="56" height="70">
    <p class="map-card__caption"><?php bbq_text( 'map_caption', 'Map: kitchens and delivery areas [Madrid, UK locations TBC]', 'Caption' ); ?></p>
    <div class="kitchen-card">
      <strong><?php bbq_text( 'kitchen_name', '[bb.q Madrid, kitchen name]', 'Kitchen card: name' ); ?></strong>
      <p><?php bbq_text( 'kitchen_info', 'Delivery only · Open today until 23:00 [TBC]', 'Kitchen card: details' ); ?></p>
      <?php $l = bbq_link( 'kitchen_btn', array( 'label' => 'Order now', 'url' => '#' ), 'Kitchen card: button' ); ?>
      <a class="btn btn--red"<?php bbq_link_attrs( $l ); ?>><?php bbq_e( $l['label'] ); ?> <span class="btn__chip"><?php bbq_icon( 'arrow' ); ?></span></a>
    </div>
  </div>
</section>

<!-- 7. Marquee: sauces -->
<?php bbq_section( 'Scrolling band 2 (yellow)' ); ?>
<div class="marquee marquee--yellow marquee--ltr" aria-hidden="true">
  <div class="marquee__track" data-marquee><?php
    bbq_home_marquee(
        'band2',
        'Band texts',
        array(
            array( 'text' => 'Our signature sauces', 'strong' => 1 ),
            array( 'text' => 'Golden Original', 'strong' => 0 ),
            array( 'text' => 'Secret Sauce', 'strong' => 0 ),
            array( 'text' => 'Honey Garlic', 'strong' => 0 ),
            array( 'text' => 'Soy Garlic', 'strong' => 0 ),
            array( 'text' => 'Hot Spicy', 'strong' => 0 ),
        )
    );
    ?></div>
</div>

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

<!-- 9. Why partner -->
<?php bbq_section( 'Why partner with us (franchise)' ); ?>
<section class="section why why--home" aria-labelledby="why-title">
  <div class="why__bg why__bg--glow" aria-hidden="true">
    <?php bbq_image( 'why_bg_img', 'cut-bucket-09.png', 'Background cut-out image', array( 'class' => 'why__bg-cut', 'alt' => '', 'width' => 832, 'height' => 671, 'loading' => 'lazy' ) ); ?>
  </div>
  <div class="cutout cutout--shadow-dark cutout--cheesling"><?php bbq_image( 'why_cut', 'cut-4pcs-cheesling.png', 'Cut-out image', array( 'alt' => '', 'width' => 860, 'height' => 419, 'loading' => 'lazy' ) ); ?></div>
  <div class="why__inner">
    <div class="section-head">
      <span class="eyebrow eyebrow--glass"><?php bbq_text( 'why_eyebrow', 'Franchise', 'Label' ); ?></span>
      <h2 class="h2" id="why-title"><?php bbq_text( 'why_title', 'Thirty years of know-how, looking for its European partners.', 'Heading' ); ?></h2>
      <p class="lead"><?php bbq_textarea( 'why_lead', 'We\'re looking for experienced multi-unit operators and area developers who want to build a region or a whole country. You bring local knowledge and operating strength. We bring the brand, the recipes and a system refined in 3,500+ restaurants.', 'Intro text' ); ?></p>
    </div>
    <div class="carousel carousel--mobile carousel--light" data-carousel>
      <div class="reasons" data-carousel-viewport>
        <?php
        $reasons = bbq_rows(
            'reasons',
            'Reasons (numbered 01, 02 … automatically)',
            array(
                'title' => array( 'text', 'Title' ),
                'text'  => array( 'textarea', 'Text' ),
            ),
            array(
                array( 'title' => 'A brand guests already know', 'text' => 'Korea\'s best-known fried chicken, with restaurants from Seoul to New York and a fast-growing following in the US.' ),
                array( 'title' => 'Express, built for speed', 'text' => 'Our Express kiosk runs on 10 to 40 m², focused on takeaway and delivery, with a tight menu and low labour costs.' ),
                array( 'title' => 'Training from the source', 'text' => 'Owners and teams train at Chicken University, bb.q\'s own training and R&D centre, running since 1999.' ),
                array( 'title' => 'A European team behind you', 'text' => 'Site selection, supply, launch marketing and day-to-day support from the team leading bb.q in Europe. [Scope to be confirmed]' ),
            )
        );
        foreach ( $reasons as $i => $reason ) :
            ?>
        <article class="reason"><span class="reason__num"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span><h3 class="reason__title"><?php bbq_e( $reason['title'] ); ?></h3><p class="reason__text"><?php bbq_e( $reason['text'] ); ?></p></article>
        <?php endforeach; ?>
      </div>
      <div class="slider__nav" data-carousel-nav>
        <button class="slider__arrow" type="button" aria-label="Previous reason" data-carousel-prev><?php bbq_icon( 'left' ); ?></button>
        <div class="slider__dots" data-carousel-dots></div>
        <button class="slider__arrow" type="button" aria-label="Next reason" data-carousel-next><?php bbq_icon( 'right' ); ?></button>
      </div>
    </div>
    <div class="btn-row">
      <?php $l = bbq_link( 'why_btn1', array( 'label' => 'Explore the franchise', 'url' => 'page:franchise' ), 'First button' ); ?>
      <a class="btn btn--outline-light"<?php bbq_link_attrs( $l ); ?>><?php bbq_e( $l['label'] ); ?> <span class="btn__chip"><?php bbq_icon( 'arrow' ); ?></span></a>
      <?php $l = bbq_link( 'why_btn2', array( 'label' => 'Submit your application', 'url' => 'page:apply' ), 'Second button' ); ?>
      <a class="btn btn--cream"<?php bbq_link_attrs( $l ); ?>><?php bbq_e( $l['label'] ); ?> <span class="btn__chip"><?php bbq_icon( 'arrow' ); ?></span></a>
    </div>
  </div>
</section>

<!-- 10. Mascot -->
<?php bbq_section( 'Mascot (ChiBBoQ)' ); ?>
<section class="section mascot" aria-labelledby="mascot-title">
  <?php $mascot = bbq_get( 'mascot_img', 'chibboq-sitting-cutout.png', 'Image', 'image' ); ?>
  <div class="mascot__img"><?php bbq_img( $mascot, array( 'alt' => bbq_get( 'mascot_alt', 'ChiBBoQ, the bb.q mascot, sitting', 'Image description (alt text)' ), 'width' => 582, 'height' => 991, 'loading' => 'lazy' ) ); ?></div>
  <div class="mascot__text">
    <span class="eyebrow"><?php bbq_text( 'mascot_eyebrow', 'For the whole family', 'Label' ); ?></span>
    <h2 class="h2" id="mascot-title"><?php bbq_text( 'mascot_title', 'Meet ChiBBoQ', 'Heading' ); ?></h2>
    <p><?php bbq_textarea( 'mascot_text', 'ChiBBoQ is the softest member of the bb.q family. You\'ll find them on our boxes and bags, peeking in at the counter and now and then dressed for the occasion. Kids tend to remember them long after the last wing is gone.', 'Text' ); ?></p>
    <?php $l = bbq_link( 'mascot_btn', array( 'label' => 'Follow ChiBBoQ on Instagram', 'url' => '#', 'new_tab' => true ), 'Button (Instagram link)' ); ?>
    <div class="btn-row"><a class="btn btn--outline-light"<?php bbq_link_attrs( $l ); ?>><?php bbq_e( $l['label'] ); ?> <span class="btn__chip"><?php bbq_icon( 'arrow' ); ?></span></a></div>
  </div>
</section>

<!-- 11. Our team (teaser) -->
<?php bbq_section( 'Our team' ); ?>
<section class="section team" aria-labelledby="team-title">
  <?php $team = bbq_get( 'team_img', 'team.jpg', 'Team photo', 'image' ); ?>
  <div class="team__img"><?php bbq_img( $team, array( 'alt' => bbq_get( 'team_alt', 'The BLT Global Brands team in Europe', 'Team photo: description (alt text)' ), 'width' => 1600, 'height' => 968, 'loading' => 'lazy' ) ); ?></div>
  <div class="team__text">
    <span class="eyebrow"><?php bbq_text( 'team_eyebrow', 'Our team', 'Label' ); ?></span>
    <h2 class="h2" id="team-title"><?php bbq_text( 'team_title', 'The people bringing bb.q to Europe', 'Heading' ); ?></h2>
    <p class="lead"><?php bbq_textarea( 'team_lead', 'A European team with years of experience in international restaurant franchising, building bb.q one market at a time. [Team intro to be supplied by BLT]', 'Intro text' ); ?></p>
    <?php $l = bbq_link( 'team_btn', array( 'label' => 'Meet the team', 'url' => 'page:about#team' ), 'Button' ); ?>
    <div class="btn-row"><a class="btn btn--outline-dark"<?php bbq_link_attrs( $l ); ?>><?php bbq_e( $l['label'] ); ?> <span class="btn__chip"><?php bbq_icon( 'arrow' ); ?></span></a></div>
  </div>
</section>

<!-- 12. News (the latest posts; edit them under Posts) -->
<?php bbq_section( 'News (cards: the 5 latest posts that aren\'t placeholder cards)' ); ?>
<section class="section news news--home" aria-labelledby="news-title">
  <div class="news__head">
    <div class="news__head-text">
      <span class="eyebrow"><?php bbq_text( 'news_eyebrow', 'News', 'Label' ); ?></span>
      <h2 class="h2" id="news-title"><?php bbq_text( 'news_title', 'What\'s new', 'Heading' ); ?></h2>
    </div>
    <?php $all = bbq_link( 'news_all', array( 'label' => 'All news', 'url' => 'page:news' ), '"All news" button' ); ?>
    <a class="btn btn--outline-dark"<?php bbq_link_attrs( $all ); ?>><?php bbq_e( $all['label'] ); ?> <span class="btn__chip"><?php bbq_icon( 'arrow' ); ?></span></a>
    <a class="news__all-link"<?php bbq_link_attrs( $all ); ?>><?php bbq_text( 'news_all_short', 'All news →', '"All news" link text on phones' ); ?></a>
  </div>
  <div class="carousel" data-carousel>
    <div class="news__track" data-carousel-viewport>
      <?php
      foreach ( bbq_schema_mode() ? array() : bbq_home_news_ids( 5 ) as $news_id ) :
          $news_link = bbq_news_card_link( $news_id );
          $news_tag  = $news_link ? 'a' : 'div';
          $news_img  = get_post_thumbnail_id( $news_id );
          ?>
      <<?php echo $news_tag; // phpcs:ignore WordPress.Security.EscapeOutput -- 'a' or 'div' ?> class="news-card<?php echo $news_link ? '' : ' news-card--static'; ?>"<?php if ( $news_link ) { bbq_link_attrs( $news_link ); } ?>>
        <?php if ( $news_img ) : ?>
        <div class="news-card__img"><?php bbq_img( $news_img, array( 'size' => 'bbq-card', 'loading' => 'lazy' ) ); ?></div>
        <?php else : ?>
        <div class="news-card__img news-card__img--placeholder" aria-hidden="true"></div>
        <?php endif; ?>
        <div class="news-card__meta"><span class="news-card__date"><?php bbq_e( bbq_news_card_meta( $news_id ) ); ?></span><h3 class="news-card__title"><?php bbq_e( get_post_field( 'post_title', $news_id, 'raw' ) ); ?><?php if ( $news_link && $news_link['new_tab'] ) : ?><span class="sr-only"> (opens in a new tab)</span><?php endif; ?></h3></div>
      </<?php echo $news_tag; // phpcs:ignore WordPress.Security.EscapeOutput ?>>
      <?php endforeach; ?>
    </div>
    <div class="slider__nav" data-carousel-nav>
      <button class="slider__arrow" type="button" aria-label="Previous articles" data-carousel-prev><?php bbq_icon( 'left' ); ?></button>
      <div class="slider__dots" data-carousel-dots></div>
      <button class="slider__arrow" type="button" aria-label="Next articles" data-carousel-next><?php bbq_icon( 'right' ); ?></button>
    </div>
  </div>
</section>

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

<!-- 14. Closing CTA -->
<?php bbq_section( 'Closing call to action' ); ?>
<section class="section closing" aria-labelledby="closing-title">
  <div class="stamp"><?php bbq_stamp(); ?></div>
  <span class="sparkle-lg" aria-hidden="true"><?php bbq_icon( 'sparkleplain' ); ?></span>
  <span class="sparkle-sm" aria-hidden="true"><?php bbq_icon( 'sparkleplain' ); ?></span>
  <div class="cta-card">
    <h2 class="h2" id="closing-title"><?php bbq_text( 'closing_title', 'Ready to bring bb.q to your market?', 'Heading' ); ?></h2>
    <p class="lead"><?php bbq_textarea( 'closing_lead', 'Tell us who you are and where you\'d like to grow. It takes two minutes. Our European team reads every enquiry and gets back to you personally.', 'Text' ); ?></p>
    <?php $l = bbq_link( 'closing_btn', array( 'label' => 'Submit your application', 'url' => 'page:apply' ), 'Button' ); ?>
    <a class="btn btn--red"<?php bbq_link_attrs( $l, ' data-hides-floating' ); ?>><?php bbq_e( $l['label'] ); ?> <span class="btn__chip"><?php bbq_icon( 'arrow' ); ?></span></a>
  </div>
  <div class="cutout cutout--shadow-dark cutout--fried"><?php bbq_image( 'closing_cut', 'cut-2pcs-fried.png', 'Cut-out image', array( 'alt' => '', 'width' => 880, 'height' => 463, 'loading' => 'lazy' ) ); ?></div>
</section>
