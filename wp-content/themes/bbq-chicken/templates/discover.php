<?php
/**
 * Discover bb.q page.
 * Static source: html-backup/src/pages/discover.html
 */
defined( 'ABSPATH' ) || exit;

// Timeline icons (Lucide: store, graduation-cap, plane, building-2, star). Editors pick one per step.
$timeline_icons = array(
	'store'    => '<svg viewBox="0 0 24 24"><path d="m2 7 4.41-4.41A2 2 0 0 1 7.83 2h8.34a2 2 0 0 1 1.42.59L22 7"/><path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"/><path d="M15 22v-4a2 2 0 0 0-2-2h-2a2 2 0 0 0-2 2v4"/><path d="M2 7h20"/><path d="M22 7v3a2 2 0 0 1-2 2 2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 16 12a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 12 12a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 8 12a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 4 12a2 2 0 0 1-2-2V7"/></svg>',
	'cap'      => '<svg viewBox="0 0 24 24"><path d="M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.08a1 1 0 0 0 0 1.832l8.57 3.908a2 2 0 0 0 1.66 0z"/><path d="M6 12.5V16a6 3 0 0 0 12 0v-3.5"/></svg>',
	'plane'    => '<svg viewBox="0 0 24 24"><path d="M17.8 19.2 16 11l3.5-3.5C21 6 21.5 4 21 3c-1-.5-3 0-4.5 1.5L13 8 4.8 6.2c-.5-.1-.9.1-1.1.5l-.3.5c-.2.5-.1 1 .3 1.3L9 12l-2 3H4l-1 1 3 2 2 3 1-1v-3l3-2 3.5 5.3c.3.4.8.5 1.3.3l.5-.2c.4-.3.6-.7.5-1.2z"/></svg>',
	'building' => '<svg viewBox="0 0 24 24"><path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"/><path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"/><path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2M10 6h4M10 10h4M10 14h4M10 18h4"/></svg>',
	'star'     => '<svg viewBox="0 0 24 24"><path d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z"/></svg>',
);

// Size attributes of the design's card images (media-library images bring their own).
$img_dims = array(
	'cut-tenders-3pcs.png'      => array( 880, 573 ),
	'cut-2pcs-fried.png'        => array( 880, 463 ),
	'cut-2pcs-secret-sauce.png' => array( 760, 412 ),
);
?>

<!-- 1. Hero (Hero pattern) -->
<?php bbq_section( 'Hero' ); ?>
<section class="section page-hero" aria-labelledby="discover-title">
  <?php $hero_img = bbq_get( 'hero_img', 'cut-8pcs-secret-sauce-bucket.png', 'Image', 'image' ); ?>
  <div class="page-hero__media"><?php bbq_img( $hero_img, array( 'alt' => bbq_get( 'hero_img_alt', 'A bucket of chicken glazed in Secret Sauce', 'Image description (alt text)' ), 'width' => 760, 'height' => 962 ) ); ?></div>
  <div class="page-hero__text">
    <span class="eyebrow eyebrow--glass"><?php bbq_text( 'hero_eyebrow', 'Discover bb.q', 'Label' ); ?></span>
    <h1 class="h-display" id="discover-title"><?php bbq_text( 'hero_title', 'Best of the Best Quality, since 1995.', 'Heading' ); ?></h1>
    <p class="lead"><?php bbq_textarea( 'hero_lead', 'bb.q stands for Best of the Best Quality. It started with one small restaurant in Korea in 1995 and grew into the country\'s best-known fried chicken brand. Today you\'ll find it from Seoul to New York, and soon across Europe.', 'Intro text' ); ?></p>
    <?php
    $hero_cta1 = bbq_link( 'hero_cta1', array( 'label' => 'See the menu', 'url' => 'page:menu' ), 'Primary button' );
    $hero_cta2 = bbq_link( 'hero_cta2', array( 'label' => 'Submit your application', 'url' => 'page:apply' ), 'Secondary button' );
    ?>
    <?php if ( $hero_cta1['label'] || $hero_cta2['label'] ) : ?>
    <div class="btn-row">
      <?php if ( $hero_cta1['label'] ) : ?>
      <a class="btn btn--cream"<?php bbq_link_attrs( $hero_cta1 ); ?>><?php bbq_e( $hero_cta1['label'] ); ?> <span class="btn__chip"><?php bbq_icon( 'arrow' ); ?></span></a>
      <?php endif; ?>
      <?php if ( $hero_cta2['label'] ) : ?>
      <a class="btn btn--outline-light"<?php bbq_link_attrs( $hero_cta2 ); ?>><?php bbq_e( $hero_cta2['label'] ); ?> <span class="btn__chip"><?php bbq_icon( 'arrow' ); ?></span></a>
      <?php endif; ?>
    </div>
    <?php endif; ?>
  </div>
  <div class="stamp"><?php bbq_stamp(); ?></div>
