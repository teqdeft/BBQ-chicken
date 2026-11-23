<?php
/**
 * Section "bb.q in Europe (map)" (discover page) · ACF layout: discover_bb_q_in_europe
 */
defined( 'ABSPATH' ) || exit;
include __DIR__ . '/_shared.php';
?>
<!-- 4. Global presence (Our team pattern) -->
<?php bbq_section( 'bb.q in Europe (map)' ); ?>
<section class="section team presence" aria-labelledby="presence-title">
  <div class="team__text">
    <span class="eyebrow"><?php bbq_text( 'presence_eyebrow', 'bb.q in Europe', 'Label' ); ?></span>
    <h2 class="h2" id="presence-title"><?php bbq_text( 'presence_title', 'Where you\'ll find bb.q in Europe', 'Heading' ); ?></h2>
    <p class="lead"><?php bbq_textarea( 'presence_lead', 'bb.q runs restaurants in 57 countries worldwide. In Europe we\'re already in Spain and the UK, and every other market is open for enquiries.', 'Intro text' ); ?></p>
    <?php $presence_cta = bbq_link( 'presence_cta', array( 'label' => 'See the European markets', 'url' => 'page:home#markets' ), 'Button' ); ?>
    <?php if ( $presence_cta['label'] ) : ?>
    <div class="btn-row"><a class="btn btn--outline-dark"<?php bbq_link_attrs( $presence_cta ); ?>><?php bbq_e( $presence_cta['label'] ); ?> <span class="btn__chip"><?php bbq_icon( 'arrow' ); ?></span></a></div>
    <?php endif; ?>
  </div>
  <figure class="presence__map">
    <?php $map_img = bbq_get( 'presence_img', 'svg/europe-map.svg', 'Map image', 'image' ); ?>
    <?php bbq_img( $map_img, array( 'alt' => bbq_get( 'presence_img_alt', 'Map of Europe: Spain and the United Kingdom have an active presence, every other European country is open for enquiries', 'Map description (alt text)', 'textarea' ), 'width' => 720, 'height' => 540, 'loading' => 'lazy' ) ); ?>
    <div class="presence__legend" aria-hidden="true"><span class="pill pill--open"><?php bbq_text( 'presence_pill_open', 'Open for enquiries', 'Map legend: open markets' ); ?></span><span class="pill pill--active"><?php bbq_text( 'presence_pill_active', 'Active presence', 'Map legend: active markets' ); ?></span></div>
  </figure>
</section>
