<?php
/**
 * Section "Why people join us" (careers page) · ACF layout: careers_why_people_join_us
 */
defined( 'ABSPATH' ) || exit;
include __DIR__ . '/_shared.php';
?>
<!-- 2. Why work with us (mobile: swipe row with arrows and dots) -->
<?php bbq_section( 'Why people join us' ); ?>
<section class="section join" aria-labelledby="join-title">
  <div class="section-head">
    <span class="eyebrow"><?php bbq_text( 'join_eyebrow', 'Why bb.q', 'Label' ); ?></span>
    <h2 class="h2" id="join-title"><?php bbq_text( 'join_title', 'Why people join us', 'Heading' ); ?></h2>
  </div>
  <div class="tiles-slider" data-slider>
    <div class="tiles" data-slider-viewport>
      <?php
      $tiles = bbq_rows(
          'tiles',
          'Photo cards (swipe row on phones)',
          array(
              'style' => array( 'select', 'Colour', array( 'yellow' => 'Yellow', 'red' => 'Red', 'sand' => 'Sand' ) ),
              'img'   => array( 'image', 'Photo' ),
              'alt'   => array( 'text', 'Photo description (alt text)' ),
              'icon'  => array( 'select', 'Icon', array( 'sprout' => 'Sprout', 'graduation' => 'Graduation cap', 'trend' => 'Growth arrow' ) ),
              'title' => array( 'text', 'Title' ),
              'text'  => array( 'textarea', 'Text' ),
          ),
          array(
              array( 'style' => 'yellow', 'img' => 'team.jpg', 'alt' => 'The bb.q team in Europe', 'icon' => 'sprout', 'title' => 'Early days', 'text' => 'Join a brand at the start of its European story and help shape it.' ),
              array( 'style' => 'red', 'img' => 'chicken-university.jpg', 'alt' => "bb.q's Chicken University training centre", 'icon' => 'graduation', 'title' => 'Real training', 'text' => 'Learn the bb.q way, from the fryer to running your own restaurant.' ),
              array( 'style' => 'sand', 'img' => 'news-barcelona.jpg', 'alt' => 'A bb.q restaurant in Europe', 'icon' => 'trend', 'title' => 'Room to move', 'text' => 'New restaurants and markets open up new roles all the time.' ),
          )
      );
      foreach ( $tiles as $tile ) :
          $size = is_string( $tile['img'] ) && isset( $tile_sizes[ $tile['img'] ] ) ? $tile_sizes[ $tile['img'] ] : array( null, null );
          ?>
      <article class="tile tile--<?php echo esc_attr( $tile['style'] ? $tile['style'] : 'yellow' ); ?>">
        <?php if ( $tile['img'] ) : ?>
        <div class="tile__img"><?php bbq_img( $tile['img'], array( 'alt' => $tile['alt'], 'width' => $size[0], 'height' => $size[1], 'loading' => 'lazy' ) ); ?></div>
        <?php endif; ?>
        <div class="tile__body">
          <span class="tile__icon" aria-hidden="true"><?php echo isset( $tile_icons[ $tile['icon'] ] ) ? $tile_icons[ $tile['icon'] ] : ''; // phpcs:ignore WordPress.Security.EscapeOutput -- fixed SVGs above ?></span>
          <h3 class="tile__title"><?php bbq_e( $tile['title'] ); ?></h3>
          <p class="tile__text"><?php bbq_e( $tile['text'] ); ?></p>
        </div>
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