</section>

<!-- 2. Our story (Process pattern) -->
<?php bbq_section( 'Our story' ); ?>
<section class="section story" id="story" aria-labelledby="story-title">
  <div class="section-head story__head">
    <span class="eyebrow eyebrow--dark"><?php bbq_text( 'story_eyebrow', 'Our story', 'Label' ); ?></span>
    <h2 class="h2" id="story-title"><?php bbq_text( 'story_title', 'Bringing communities together through delicious food', 'Heading' ); ?></h2>
    <div class="story__intro">
      <?php
      $story_intro = bbq_rows(
          'story_intro',
          'Intro paragraphs',
          array( 'text' => array( 'textarea', 'Paragraph' ) ),
          array(
              array( 'text' => 'Founded in 1995, bb.q Chicken (Best of the Best Quality) was born with a clear vision: to share the authentic taste of Korean fried chicken with the world.' ),
              array( 'text' => 'Managed across Europe by BLT Global Brands, we combine traditional recipes, proprietary crispiness techniques, and world-class operational standards. With over 3,500 locations across 57 countries, we believe that great food has the power to connect people. We are more than a restaurant brand. We are a global culinary experience dedicated to quality, innovation, and bringing communities together through delicious food.' ),
          )
      );
      foreach ( $story_intro as $para ) :
          ?>
      <p><?php bbq_e( $para['text'] ); ?></p>
      <?php endforeach; ?>
    </div>
  </div>

  <ol class="timeline">
    <?php
    $timeline = bbq_rows(
        'timeline',
        'Timeline steps',
        array(
            'year'  => array( 'text', 'Year' ),
            'title' => array( 'text', 'Title' ),
            'text'  => array( 'textarea', 'Text' ),
            'icon'  => array( 'select', 'Icon', array( 'store' => 'Restaurant', 'cap' => 'Graduation cap', 'plane' => 'Plane', 'building' => 'Building', 'star' => 'Star' ) ),
            'style' => array( 'select', 'Icon colour', array( 'cream' => 'Cream', 'yellow' => 'Yellow (highlight)' ) ),
        ),
        array(
            array( 'year' => '1995', 'title' => 'First restaurant', 'text' => 'The first bb.q opens in Jeongok, Korea.', 'icon' => 'store', 'style' => 'yellow' ),
            array( 'year' => '1999', 'title' => '1,000 restaurants', 'text' => 'bb.q passes 1,000 restaurants and opens Chicken University.', 'icon' => 'cap', 'style' => 'cream' ),
            array( 'year' => '2006', 'title' => 'Into the US', 'text' => 'The first restaurants open in the United States.', 'icon' => 'plane', 'style' => 'cream' ),
            array( 'year' => '2017', 'title' => 'Manhattan', 'text' => 'bb.q opens on 32nd Street in New York.', 'icon' => 'building', 'style' => 'cream' ),
            array( 'year' => '2025', 'title' => 'Thirty years', 'text' => '3,500+ restaurants worldwide and a new chapter in Europe.', 'icon' => 'star', 'style' => 'cream' ),
        )
    );
    foreach ( $timeline as $step ) :
        $icon = isset( $timeline_icons[ $step['icon'] ] ) ? $timeline_icons[ $step['icon'] ] : $timeline_icons['star'];
        ?>
    <li class="timeline__step">
      <div class="timeline__icon<?php echo 'yellow' === $step['style'] ? ' timeline__icon--yellow' : ''; ?>" aria-hidden="true">
        <?php echo $icon; // phpcs:ignore WordPress.Security.EscapeOutput -- fixed SVGs above ?>
      </div>
      <h3 class="timeline__title"><?php if ( '' !== (string) $step['year'] ) : ?><span class="timeline__year"><?php bbq_e( $step['year'] ); ?></span><span class="timeline__sep"> · </span><?php endif; ?><?php bbq_e( $step['title'] ); ?></h3>
      <p class="timeline__text"><?php bbq_e( $step['text'] ); ?></p>
    </li>
    <?php endforeach; ?>
  </ol>
</section>

