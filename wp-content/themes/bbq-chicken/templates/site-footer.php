<?php
/**
 * Site footer. Fields: Appearance → bb.q settings. Link columns: Appearance → Menus (Footer menu).
 */
defined( 'ABSPATH' ) || exit;

bbq_section( 'Footer: "Hungry?" bar' );
?>
<footer class="site-footer">
  <div class="site-footer__inner">
    <div class="order-bar">
      <div class="order-bar__text">
        <p class="order-bar__title"><?php bbq_text( 'order_bar_title', 'Hungry?', 'Title' ); ?></p>
        <p class="order-bar__sub"><?php bbq_text( 'order_bar_sub', 'Order bb.q from a kitchen near you, or find your nearest restaurant.', 'Text' ); ?></p>
      </div>
      <div class="btn-row">
        <?php $b1 = bbq_link( 'order_bar_btn1', array( 'label' => 'Order now', 'url' => 'page:home#find' ), 'First button' ); ?>
        <a class="btn btn--cream"<?php bbq_link_attrs( $b1 ); ?>><?php bbq_e( $b1['label'] ); ?> <span class="btn__chip"><?php bbq_icon( 'arrow' ); ?></span></a>
        <?php $b2 = bbq_link( 'order_bar_btn2', array( 'label' => 'Find a restaurant', 'url' => 'page:home#find' ), 'Second button' ); ?>
        <a class="btn btn--outline-light"<?php bbq_link_attrs( $b2 ); ?>><?php bbq_e( $b2['label'] ); ?> <span class="btn__chip"><?php bbq_icon( 'arrow' ); ?></span></a>
      </div>
    </div>

    <?php bbq_section( 'Footer: brand and social links' ); ?>
    <div class="footer-brand">
      <?php bbq_image( 'footer_logo', 'svg/logo-on-dark.svg', 'Logo', array( 'class' => 'footer-brand__logo', 'alt' => 'bb.q Chicken', 'width' => 342, 'height' => 57, 'loading' => 'lazy' ) ); ?>
      <p class="footer-brand__slogan"><?php bbq_html( 'footer_slogan', 'REAL CRISPY.<br class="only-mobile"> REAL KOREAN.', 'Slogan' ); ?></p>
      <p class="footer-brand__sub"><?php bbq_text( 'footer_sub', 'bb.q Chicken in Europe is developed by BLT Global Brands.', 'Line under the slogan' ); ?></p>
      <div class="socials">
        <a href="<?php echo esc_url( bbq_get( 'social_instagram', '#', 'Instagram link (https://…)' ) ); ?>" aria-label="Instagram"><?php bbq_icon( 'instagram' ); ?></a>
        <a href="<?php echo esc_url( bbq_get( 'social_facebook', '#', 'Facebook link (https://…)' ) ); ?>" aria-label="Facebook"><?php bbq_icon( 'facebook' ); ?></a>
        <a href="<?php echo esc_url( bbq_get( 'social_linkedin', '#', 'LinkedIn link (https://…)' ) ); ?>" aria-label="LinkedIn"><?php bbq_icon( 'linkedin' ); ?></a>
        <?php $tiktok = bbq_get( 'social_tiktok', 'https://www.tiktok.com/@bbqchicken.es', 'TikTok link (https://…, empty = hidden)' ); ?>
        <?php if ( '' !== trim( (string) $tiktok ) ) : ?>
        <a href="<?php echo esc_url( $tiktok ); ?>" aria-label="TikTok" target="_blank" rel="noopener"><?php bbq_icon( 'tiktok' ); ?></a>
        <?php endif; ?>
      </div>
    </div>

    <?php bbq_nav_footer(); ?>

    <?php bbq_section( 'Footer: bottom line' ); ?>
    <div class="footer-base">
      <div class="footer-base__row">
        <p><?php bbq_text( 'footer_copyright', '© 2026 BLT Global Brands. bb.q Chicken is a trademark of Genesis BBQ.', 'Copyright' ); ?></p>
        <p><?php bbq_html( 'footer_langs', '<a href="#">English</a> · <a href="#">Español</a>', 'Languages' ); ?></p>
      </div>
      <p class="footer-base__love"><?php echo str_replace( '{heart}', bbq_icon_svg( 'heart' ), wp_kses_post( bbq_get( 'footer_love', 'Made with love {heart} by Studio Ubique', 'Credit line ({heart} = the heart icon)', 'html' ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?></p>
    </div>
  </div>
</footer>
