<?php
/**
 * News article (single post, single.php). Static source: html-backup/src/pages/news-article.html
 *
 * From the post: title, label/date line and sources/"Read the full article" (the "News card" box),
 * the article text (post content, block editor – paragraphs, headings, Image blocks with captions).
 * The fixed texts of this layout are fields stored on the News page (bbq_render_fields( 'news-article' )).
 * Related articles: the latest 3 other posts (placeholders left out), same cards as the News page.
 */
defined( 'ABSPATH' ) || exit;

$live    = ! bbq_schema_mode();
$article = null;
if ( $live && have_posts() ) {
	the_post();
	$article = get_post();
}

bbq_section( 'Article page: header' );
$label_default = bbq_get( 'article_label', 'News', 'Label above the title (when the post has none)', 'text', array( 'help' => 'Each post can set its own label and date line in its "News card" box.' ) );
$read_time     = bbq_get( 'article_read_time', '%s min read', 'Reading time after the date line', 'text', array( 'help' => '%s = minutes, calculated from the article text. Empty = no reading time.' ) );

bbq_section( 'Article page: sources and share links' );
$full_label   = bbq_get( 'article_full_label', 'Read the full article', '"Read the full article" button (when the post gives no text)' );
$full_sr      = bbq_get( 'article_new_tab', '(opens in a new tab)', 'Screen-reader note on outside links' );
$share_label  = bbq_get( 'share_label', 'Share:', 'Share: label' );
$share_li     = bbq_get( 'share_linkedin', 'LinkedIn', 'Share: LinkedIn' );
$share_x      = bbq_get( 'share_x', 'X', 'Share: X' );
$share_email  = bbq_get( 'share_email', 'Email', 'Share: email' );
$share_copy   = bbq_get( 'share_copy', 'Copy link', 'Share: copy link' );
$share_copied = bbq_get( 'share_copied', 'Link copied', 'Share: text after copying' );

if ( $article ) :
	$label = trim( (string) bbq_news_field( $article->ID, 'label' ) );
	$line  = bbq_news_date_line( $article->ID );
	if ( '' !== trim( (string) $read_time ) ) {
		$line .= ' · ' . str_replace( '%s', (string) bbq_news_read_minutes( $article ), $read_time );
	}
	$sources   = trim( (string) bbq_news_field( $article->ID, 'sources' ) );
	$full      = bbq_news_field( $article->ID, 'full_article' );
	$has_full  = is_array( $full ) && '' !== trim( (string) $full['url'] );
	$full_text = $has_full && '' !== trim( (string) $full['label'] ) ? $full['label'] : $full_label;
	$share_url = rawurlencode( get_permalink( $article ) );
	$share_ttl = rawurlencode( html_entity_decode( wp_get_document_title(), ENT_QUOTES, get_bloginfo( 'charset' ) ) );
	?>
<article class="article" aria-labelledby="article-title">
  <!-- 1. Page header -->
  <header class="section page-hero page-hero--short">
    <div class="page-hero__text">
      <span class="eyebrow eyebrow--glass"><?php bbq_e( '' !== $label ? $label : $label_default ); ?></span>
      <h1 class="h-display" id="article-title"><?php echo bbq_news_title( $article ); // phpcs:ignore WordPress.Security.EscapeOutput -- escaped ?></h1>
      <p class="lead"><?php bbq_e( $line ); ?></p>
    </div>
  </header>

  <!-- 2. Article body -->
  <div class="section article-body">
    <div class="article-body__col">
      <?php the_content(); ?>

      <?php if ( '' !== $sources || $has_full ) : ?>
      <div class="article-source">
        <?php if ( '' !== $sources ) : ?>
        <p class="article-source__text"><?php bbq_k( $sources ); ?></p>
        <?php endif; ?>
        <?php if ( $has_full ) : ?>
        <a class="btn btn--outline-dark only-desktop"<?php bbq_link_attrs( $full ); ?>><?php bbq_e( $full_text ); ?> <?php if ( ! empty( $full['new_tab'] ) ) : ?><span class="sr-only"><?php bbq_e( $full_sr ); ?></span><?php endif; ?><span class="btn__chip"><?php bbq_icon( 'arrow' ); ?></span></a>
        <a class="article-source__link only-mobile"<?php bbq_link_attrs( $full ); ?>><?php bbq_e( $full_text ); ?> →<?php if ( ! empty( $full['new_tab'] ) ) : ?><span class="sr-only"> <?php bbq_e( $full_sr ); ?></span><?php endif; ?></a>
        <?php endif; ?>
      </div>
      <?php endif; ?>

      <p class="article-share" data-share><?php bbq_e( $share_label ); ?> <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo esc_attr( $share_url ); ?>" target="_blank" rel="noopener" data-share-linkedin><?php bbq_e( $share_li ); ?></a> · <a href="https://x.com/intent/post?url=<?php echo esc_attr( $share_url . '&text=' . $share_ttl ); ?>" target="_blank" rel="noopener" data-share-x><?php bbq_e( $share_x ); ?></a> · <a href="mailto:?subject=<?php echo esc_attr( $share_ttl . '&body=' . $share_url ); ?>" data-share-email><?php bbq_e( $share_email ); ?></a> · <button type="button" data-share-copy><?php bbq_e( $share_copy ); ?></button></p>
    </div>
  </div>
