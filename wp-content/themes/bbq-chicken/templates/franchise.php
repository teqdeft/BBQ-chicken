<?php
/**
 * Franchise page.
 * Static source: html-backup/src/pages/franchise.html
 * Helpers: inc/parts/franchise.php. Form: inc/forms/application.php (also on the Apply page and in the pop-up).
 */
defined( 'ABSPATH' ) || exit;

// Line icons of the page's sprite (below). Editors pick one per criterion, benefit and step.
$icon_choices = array(
	'store'     => 'Shop',
	'buildings' => 'Buildings',
	'coin'      => 'Coin',
	'coins'     => 'Coins',
	'pin'       => 'Map pin',
	'cog'       => 'Cog',
	'cap'       => 'Graduation cap',
	'truck'     => 'Truck',
	'megaphone' => 'Megaphone',
	'file'      => 'Document',
	'clipboard' => 'Clipboard',
	'rocket'    => 'Rocket',
);
$marquee_fields = array(
	'text'   => array( 'html', 'Text' ),
	'strong' => array( 'toggle', 'Bold' ),
);
?>
<!-- Icon sprite (line icons used on this page) -->
<svg class="icon-sprite" aria-hidden="true" focusable="false">
  <symbol id="i-store" viewBox="0 0 24 24"><path d="M4.5 11v9.5h15V11"/><path d="M2.5 9.5 4.5 4h15l2 5.5a2.75 2.75 0 0 1-5 1.6 3 3 0 0 1-4.5 0 3 3 0 0 1-4.5 0 2.75 2.75 0 0 1-5-1.6Z"/><path d="M9.75 20.5v-5h4.5v5"/></symbol>
  <symbol id="i-buildings" viewBox="0 0 24 24"><path d="M2.5 21h19"/><path d="M4.5 21V6.5L12 3v18"/><path d="M12 9.5l7.5 2.5V21"/><path d="M7.5 8.5h1.5M7.5 12h1.5M7.5 15.5h1.5M15 14.5h1.5M15 18h1.5"/></symbol>
  <symbol id="i-coin" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9.5"/><path d="M15.6 8.7a4.6 4.6 0 1 0 0 6.6"/><path d="M7.4 10.9h5.6M7.4 13.4h4.8"/></symbol>
  <symbol id="i-pin" viewBox="0 0 24 24"><path d="M12 21.5s-7-6.3-7-12a7 7 0 0 1 14 0c0 5.7-7 12-7 12Z"/><circle cx="12" cy="9.5" r="2.6"/></symbol>
  <symbol id="i-cog" viewBox="0 0 24 24"><path d="M18.93 9.39 21.76 9.82v4.36l-2.83.43-.19.44 1.7 2.31-3.08 3.08-2.31-1.7-.44.19-.43 2.83H9.82l-.43-2.83-.44-.19-2.31 1.7-3.08-3.08 1.7-2.31-.19-.44-2.83-.43V9.82l2.83-.43.19-.44-1.7-2.31 3.08-3.08 2.31 1.7.44-.19.43-2.83h4.36l.43 2.83.44.19 2.31-1.7 3.08 3.08-1.7 2.31Z"/><circle cx="12" cy="12" r="3.2"/></symbol>
  <symbol id="i-cap" viewBox="0 0 24 24"><path d="M1.5 9.5 12 4.5l10.5 5L12 14.5Z"/><path d="M5.5 11.5v4.8c0 1.6 2.9 3.2 6.5 3.2s6.5-1.6 6.5-3.2v-4.8"/><path d="M22.5 9.5v5.5"/></symbol>
  <symbol id="i-truck" viewBox="0 0 24 24"><path d="M14 16.5V5H2v11.5h2.5"/><path d="M14 8.5h4l4 4.5v3.5h-2"/><path d="M8.5 16.5H15"/><circle cx="6.5" cy="17" r="2"/><circle cx="18" cy="17" r="2"/></symbol>
  <symbol id="i-megaphone" viewBox="0 0 24 24"><path d="M3 9.5h3.5L16 4.5v15l-9.5-5H3Z"/><path d="M6.5 14.5 8 20h3l-1.2-4.6"/><path d="M19 9a4.2 4.2 0 0 1 0 6"/></symbol>
  <symbol id="i-coins" viewBox="0 0 24 24"><ellipse cx="12" cy="6" rx="8" ry="3"/><path d="M4 6v12c0 1.7 3.6 3 8 3s8-1.3 8-3V6"/><path d="M4 12c0 1.7 3.6 3 8 3s8-1.3 8-3"/></symbol>
  <symbol id="i-file" viewBox="0 0 24 24"><path d="M14 2.5H6.5a1.5 1.5 0 0 0-1.5 1.5v16a1.5 1.5 0 0 0 1.5 1.5h11a1.5 1.5 0 0 0 1.5-1.5V7.5Z"/><path d="M14 2.5v5h5"/><path d="M8.5 12.5h7M8.5 16h5"/></symbol>
  <symbol id="i-clipboard" viewBox="0 0 24 24"><rect x="8" y="2.5" width="8" height="4" rx="1"/><path d="M16 4.5h2a2 2 0 0 1 2 2v13a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-13a2 2 0 0 1 2-2h2"/><path d="m8.75 14 2.25 2.25 4.25-4.5"/></symbol>
  <symbol id="i-rocket" viewBox="0 0 24 24"><path d="M5 15.5c-1.5 1.3-2 5-2 5s3.7-.5 5-2c.7-.8.7-2.1-.1-2.9a2.1 2.1 0 0 0-2.9-.1Z"/><path d="m12 15-3-3a22 22 0 0 1 2-4A12.9 12.9 0 0 1 22 2c0 2.7-.8 7.5-6 11a22.4 22.4 0 0 1-4 2Z"/><path d="M9 12H4s.6-3 2-4c1.6-1.1 5 0 5 0"/><path d="M12 15v5s3-.6 4-2c1.1-1.6 0-5 0-5"/></symbol>
