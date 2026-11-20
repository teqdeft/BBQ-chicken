<?php
/**
 * Real estate page (premises offers from landlords, agents and developers).
 * Static source: html-backup/src/pages/real-estate.html
 * The form is inc/forms/real-estate.php (Contact Form 7); other pages link to its section as real-estate#offer.
 */
defined( 'ABSPATH' ) || exit;

// Criteria icons (Figma: ruler, map pin, eye, zap, file-text). Editors pick one per row.
$crit_icons = array(
	'ruler'    => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21.3 15.3a2.4 2.4 0 0 1 0 3.4l-2.6 2.6a2.4 2.4 0 0 1-3.4 0L2.7 8.7a2.41 2.41 0 0 1 0-3.4l2.6-2.6a2.41 2.41 0 0 1 3.4 0Z"/><path d="m14.5 12.5 2-2"/><path d="m11.5 9.5 2-2"/><path d="m8.5 6.5 2-2"/><path d="m17.5 15.5 2-2"/></svg>',
	'pin'      => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"/><circle cx="12" cy="10" r="3"/></svg>',
	'eye'      => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/><circle cx="12" cy="12" r="3"/></svg>',
	'bolt'     => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z"/></svg>',
	'document' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M10 9H8"/><path d="M16 13H8"/><path d="M16 17H8"/></svg>',
);
?>

<!-- 1. Hero: red glow with two food cut-outs on desktop (Figma v4); mobile keeps the photo hero -->
<?php bbq_section( 'Hero' ); ?>
<section class="hero re-hero" aria-labelledby="re-hero-title">
  <div class="re-hero__cutout re-hero__cutout--sauce" aria-hidden="true"><?php bbq_image( 'hero_cutout_left', 'cut-2pcs-secret-sauce.png', 'Cut-out, bottom left (desktop)', array( 'alt' => '', 'width' => 760, 'height' => 412 ) ); ?></div>
  <div class="re-hero__cutout re-hero__cutout--fried" aria-hidden="true"><?php bbq_image( 'hero_cutout_right', 'cut-2pcs-fried.png', 'Cut-out, bottom right (desktop)', array( 'alt' => '', 'width' => 880, 'height' => 463 ) ); ?></div>
  <?php bbq_image( 'hero_mobile_img', 'hero-mobile.jpg', 'Background photo (phones)', array( 'class' => 'hero__mobile-bg', 'alt' => '', 'width' => 800, 'height' => 1000, 'style' => 'display:none' ) ); ?>
  <div class="hero__content">
    <h1 class="h-display hero__title" id="re-hero-title"><?php bbq_text( 'hero_title', 'Got premises that suit bb.q?', 'Heading' ); ?></h1>
    <p class="hero__lead"><?php bbq_textarea( 'hero_lead', "We're looking for busy, visible locations for bb.q restaurants across Europe. Landlords, agents and developers: tell us about your premises, and we'll tell you quickly whether it fits.", 'Intro text' ); ?></p>
    <?php $hero_cta = bbq_link( 'hero_cta', array( 'label' => 'Offer your premises', 'url' => '#offer' ), 'Button' ); ?>
    <?php if ( $hero_cta['label'] ) : ?>
    <div class="btn-row">
      <a class="btn btn--cream"<?php bbq_link_attrs( $hero_cta ); ?>><?php bbq_e( $hero_cta['label'] ); ?> <span class="btn__chip"><?php bbq_icon( 'arrow' ); ?></span></a>
    </div>
    <?php endif; ?>
  </div>
  <div class="stamp"><?php bbq_stamp(); ?></div>
</section>

