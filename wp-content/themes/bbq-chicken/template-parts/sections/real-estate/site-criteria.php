<?php
/**
 * Section "Site criteria" (real-estate page) · ACF layout: real_estate_site_criteria
 */
defined( 'ABSPATH' ) || exit;
include __DIR__ . '/_shared.php';
?>
<!-- 2. What we look for (site criteria) -->
<?php bbq_section( 'Site criteria' ); ?>
<section class="section criteria" aria-labelledby="criteria-title">
  <div class="criteria__head">
    <span class="eyebrow eyebrow--glass"><?php bbq_text( 'criteria_eyebrow', 'Site criteria', 'Label' ); ?></span>
    <h2 class="h2" id="criteria-title"><?php bbq_text( 'criteria_title', 'What we look for', 'Heading' ); ?></h2>
    <p class="lead"><?php bbq_textarea( 'criteria_lead', 'A starting point. Every site gets a proper look from our team.', 'Intro text' ); ?></p>
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
            array( 'icon' => 'bolt', 'title' => 'Technical', 'text' => 'Extraction possible, sufficient power supply and delivery access.' ),
            array( 'icon' => 'document', 'title' => 'Terms', 'text' => 'Leasehold preferred.' ),
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