</article>
<?php endif; ?>

<!-- 3. Related articles (mobile: swipe row with arrows + dots, uses the shared [data-slider] behaviour) -->
<?php
bbq_section( 'Article page: related articles' );
$related_eyebrow = bbq_get( 'related_eyebrow', 'More news', 'Label' );
$related_title   = bbq_get( 'related_title', 'Related articles', 'Heading', 'text', array( 'help' => 'Shows the latest three other news posts.' ) );
$related_all     = bbq_link( 'related_all', array( 'label' => 'All news', 'url' => 'page:news' ), 'Button' );
$related         = $article ? bbq_news_latest( 3, array( $article->ID ) ) : array();
if ( $related ) :
	?>
<section class="section news related" aria-labelledby="related-title" data-slider>
  <div class="news__head">
    <div class="news__head-text">
      <span class="eyebrow"><?php bbq_e( $related_eyebrow ); ?></span>
      <h2 class="h2" id="related-title"><?php bbq_e( $related_title ); ?></h2>
    </div>
    <?php if ( $related_all['label'] ) : ?>
    <a class="btn btn--outline-dark"<?php bbq_link_attrs( $related_all ); ?>><?php bbq_e( $related_all['label'] ); ?> <span class="btn__chip"><?php bbq_icon( 'arrow' ); ?></span></a>
    <?php endif; ?>
  </div>
  <div class="news__list" data-slider-viewport>
    <?php
    foreach ( $related as $related_post ) {
        bbq_news_card( $related_post, array( 'new_tab_text' => $full_sr ) );
    }
    ?>
  </div>
  <div class="related__nav">
    <button class="related__arrow" type="button" aria-label="Previous article" data-slider-prev><?php bbq_icon( 'left' ); ?></button>
    <div class="related__dots" data-slider-dots></div>
    <button class="related__arrow" type="button" aria-label="Next article" data-slider-next><?php bbq_icon( 'right' ); ?></button>
  </div>
</section>
<?php endif; ?>

<!-- 4. Closing CTA -->
<?php bbq_section( 'Article page: closing banner' ); ?>
<section class="section closing" aria-labelledby="closing-title">
  <div class="stamp"><?php bbq_stamp(); ?></div>
  <span class="sparkle-lg" aria-hidden="true"><?php bbq_icon( 'sparkleplain' ); ?></span>
  <span class="sparkle-sm" aria-hidden="true"><?php bbq_icon( 'sparkleplain' ); ?></span>
  <div class="cta-card">
    <h2 class="h2" id="closing-title"><?php bbq_text( 'article_closing_title', 'Ready to bring bb.q to your market?', 'Heading' ); ?></h2>
    <p class="lead"><?php bbq_textarea( 'article_closing_lead', 'Tell us who you are and where you\'d like to grow. It takes two minutes. Our European team reads every enquiry and gets back to you personally.', 'Text' ); ?></p>
    <?php $closing_cta = bbq_link( 'article_closing_cta', array( 'label' => 'Submit your application', 'url' => 'page:apply' ), 'Button' ); ?>
    <a class="btn btn--red"<?php bbq_link_attrs( $closing_cta, ' data-hides-floating' ); ?>><?php bbq_e( $closing_cta['label'] ); ?> <span class="btn__chip"><?php bbq_icon( 'arrow' ); ?></span></a>
  </div>
  <div class="cutout cutout--shadow-dark cutout--fried"><?php bbq_image( 'article_closing_img', 'cut-2pcs-fried.png', 'Image', array( 'alt' => '', 'width' => 880, 'height' => 463, 'loading' => 'lazy' ) ); ?></div>
</section>

<?php if ( $article ) : ?>
<script>
  /* Share links: fill in this page's URL; "Copy link" copies it to the clipboard. */
  (function () {
    var share = document.querySelector('[data-share]');
    if (!share) return;
    var url = encodeURIComponent(location.href);
    var title = encodeURIComponent(document.title);
    share.querySelector('[data-share-linkedin]').href = 'https://www.linkedin.com/sharing/share-offsite/?url=' + url;
    share.querySelector('[data-share-x]').href = 'https://x.com/intent/post?url=' + url + '&text=' + title;
    share.querySelector('[data-share-email]').href = 'mailto:?subject=' + title + '&body=' + url;
    var copy = share.querySelector('[data-share-copy]');
    var label = copy.textContent, copied = <?php echo wp_json_encode( (string) $share_copied ); ?>;
    copy.addEventListener('click', function () {
      if (!navigator.clipboard) return;
      navigator.clipboard.writeText(location.href).then(function () {
        copy.textContent = copied;
        setTimeout(function () { copy.textContent = label; }, 2000);
      }, function () {}); /* clipboard blocked by the browser: nothing to do */
    });
  })();
</script>
<?php endif; ?>