</svg>

<!-- 1. Hero -->
<?php bbq_section( 'Hero' ); ?>
<section class="section page-hero franchise-hero" aria-labelledby="franchise-title">
  <div class="page-hero__text">
    <span class="eyebrow eyebrow--glass"><?php bbq_text( 'hero_eyebrow', 'Franchise', 'Label' ); ?></span>
    <h1 class="h-display" id="franchise-title"><?php bbq_text( 'hero_title', 'Bring bb.q Chicken to your market.', 'Heading' ); ?></h1>
    <p class="lead"><?php bbq_textarea( 'hero_lead', 'Ready to join the bb.q Chicken franchise network in Europe? We\'re looking for experienced operators to open bb.q restaurants across the continent.', 'Intro text' ); ?></p>
    <?php $hero_cta = bbq_link( 'hero_cta', array( 'label' => 'Submit your application', 'url' => 'page:apply' ), 'Button' ); ?>
    <?php if ( $hero_cta['label'] ) : ?>
    <div class="btn-row">
      <a class="btn btn--cream"<?php bbq_link_attrs( $hero_cta ); ?>><?php bbq_e( $hero_cta['label'] ); ?> <span class="btn__chip"><?php bbq_icon( 'arrow' ); ?></span></a>
    </div>
    <?php endif; ?>
  </div>
  <div class="page-hero__media"><?php bbq_image( 'hero_img', 'cut-bucket-spill.png', 'Image', array( 'alt' => '', 'width' => 840, 'height' => 599, 'fetchpriority' => 'high' ) ); ?></div>
  <div class="stamp"><?php bbq_stamp(); ?></div>
</section>

<!-- 2. Marquee: open for partners -->
<?php bbq_section( 'Moving band: open for partners' ); ?>
<div class="marquee marquee--dark" aria-hidden="true">
  <div class="marquee__track" data-marquee>
