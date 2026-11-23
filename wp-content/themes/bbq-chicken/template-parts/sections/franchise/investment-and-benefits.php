<?php
/**
 * Section "Investment and benefits" (franchise page) · ACF layout: franchise_investment_and_benefits
 */
defined( 'ABSPATH' ) || exit;
include __DIR__ . '/_shared.php';
?>
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
