<?php
/**
 * Section "Who we're looking for" (franchise page) · ACF layout: franchise_who_were_looking_for
 */
defined( 'ABSPATH' ) || exit;
include __DIR__ . '/_shared.php';
?>
<!-- 6. Franchise criteria -->
<?php bbq_section( 'Who we\'re looking for' ); ?>
<section class="section criteria" aria-labelledby="criteria-title">
  <div class="section-head criteria__head">
    <span class="eyebrow"><?php bbq_text( 'criteria_eyebrow', 'Criteria', 'Label' ); ?></span>
    <h2 class="h2" id="criteria-title"><?php bbq_text( 'criteria_title', 'Who we\'re looking for', 'Heading' ); ?></h2>
  </div>

  <div class="fslider" data-slider>
    <ul class="criteria__list" data-slider-viewport>
      <?php
      $criteria = bbq_rows(
          'criteria',
          'Criteria',
          array(
              'style' => array( 'select', 'Colour', array( 'yellow' => 'Yellow', 'red' => 'Red', 'sand' => 'Sand', 'dark' => 'Dark' ) ),
              'icon'  => array( 'select', 'Icon', $icon_choices ),
              'title' => array( 'text', 'Title' ),
              'text'  => array( 'textarea', 'Text' ),
          ),
          array(
              array( 'style' => 'yellow', 'icon' => 'store', 'title' => 'Experience in QSR or retail', 'text' => 'You run food service or retail units today.' ),
              array( 'style' => 'red', 'icon' => 'buildings', 'title' => 'Multi-unit capacity', 'text' => 'You can open and run several restaurants in a region.' ),
              array( 'style' => 'sand', 'icon' => 'coin', 'title' => 'Financial backing', 'text' => 'You can fund a multi-unit development plan.' ),
              array( 'style' => 'dark', 'icon' => 'pin', 'title' => 'Local market knowledge', 'text' => 'You know the landlords, suppliers and people in your market.' ),
          )
      );
      foreach ( $criteria as $item ) :
          ?>
      <li class="criterion criterion--<?php echo esc_attr( $item['style'] ? $item['style'] : 'yellow' ); ?>">
        <span class="criterion__icon" aria-hidden="true"><svg viewBox="0 0 24 24"><use href="#i-<?php echo esc_attr( $item['icon'] ? $item['icon'] : 'store' ); ?>"/></svg></span>
        <h3 class="criterion__title"><?php bbq_e( $item['title'] ); ?></h3>
        <p class="criterion__text"><?php bbq_e( $item['text'] ); ?></p>
      </li>
      <?php endforeach; ?>
    </ul>
    <div class="slider__nav fslider__nav">
      <button class="slider__arrow" type="button" aria-label="Previous criterion" data-slider-prev><?php bbq_icon( 'left' ); ?></button>
      <div class="slider__dots" data-slider-dots></div>
      <button class="slider__arrow" type="button" aria-label="Next criterion" data-slider-next><?php bbq_icon( 'right' ); ?></button>
    </div>
  </div>

  <div class="mid-cta">
    <div class="mid-cta__box">
      <p class="mid-cta__text"><?php bbq_text( 'midcta_text', 'Ready to join our franchise network?', 'Call to action: text' ); ?></p>
      <?php $mid_cta = bbq_link( 'midcta_btn', array( 'label' => 'Submit your application', 'url' => 'page:apply' ), 'Call to action: button' ); ?>
      <a class="btn btn--cream"<?php bbq_link_attrs( $mid_cta ); ?>><?php bbq_e( $mid_cta['label'] ); ?> <span class="btn__chip"><?php bbq_icon( 'arrow' ); ?></span></a>
    </div>
    <?php bbq_image( 'midcta_img', 'chibboq-glasses.png', 'Call to action: ChiBBoQ image', array( 'class' => 'mid-cta__chibboq', 'alt' => '', 'width' => 714, 'height' => 906, 'loading' => 'lazy' ) ); ?>
  </div>
</section>