<?php
foreach ( bbq_rows(
	'marquee1',
	'Words',
	$marquee_fields,
	array(
		array( 'text' => 'Open for partners', 'strong' => 1 ),
		array( 'text' => 'Europe', 'strong' => 0 ),
	)
) as $item ) :
	?>
    <span class="marquee__item<?php echo $item['strong'] ? ' marquee__item--strong' : ''; ?>"><?php bbq_k( $item['text'] ); ?></span><?php bbq_icon( 'sparkle' ); ?>

<?php endforeach; ?>
  </div>
</div>

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

<!-- 4. Opportunity -->
<?php bbq_section( 'The opportunity' ); ?>
<section class="section opportunity" aria-labelledby="opportunity-title">
  <div class="opportunity__box">
    <span class="opportunity__icon" aria-hidden="true">↗</span>
    <div class="opportunity__text">
      <span class="eyebrow"><?php bbq_text( 'opp_eyebrow', 'The opportunity', 'Label' ); ?></span>
      <h2 class="opportunity__title" id="opportunity-title"><?php bbq_text( 'opp_title', 'Korean fried chicken is one of Europe\'s fastest-growing food categories.', 'Heading' ); ?></h2>
    </div>
    <p class="opportunity__figure"><strong><?php bbq_text( 'opp_figure', '+24.5%', 'Key figure' ); ?></strong> <span><?php bbq_text( 'opp_figure_label', 'Annual K-food growth in Europe', 'Key figure: caption' ); ?></span></p>
  </div>
</section>

<!-- 5. Formats -->
<?php bbq_section( 'Formats' ); ?>
<section class="section formats" aria-labelledby="formats-title">
  <div class="section-head formats__head">
    <span class="eyebrow"><?php bbq_text( 'formats_eyebrow', 'The formats', 'Label' ); ?></span>
    <h2 class="h2" id="formats-title"><?php bbq_text( 'formats_title', 'Compact, fast and built for delivery', 'Heading' ); ?></h2>
  </div>
  <p class="formats__sub"><?php bbq_text( 'formats_sub', 'One bb.q QSR design, in the format that fits your site.', 'Subheading' ); ?></p>

  <div class="fslider" data-slider>
    <ul class="format-blocks" data-slider-viewport>
      <?php
      $formats = bbq_rows(
          'formats',
          'Formats',
          array(
              'style' => array( 'select', 'Colour', array( 'dark' => 'Dark', 'red' => 'Red', 'yellow' => 'Yellow' ) ),
              'img'   => array( 'image', 'Image' ),
              'title' => array( 'text', 'Title' ),
              'text'  => array( 'textarea', 'Text' ),
          ),
          array(
              array( 'style' => 'dark', 'img' => 'format-flagship.jpg', 'title' => 'Flagship', 'text' => 'A full-size bb.q restaurant for prime locations. 300 to 500 m².' ),
              array( 'style' => 'red', 'img' => 'format-traditional.jpg', 'title' => 'Traditional restaurant', 'text' => 'The classic quick-service restaurant, for dine-in and takeaway. 120 to 200 m².' ),
              array( 'style' => 'yellow', 'img' => 'format-shop-in-shop.jpg', 'title' => 'Shop-in-shop', 'text' => 'A bb.q counter inside an existing venue. 60 to 120 m².' ),
          )
      );
      foreach ( $formats as $item ) :
          ?>
      <li class="format-block format-block--<?php echo esc_attr( $item['style'] ? $item['style'] : 'dark' ); ?>">
        <div class="format-block__img<?php echo bbq_franchise_is_cutout( $item['img'] ) ? '' : ' format-block__img--photo'; ?>"><?php bbq_img( $item['img'], array( 'alt' => '' ) + bbq_franchise_img_size( $item['img'] ) + array( 'loading' => 'lazy' ) ); ?></div>
        <h3 class="format-block__title"><?php bbq_e( $item['title'] ); ?></h3>
        <p class="format-block__text"><?php bbq_e( $item['text'] ); ?></p>
      </li>
      <?php endforeach; ?>
    </ul>
    <div class="slider__nav fslider__nav">
      <button class="slider__arrow" type="button" aria-label="Previous format" data-slider-prev><?php bbq_icon( 'left' ); ?></button>
      <div class="slider__dots" data-slider-dots></div>
      <button class="slider__arrow" type="button" aria-label="Next format" data-slider-next><?php bbq_icon( 'right' ); ?></button>
    </div>
  </div>
