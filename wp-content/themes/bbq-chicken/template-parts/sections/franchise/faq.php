<?php
/**
 * Section "FAQ" (franchise page) · ACF layout: franchise_faq
 */
defined( 'ABSPATH' ) || exit;
include __DIR__ . '/_shared.php';
?>
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
