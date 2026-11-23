<?php
/**
 * Section "Our story" (discover page) · ACF layout: discover_our_story
 */
defined( 'ABSPATH' ) || exit;
include __DIR__ . '/_shared.php';
?>
<!-- 2. Our story (Process pattern) -->
<?php bbq_section( 'Our story' ); ?>
<section class="section story" id="story" aria-labelledby="story-title">
  <div class="section-head story__head">
    <span class="eyebrow eyebrow--dark"><?php bbq_text( 'story_eyebrow', 'Our story', 'Label' ); ?></span>
    <h2 class="h2" id="story-title"><?php bbq_text( 'story_title', 'Bringing communities together through delicious food', 'Heading' ); ?></h2>
    <div class="story__intro">
      <?php
      $story_intro = bbq_rows(
          'story_intro',
          'Intro paragraphs',
          array( 'text' => array( 'textarea', 'Paragraph' ) ),
          array(
              array( 'text' => 'Founded in 1995, bb.q Chicken (Best of the Best Quality) was born with a clear vision: to share the authentic taste of Korean fried chicken with the world.' ),
              array( 'text' => 'Managed across Europe by BLT Global Brands, we combine traditional recipes, proprietary crispiness techniques, and world-class operational standards. With over 3,500 locations across 57 countries, we believe that great food has the power to connect people. We are more than a restaurant brand. We are a global culinary experience dedicated to quality, innovation, and bringing communities together through delicious food.' ),
          )
      );
      foreach ( $story_intro as $para ) :
          ?>
      <p><?php bbq_e( $para['text'] ); ?></p>
      <?php endforeach; ?>
    </div>
  </div>

  <ol class="timeline">
    <?php
    $timeline = bbq_rows(
        'timeline',
        'Timeline steps',
        array(
            'year'  => array( 'text', 'Year' ),
            'title' => array( 'text', 'Title' ),
            'text'  => array( 'textarea', 'Text' ),
            'icon'  => array( 'select', 'Icon', array( 'store' => 'Restaurant', 'cap' => 'Graduation cap', 'plane' => 'Plane', 'building' => 'Building', 'star' => 'Star' ) ),
            'style' => array( 'select', 'Icon colour', array( 'cream' => 'Cream', 'yellow' => 'Yellow (highlight)' ) ),
        ),
        array(
            array( 'year' => '1995', 'title' => 'First restaurant', 'text' => 'The first bb.q opens in Jeongok, Korea.', 'icon' => 'store', 'style' => 'yellow' ),
            array( 'year' => '1999', 'title' => '1,000 restaurants', 'text' => 'bb.q passes 1,000 restaurants and opens Chicken University.', 'icon' => 'cap', 'style' => 'cream' ),
            array( 'year' => '2006', 'title' => 'Into the US', 'text' => 'The first restaurants open in the United States.', 'icon' => 'plane', 'style' => 'cream' ),
            array( 'year' => '2017', 'title' => 'Manhattan', 'text' => 'bb.q opens on 32nd Street in New York.', 'icon' => 'building', 'style' => 'cream' ),
            array( 'year' => '2025', 'title' => 'Thirty years', 'text' => '3,500+ restaurants worldwide and a new chapter in Europe.', 'icon' => 'star', 'style' => 'cream' ),
        )
    );
    foreach ( $timeline as $step ) :
        $icon = isset( $timeline_icons[ $step['icon'] ] ) ? $timeline_icons[ $step['icon'] ] : $timeline_icons['star'];
        ?>
    <li class="timeline__step">
      <div class="timeline__icon<?php echo 'yellow' === $step['style'] ? ' timeline__icon--yellow' : ''; ?>" aria-hidden="true">
        <?php echo $icon; // phpcs:ignore WordPress.Security.EscapeOutput -- fixed SVGs above ?>
      </div>
      <h3 class="timeline__title"><?php if ( '' !== (string) $step['year'] ) : ?><span class="timeline__year"><?php bbq_e( $step['year'] ); ?></span><span class="timeline__sep"> · </span><?php endif; ?><?php bbq_e( $step['title'] ); ?></h3>
      <p class="timeline__text"><?php bbq_e( $step['text'] ); ?></p>
    </li>
    <?php endforeach; ?>
  </ol>
</section>
