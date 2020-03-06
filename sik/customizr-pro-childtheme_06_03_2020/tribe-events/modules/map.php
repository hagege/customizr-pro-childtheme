<?php
/**
 * Template used for maps embedded within single events and venues.
 * Override this template in your own theme by creating a file at:
 *
 *     [your-theme]/tribe-events/modules/map.php
 *
 * @version 4.6.19
 *
 * @var $index
 * @var $width
 * @var $height
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$address = tribe_get_address( $venue_id ).", ".tribe_get_zip( $venue_id )." ".tribe_get_city( $venue_id ).", ".tribe_get_country( $venue_id );
$shortcode = '[leaflet-map zoomcontrol address="'.$address.'" zoom="14"]';
  /* $shortcode = '[leaflet-map zoomcontrol address="'.$address.'" zoom="16? fit_markers="1?]'; */
$shortcode .= '[leaflet-marker address="'.$address.', DE"]';
/* $shortcode  = '[leaflet-map address="'.$address.'" zoom="15" fit_markers="1"]'; */
echo do_shortcode($shortcode);
?>
