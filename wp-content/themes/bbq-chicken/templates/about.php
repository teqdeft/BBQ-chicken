<?php
/**
 * About BLT Global Brands page.
 * Static source: html-backup/src/pages/about.html
 * Helpers: inc/parts/about.php (the hero photo's phone <source>).
 *
 * The values bento grid has a fixed layout (every tile has its own grid position, colour and icon
 * in about.css), so its tiles are individual fields rather than rows. The leadership team is a row list.
 */
defined( 'ABSPATH' ) || exit;

// Value tile icons (Lucide: utensils, users, message-circle-check).
$value_icons = array(
	'utensils' => '<svg viewBox="0 0 24 24"><path d="M3 2v7c0 1.1.9 2 2 2h4a2 2 0 0 0 2-2V2"/><path d="M7 2v20"/><path d="M21 15V2a5 5 0 0 0-5 5v6c0 1.1.9 2 2 2h3Zm0 0v7"/></svg>',
	'users'    => '<svg viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
	'check'    => '<svg viewBox="0 0 24 24"><path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"/><path d="m9 12 2 2 4-4"/></svg>',
);

// The grid tiles in page order (= swipe order on phones). Desktop position in the label.
$value_tiles = array(
	array( 'key' => 'act', 'kind' => 'icon', 'class' => 'value--yellow value--act', 'icon' => 'utensils', 'label' => 'Tile 1 · yellow (desktop: middle row, left)', 'title' => 'Act as brand ambassadors', 'text' => 'We champion the quality, heritage, and values of every brand we represent.' ),
	array( 'key' => 'customers', 'kind' => 'icon', 'class' => 'value--red value--customers', 'icon' => 'users', 'label' => 'Tile 2 · red (desktop: top right)', 'title' => 'Customers first', 'text' => 'We prioritise guest satisfaction and franchisee success in everything we do.' ),
	array( 'key' => 'ethics', 'kind' => 'icon', 'class' => 'value--sand value--ethics', 'icon' => 'check', 'label' => 'Tile 3 · sand (desktop: middle row, second)', 'title' => 'High ethical standards', 'text' => 'We conduct business with absolute transparency, honesty, and integrity.' ),
	array( 'key' => 'respect', 'kind' => 'photo', 'class' => 'value--photo value--respect', 'img' => 'team.jpg', 'w' => 1600, 'h' => 968, 'label' => 'Tile 4 · wide photo (desktop: top left)', 'title' => 'Respect one another and value our employees', 'text' => 'We foster an inclusive, supportive workplace where every team member is valued.' ),
	array( 'key' => 'learning', 'kind' => 'photo', 'class' => 'value--photo value--learning', 'img' => 'chicken-university.jpg', 'w' => 1520, 'h' => 776, 'label' => 'Tile 5 · wide photo (desktop: bottom row)', 'title' => 'Foster continuous learning', 'text' => 'We embrace innovation, training, and ongoing professional development.' ),
	array( 'key' => 'give', 'kind' => 'icon', 'class' => 'value--dark value--give', 'icon' => 'users', 'label' => 'Tile 6 · dark, red on phones (desktop: middle row, right)', 'title' => 'Give back to our communities', 'text' => 'We actively enrich and support the neighbourhoods and local communities we serve.' ),
	array( 'key' => 'possible', 'kind' => 'icon', 'class' => 'value--sand value--possible', 'icon' => 'check', 'label' => 'Tile 7 · sand (desktop: bottom left)', 'title' => 'Believe in the power of possible', 'text' => 'We approach expansion and challenges with an ambitious, forward-thinking mindset.' ),
);
?>

