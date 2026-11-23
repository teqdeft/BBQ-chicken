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
      // The people are Team posts (menu: Team): the picked ones in the picked order, else all in their order.
      $picked = bbq_posts( 'leaders_pick', 'Team members', 'team_member', array( 'help' => 'Pick the people for this section and drag them into order. Empty = all team members, in their Order. People are added and edited under Team in the admin menu.' ) );
      $people = bbq_cards( 'team_member', $picked ); // inc/card-types.php
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
