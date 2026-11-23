<?php
/**
 * Section "Why partner with us (franchise)" (home page) · ACF layout: home_why_partner_with_us
 */
defined( 'ABSPATH' ) || exit;
include __DIR__ . '/_shared.php';
?>
<!-- 9. Why partner -->
<?php bbq_section( 'Why partner with us (franchise)' ); ?>
<section class="section why why--home" aria-labelledby="why-title">
  <div class="why__bg why__bg--glow" aria-hidden="true">
    <?php bbq_image( 'why_bg_img', 'cut-bucket-09.png', 'Background cut-out image', array( 'class' => 'why__bg-cut', 'alt' => '', 'width' => 832, 'height' => 671, 'loading' => 'lazy' ) ); ?>
  </div>
  <div class="cutout cutout--shadow-dark cutout--cheesling"><?php bbq_image( 'why_cut', 'cut-4pcs-cheesling.png', 'Cut-out image', array( 'alt' => '', 'width' => 860, 'height' => 419, 'loading' => 'lazy' ) ); ?></div>
  <div class="why__inner">
    <div class="section-head">
      <span class="eyebrow eyebrow--glass"><?php bbq_text( 'why_eyebrow', 'Franchise', 'Label' ); ?></span>
      <h2 class="h2" id="why-title"><?php bbq_text( 'why_title', 'Thirty years of know-how, looking for its European partners.', 'Heading' ); ?></h2>
      <p class="lead"><?php bbq_textarea( 'why_lead', 'We\'re looking for experienced multi-unit operators and area developers who want to build a region or a whole country. You bring local knowledge and operating strength. We bring the brand, the recipes and a system refined in 3,500+ restaurants.', 'Intro text' ); ?></p>
    </div>
    <div class="carousel carousel--mobile carousel--light" data-carousel>
      <div class="reasons" data-carousel-viewport>
        <?php
        $reasons = bbq_rows(
            'reasons',
            'Reasons (numbered 01, 02 … automatically)',
            array(
                'title' => array( 'text', 'Title' ),
                'text'  => array( 'textarea', 'Text' ),
            ),
            array(
                array( 'title' => 'A brand guests already know', 'text' => 'Korea\'s best-known fried chicken, with restaurants from Seoul to New York and a fast-growing following in the US.' ),
                array( 'title' => 'Express, built for speed', 'text' => 'Our Express kiosk runs on 10 to 40 m², focused on takeaway and delivery, with a tight menu and low labour costs.' ),
                array( 'title' => 'Training from the source', 'text' => 'Owners and teams train at Chicken University, bb.q\'s own training and R&D centre, running since 1999.' ),
                array( 'title' => 'A new European team behind you', 'text' => 'Site selection, supply, launch marketing and day-to-day support from the team leading bb.q in Europe.' ),
            )
        );
        foreach ( $reasons as $i => $reason ) :
            ?>
        <article class="reason"><span class="reason__num"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span><h3 class="reason__title"><?php bbq_e( $reason['title'] ); ?></h3><p class="reason__text"><?php bbq_e( $reason['text'] ); ?></p></article>
        <?php endforeach; ?>
      </div>
      <div class="slider__nav" data-carousel-nav>
        <button class="slider__arrow" type="button" aria-label="Previous reason" data-carousel-prev><?php bbq_icon( 'left' ); ?></button>
        <div class="slider__dots" data-carousel-dots></div>
        <button class="slider__arrow" type="button" aria-label="Next reason" data-carousel-next><?php bbq_icon( 'right' ); ?></button>
      </div>
    </div>
    <div class="btn-row">
      <?php $l = bbq_link( 'why_btn1', array( 'label' => 'Explore the franchise', 'url' => 'page:franchise' ), 'First button' ); ?>
      <a class="btn btn--outline-light"<?php bbq_link_attrs( $l ); ?>><?php bbq_e( $l['label'] ); ?> <span class="btn__chip"><?php bbq_icon( 'arrow' ); ?></span></a>
      <?php $l = bbq_link( 'why_btn2', array( 'label' => 'Submit your application', 'url' => 'page:apply' ), 'Second button' ); ?>
      <a class="btn btn--cream"<?php bbq_link_attrs( $l ); ?>><?php bbq_e( $l['label'] ); ?> <span class="btn__chip"><?php bbq_icon( 'arrow' ); ?></span></a>
    </div>
  </div>
</section>
