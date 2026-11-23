<?php
/**
 * Section "The road to franchising" (franchise page) · ACF layout: franchise_the_road_to_franchising
 */
defined( 'ABSPATH' ) || exit;
include __DIR__ . '/_shared.php';
?>
<!-- 9. Process -->
<?php bbq_section( 'The road to franchising' ); ?>
<section class="section process" aria-labelledby="process-title">
  <div class="section-head process__head">
    <span class="eyebrow"><?php bbq_text( 'process_eyebrow', 'The road to franchising', 'Label' ); ?></span>
    <h2 class="h2" id="process-title"><?php bbq_text( 'process_title', 'Five steps to becoming a bb.q franchisee', 'Heading' ); ?></h2>
  </div>

  <ol class="steps">
    <?php
    $steps = bbq_rows(
        'steps',
        'Steps (the first icon is yellow)',
        array(
            'icon'  => array( 'select', 'Icon', $icon_choices ),
            'title' => array( 'text', 'Title' ),
            'text'  => array( 'textarea', 'Text' ),
        ),
        array(
            array( 'icon' => 'file', 'title' => 'Submit your application', 'text' => 'Tell us about your background, business experience and the territory or city you\'re targeting in Europe.' ),
            array( 'icon' => 'clipboard', 'title' => 'Evaluation', 'text' => 'We review your profile, financial capacity and operational readiness, then schedule an introductory meeting.' ),
            array( 'icon' => 'pin', 'title' => 'Territory selection', 'text' => 'With our real estate and operations experts we find and approve the right site.' ),
            array( 'icon' => 'cap', 'title' => 'Agreement and training', 'text' => 'We sign the franchise agreement and you and your team start our full training programme.' ),
            array( 'icon' => 'rocket', 'title' => 'Launch and support', 'text' => 'Opening marketing, supply chain set-up with our official CCEP partnership, and ongoing support from day one.' ),
        )
    );
    foreach ( $steps as $i => $item ) :
        ?>
    <li class="step">
      <div class="step__rail">
        <span class="step__icon<?php echo 0 === $i ? ' step__icon--first' : ''; ?>" aria-hidden="true"><svg viewBox="0 0 24 24"><use href="#i-<?php echo esc_attr( $item['icon'] ? $item['icon'] : 'file' ); ?>"/></svg></span>
      </div>
      <div class="step__body">
        <h3 class="step__title"><?php bbq_e( $item['title'] ); ?></h3>
        <p class="step__text"><?php bbq_e( $item['text'] ); ?></p>
      </div>
    </li>
    <?php endforeach; ?>
  </ol>

  <?php $process_cta = bbq_link( 'process_cta', array( 'label' => 'Submit your application', 'url' => 'page:apply' ), 'Button' ); ?>
  <?php if ( $process_cta['label'] ) : ?>
  <div class="process__cta">
    <a class="btn btn--cream"<?php bbq_link_attrs( $process_cta ); ?>><?php bbq_e( $process_cta['label'] ); ?> <span class="btn__chip"><?php bbq_icon( 'arrow' ); ?></span></a>
  </div>
  <?php endif; ?>
</section>