<!-- 2. What we look for (site criteria) -->
<?php bbq_section( 'Site criteria' ); ?>
<section class="section criteria" aria-labelledby="criteria-title">
  <div class="criteria__head">
    <span class="eyebrow eyebrow--glass"><?php bbq_text( 'criteria_eyebrow', 'Site criteria', 'Label' ); ?></span>
    <h2 class="h2" id="criteria-title"><?php bbq_text( 'criteria_title', 'What we look for', 'Heading' ); ?></h2>
    <p class="lead"><?php bbq_textarea( 'criteria_lead', "A starting point. Every site gets a proper look from our team. [Replace with BLT's own site checklist when available]", 'Intro text' ); ?></p>
    <div class="criteria__cutout" aria-hidden="true"><?php bbq_image( 'criteria_img', 'cut-2pcs-secret-sauce.png', 'Cut-out image (desktop)', array( 'alt' => '', 'width' => 760, 'height' => 412, 'loading' => 'lazy' ) ); ?></div>
  </div>

  <div class="criteria__list">
    <?php
    $criteria = bbq_rows(
        'criteria',
        'Criteria (the first one is open when the page loads)',
        array(
            'icon'  => array( 'select', 'Icon', array( 'ruler' => 'Ruler', 'pin' => 'Map pin', 'eye' => 'Eye', 'bolt' => 'Lightning', 'document' => 'Document' ) ),
            'title' => array( 'text', 'Title' ),
            'text'  => array( 'textarea', 'Text' ),
        ),
        array(
            array( 'icon' => 'ruler', 'title' => 'Size', 'text' => 'Flagship 300 to 500 m², traditional restaurant 120 to 200 m², shop-in-shop 60 to 120 m², Express kiosk 10 to 40 m².' ),
            array( 'icon' => 'pin', 'title' => 'Location', 'text' => 'High streets, transport hubs, shopping centres and retail parks in or near city centres.' ),
            array( 'icon' => 'eye', 'title' => 'Footfall and visibility', 'text' => 'Strong daytime and evening footfall, a visible frontage and room for signage.' ),
            array( 'icon' => 'bolt', 'title' => 'Technical', 'text' => 'Extraction possible, sufficient power supply [kW to be confirmed] and delivery access.' ),
            array( 'icon' => 'document', 'title' => 'Terms', 'text' => 'Leasehold preferred. [Lease length and terms to be confirmed]' ),
        )
    );
    foreach ( $criteria as $i => $crit ) :
        ?>
    <details class="crit" name="criteria"<?php echo 0 === $i ? ' open' : ''; ?>>
      <summary class="crit__row">
        <span class="crit__icon" aria-hidden="true"><?php echo isset( $crit_icons[ $crit['icon'] ] ) ? $crit_icons[ $crit['icon'] ] : ''; // phpcs:ignore WordPress.Security.EscapeOutput -- fixed SVGs above ?></span>
        <h3 class="crit__title"><?php bbq_e( $crit['title'] ); ?></h3>
        <span class="crit__toggle" aria-hidden="true"></span>
      </summary>
      <p class="crit__answer"><?php bbq_e( $crit['text'] ); ?></p>
    </details>
    <?php endforeach; ?>
  </div>
</section>

<!-- 3. Offer your premises (form) -->
<?php bbq_section( 'Offer form' ); ?>
<section class="section form-section" id="offer" aria-labelledby="offer-title">
  <div class="form-card">
    <div class="form-card__intro">
      <span class="eyebrow"><?php bbq_text( 'offer_eyebrow', 'Offer your premises', 'Label' ); ?></span>
      <h2 class="h2" id="offer-title"><?php bbq_text( 'offer_title', 'Tell us about your premises', 'Heading' ); ?></h2>
      <p class="lead"><?php bbq_textarea( 'offer_lead', 'The basics are enough to start. Plans and photos help us answer faster.', 'Intro text' ); ?></p>
      <div class="info-box">
        <p class="info-box__title"><?php bbq_text( 'info_title', 'What happens next', 'Info box: title' ); ?></p>
        <?php
        $steps = bbq_rows(
            'info_steps',
            'Info box: steps',
            array(
                'text' => array( 'text', 'Text' ),
                'link' => array( 'link', 'Link after the text (optional)' ),
            ),
            array(
                array( 'text' => 'We reply within 5 working days.' ),
                array( 'text' => 'Our real estate team takes a look at the site.' ),
                array( 'text' => 'Want to open a bb.q yourself?', 'link' => array( 'label' => 'Submit your application →', 'url' => 'page:apply' ) ),
            )
        );
        foreach ( $steps as $step ) :
            if ( $step['link']['label'] ) :
                // Text + link in one span, so the step's flex layout keeps them on one line.
                ?>
        <p class="info-box__step"><span><?php bbq_e( $step['text'] ); ?> <a<?php bbq_link_attrs( $step['link'] ); ?>><?php bbq_e( $step['link']['label'] ); ?></a></span></p>
            <?php else : ?>
        <p class="info-box__step"><?php bbq_e( $step['text'] ); ?></p>
            <?php
            endif;
        endforeach;
        ?>
      </div>
    </div>

    <?php bbq_form( 'real-estate' ); ?>
  </div>
</section>
