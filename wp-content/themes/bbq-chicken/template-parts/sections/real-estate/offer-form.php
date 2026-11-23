<?php
/**
 * Section "Offer form" (real-estate page) · ACF layout: real_estate_offer_form
 */
defined( 'ABSPATH' ) || exit;
include __DIR__ . '/_shared.php';
?>
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