</section>

<!-- 6. Franchise criteria -->
<?php bbq_section( 'Who we\'re looking for' ); ?>
<section class="section criteria" aria-labelledby="criteria-title">
  <div class="section-head criteria__head">
    <span class="eyebrow"><?php bbq_text( 'criteria_eyebrow', 'Criteria', 'Label' ); ?></span>
    <h2 class="h2" id="criteria-title"><?php bbq_text( 'criteria_title', 'Who we\'re looking for', 'Heading' ); ?></h2>
  </div>

  <div class="fslider" data-slider>
    <ul class="criteria__list" data-slider-viewport>
      <?php
      $criteria = bbq_rows(
          'criteria',
          'Criteria',
          array(
              'style' => array( 'select', 'Colour', array( 'yellow' => 'Yellow', 'red' => 'Red', 'sand' => 'Sand', 'dark' => 'Dark' ) ),
              'icon'  => array( 'select', 'Icon', $icon_choices ),
              'title' => array( 'text', 'Title' ),
              'text'  => array( 'textarea', 'Text' ),
          ),
          array(
              array( 'style' => 'yellow', 'icon' => 'store', 'title' => 'Experience in QSR or retail', 'text' => 'You run food service or retail units today.' ),
              array( 'style' => 'red', 'icon' => 'buildings', 'title' => 'Multi-unit capacity', 'text' => 'You can open and run several restaurants in a region.' ),
              array( 'style' => 'sand', 'icon' => 'coin', 'title' => 'Financial backing', 'text' => 'You can fund a multi-unit development plan.' ),
              array( 'style' => 'dark', 'icon' => 'pin', 'title' => 'Local market knowledge', 'text' => 'You know the landlords, suppliers and people in your market.' ),
          )
      );
      foreach ( $criteria as $item ) :
          ?>
      <li class="criterion criterion--<?php echo esc_attr( $item['style'] ? $item['style'] : 'yellow' ); ?>">
        <span class="criterion__icon" aria-hidden="true"><svg viewBox="0 0 24 24"><use href="#i-<?php echo esc_attr( $item['icon'] ? $item['icon'] : 'store' ); ?>"/></svg></span>
        <h3 class="criterion__title"><?php bbq_e( $item['title'] ); ?></h3>
        <p class="criterion__text"><?php bbq_e( $item['text'] ); ?></p>
      </li>
      <?php endforeach; ?>
    </ul>
    <div class="slider__nav fslider__nav">
      <button class="slider__arrow" type="button" aria-label="Previous criterion" data-slider-prev><?php bbq_icon( 'left' ); ?></button>
      <div class="slider__dots" data-slider-dots></div>
      <button class="slider__arrow" type="button" aria-label="Next criterion" data-slider-next><?php bbq_icon( 'right' ); ?></button>
    </div>
  </div>

  <div class="mid-cta">
    <div class="mid-cta__box">
      <p class="mid-cta__text"><?php bbq_text( 'midcta_text', 'Ready to join our franchise network?', 'Call to action: text' ); ?></p>
      <?php $mid_cta = bbq_link( 'midcta_btn', array( 'label' => 'Submit your application', 'url' => 'page:apply' ), 'Call to action: button' ); ?>
      <a class="btn btn--cream"<?php bbq_link_attrs( $mid_cta ); ?>><?php bbq_e( $mid_cta['label'] ); ?> <span class="btn__chip"><?php bbq_icon( 'arrow' ); ?></span></a>
    </div>
    <?php bbq_image( 'midcta_img', 'chibboq-glasses.png', 'Call to action: ChiBBoQ image', array( 'class' => 'mid-cta__chibboq', 'alt' => '', 'width' => 714, 'height' => 906, 'loading' => 'lazy' ) ); ?>
  </div>