<!-- 1. Hero: BLT Global Brands (Our team pattern) -->
<?php bbq_section( 'Page header' ); ?>
<section class="section team about-hero" aria-labelledby="about-title">
  <?php
  $hero_img   = bbq_get( 'hero_img', 'team.jpg', 'Team photo', 'image' );
  $hero_img_m = bbq_get( 'hero_img_mobile', 'european-team.jpg', 'Team photo on phones', 'image' );
  $hero_alt   = bbq_get( 'hero_img_alt', 'The BLT Global Brands team in Europe', 'Photo description (alt text)' );
  ?>
  <div class="team__img">
    <picture>
      <?php bbq_about_source( $hero_img_m, '(max-width: 767px)', 768, 526 ); ?>
      <?php bbq_img( $hero_img, array( 'alt' => $hero_alt, 'width' => 1600, 'height' => 968 ) ); ?>
    </picture>
  </div>
  <div class="team__text">
    <span class="eyebrow"><?php bbq_text( 'hero_eyebrow', 'BLT Global Brands', 'Label' ); ?></span>
    <h1 class="h2" id="about-title"><?php bbq_text( 'hero_title', 'Global excellence, local expertise', 'Heading' ); ?></h1>
    <div class="lead about-hero__body">
      <?php
      $hero_body = bbq_rows(
          'hero_body',
          'Text paragraphs',
          array( 'text' => array( 'textarea', 'Paragraph' ) ),
          array(
              array( 'text' => 'BLT Global Brands acts as a strategic master partner and operating force across European markets. We bridge the gap between world-class brand heritage and neighbourhood-level execution through agile infrastructure, robust supply chain logistics, and dedicated local marketing support.' ),
              array( 'text' => 'Our core commitment is to bring the most beloved brands to neighbourhoods worldwide while maintaining high ethical standards and improving the quality of life for our communities, customers, and employees.' ),
          )
      );
      foreach ( $hero_body as $para ) :
          ?>
      <p><?php bbq_e( $para['text'] ); ?></p>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- 2. Mission (desktop: red glow with two bucket cut-outs; mobile: photo header) -->
<?php bbq_section( 'Mission' ); ?>
<section class="hero mission" aria-labelledby="mission-title">
  <div class="mission__art" aria-hidden="true">
    <?php bbq_image( 'mission_cut_left', 'cut-8pcs-secret-sauce-bucket.png', 'Left cut-out (desktop)', array( 'class' => 'mission__cut mission__cut--left', 'alt' => '', 'width' => 760, 'height' => 962, 'loading' => 'lazy' ) ); ?>
    <?php bbq_image( 'mission_cut_right', 'cut-8pcs-fried-bucket.png', 'Right cut-out (desktop)', array( 'class' => 'mission__cut mission__cut--right', 'alt' => '', 'width' => 660, 'height' => 838, 'loading' => 'lazy' ) ); ?>
  </div>
  <?php bbq_image( 'mission_bg_mobile', 'hero-mobile.jpg', 'Background photo (phones)', array( 'class' => 'hero__mobile-bg', 'alt' => '', 'width' => 800, 'height' => 1000, 'loading' => 'lazy' ) ); ?>
  <div class="hero__content">
    <h2 class="h-display hero__title" id="mission-title"><?php bbq_text( 'mission_title', 'Great Korean fried chicken, on every high street in Europe.', 'Heading' ); ?></h2>
    <p class="hero__lead"><?php bbq_textarea( 'mission_lead', 'We want bb.q to be the chicken Europeans pick on a Friday night, for a family dinner or a quick lunch. We\'ll get there with strong local partners, restaurants that run well and food people come back for.', 'Text' ); ?></p>
  </div>
  <div class="stamp"><?php bbq_stamp(); ?></div>
</section>

