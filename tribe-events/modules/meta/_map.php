<?php
/**
 * Single Event Meta (Map) Template
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe-events/modules/meta/map.php
 *
 * @package TribeEventsCalendar
 * @version 4.4
 */

$map = tribe_get_embedded_map();

if ( empty( $map ) ) {
	return;
}

?>

<div class="tribe-events-venue-map"> 
	<?php
	// Zeigt Openstreetmap:
  $address = tribe_get_address( $venue_id ).", ".tribe_get_zip( $venue_id )." ".tribe_get_city( $venue_id ).", ".tribe_get_country( $venue_id );
  $shortcode = '[leaflet-map zoomcontrol address="'.$address.'" zoom="14"]';
  /* $shortcode = '[leaflet-map zoomcontrol address="'.$address.'" zoom="16? fit_markers="1?]'; */
  $shortcode .= '[leaflet-marker address="'.$address.', DE"]';
  echo do_shortcode($shortcode);
/*
	do_action( 'tribe_events_single_meta_map_section_start' );
  $str = '[leaflet-map lat=x lng=y zoom=5]';
  $address = $venue->venue_name.", ".$venue->venue_address.", ".$venue->venue_country."-".$venue->venue_postal_code." ".$venue->venue_city;
  $str .= ' [leaflet-marker address="'.$address.', DE"]
  '.$venue->venue_name.'[/leaflet-marker]';
  echo do_shortcode($str);
  /*
  $address = tribe_get_address( $venue_id ).", ".tribe_get_zip( $venue_id )." ".tribe_get_city( $venue_id ).", ".tribe_get_country( $venue_id ); 
  $shortcode  = '[leaflet-map address="'.$address.'" zoom="15" fit_markers="1"]';
  $pin = '[leaflet-marker address="'.$address.', DE"]';
  echo do_shortcode($shortcode);
  /* echo do_shortcode($pin); */
	// echo $map;
  
	do_action( 'tribe_events_single_meta_map_section_end' );
	?>
</div>
