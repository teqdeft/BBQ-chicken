<?php
/**
 * Section "Our team" (home page) · ACF layout: home_our_team
 */
defined( 'ABSPATH' ) || exit;
include __DIR__ . '/_shared.php';
?>
<!-- 11. Our team (teaser) -->
<?php bbq_section( 'Our team' ); ?>
<section class="section team" aria-labelledby="team-title">
  <?php $team = bbq_get( 'team_img', 'team.jpg', 'Team photo', 'image' ); ?>
  <div class="team__img"><?php bbq_img( $team, array( 'alt' => bbq_get( 'team_alt', 'The BLT Global Brands team in Europe', 'Team photo: description (alt text)' ), 'width' => 1600, 'height' => 968, 'loading' => 'lazy' ) ); ?></div>
  <div class="team__text">
    <span class="eyebrow"><?php bbq_text( 'team_eyebrow', 'Our team', 'Label' ); ?></span>
    <h2 class="h2" id="team-title"><?php bbq_text( 'team_title', 'The people bringing bb.q to Europe', 'Heading' ); ?></h2>
    <p class="lead"><?php bbq_textarea( 'team_lead', 'A European team with years of experience in international restaurant franchising, building bb.q one market at a time.', 'Intro text' ); ?></p>
    <?php $l = bbq_link( 'team_btn', array( 'label' => 'Meet the team', 'url' => 'page:about#team' ), 'Button' ); ?>
    <div class="btn-row"><a class="btn btn--outline-dark"<?php bbq_link_attrs( $l ); ?>><?php bbq_e( $l['label'] ); ?> <span class="btn__chip"><?php bbq_icon( 'arrow' ); ?></span></a></div>
  </div>
</section>
