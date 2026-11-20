<?php
/**
 * Contact page. Reference conversion for the other templates (see CONVERTING.md).
 * Static source: html-backup/src/pages/contact.html
 */
defined( 'ABSPATH' ) || exit;

// Card icons (Figma: file-check, building, megaphone). Editors pick one per card.
$tile_icons = array(
	'file-check' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="m9 15 2 2 4-4"/></svg>',
	'building'   => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><rect width="16" height="20" x="4" y="2" rx="2" ry="2"/><path d="M9 22v-4h6v4"/><path d="M8 6h.01M16 6h.01M12 6h.01M12 10h.01M12 14h.01M16 10h.01M16 14h.01M8 10h.01M8 14h.01"/></svg>',
	'megaphone'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="m3 11 18-5v12L3 14v-3z"/><path d="M11.6 16.8a3 3 0 1 1-5.8-1.6"/></svg>',
);
?>

<!-- 1. Page header -->
<?php bbq_section( 'Page header' ); ?>
<section class="section page-hero page-hero--short" aria-labelledby="contact-title">
  <div class="page-hero__text">
    <span class="eyebrow eyebrow--glass"><?php bbq_text( 'hero_eyebrow', 'Contact', 'Label' ); ?></span>
    <h1 class="h-display" id="contact-title"><?php bbq_text( 'hero_title', 'Get in touch', 'Heading' ); ?></h1>
    <p class="lead"><?php bbq_textarea( 'hero_lead', 'Pick the topic that fits and your message goes straight to the right person.', 'Intro text' ); ?></p>
  </div>
</section>

<!-- 2. Shortcuts -->
<?php bbq_section( 'Shortcut cards' ); ?>
<section class="section shortcuts" aria-label="Contact shortcuts">
  <div class="tiles-slider" data-slider>
    <div class="tiles" data-slider-viewport>
      <?php
      $tiles = bbq_rows(
          'tiles',
          'Cards',
          array(
              'style' => array( 'select', 'Colour', array( 'yellow' => 'Yellow', 'red' => 'Red', 'sand' => 'Sand' ) ),
              'icon'  => array( 'select', 'Icon', array( 'file-check' => 'Form', 'building' => 'Building', 'megaphone' => 'Megaphone' ) ),
              'title' => array( 'text', 'Title' ),
              'text'  => array( 'textarea', 'Text' ),
              'link'  => array( 'link', 'Link (mailto:… shows an email address)' ),
          ),
          array(
              array( 'style' => 'yellow', 'icon' => 'file-check', 'title' => 'Franchise', 'text' => 'Want to open bb.q restaurants? Use the short application.', 'link' => array( 'label' => 'Submit your application →', 'url' => 'page:apply' ) ),
              array( 'style' => 'red', 'icon' => 'building', 'title' => 'Real estate', 'text' => 'Have a site that could suit bb.q?', 'link' => array( 'label' => 'Offer your premises →', 'url' => 'page:real-estate#offer' ) ),
              array( 'style' => 'sand', 'icon' => 'megaphone', 'title' => 'Press & Media', 'text' => 'Interview requests, images and press releases.', 'link' => array( 'label' => 'marketing@bltglobalbrands.com', 'url' => 'mailto:marketing@bltglobalbrands.com' ) ),
          )
      );
      foreach ( $tiles as $tile ) :
          $is_mail = 0 === strpos( (string) $tile['link']['url'], 'mailto:' );
          ?>
      <article class="tile tile--<?php echo esc_attr( $tile['style'] ); ?>">
        <span class="tile__icon" aria-hidden="true"><?php echo isset( $tile_icons[ $tile['icon'] ] ) ? $tile_icons[ $tile['icon'] ] : ''; // phpcs:ignore WordPress.Security.EscapeOutput -- fixed SVGs above ?></span>
        <h2 class="tile__title"><?php bbq_e( $tile['title'] ); ?></h2>
        <p class="tile__text"><?php bbq_e( $tile['text'] ); ?></p>
        <?php if ( $tile['link']['label'] ) : ?>
        <a class="tile__link<?php echo $is_mail ? ' tile__link--email' : ''; ?>"<?php bbq_link_attrs( $tile['link'] ); ?>><?php
            // Long email addresses may break after the @.
            echo $is_mail ? str_replace( '@', '@<wbr>', esc_html( $tile['link']['label'] ) ) : esc_html( $tile['link']['label'] ); // phpcs:ignore WordPress.Security.EscapeOutput
        ?></a>
        <?php endif; ?>
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

<!-- 3. Contact form -->
<?php bbq_section( 'Contact form' ); ?>
<section class="section form-section" id="message" aria-labelledby="message-title">
  <div class="form-card">
    <div class="form-card__intro">
      <span class="eyebrow"><?php bbq_text( 'form_eyebrow', 'Other questions', 'Label' ); ?></span>
      <h2 class="h2" id="message-title"><?php bbq_text( 'form_title', 'Send us a message', 'Heading' ); ?></h2>
      <address class="lead contact-address"><?php bbq_html( 'form_address', 'BLT Global Brands<br>Calle Fernando el Santo, 25, 4º D<br>28010 Madrid, Spain<br>[Email address]', 'Address' ); ?></address>
      <div class="info-box">
        <p class="info-box__title"><?php bbq_text( 'info_title', 'Good to know', 'Info box: title' ); ?></p>
        <?php foreach ( bbq_rows( 'info_steps', 'Info box: lines', array( 'text' => array( 'text', 'Text' ) ), array( array( 'text' => 'We reply within 5 working days.' ) ) ) as $step ) : ?>
        <p class="info-box__step"><?php bbq_e( $step['text'] ); ?></p>
        <?php endforeach; ?>
      </div>
    </div>

    <?php bbq_form( 'contact' ); ?>
  </div>
</section>
