<?php
/**
 * Careers page.
 * Static source: html-backup/src/pages/careers.html
 * The form is inc/forms/careers.php (Contact Form 7); the vacancy links point at its section (#open-application).
 */
defined( 'ABSPATH' ) || exit;

// Card icons (Figma: sprout, graduation cap, trending up). Editors pick one per card.
$tile_icons = array(
	'sprout'     => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M7 20h10"/><path d="M10 20c5.5-2.5.8-6.4 3-10"/><path d="M9.5 9.4c1.1.8 1.8 2.2 2.3 3.7-2 .4-3.5.4-4.8-.3-1.2-.6-2.3-1.9-3-4.2 2.8-.5 4.4 0 5.5.8z"/><path d="M14.1 6a7 7 0 0 0-1.1 4c1.9-.1 3.3-.6 4.3-1.4 1-1 1.6-2.3 1.7-4.6-2.7.1-4 1-4.9 2z"/></svg>',
	'graduation' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>',
	'trend'      => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/></svg>',
);
// Pixel sizes of the design's default photos (media-library images bring their own).
$tile_sizes = array(
	'team.jpg'               => array( 1600, 968 ),
	'chicken-university.jpg' => array( 1520, 776 ),
	'news-barcelona.jpg'     => array( 960, 541 ),
);
?>

<!-- 1. Page header -->
<?php bbq_section( 'Page header' ); ?>
<section class="section page-hero page-hero--short" aria-labelledby="careers-title">
  <div class="page-hero__text">
    <span class="eyebrow eyebrow--glass"><?php bbq_text( 'hero_eyebrow', 'Careers', 'Label' ); ?></span>
    <h1 class="h-display" id="careers-title"><?php bbq_html( 'hero_title', 'Grow with bb.q<br> in Europe', 'Heading' ); ?></h1>
    <p class="lead"><?php bbq_textarea( 'hero_lead', "We're building bb.q across Europe from the ground up. That means new restaurants, new markets and plenty of room to grow, for cooks, managers and the people behind the scenes.", 'Intro text' ); ?></p>
  </div>
</section>

<!-- 2. Why work with us (mobile: swipe row with arrows and dots) -->
<?php bbq_section( 'Why people join us' ); ?>
<section class="section join" aria-labelledby="join-title">
  <div class="section-head">
    <span class="eyebrow"><?php bbq_text( 'join_eyebrow', 'Why bb.q', 'Label' ); ?></span>
    <h2 class="h2" id="join-title"><?php bbq_text( 'join_title', 'Why people join us', 'Heading' ); ?></h2>
  </div>
  <div class="tiles-slider" data-slider>
    <div class="tiles" data-slider-viewport>
      <?php
      $tiles = bbq_rows(
          'tiles',
          'Photo cards (swipe row on phones)',
          array(
              'style' => array( 'select', 'Colour', array( 'yellow' => 'Yellow', 'red' => 'Red', 'sand' => 'Sand' ) ),
              'img'   => array( 'image', 'Photo' ),
              'alt'   => array( 'text', 'Photo description (alt text)' ),
              'icon'  => array( 'select', 'Icon', array( 'sprout' => 'Sprout', 'graduation' => 'Graduation cap', 'trend' => 'Growth arrow' ) ),
              'title' => array( 'text', 'Title' ),
              'text'  => array( 'textarea', 'Text' ),
          ),
          array(
              array( 'style' => 'yellow', 'img' => 'team.jpg', 'alt' => 'The bb.q team in Europe', 'icon' => 'sprout', 'title' => 'Early days', 'text' => 'Join a brand at the start of its European story and help shape it.' ),
              array( 'style' => 'red', 'img' => 'chicken-university.jpg', 'alt' => "bb.q's Chicken University training centre", 'icon' => 'graduation', 'title' => 'Real training', 'text' => 'Learn the bb.q way, from the fryer to running your own restaurant.' ),
              array( 'style' => 'sand', 'img' => 'news-barcelona.jpg', 'alt' => 'A bb.q restaurant in Europe', 'icon' => 'trend', 'title' => 'Room to move', 'text' => 'New restaurants and markets open up new roles all the time.' ),
          )
      );
      foreach ( $tiles as $tile ) :
          $size = is_string( $tile['img'] ) && isset( $tile_sizes[ $tile['img'] ] ) ? $tile_sizes[ $tile['img'] ] : array( null, null );
          ?>
      <article class="tile tile--<?php echo esc_attr( $tile['style'] ? $tile['style'] : 'yellow' ); ?>">
        <?php if ( $tile['img'] ) : ?>
        <div class="tile__img"><?php bbq_img( $tile['img'], array( 'alt' => $tile['alt'], 'width' => $size[0], 'height' => $size[1], 'loading' => 'lazy' ) ); ?></div>
        <?php endif; ?>
        <div class="tile__body">
          <span class="tile__icon" aria-hidden="true"><?php echo isset( $tile_icons[ $tile['icon'] ] ) ? $tile_icons[ $tile['icon'] ] : ''; // phpcs:ignore WordPress.Security.EscapeOutput -- fixed SVGs above ?></span>
          <h3 class="tile__title"><?php bbq_e( $tile['title'] ); ?></h3>
          <p class="tile__text"><?php bbq_e( $tile['text'] ); ?></p>
        </div>
      </article>
      <?php endforeach; ?>
    </div>
    <div class="slider__nav tiles-nav">
      <button class="slider__arrow" type="button" aria-label="Previous" data-slider-prev><?php bbq_icon( 'left' ); ?></button>
      <div class="slider__dots" data-slider-dots></div>
      <button class="slider__arrow" type="button" aria-label="Next" data-slider-next><?php bbq_icon( 'right' ); ?></button>
    </div>
  </div>
  <?php bbq_image( 'peek_img', 'chibboq-glasses.png', 'ChiBBoQ image', array( 'class' => 'chibboq-peek', 'alt' => '', 'width' => 714, 'height' => 906, 'loading' => 'lazy' ) ); ?>
