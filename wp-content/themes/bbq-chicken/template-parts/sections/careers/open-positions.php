<?php
/**
 * Section "Open positions" (careers page) · ACF layout: careers_open_positions
 */
defined( 'ABSPATH' ) || exit;
include __DIR__ . '/_shared.php';
?>
<!-- 3. Open positions -->
<?php bbq_section( 'Open positions' ); ?>
<section class="section vacancies" aria-labelledby="vacancies-title">
  <div class="section-head">
    <span class="eyebrow"><?php bbq_text( 'vac_eyebrow', 'Open positions', 'Label' ); ?></span>
    <h2 class="h2" id="vacancies-title"><?php bbq_text( 'vac_title', 'Current vacancies', 'Heading' ); ?></h2>
  </div>
  <?php
  $vacancies = bbq_rows(
      'vacancies',
      'Vacancies (none: the "no open positions" message below is shown)',
      array(
          'title' => array( 'text', 'Role' ),
          'lang'  => array( 'text', 'Language of the role name, if not English (e.g. es)' ),
          'meta'  => array( 'text', 'Location and contract (city first)' ),
          'link'  => array( 'link', 'Link (job page, or #open-application for the form below)' ),
      ),
      array(
          array( 'title' => 'Kitchen Staff', 'lang' => '', 'meta' => 'London, United Kingdom', 'link' => array( 'label' => 'View role →', 'url' => '#open-application' ) ),
          array( 'title' => 'Responsables de Cocina', 'lang' => 'es', 'meta' => 'Madrid, Spain', 'link' => array( 'label' => 'View role →', 'url' => '#open-application' ) ),
      )
  );
  if ( $vacancies ) :
      ?>
  <ul class="vacancy-list">
      <?php
      foreach ( $vacancies as $job ) :
          // Screen readers hear "View role: Kitchen Staff, London" (link text + role + city).
          $city  = trim( (string) preg_replace( '/\s*[,·].*$/u', '', (string) $job['meta'] ) );
          $aria  = trim( str_replace( '→', '', (string) $job['link']['label'] ) ) . ': ' . $job['title'] . ( '' !== $city ? ', ' . $city : '' );
          $lang  = sanitize_key( (string) $job['lang'] );
          ?>
    <li class="vacancy">
      <div class="vacancy__role">
        <h3 class="vacancy__title"<?php echo $lang ? ' lang="' . esc_attr( $lang ) . '"' : ''; // phpcs:ignore WordPress.Security.EscapeOutput ?>><?php bbq_e( $job['title'] ); ?></h3>
        <?php if ( $job['meta'] ) : ?>
        <p class="vacancy__meta"><?php bbq_e( $job['meta'] ); ?></p>
        <?php endif; ?>
      </div>
          <?php if ( $job['link']['label'] ) : ?>
      <a class="vacancy__link"<?php bbq_link_attrs( $job['link'], ' aria-label="' . esc_attr( $aria ) . '"' ); ?>><?php bbq_e( $job['link']['label'] ); ?></a>
          <?php endif; ?>
    </li>
      <?php endforeach; ?>
  </ul>
  <?php endif; ?>
  <!-- Empty state: shown instead of the list when there are no vacancies -->
  <div class="empty-state"<?php echo $vacancies ? ' hidden' : ''; ?>>
    <h3 class="empty-state__title"><?php bbq_text( 'empty_title', 'No open positions right now', 'No vacancies: heading' ); ?></h3>
    <p class="empty-state__text"><?php bbq_textarea( 'empty_text', "New roles open as we grow. Send us an open application and we'll keep you in mind for your country.", 'No vacancies: text' ); ?></p>
  </div>
</section>
