<?php
/**
 * Google Tag Manager (container GTM-MTGPBSTM), printed at the top of <head> on every page of the site.
 * Left out on local development hosts (localhost, *.test …, see bbq_is_local_host()) so test visits
 * don't end up in the statistics.
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'wp_head',
	function () {
		if ( bbq_is_local_host() ) {
			return;
		}
		?>
<script async src="https://www.googletagmanager.com/gtm.js?id=GTM-MTGPBSTM"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
</script>
		<?php
	},
	1
);
