<?php
/**
 * Section "Leadership team" (about page) · ACF layout: about_leadership_team
 */
defined( 'ABSPATH' ) || exit;
include __DIR__ . '/_shared.php';
?>
<!-- 4. Leadership (4 per row, wraps as the team grows) -->
<?php bbq_section( 'Leadership team' ); ?>
<section class="section leaders" id="team" aria-labelledby="leaders-title">
  <div class="section-head leaders__head">
    <span class="eyebrow"><?php bbq_text( 'leaders_eyebrow', 'Leadership', 'Label' ); ?></span>
    <h2 class="h2" id="leaders-title"><?php bbq_text( 'leaders_title', 'One team, one community', 'Heading' ); ?></h2>
  </div>
  <div class="row-slider" data-slider>
    <div class="leaders__list" data-slider-viewport>
      <?php
      $people = bbq_rows(
          'leaders',
          'People',
          array(
              'img'  => array( 'image', 'Portrait photo' ),
              'name' => array( 'text', 'Name' ),
              'role' => array( 'text', 'Role' ),
              'alt'  => array( 'text', 'Photo description (alt text)' ),
          ),
          array(
              array( 'img' => 'team-thomas-talarico.jpg', 'name' => 'Thomas C. Talarico', 'role' => 'CEO and Partner', 'alt' => 'Portrait of Thomas C. Talarico' ),
              array( 'img' => 'team-maria-de-los-reyes-barrenengoa.jpg', 'name' => 'María de los Reyes Barrenengoa', 'role' => 'Marketing', 'alt' => 'Portrait of María de los Reyes Barrenengoa' ),
              array( 'img' => 'team-daniela-haack.jpg', 'name' => 'Daniela Haack', 'role' => 'Marketing', 'alt' => 'Portrait of Daniela Haack' ),
              array( 'img' => 'team-patricia-rader.jpg', 'name' => 'Patricia Rader', 'role' => 'Human Resources', 'alt' => 'Portrait of Patricia Rader' ),
              array( 'img' => 'team-julian-de-miguel.jpg', 'name' => 'Julián de Miguel', 'role' => 'IT', 'alt' => 'Portrait of Julián de Miguel' ),
              array( 'img' => 'team-julieta-cruz.jpg', 'name' => 'Julieta Cruz', 'role' => 'Staff Accountant', 'alt' => 'Portrait of Julieta Cruz' ),
              array( 'img' => 'team-emma-heckel.jpg', 'name' => 'Emma Heckel', 'role' => 'Procurement', 'alt' => 'Portrait of Emma Heckel' ),
          )
      );
      foreach ( $people as $person ) :
          ?>
      <article class="person">
        <div class="person__photo"><?php bbq_img( $person['img'], array( 'alt' => $person['alt'], 'width' => 720, 'height' => 900, 'loading' => 'lazy' ) ); ?></div>
        <div class="person__meta"><p class="person__role"><?php bbq_e( $person['role'] ); ?></p><h3 class="person__name"><?php bbq_e( $person['name'] ); ?></h3></div>
      </article>
      <?php endforeach; ?>
    </div>
    <div class="row-nav">
      <button class="row-nav__arrow" type="button" aria-label="Previous" data-slider-prev><?php bbq_icon( 'left' ); ?></button>
      <div class="row-nav__dots" data-slider-dots></div>
      <button class="row-nav__arrow" type="button" aria-label="Next" data-slider-next><?php bbq_icon( 'right' ); ?></button>
    </div>
  </div>
</section>