</section>

<!-- 3. Open positions -->
<?php bbq_section( 'Open positions' ); ?>
<section class="section vacancies" aria-labelledby="vacancies-title">
  <div class="section-head">
    <span class="eyebrow"><?php bbq_text( 'vac_eyebrow', 'Open positions', 'Label' ); ?></span>
    <h2 class="h2" id="vacancies-title"><?php bbq_text( 'vac_title', 'Current vacancies', 'Heading' ); ?></h2>
  </div>
  <?php
  $vacancies = bbq_rows(
      'vacancies',
      'Vacancies (none: the "no open positions" message below is shown)',
      array(
          'title' => array( 'text', 'Role' ),
          'lang'  => array( 'text', 'Language of the role name, if not English (e.g. es)' ),
          'meta'  => array( 'text', 'Location and contract (city first)' ),
          'link'  => array( 'link', 'Link (job page, or #open-application for the form below)' ),
      ),
      array(
          array( 'title' => 'Kitchen Staff', 'lang' => '', 'meta' => 'London, United Kingdom · [Contract type TBC]', 'link' => array( 'label' => 'View role →', 'url' => '#open-application' ) ),
          array( 'title' => 'Responsables de Cocina', 'lang' => 'es', 'meta' => 'Madrid, Spain · [Contract type TBC]', 'link' => array( 'label' => 'View role →', 'url' => '#open-application' ) ),
      )
  );
  if ( $vacancies ) :
      ?>
  <ul class="vacancy-list">
      <?php
      foreach ( $vacancies as $job ) :
          // Screen readers hear "View role: Kitchen Staff, London" (link text + role + city).
          $city  = trim( (string) preg_replace( '/\s*[,·].*$/u', '', (string) $job['meta'] ) );
          $aria  = trim( str_replace( '→', '', (string) $job['link']['label'] ) ) . ': ' . $job['title'] . ( '' !== $city ? ', ' . $city : '' );
          $lang  = sanitize_key( (string) $job['lang'] );
          ?>
    <li class="vacancy">
      <div class="vacancy__role">
        <h3 class="vacancy__title"<?php echo $lang ? ' lang="' . esc_attr( $lang ) . '"' : ''; // phpcs:ignore WordPress.Security.EscapeOutput ?>><?php bbq_e( $job['title'] ); ?></h3>
        <?php if ( $job['meta'] ) : ?>
        <p class="vacancy__meta"><?php bbq_e( $job['meta'] ); ?></p>
        <?php endif; ?>
      </div>
          <?php if ( $job['link']['label'] ) : ?>
      <a class="vacancy__link"<?php bbq_link_attrs( $job['link'], ' aria-label="' . esc_attr( $aria ) . '"' ); ?>><?php bbq_e( $job['link']['label'] ); ?></a>
          <?php endif; ?>
    </li>
      <?php endforeach; ?>
  </ul>
  <?php endif; ?>
  <!-- Empty state: shown instead of the list when there are no vacancies -->
  <div class="empty-state"<?php echo $vacancies ? ' hidden' : ''; ?>>
    <h3 class="empty-state__title"><?php bbq_text( 'empty_title', 'No open positions right now', 'No vacancies: heading' ); ?></h3>
    <p class="empty-state__text"><?php bbq_textarea( 'empty_text', "New roles open as we grow. Send us an open application and we'll keep you in mind for your country.", 'No vacancies: text' ); ?></p>
  </div>
</section>

<!-- 4. Open application (form) -->
<?php bbq_section( 'Open application form' ); ?>
<section class="section form-section" id="open-application" aria-labelledby="application-title">
  <div class="form-card">
    <div class="form-card__intro">
      <span class="eyebrow"><?php bbq_text( 'form_eyebrow', 'Open application', 'Label' ); ?></span>
      <h2 class="h2" id="application-title"><?php bbq_text( 'form_title', "Tell us what you'd like to do", 'Heading' ); ?></h2>
      <p class="lead"><?php bbq_textarea( 'form_lead', 'Kitchen, restaurant management, operations or head office. A short note and your CV are enough.', 'Intro text' ); ?></p>
    </div>

    <?php bbq_form( 'careers' ); ?>
  </div>
</section>
