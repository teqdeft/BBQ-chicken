<?php
/**
 * Section "Intro" (home page) · ACF layout: home_intro
 */
defined( 'ABSPATH' ) || exit;
include __DIR__ . '/_shared.php';
?>
<!-- 1. BLT Global Brands intro -->
<?php
bbq_section( 'Intro' );
$peek = bbq_get( 'intro_peek', 'chibboq-peeking.png', 'ChiBBoQ peeking in (image)', 'image' );
?>
<section class="section intro" aria-labelledby="intro-title">
  <div class="intro__text">
    <span class="eyebrow"><?php bbq_text( 'intro_eyebrow', 'BLT Global Brands', 'Label' ); ?></span>
    <h1 class="h-display" id="intro-title"><?php bbq_text( 'intro_title', 'Global excellence, local expertise.', 'Heading' ); ?></h1>
    <p class="lead"><?php bbq_textarea( 'intro_lead', 'BLT Global Brands is the strategic master partner driving bb.q Chicken\'s expansion across Europe. By combining three decades of international culinary heritage with local operational expertise, our mission is to bring the most beloved brands to neighbourhoods worldwide while maintaining high ethical standards and enriching our local communities.', 'Intro text' ); ?></p>
    <div class="btn-row">
      <?php $l = bbq_link( 'intro_btn1', array( 'label' => 'Franchise with us', 'url' => 'page:franchise' ), 'First button' ); ?>
      <a class="btn btn--red"<?php bbq_link_attrs( $l ); ?>><?php bbq_e( $l['label'] ); ?> <span class="btn__chip"><?php bbq_icon( 'arrow' ); ?></span></a>
      <?php $l = bbq_link( 'intro_btn2', array( 'label' => 'About BLT Global Brands', 'url' => 'page:about' ), 'Second button' ); ?>
      <a class="btn btn--outline-dark"<?php bbq_link_attrs( $l ); ?>><?php bbq_e( $l['label'] ); ?> <span class="btn__chip"><?php bbq_icon( 'arrow' ); ?></span></a>
    </div>
  </div>

  <?php bbq_section( 'Intro: our brands' ); ?>
  <div class="intro__brands">
    <span class="label-caps intro__brands-label"><?php bbq_text( 'brands_label', 'Our brands', 'Label above the cards' ); ?></span>
    <div class="carousel carousel--mobile" data-carousel>
      <div class="brand-cards" data-carousel-viewport>
        <?php
        $brands = bbq_rows(
            'brands',
            'Brand cards',
            array(
                'img'      => array( 'image', 'Food cut-out' ),
                'logo'     => array( 'image', 'Logo' ),
                'logo_alt' => array( 'text', 'Brand name (logo alt text)' ),
                'tag'      => array( 'text', 'Tagline' ),
                'link'     => array( 'link', 'Link' ),
            ),
            array(
                array( 'img' => 'cut-2pcs-secret-sauce.png', 'logo' => 'svg/logo-on-dark.svg', 'logo_alt' => 'bb.q Chicken', 'tag' => 'Korean fried chicken, since 1995', 'link' => array( 'label' => 'Discover bb.q →', 'url' => 'page:discover' ) ),
            )
        );
        foreach ( $brands as $brand ) :
            ?>
        <article class="brand-card">
          <div class="cutout"><?php bbq_img( $brand['img'], array( 'alt' => '', 'width' => 760, 'height' => 412 ) ); ?></div>
          <?php bbq_img( $brand['logo'], array( 'class' => 'brand-card__logo', 'alt' => $brand['logo_alt'], 'width' => 250, 'height' => 42 ) ); ?>
          <p class="brand-card__tag"><?php bbq_e( $brand['tag'] ); ?></p>
          <?php if ( $brand['link']['label'] ) : ?>
          <a class="brand-card__link"<?php bbq_link_attrs( $brand['link'] ); ?>><?php bbq_e( $brand['link']['label'] ); ?></a>
          <?php endif; ?>
        </article>
        <?php endforeach; ?>
        <?php
        // off since Figma v5 (one brand); the text field stays editable for when it is switched back on
        $soon_show = bbq_toggle( 'brands_soon_show', false, 'Show the "More brands coming soon" card' );
        $soon_text = bbq_get( 'brands_soon_text', 'More brands<br>coming soon', '"Coming soon" card text', 'html' );
        if ( $soon_show ) :
            ?>
        <div class="brand-card brand-card--soon">
          <span class="plus" aria-hidden="true">+</span>
          <strong><?php echo wp_kses_post( $soon_text ); ?></strong>
        </div>
        <?php endif; ?>
      </div>
      <div class="slider__nav" data-carousel-nav>
        <button class="slider__arrow" type="button" aria-label="Previous brand" data-carousel-prev><?php bbq_icon( 'left' ); ?></button>
        <div class="slider__dots" data-carousel-dots></div>
        <button class="slider__arrow" type="button" aria-label="Next brand" data-carousel-next><?php bbq_icon( 'right' ); ?></button>
      </div>
    </div>
    <?php $note = bbq_get( 'brands_note', '', 'Note under the cards (desktop only, empty = hidden)', 'textarea' ); ?>
    <?php if ( '' !== trim( (string) $note ) ) : ?>
    <p class="intro__note only-desktop"><?php bbq_e( $note ); ?></p>
    <?php endif; ?>
    <?php bbq_img( $peek, array( 'class' => 'peek', 'alt' => '', 'width' => 300, 'height' => 537 ) ); ?>
  </div>
</section>
