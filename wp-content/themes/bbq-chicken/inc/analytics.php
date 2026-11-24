<?php
/**
 * Cookie consent (Cookiebot) and Google Tag Manager, printed at the top of <head> on every page.
 *
 *   Cookiebot   only with a Cookiebot ID (Website settings → Cookie consent). It comes first: Google Consent
 *               Mode starts with everything but security storage denied, then the Cookiebot banner, which
 *               blocks other cookie-setting scripts until the visitor agrees (auto-blocking) and passes the
 *               choice on to Google's tags. The footer link "Cookie settings" reopens the banner
 *               (assets/js/main.js), and [cookie_declaration] prints Cookiebot's cookie list (cookie policy).
 *   GTM         container GTM-MTGPBSTM, left out on local development hosts (localhost, *.test …, see
 *               bbq_is_local_host()) so test visits don't end up in the statistics. Cookiebot lets it load
 *               (data-cookieconsent="ignore"); the tags inside it follow the visitor's consent.
 */

defined( 'ABSPATH' ) || exit;

/** The Cookiebot ID (Domain Group ID, a UUID) from the Website settings; '' when not set or not valid. */
function bbq_cookiebot_id() {
	$id = trim( (string) bbq_opt( 'cookiebot_id', '' ) );
	return preg_match( '/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i', $id ) ? strtolower( $id ) : '';
}

add_action(
	'wp_head',
	function () {
		$cbid = bbq_cookiebot_id();
		if ( '' === $cbid ) {
			return;
		}
		?>
<script data-cookieconsent="ignore">
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('consent', 'default', {
    ad_personalization: 'denied',
    ad_storage: 'denied',
    ad_user_data: 'denied',
    analytics_storage: 'denied',
    functionality_storage: 'denied',
    personalization_storage: 'denied',
    security_storage: 'granted',
    wait_for_update: 500
  });
  gtag('set', 'ads_data_redaction', true);
</script>
<script id="Cookiebot" src="https://consent.cookiebot.com/uc.js" data-cbid="<?php echo esc_attr( $cbid ); ?>" data-blockingmode="auto" type="text/javascript"></script>
		<?php
	},
	0
);

add_action(
	'wp_head',
	function () {
		if ( bbq_is_local_host() ) {
			return;
		}
		?>
<script async src="https://www.googletagmanager.com/gtm.js?id=GTM-MTGPBSTM" data-cookieconsent="ignore"></script>
<script data-cookieconsent="ignore">
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
</script>
		<?php
	},
	1
);

/**
 * [cookie_declaration]: Cookiebot's list of the cookies on the site (name, purpose, provider, expiry, type),
 * kept up to date by Cookiebot's monthly scan. Put it in the cookie policy, in the section that lists the cookies.
 */
add_shortcode(
	'cookie_declaration',
	function () {
		$cbid = bbq_cookiebot_id();
		if ( '' === $cbid ) {
			return '';
		}
		return '<div class="cookie-declaration"><script id="CookieDeclaration" src="' . esc_url( 'https://consent.cookiebot.com/' . $cbid . '/cd.js' ) . '" type="text/javascript" async></script></div>';
	}
);