<!-- 3. Values (bento grid on desktop, swipe row on mobile) -->
<?php bbq_section( 'Values' ); ?>
<section class="section values" aria-labelledby="values-title">
  <div class="section-head">
    <span class="eyebrow"><?php bbq_text( 'values_eyebrow', 'BLT Global Brands', 'Label' ); ?></span>
    <h2 class="h2" id="values-title"><?php bbq_text( 'values_title', 'Our core values', 'Heading' ); ?></h2>
    <p class="values__lead"><?php bbq_textarea( 'values_lead', 'At BLT Global Brands, our culture and daily operations are driven by a steadfast commitment to excellence, integrity, and people.', 'Intro text' ); ?></p>
  </div>
  <?php
  bbq_section( 'Values: grid tiles' );
  $chibboq_img = bbq_get( 'val_chibboq_img', 'chibboq-glasses.png', 'ChiBBoQ tile (desktop: tall tile, top row; phones: above the swipe row): image', 'image' );
  ?>
  <div class="value-tile value-tile--chibboq value-tile--mobile" aria-hidden="true"><?php bbq_img( $chibboq_img, array( 'alt' => '', 'width' => 714, 'height' => 906, 'loading' => 'lazy' ) ); ?></div>
  <div class="row-slider" data-slider>
    <div class="value-grid" data-slider-viewport>
      <?php
      foreach ( $value_tiles as $tile ) :
          $k = 'val_' . $tile['key'];
          ?>
      <article class="value <?php echo esc_attr( $tile['class'] ); ?>">
        <?php if ( 'photo' === $tile['kind'] ) : ?>
        <?php bbq_image( $k . '_img', $tile['img'], $tile['label'] . ': photo', array( 'class' => 'value__photo', 'alt' => '', 'width' => $tile['w'], 'height' => $tile['h'], 'loading' => 'lazy' ) ); ?>
        <?php else : ?>
        <span class="value__icon" aria-hidden="true"><?php echo $value_icons[ $tile['icon'] ]; // phpcs:ignore WordPress.Security.EscapeOutput -- fixed SVGs above ?></span>
        <?php endif; ?>
        <h3 class="value__title"><?php bbq_text( $k . '_title', $tile['title'], $tile['label'] . ': title' ); ?></h3>
        <p class="value__text"><?php bbq_textarea( $k . '_text', $tile['text'], $tile['label'] . ': text' ); ?></p>
      </article>
      <?php endforeach; ?>
      <div class="value-tile value-tile--chibboq value-tile--desktop" aria-hidden="true"><?php bbq_img( $chibboq_img, array( 'alt' => '', 'width' => 714, 'height' => 906, 'loading' => 'lazy' ) ); ?></div>
      <div class="value-tile value-tile--product value-tile--desktop" aria-hidden="true"><?php bbq_image( 'val_product_img', 'cut-8pcs-fried-bucket.png', 'Product tile (desktop only: bottom right): image', array( 'alt' => '', 'width' => 660, 'height' => 838, 'loading' => 'lazy' ) ); ?></div>
    </div>
    <div class="row-nav">
      <button class="row-nav__arrow" type="button" aria-label="Previous" data-slider-prev><?php bbq_icon( 'left' ); ?></button>
      <div class="row-nav__dots" data-slider-dots></div>
      <button class="row-nav__arrow" type="button" aria-label="Next" data-slider-next><?php bbq_icon( 'right' ); ?></button>
    </div>
  </div>
</section>

<!-- 4. Leadership (4 per row, wraps as the team grows) -->
<?php bbq_section( 'Leadership team' ); ?>
<section class="section leaders" id="team" aria-labelledby="leaders-title">
  <div class="section-head leaders__head">
    <span class="eyebrow"><?php bbq_text( 'leaders_eyebrow', 'Leadership', 'Label' ); ?></span>
    <h2 class="h2" id="leaders-title"><?php bbq_text( 'leaders_title', 'One team, one community', 'Heading' ); ?></h2>
  </div>
  <div class="row-slider" data-slider>
    <div class="leaders__list" data-slider-viewport>
      <?php
      $people = bbq_rows(
          'leaders',
          'People',
          array(
              'img'  => array( 'image', 'Portrait photo' ),
              'name' => array( 'text', 'Name' ),
              'role' => array( 'text', 'Role' ),
              'alt'  => array( 'text', 'Photo description (alt text)' ),
          ),
          array(
              array( 'img' => 'team-thomas-talarico.jpg', 'name' => 'Thomas C. Talarico', 'role' => 'CEO and Partner', 'alt' => 'Portrait of Thomas C. Talarico' ),
              array( 'img' => 'team-maria-de-los-reyes-barrenengoa.jpg', 'name' => 'María de los Reyes Barrenengoa', 'role' => 'Marketing', 'alt' => 'Portrait of María de los Reyes Barrenengoa' ),
              array( 'img' => 'team-daniela-haack.jpg', 'name' => 'Daniela Haack', 'role' => 'Marketing', 'alt' => 'Portrait of Daniela Haack' ),
              array( 'img' => 'team-patricia-rader.jpg', 'name' => 'Patricia Rader', 'role' => 'Human Resources', 'alt' => 'Portrait of Patricia Rader' ),
              array( 'img' => 'team-julian-de-miguel.jpg', 'name' => 'Julián de Miguel', 'role' => 'IT', 'alt' => 'Portrait of Julián de Miguel' ),
              array( 'img' => 'team-julieta-cruz.jpg', 'name' => 'Julieta Cruz', 'role' => 'Staff Accountant', 'alt' => 'Portrait of Julieta Cruz' ),
              array( 'img' => 'team-emma-heckel.jpg', 'name' => 'Emma Heckel', 'role' => 'Procurement', 'alt' => 'Portrait of Emma Heckel' ),
          )
      );
      foreach ( $people as $person ) :
          ?>
      <article class="person">
        <div class="person__photo"><?php bbq_img( $person['img'], array( 'alt' => $person['alt'], 'width' => 720, 'height' => 900, 'loading' => 'lazy' ) ); ?></div>
        <div class="person__meta"><p class="person__role"><?php bbq_e( $person['role'] ); ?></p><h3 class="person__name"><?php bbq_e( $person['name'] ); ?></h3></div>
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