</section>

<!-- 7. Marquee: benefits -->
<?php bbq_section( 'Moving band: benefits' ); ?>
<div class="marquee marquee--yellow marquee--ltr" aria-hidden="true">
  <div class="marquee__track" data-marquee>
<?php
foreach ( bbq_rows(
	'marquee2',
	'Words',
	$marquee_fields,
	array(
		array( 'text' => 'What you get as a bb.q partner', 'strong' => 1 ),
		array( 'text' => 'Operational support', 'strong' => 0 ),
		array( 'text' => 'Training<span class="only-desktop"> at Chicken University</span>', 'strong' => 0 ),
		array( 'text' => 'Supply chain', 'strong' => 0 ),
		array( 'text' => 'Launch marketing', 'strong' => 0 ),
	)
) as $item ) :
	?>
    <span class="marquee__item<?php echo $item['strong'] ? ' marquee__item--strong' : ''; ?>"><?php bbq_k( $item['text'] ); ?></span><?php bbq_icon( 'sparkle' ); ?>

<?php endforeach; ?>
  </div>
</div>

<!-- 8. Investment and benefits -->
<?php bbq_section( 'Investment and benefits' ); ?>
<section class="section benefits" aria-labelledby="benefits-title">
  <div class="benefits__head">
    <span class="eyebrow eyebrow--glass"><?php bbq_text( 'benefits_eyebrow', 'Investment and benefits', 'Label' ); ?></span>
    <h2 class="h2" id="benefits-title"><?php bbq_text( 'benefits_title', 'What you get as a bb.q partner', 'Heading' ); ?></h2>
    <p class="lead"><?php bbq_textarea( 'benefits_lead', 'Thirty years of know-how behind every restaurant.', 'Intro text' ); ?></p>
    <div class="benefits__cutout" aria-hidden="true"><?php bbq_image( 'benefits_img', 'cut-2pcs-secret-sauce.png', 'Cut-out image', array( 'alt' => '', 'width' => 760, 'height' => 412, 'loading' => 'lazy' ) ); ?></div>
  </div>

  <div class="benefits__body">
    <div class="acc acc--dark">
      <?php
      $benefits = bbq_rows(
          'benefits',
          'Benefits (the first one starts open)',
          array(
              'icon'   => array( 'select', 'Icon', $icon_choices ),
              'bubble' => array( 'select', 'Icon colour', array( '#E31937' => 'Red', '#E73F39' => 'Red-orange', '#EB663A' => 'Orange', '#EE8D3B' => 'Light orange', '#F2B33D' => 'Yellow' ) ),
              'title'  => array( 'text', 'Title' ),
              'text'   => array( 'textarea', 'Text' ),
          ),
          array(
              array( 'icon' => 'cog', 'bubble' => '#E31937', 'title' => 'Operational support', 'text' => 'Complete site opening assistance, detailed operational manuals, quality audits (QCS), and dedicated ongoing guidance from our European operations team, from your very first location to your tenth and beyond.' ),
              array( 'icon' => 'cap', 'bubble' => '#E73F39', 'title' => 'Training at Chicken University', 'text' => 'Access to the world\'s only corporate educational facility dedicated exclusively to F&B franchise training, backed by over 30 Ph.D. and Master\'s-certified R&D researchers to train your managers and staff in authentic recipes and operational excellence.' ),
              array( 'icon' => 'truck', 'bubble' => '#EB663A', 'title' => 'Supply chain', 'text' => 'End-to-end supply chain logistics with guaranteed access to our proprietary marinades, sauces, and ingredients, including our strategic global partnership with Coca-Cola (CCEP) for seamless beverage supply.' ),
              array( 'icon' => 'megaphone', 'bubble' => '#EE8D3B', 'title' => 'Launch marketing', 'text' => 'Comprehensive grand-opening campaign toolkits, localised PR, high-impact social media strategies, and direct aggregator integrations (Uber Eats, Deliveroo, Glovo, Just Eat) driven by our European marketing coordination team.' ),
              array( 'icon' => 'coins', 'bubble' => '#F2B33D', 'title' => 'Flexible Formats', 'text' => 'Flexible formats (including QSR traditional and flagship locations as well as shop-in-shop formats) designed for high ROI, low initial CAPEX, transparent fee structures, and scalable multi-unit development opportunities.' ),
          )
      );
      foreach ( $benefits as $i => $item ) :
          $bubble = preg_match( '/^#[0-9A-Fa-f]{6}$/', (string) $item['bubble'] ) ? $item['bubble'] : '#E31937';
          ?>
      <details class="acc__item" name="benefits"<?php echo 0 === $i ? ' open' : ''; ?>>
        <summary class="acc__head">
          <span class="acc__icon" style="--bubble:<?php echo esc_attr( $bubble ); ?>;--ink:#FFFFFF" aria-hidden="true"><svg viewBox="0 0 24 24"><use href="#i-<?php echo esc_attr( $item['icon'] ? $item['icon'] : 'cog' ); ?>"/></svg></span>
          <span class="acc__title"><?php bbq_e( $item['title'] ); ?></span>
          <span class="acc__toggle" aria-hidden="true"></span>
        </summary>
        <p class="acc__text"><?php bbq_e( $item['text'] ); ?></p>
      </details>
      <?php endforeach; ?>
    </div>
    <p class="benefits__note"><?php bbq_text( 'benefits_note', 'Investment ranges, fees and terms are shared in the first conversation.', 'Note below the list' ); ?></p>
  </div>
