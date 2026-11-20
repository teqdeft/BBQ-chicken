<?php
/**
 * Site-wide settings that aren't printed in the header or footer (Appearance → bb.q settings).
 * Read them anywhere with bbq_opt( 'key', 'default' ).
 */
defined( 'ABSPATH' ) || exit;

bbq_section( 'Delivery map (home page)' );
bbq_get( 'map_lat', '40.4168', 'Map centre: latitude', 'text', array( 'help' => 'Madrid by default.' ) );
bbq_get( 'map_lng', '-3.7038', 'Map centre: longitude' );
bbq_get( 'map_zoom', '13', 'Zoom level (desktop; one less on phones)' );
bbq_get( 'map_radius', '2400', 'Delivery circle radius (metres)' );
bbq_get( 'map_gmaps_key', '', 'Google Maps API key', 'text', array( 'help' => 'With a key the map uses Google Maps (dark style). Without one it uses Esri\'s dark tiles, which need an ArcGIS account for production use.' ) );