<!-- 3. What makes it Korean (Express format pattern) -->
<?php bbq_section( 'The food' ); ?>
<section class="section formats" aria-labelledby="formats-title">
  <div class="section-head formats__head">
    <span class="eyebrow"><?php bbq_text( 'formats_eyebrow', 'The food', 'Label' ); ?></span>
    <h2 class="h2" id="formats-title"><?php bbq_text( 'formats_title', 'What makes it Korean fried chicken', 'Heading' ); ?></h2>
    <p class="formats__lead"><?php bbq_textarea( 'formats_lead', 'Korean fried chicken is fried twice. The first fry cooks it, the second makes it shatter. Then comes the sauce.', 'Intro text' ); ?></p>
  </div>
  <div class="row-slider" data-slider>
    <div class="format-grid" data-slider-viewport>
      <?php
      $formats = bbq_rows(
          'formats',
          'Cards',
          array(
              'style' => array( 'select', 'Colour', array( 'dark' => 'Dark', 'red' => 'Red', 'wine' => 'Wine red' ) ),
              'img'   => array( 'image', 'Image' ),
              'title' => array( 'text', 'Title' ),
              'text'  => array( 'textarea', 'Text' ),
              'alt'   => array( 'text', 'Image description (alt text)' ),
          ),
          array(
              array( 'style' => 'dark', 'img' => 'cut-tenders-3pcs.png', 'title' => 'Double-fried', 'text' => 'Fried twice, so the coating stays crisp even under a glaze.', 'alt' => 'Three crispy chicken tenders' ),
              array( 'style' => 'red', 'img' => 'cut-2pcs-fried.png', 'title' => 'Sauced, not smothered', 'text' => 'Secret Sauce, Honey Garlic, Galbi, Jasoman or Gangjeong, brushed on right after frying.', 'alt' => 'Two pieces of golden fried chicken' ),
              array( 'style' => 'wine', 'img' => 'cut-2pcs-secret-sauce.png', 'title' => 'Made for sharing', 'text' => 'Buckets, boxes and sides meant for the middle of the table.', 'alt' => 'Two pieces of chicken glazed in Secret Sauce' ),
          )
      );
      foreach ( $formats as $card ) :
          $dims = isset( $img_dims[ $card['img'] ] ) ? $img_dims[ $card['img'] ] : array( null, null );
          ?>
      <article class="format-card format-card--<?php echo esc_attr( $card['style'] ? $card['style'] : 'dark' ); ?>">
        <div class="format-card__img"><?php bbq_img( $card['img'], array( 'alt' => $card['alt'], 'width' => $dims[0], 'height' => $dims[1], 'loading' => 'lazy' ) ); ?></div>
        <h3 class="format-card__title"><?php bbq_e( $card['title'] ); ?></h3>
        <p class="format-card__text"><?php bbq_e( $card['text'] ); ?></p>
      </article>
      <?php endforeach; ?>
    </div>
    <div class="row-nav">
      <button class="row-nav__arrow" type="button" aria-label="Previous" data-slider-prev><?php bbq_icon( 'left' ); ?></button>
      <div class="row-nav__dots" data-slider-dots></div>
      <button class="row-nav__arrow" type="button" aria-label="Next" data-slider-next><?php bbq_icon( 'right' ); ?></button>
    </div>
  </div>
</section>

<!-- 4. Global presence (Our team pattern) -->
<?php bbq_section( 'bb.q in Europe (map)' ); ?>
<section class="section team presence" aria-labelledby="presence-title">
  <div class="team__text">
    <span class="eyebrow"><?php bbq_text( 'presence_eyebrow', 'bb.q in Europe', 'Label' ); ?></span>
    <h2 class="h2" id="presence-title"><?php bbq_text( 'presence_title', 'Where you\'ll find bb.q in Europe', 'Heading' ); ?></h2>
    <p class="lead"><?php bbq_textarea( 'presence_lead', 'bb.q runs restaurants in 57 countries worldwide. In Europe we\'re already in Spain and the UK, and every other market is open for enquiries.', 'Intro text' ); ?></p>
    <?php $presence_cta = bbq_link( 'presence_cta', array( 'label' => 'See the European markets', 'url' => 'page:home#markets' ), 'Button' ); ?>
    <?php if ( $presence_cta['label'] ) : ?>
    <div class="btn-row"><a class="btn btn--outline-dark"<?php bbq_link_attrs( $presence_cta ); ?>><?php bbq_e( $presence_cta['label'] ); ?> <span class="btn__chip"><?php bbq_icon( 'arrow' ); ?></span></a></div>
    <?php endif; ?>
  </div>
  <figure class="presence__map">
    <?php $map_img = bbq_get( 'presence_img', 'svg/europe-map.svg', 'Map image', 'image' ); ?>
    <?php bbq_img( $map_img, array( 'alt' => bbq_get( 'presence_img_alt', 'Map of Europe: Spain and the United Kingdom have an active presence, every other European country is open for enquiries', 'Map description (alt text)', 'textarea' ), 'width' => 720, 'height' => 540, 'loading' => 'lazy' ) ); ?>
    <div class="presence__legend" aria-hidden="true"><span class="pill pill--open"><?php bbq_text( 'presence_pill_open', 'Open for enquiries', 'Map legend: open markets' ); ?></span><span class="pill pill--active"><?php bbq_text( 'presence_pill_active', 'Active presence', 'Map legend: active markets' ); ?></span></div>
  </figure>
</section>