</section>

<!-- 9. Process -->
<?php bbq_section( 'The road to franchising' ); ?>
<section class="section process" aria-labelledby="process-title">
  <div class="section-head process__head">
    <span class="eyebrow"><?php bbq_text( 'process_eyebrow', 'The road to franchising', 'Label' ); ?></span>
    <h2 class="h2" id="process-title"><?php bbq_text( 'process_title', 'Five steps to becoming a bb.q franchisee', 'Heading' ); ?></h2>
  </div>

  <ol class="steps">
    <?php
    $steps = bbq_rows(
        'steps',
        'Steps (the first icon is yellow)',
        array(
            'icon'  => array( 'select', 'Icon', $icon_choices ),
            'title' => array( 'text', 'Title' ),
            'text'  => array( 'textarea', 'Text' ),
        ),
        array(
            array( 'icon' => 'file', 'title' => 'Submit your application', 'text' => 'Tell us about your background, business experience and the territory or city you\'re targeting in Europe.' ),
            array( 'icon' => 'clipboard', 'title' => 'Evaluation', 'text' => 'We review your profile, financial capacity and operational readiness, then schedule an introductory meeting.' ),
            array( 'icon' => 'pin', 'title' => 'Territory selection', 'text' => 'With our real estate and operations experts we find and approve the right site.' ),
            array( 'icon' => 'cap', 'title' => 'Agreement and training', 'text' => 'We sign the franchise agreement and you and your team start our full training programme.' ),
            array( 'icon' => 'rocket', 'title' => 'Launch and support', 'text' => 'Opening marketing, supply chain set-up with our official CCEP partnership, and ongoing support from day one.' ),
        )
    );
    foreach ( $steps as $i => $item ) :
        ?>
    <li class="step">
      <div class="step__rail">
        <span class="step__icon<?php echo 0 === $i ? ' step__icon--first' : ''; ?>" aria-hidden="true"><svg viewBox="0 0 24 24"><use href="#i-<?php echo esc_attr( $item['icon'] ? $item['icon'] : 'file' ); ?>"/></svg></span>
      </div>
      <div class="step__body">
        <h3 class="step__title"><?php bbq_e( $item['title'] ); ?></h3>
        <p class="step__text"><?php bbq_e( $item['text'] ); ?></p>
      </div>
    </li>
    <?php endforeach; ?>
  </ol>

  <?php $process_cta = bbq_link( 'process_cta', array( 'label' => 'Submit your application', 'url' => 'page:apply' ), 'Button' ); ?>
  <?php if ( $process_cta['label'] ) : ?>
  <div class="process__cta">
    <a class="btn btn--cream"<?php bbq_link_attrs( $process_cta ); ?>><?php bbq_e( $process_cta['label'] ); ?> <span class="btn__chip"><?php bbq_icon( 'arrow' ); ?></span></a>
  </div>
  <?php endif; ?>