<!-- 5. Relationship (Our team pattern) -->
<?php bbq_section( 'Genesis BBQ' ); ?>
<section class="section team relation" aria-labelledby="relation-title">
  <div class="team__text">
    <span class="eyebrow"><?php bbq_text( 'relation_eyebrow', 'Part of the bb.q family', 'Label' ); ?></span>
    <h2 class="h2" id="relation-title"><?php bbq_text( 'relation_title', 'Backed by Genesis BBQ in Seoul', 'Heading' ); ?></h2>
    <p class="lead"><?php bbq_textarea( 'relation_lead', 'bb.q Chicken is part of Genesis BBQ Group, Korea\'s largest foodservice franchise company. BLT Global Brands develops the brand in Europe as its franchisor.', 'Text' ); ?></p>
    <?php $relation_cta = bbq_link( 'relation_cta', array( 'label' => 'Discover bb.q', 'url' => 'page:discover' ), 'Button' ); ?>
    <?php if ( $relation_cta['label'] ) : ?>
    <div class="btn-row"><a class="btn btn--outline-dark"<?php bbq_link_attrs( $relation_cta ); ?>><?php bbq_e( $relation_cta['label'] ); ?> <span class="btn__chip"><?php bbq_icon( 'arrow' ); ?></span></a></div>
    <?php endif; ?>
  </div>
  <?php $relation_img = bbq_get( 'relation_img', 'genesis-bbq-hq.jpg', 'Photo', 'image' ); ?>
  <div class="team__img"><?php bbq_img( $relation_img, array( 'alt' => bbq_get( 'relation_img_alt', 'The Genesis BBQ headquarters in Seoul', 'Photo description (alt text)' ), 'width' => 1520, 'height' => 1140, 'loading' => 'lazy' ) ); ?></div>
</section>

<!-- 6. Closing CTA (Closing CTA pattern) -->
<?php bbq_section( 'Closing call to action' ); ?>
<section class="section closing" aria-labelledby="closing-title">
  <div class="stamp"><?php bbq_stamp(); ?></div>
  <span class="sparkle-lg" aria-hidden="true"><?php bbq_icon( 'sparkleplain' ); ?></span>
  <span class="sparkle-sm" aria-hidden="true"><?php bbq_icon( 'sparkleplain' ); ?></span>
  <div class="cta-card">
    <h2 class="h2" id="closing-title"><?php bbq_text( 'closing_title', 'Let\'s build bb.q in your market', 'Heading' ); ?></h2>
    <p class="lead"><?php bbq_textarea( 'closing_lead', 'We\'re looking for partners right across Europe.', 'Text' ); ?></p>
    <?php
    $closing_cta1 = bbq_link( 'closing_cta1', array( 'label' => 'Submit your application', 'url' => 'page:apply' ), 'Primary button' );
    $closing_cta2 = bbq_link( 'closing_cta2', array( 'label' => 'Contact us', 'url' => 'page:contact' ), 'Secondary button' );
    ?>
    <?php if ( $closing_cta1['label'] || $closing_cta2['label'] ) : ?>
    <div class="btn-row">
      <?php if ( $closing_cta1['label'] ) : ?>
      <a class="btn btn--red"<?php bbq_link_attrs( $closing_cta1, ' data-hides-floating' ); ?>><?php bbq_e( $closing_cta1['label'] ); ?> <span class="btn__chip"><?php bbq_icon( 'arrow' ); ?></span></a>
      <?php endif; ?>
      <?php if ( $closing_cta2['label'] ) : ?>
      <a class="btn btn--outline-dark"<?php bbq_link_attrs( $closing_cta2 ); ?>><?php bbq_e( $closing_cta2['label'] ); ?> <span class="btn__chip"><?php bbq_icon( 'arrow' ); ?></span></a>
      <?php endif; ?>
    </div>
    <?php endif; ?>
  </div>
  <div class="cutout cutout--shadow-dark cutout--fried"><?php bbq_image( 'closing_img', 'cut-2pcs-fried.png', 'Chicken cut-out', array( 'alt' => '', 'width' => 880, 'height' => 463, 'loading' => 'lazy' ) ); ?></div>
</section>
