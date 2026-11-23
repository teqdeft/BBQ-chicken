<?php
/**
 * Shared setup for the franchise sections (included by each of them).
 */
defined( 'ABSPATH' ) || exit;
// Line icons of the page's sprite (below). Editors pick one per criterion, benefit and step.
$icon_choices = array(
	'store'     => 'Shop',
	'buildings' => 'Buildings',
	'coin'      => 'Coin',
	'coins'     => 'Coins',
	'pin'       => 'Map pin',
	'cog'       => 'Cog',
	'cap'       => 'Graduation cap',
	'truck'     => 'Truck',
	'megaphone' => 'Megaphone',
	'file'      => 'Document',
	'clipboard' => 'Clipboard',
	'rocket'    => 'Rocket',
);
$marquee_fields = array(
	'text'   => array( 'html', 'Text' ),
	'strong' => array( 'toggle', 'Bold' ),
);
?>
<?php if ( empty( $GLOBALS['bbq_franchise_sprite'] ) ) : $GLOBALS['bbq_franchise_sprite'] = true; ?>
<!-- Icon sprite (line icons used on this page) -->
<svg class="icon-sprite" aria-hidden="true" focusable="false">
  <symbol id="i-store" viewBox="0 0 24 24"><path d="M4.5 11v9.5h15V11"/><path d="M2.5 9.5 4.5 4h15l2 5.5a2.75 2.75 0 0 1-5 1.6 3 3 0 0 1-4.5 0 3 3 0 0 1-4.5 0 2.75 2.75 0 0 1-5-1.6Z"/><path d="M9.75 20.5v-5h4.5v5"/></symbol>
  <symbol id="i-buildings" viewBox="0 0 24 24"><path d="M2.5 21h19"/><path d="M4.5 21V6.5L12 3v18"/><path d="M12 9.5l7.5 2.5V21"/><path d="M7.5 8.5h1.5M7.5 12h1.5M7.5 15.5h1.5M15 14.5h1.5M15 18h1.5"/></symbol>
  <symbol id="i-coin" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9.5"/><path d="M15.6 8.7a4.6 4.6 0 1 0 0 6.6"/><path d="M7.4 10.9h5.6M7.4 13.4h4.8"/></symbol>
  <symbol id="i-pin" viewBox="0 0 24 24"><path d="M12 21.5s-7-6.3-7-12a7 7 0 0 1 14 0c0 5.7-7 12-7 12Z"/><circle cx="12" cy="9.5" r="2.6"/></symbol>
  <symbol id="i-cog" viewBox="0 0 24 24"><path d="M18.93 9.39 21.76 9.82v4.36l-2.83.43-.19.44 1.7 2.31-3.08 3.08-2.31-1.7-.44.19-.43 2.83H9.82l-.43-2.83-.44-.19-2.31 1.7-3.08-3.08 1.7-2.31-.19-.44-2.83-.43V9.82l2.83-.43.19-.44-1.7-2.31 3.08-3.08 2.31 1.7.44-.19.43-2.83h4.36l.43 2.83.44.19 2.31-1.7 3.08 3.08-1.7 2.31Z"/><circle cx="12" cy="12" r="3.2"/></symbol>
  <symbol id="i-cap" viewBox="0 0 24 24"><path d="M1.5 9.5 12 4.5l10.5 5L12 14.5Z"/><path d="M5.5 11.5v4.8c0 1.6 2.9 3.2 6.5 3.2s6.5-1.6 6.5-3.2v-4.8"/><path d="M22.5 9.5v5.5"/></symbol>
  <symbol id="i-truck" viewBox="0 0 24 24"><path d="M14 16.5V5H2v11.5h2.5"/><path d="M14 8.5h4l4 4.5v3.5h-2"/><path d="M8.5 16.5H15"/><circle cx="6.5" cy="17" r="2"/><circle cx="18" cy="17" r="2"/></symbol>
  <symbol id="i-megaphone" viewBox="0 0 24 24"><path d="M3 9.5h3.5L16 4.5v15l-9.5-5H3Z"/><path d="M6.5 14.5 8 20h3l-1.2-4.6"/><path d="M19 9a4.2 4.2 0 0 1 0 6"/></symbol>
  <symbol id="i-coins" viewBox="0 0 24 24"><ellipse cx="12" cy="6" rx="8" ry="3"/><path d="M4 6v12c0 1.7 3.6 3 8 3s8-1.3 8-3V6"/><path d="M4 12c0 1.7 3.6 3 8 3s8-1.3 8-3"/></symbol>
  <symbol id="i-file" viewBox="0 0 24 24"><path d="M14 2.5H6.5a1.5 1.5 0 0 0-1.5 1.5v16a1.5 1.5 0 0 0 1.5 1.5h11a1.5 1.5 0 0 0 1.5-1.5V7.5Z"/><path d="M14 2.5v5h5"/><path d="M8.5 12.5h7M8.5 16h5"/></symbol>
  <symbol id="i-clipboard" viewBox="0 0 24 24"><rect x="8" y="2.5" width="8" height="4" rx="1"/><path d="M16 4.5h2a2 2 0 0 1 2 2v13a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-13a2 2 0 0 1 2-2h2"/><path d="m8.75 14 2.25 2.25 4.25-4.5"/></symbol>
  <symbol id="i-rocket" viewBox="0 0 24 24"><path d="M5 15.5c-1.5 1.3-2 5-2 5s3.7-.5 5-2c.7-.8.7-2.1-.1-2.9a2.1 2.1 0 0 0-2.9-.1Z"/><path d="m12 15-3-3a22 22 0 0 1 2-4A12.9 12.9 0 0 1 22 2c0 2.7-.8 7.5-6 11a22.4 22.4 0 0 1-4 2Z"/><path d="M9 12H4s.6-3 2-4c1.6-1.1 5 0 5 0"/><path d="M12 15v5s3-.6 4-2c1.1-1.6 0-5 0-5"/></symbol>
</svg>
<?php endif; ?>