</section>

<!-- 10. FAQ -->
<?php bbq_section( 'FAQ' ); ?>
<section class="section faq" id="faq" aria-labelledby="faq-title">
  <div class="faq__head">
    <span class="eyebrow"><?php bbq_text( 'faq_eyebrow', 'FAQ', 'Label' ); ?></span>
    <h2 class="h2" id="faq-title"><?php bbq_text( 'faq_title', 'Frequently Asked Questions', 'Heading' ); ?></h2>
    <p class="lead"><?php bbq_textarea( 'faq_lead', 'Didn\'t find your answer? Add your question to your application, or get in touch.', 'Intro text' ); ?></p>
    <?php $faq_cta = bbq_link( 'faq_cta', array( 'label' => 'Submit your application', 'url' => 'page:apply' ), 'Button' ); ?>
    <?php if ( $faq_cta['label'] ) : ?>
    <div class="faq__cta">
      <a class="btn btn--red"<?php bbq_link_attrs( $faq_cta ); ?>><?php bbq_e( $faq_cta['label'] ); ?> <span class="btn__chip"><?php bbq_icon( 'arrow' ); ?></span></a>
    </div>
    <?php endif; ?>
  </div>

  <div class="faq__body">
    <div class="acc acc--light">
      <?php
      $faq = bbq_rows(
          'faq',
          'Questions (the first one starts open; also published as FAQ structured data for search engines)',
          array(
              'q' => array( 'text', 'Question' ),
              'a' => array( 'textarea', 'Answer' ),
          ),
          array(
              array( 'q' => 'How much does it cost to open a bb.q restaurant?', 'a' => 'Investment depends on the market and site format. Flagship, traditional restaurant or shop-in-shop. We walk you through investment ranges, fees, and terms during our initial conversation.' ),
              array( 'q' => 'Do I need restaurant experience?', 'a' => 'While previous experience in the hospitality or food service industry is a strong advantage, it is not strictly mandatory. We provide comprehensive operational training, recipes, and ongoing guidance to ensure your success as a franchisee.' ),
              array( 'q' => 'Do you only work with multi-unit operators?', 'a' => 'No, we work with both single-unit and multi-unit operators. We look for passionate partners who share our commitment to quality and growth, regardless of whether you are opening your first location or expanding an existing portfolio.' ),
              array( 'q' => 'Which markets are open?', 'a' => 'We are actively expanding across Europe and globally. Currently, our operations are live in Spain and the UK, with broad opportunities open for enquiries and new franchise developments in all European territories.' ),
              array( 'q' => 'Do I get an exclusive territory?', 'a' => 'Yes, franchise partners are granted a defined exclusive territory to ensure you can build your local customer base and market presence without internal competition.' ),
              array( 'q' => 'What support do I get at launch?', 'a' => 'From day one, you receive end-to-end support including site evaluation guidance, operational and culinary training (at Chicken University), supply chain setup, marketing strategies, and launch campaign coordination.' ),
              array( 'q' => 'How does delivery work?', 'a' => 'We partner with major delivery aggregators such as Uber Eats, Just Eat, and Glovo (depending on the market). Our restaurants are fully integrated with these platforms to maximise reach and streamline order management.' ),
              array( 'q' => 'What happens after I submit my application?', 'a' => 'Our expansion team reviews your application within 5 working days. If your profile aligns with our goals, we will reach out to schedule an initial introductory call to discuss territories, investment models, and next steps.' ),
              array( 'q' => 'Is this website a franchise offer?', 'a' => 'This website serves as an informational platform for prospective partners interested in franchise opportunities with bb.q Chicken. It does not constitute a formal franchise offering, which will be provided upon review and approval of your application.' ),
          )
      );
      foreach ( $faq as $i => $item ) :
          ?>
      <details class="acc__item" name="faq"<?php echo 0 === $i ? ' open' : ''; ?>>
        <summary class="acc__head"><span class="acc__title"><?php bbq_e( $item['q'] ); ?></span><span class="acc__toggle" aria-hidden="true"></span></summary>
        <p class="acc__text"><?php bbq_e( $item['a'] ); ?></p>
      </details>
      <?php endforeach; ?>
    </div>
    <?php $faq_note = bbq_get( 'faq_note', 'Maximum nine questions. All franchise questions stay on this page (SEO).', 'Note below the questions (desktop only)' ); ?>
    <?php if ( '' !== trim( $faq_note ) ) : ?>
    <p class="faq__note only-desktop"><?php bbq_e( $faq_note ); ?></p>
    <?php endif; ?>
  </div>

  <?php
  // FAQ structured data, built from the questions above.
  $faq_ld = array();
  foreach ( $faq as $item ) {
      $q = trim( wp_strip_all_tags( (string) $item['q'] ) );
      $a = trim( wp_strip_all_tags( (string) $item['a'] ) );
      if ( '' !== $q && '' !== $a ) {
          $faq_ld[] = array(
              '@type'          => 'Question',
              'name'           => $q,
              'acceptedAnswer' => array(
                  '@type' => 'Answer',
                  'text'  => $a,
              ),
          );
      }
  }
  if ( $faq_ld ) :
      ?>
  <script type="application/ld+json"><?php echo wp_json_encode( array( '@context' => 'https://schema.org', '@type' => 'FAQPage', 'mainEntity' => $faq_ld ), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP ); ?></script>
  <?php endif; ?>
