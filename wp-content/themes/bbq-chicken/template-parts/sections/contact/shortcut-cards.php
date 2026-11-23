<?php
/**
 * Section "Shortcut cards" (contact page) · ACF layout: contact_shortcut_cards
 */
defined( 'ABSPATH' ) || exit;
include __DIR__ . '/_shared.php';
?>
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
