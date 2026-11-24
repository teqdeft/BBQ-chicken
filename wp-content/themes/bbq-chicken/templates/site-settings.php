<?php
/**
 * Site-wide settings that aren't printed in the header or footer (Website settings, ACF options page).
 * Read them anywhere with bbq_opt( 'key', 'default' ).
 */
defined( 'ABSPATH' ) || exit;

bbq_section( 'Delivery map (home page)' );
bbq_get( 'map_lat', '40.4319', 'Map centre: latitude', 'text', array( 'help' => 'The middle of the three Madrid kitchens by default.' ) );
bbq_get( 'map_lng', '-3.6831', 'Map centre: longitude' );
bbq_get( 'map_zoom', '12', 'Zoom level (desktop; one less on phones)' );
bbq_get( 'map_radius', '4600', 'Delivery circle radius (metres)' );
bbq_get( 'map_pins', "40.4409, -3.6753\n40.3971, -3.6660\n40.4577, -3.7080", 'Kitchens on the map (one per line: latitude, longitude)', 'textarea', array( 'help' => 'One pin per kitchen. Madrid: Calle Zabaleta 1, Calle Felipe Fraile 5 and Calle José Calvo 10. Empty = these three.' ) );
bbq_get( 'map_gmaps_key', '', 'Google Maps API key', 'text', array( 'help' => 'With a key the map uses Google Maps (dark style). Without one it uses Esri\'s dark tiles, which need an ArcGIS account for production use.' ) );

bbq_section( 'Cookie consent (Cookiebot)' );
bbq_get( 'cookiebot_id', '', 'Cookiebot ID', 'text', array( 'help' => 'The Domain Group ID from your Cookiebot account (Settings → Your scripts), e.g. 1a2b3c4d-1a2b-3c4d-5e6f-1a2b3c4d5e6f. With it the cookie banner appears, Google\'s tags wait for consent and the footer link "Cookie settings" reopens the banner. Put [cookie_declaration] in the cookie policy for Cookiebot\'s list of cookies. Empty = no banner.' ) );
