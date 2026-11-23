<?php
/**
 * Section "Sauces" (menu page) · ACF layout: menu_sauces
 */
defined( 'ABSPATH' ) || exit;
include __DIR__ . '/_shared.php';
?>
<!-- 3. Sauces -->
<?php bbq_section( 'Sauces' ); ?>
<section class="section sauces" aria-labelledby="sauces-title">
  <div class="section-head">
    <span class="eyebrow"><?php bbq_text( 'sauces_eyebrow', 'Sauces', 'Label' ); ?></span>
    <h2 class="h2" id="sauces-title"><?php bbq_text( 'sauces_title', 'Pick your sauce', 'Heading' ); ?></h2>
  </div>
  <div class="row-slider" data-slider>
    <div class="sauce-grid" data-slider-viewport>
      <?php
      $spice_sr = bbq_get( 'sauces_spice_sr', 'Spice level', 'Chilli rating: text read out by screen readers ("… 1 of 3" is added)' );
      // The sauces are Sauces posts (menu: Sauces): the picked ones in the picked order, else all in their order.
      $picked   = bbq_posts( 'sauces_pick', 'Sauces', 'menu_sauce', array( 'help' => 'Pick the sauces for this section and drag them into order. Empty = all sauces, in their Order. Sauces are added and edited under Sauces in the admin menu.' ) );
      $sauces   = bbq_cards( 'menu_sauce', $picked ); // inc/card-types.php
      foreach ( $sauces as $sauce ) :
          ?>
      <article class="sauce">
        <div class="sauce__img"><?php bbq_img( $sauce['img'], array( 'alt' => $sauce['alt'], 'width' => 900, 'height' => 422, 'loading' => 'lazy' ) ); ?></div>
        <h3 class="sauce__title"><?php bbq_e( $sauce['title'] ); ?></h3>
        <?php if ( '' !== trim( (string) $sauce['text'] ) ) : ?>
        <p class="sauce__text"><?php bbq_e( $sauce['text'] ); ?></p>
        <?php endif; ?>
        <?php echo bbq_menu_spice( $sauce['spice'], $sauce['note'], $spice_sr ); // phpcs:ignore WordPress.Security.EscapeOutput -- escaped in the helper ?>
      </article>
      <?php endforeach; ?>
    </div>
    <div class="row-nav">
      <button class="row-nav__arrow" type="button" aria-label="Previous" data-slider-prev><?php bbq_icon( 'left' ); ?></button>
      <div class="row-nav__dots" data-slider-dots></div>
      <button class="row-nav__arrow" type="button" aria-label="Next" data-slider-next><?php bbq_icon( 'right' ); ?></button>
    </div>
  </div>
  <div class="sauces__cta">
    <p class="sauces__cta-text"><?php bbq_text( 'sauces_cta_text', 'Brushed on straight after frying, so the crunch survives.', 'Text next to the button' ); ?></p>
    <?php $sauces_cta = bbq_link( 'sauces_cta', array( 'label' => 'Order now', 'url' => 'page:home#find' ), 'Button' ); ?>
    <?php if ( $sauces_cta['label'] ) : ?>
    <a class="btn btn--cream"<?php bbq_link_attrs( $sauces_cta ); ?>><?php bbq_e( $sauces_cta['label'] ); ?> <span class="btn__chip"><?php bbq_icon( 'arrow' ); ?></span></a>
    <?php endif; ?>
  </div>
  <?php bbq_image( 'sauces_peek', 'chibboq-glasses.png', 'ChiBBoQ image', array( 'class' => 'sauces__peek', 'alt' => '', 'width' => 714, 'height' => 906, 'loading' => 'lazy' ) ); ?>
</section>