<!-- 5. Chicken University (Our team pattern) -->
<?php bbq_section( 'Chicken University' ); ?>
<section class="section team university" aria-labelledby="university-title">
  <?php $uni_img = bbq_get( 'uni_img', 'chicken-university.jpg', 'Photo', 'image' ); ?>
  <div class="team__img"><?php bbq_img( $uni_img, array( 'alt' => bbq_get( 'uni_img_alt', 'Chicken University, bb.q\'s training and R&D campus in Korea', 'Photo description (alt text)' ), 'width' => 1520, 'height' => 776, 'loading' => 'lazy' ) ); ?></div>
  <div class="team__text">
    <span class="eyebrow"><?php bbq_text( 'uni_eyebrow', 'Chicken University', 'Label' ); ?></span>
    <h2 class="h2" id="university-title"><?php bbq_text( 'uni_title', 'Where every bb.q cook learns the recipe', 'Heading' ); ?></h2>
    <p class="lead"><?php bbq_textarea( 'uni_lead', 'Since 1999, bb.q has trained owners, managers and kitchen teams at its own campus in Korea. It\'s also where the R&D team develops new flavours. European partners and their teams train on the same programme.', 'Text' ); ?></p>
  </div>
</section>

<!-- 6. Mascot (Mascot pattern) -->
<?php bbq_section( 'ChiBBoQ (mascot)' ); ?>
<section class="section mascot" id="chibboq" aria-labelledby="mascot-title">
  <?php $mascot_img = bbq_get( 'mascot_img', 'chibboq-sitting-cutout.png', 'Image', 'image' ); ?>
  <div class="mascot__img"><?php bbq_img( $mascot_img, array( 'alt' => bbq_get( 'mascot_img_alt', 'ChiBBoQ, the bb.q mascot, sitting', 'Image description (alt text)' ), 'width' => 582, 'height' => 991, 'loading' => 'lazy' ) ); ?></div>
  <div class="mascot__text">
    <span class="eyebrow eyebrow--dark"><?php bbq_text( 'mascot_eyebrow', 'For the whole family', 'Label' ); ?></span>
    <h2 class="h2" id="mascot-title"><?php bbq_text( 'mascot_title', 'ChiBBoQ and friends', 'Heading' ); ?></h2>
    <p><?php bbq_textarea( 'mascot_text', 'ChiBBoQ, Ollie and Chiky are the softest residents of Genesis Village. They live on our boxes and bags, pop up in restaurants now and then, and keep the youngest guests busy while the grown-ups finish the wings.', 'Text' ); ?></p>
    <?php $mascot_cta = bbq_link( 'mascot_cta', array( 'label' => 'Follow ChiBBoQ on Instagram', 'url' => '#', 'new_tab' => true ), 'Button (Instagram link)' ); ?>
    <?php if ( $mascot_cta['label'] ) : ?>
    <div class="btn-row"><a class="btn btn--outline-light"<?php bbq_link_attrs( $mascot_cta ); ?>><?php bbq_e( $mascot_cta['label'] ); ?> <span class="btn__chip"><?php bbq_icon( 'arrow' ); ?></span></a></div>
    <?php endif; ?>
  </div>
</section>

<!-- 7. Closing CTA (Closing CTA pattern) -->
<?php bbq_section( 'Closing call to action' ); ?>
<section class="section closing" aria-labelledby="closing-title">
  <div class="stamp"><?php bbq_stamp(); ?></div>
  <span class="sparkle-lg" aria-hidden="true"><?php bbq_icon( 'sparkleplain' ); ?></span>
  <span class="sparkle-sm" aria-hidden="true"><?php bbq_icon( 'sparkleplain' ); ?></span>
  <div class="cta-card">
    <h2 class="h2" id="closing-title"><?php bbq_text( 'closing_title', 'Want to bring bb.q to your city?', 'Heading' ); ?></h2>
    <p class="lead"><?php bbq_textarea( 'closing_lead', 'We\'re looking for experienced operators right across Europe. Tell us who you are and where you\'d like to grow.', 'Text' ); ?></p>
    <?php $closing_cta = bbq_link( 'closing_cta', array( 'label' => 'Submit your application', 'url' => 'page:apply' ), 'Button' ); ?>
    <?php if ( $closing_cta['label'] ) : ?>
    <a class="btn btn--red"<?php bbq_link_attrs( $closing_cta, ' data-hides-floating' ); ?>><?php bbq_e( $closing_cta['label'] ); ?> <span class="btn__chip"><?php bbq_icon( 'arrow' ); ?></span></a>
    <?php endif; ?>
  </div>
  <div class="cutout cutout--shadow-dark cutout--fried"><?php bbq_image( 'closing_img', 'cut-2pcs-fried.png', 'Chicken cut-out', array( 'alt' => '', 'width' => 880, 'height' => 463, 'loading' => 'lazy' ) ); ?></div>
</section>