</section>

<!-- 11. Submit your application (form) — the same form is on the Apply page and in the pop-up (assets/js/apply.js) -->
<?php bbq_section( 'Application form' ); ?>
<section class="section form-section app-section" id="apply" aria-labelledby="apply-title" data-hides-floating>
  <div class="form-card form-card--app">
    <div class="form-card__intro">
      <span class="eyebrow"><?php bbq_text( 'apply_eyebrow', 'Apply', 'Label' ); ?></span>
      <h2 class="h2" id="apply-title"><?php bbq_text( 'apply_title', 'Submit your application', 'Heading' ); ?></h2>
      <p class="lead"><?php bbq_html( 'apply_lead', 'Ready to join the bb.q Chicken franchise network? Tell us who you are and where you\'d like to grow. Our expansion team reads every application<span class="only-desktop"> personally</span>.', 'Intro text', array( 'help' => 'Text inside <span class="only-desktop">…</span> is hidden on phones.' ) ); ?></p>
      <div class="info-box">
        <p class="info-box__title"><?php bbq_text( 'apply_info_title', 'What happens next', 'Info box: title' ); ?></p>
        <?php
        $apply_steps = bbq_rows(
            'apply_info_steps',
            'Info box: steps',
            array( 'text' => array( 'text', 'Text' ) ),
            array(
                array( 'text' => 'We reply within 5 working days.' ),
                array( 'text' => 'We schedule an introductory meeting.' ),
                array( 'text' => 'Together we look at your territory and the right site.' ),
            )
        );
        foreach ( $apply_steps as $item ) :
            ?>
        <p class="info-box__step"><?php bbq_e( $item['text'] ); ?></p>
        <?php endforeach; ?>
      </div>
    </div>

    <?php bbq_franchise_application_form(); ?>
  </div>
</section>
