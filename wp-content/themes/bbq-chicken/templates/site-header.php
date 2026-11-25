<?php
/**
 * Site header + mobile menu. Fields: Website settings (ACF options page). Links: Appearance → Menus (Header menu).
 */
defined( 'ABSPATH' ) || exit;

bbq_section( 'Header' );
$apply = bbq_link( 'header_apply', array( 'label' => 'Submit your application', 'url' => 'page:apply' ), 'Application button (header and mobile menu)' );
?>
<header class="site-header" data-header>
  <?php bbq_nav_primary(); ?>

  <a class="site-header__logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="bb.q Chicken – home">
    <?php bbq_image( 'logo', 'svg/logo-on-dark.svg', 'Logo (on dark)', array( 'alt' => 'bb.q Chicken', 'width' => 250, 'height' => 42 ) ); ?>
  </a>

  <div class="header-right">
    <?php if ( ! bbq_language_menu() ) : // inc/languages.php ?>
    <a class="lang-switch" href="#" aria-label="Language: English"><?php bbq_text( 'lang_label', 'EN ▾', 'Language switch', array( 'help' => 'Shown only without TranslatePress; with it, the languages come from TranslatePress.' ) ); ?></a>
    <?php endif; ?>
    <div class="order-menu" data-dropdown>
      <button class="btn btn--outline-light" type="button" aria-expanded="false" aria-controls="dd-order">
        <?php bbq_text( 'order_label', 'Order now', 'Order button' ); ?> <span class="btn__chip"><?php bbq_icon( 'chevdown' ); ?></span>
      </button>
      <div class="dropdown" id="dd-order">
        <span class="dropdown__label"><?php bbq_text( 'order_menu_label', 'Order bb.q on', 'Order menu: heading' ); ?></span>
        <div class="dropdown__list">
          <?php
          bbq_section( 'Ordering platforms' );
          $platforms = bbq_rows(
              'platforms',
              'Ordering platforms (order menu; a platform without a link is hidden)',
              array(
                  'name' => array( 'text', 'Name' ),
                  'url'  => array( 'text', 'Link (https://…)' ),
              ),
              array(
                  array( 'name' => 'Glovo', 'url' => 'https://glovo.go.link/open?link_type=store&store_id=617208&adjust_t=s321jkn' ),
                  array( 'name' => 'Uber Eats', 'url' => 'https://www.ubereats.com/store-browse-uuid/7a2ca0a0-0ec2-5a74-997a-08690eed5876?diningMode=DELIVERY' ),
                  array( 'name' => 'Just Eat', 'url' => 'https://www.just-eat.es/restaurants-bbq-chicken-madrid/menu' ),
                  array( 'name' => 'Deliveroo', 'url' => '' ),
              )
          );
          foreach ( $platforms as $p ) :
              if ( '' === (string) $p['name'] || in_array( trim( (string) $p['url'] ), array( '', '#' ), true ) ) {
                  continue; // no store link yet
              }
              ?>
          <a class="platform-link" href="<?php echo esc_url( bbq_url( $p['url'] ) ); ?>" target="_blank" rel="noopener"><span><?php bbq_e( $p['name'] ); ?></span><span aria-hidden="true">↗</span></a>
          <?php endforeach; ?>
        </div>
        <div class="dropdown__divider"></div>
        <?php $find = bbq_link( 'order_find', array( 'label' => 'Find a restaurant (map) →', 'url' => 'page:home#find' ), 'Order menu: find a restaurant link' ); ?>
        <a class="dropdown__find"<?php bbq_link_attrs( $find ); ?>><?php bbq_e( $find['label'] ); ?></a>
        <p class="dropdown__note"><?php bbq_text( 'order_note', 'Spain: Glovo, Uber Eats, Just Eat. UK: Uber Eats, Just Eat, Deliveroo.', 'Order menu: note' ); ?></p>
      </div>
    </div>
    <a class="btn btn--cream"<?php bbq_link_attrs( $apply ); ?>><?php bbq_e( $apply['label'] ); ?> <span class="btn__chip"><?php bbq_icon( 'arrow' ); ?></span></a>
    <button class="burger" type="button" aria-label="Open menu" aria-expanded="false" aria-controls="mobile-menu" data-burger>
      <span></span><span></span><span></span>
    </button>
  </div>
</header>

<?php bbq_section( 'Mobile menu' ); ?>
<div class="mobile-menu" id="mobile-menu" aria-label="Menu">
  <div class="mobile-menu__inner">
    <?php bbq_nav_mobile(); ?>
    <div class="mobile-menu__actions">
      <a class="btn btn--cream"<?php bbq_link_attrs( $apply ); ?>><?php bbq_e( $apply['label'] ); ?> <span class="btn__chip"><?php bbq_icon( 'arrow' ); ?></span></a>
      <?php $morder = bbq_link( 'mobile_order', array( 'label' => 'Order now', 'url' => 'page:home#find' ), 'Mobile menu: order button' ); ?>
      <a class="btn btn--outline-light"<?php bbq_link_attrs( $morder ); ?>><?php bbq_e( $morder['label'] ); ?> <span class="btn__chip"><?php bbq_icon( 'arrow' ); ?></span></a>
      <p class="mobile-menu__lang"><?php if ( ! bbq_language_links() ) { bbq_html( 'mobile_lang', 'English · <a href="#">Español</a>', 'Mobile menu: languages', array( 'help' => 'Shown only without TranslatePress.' ) ); } ?></p>
    </div>
  </div>
  <?php bbq_image( 'mobile_peek', 'chibboq-peeking.png', 'Mobile menu: ChiBBoQ image', array( 'class' => 'mobile-menu__peek', 'alt' => '', 'width' => 300, 'height' => 537, 'loading' => 'lazy' ) ); ?>
</div>
