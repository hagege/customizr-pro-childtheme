<?php


/*----------------------------------------------------------------*/
/* Start: shortcode für Copyright, Link, Link Kinderflohmärkte, Link Veranstaltungsliste, Link Ferien, interner Link
/* Datum: 23.2.2019
/* Autor: hgg
/*----------------------------------------------------------------*/
// Zeigt bei einer Veranstaltung oder einem Beitrag automatisch den Text aus "Beschriftung" in kursiv
// Aufruf-Beispiele:
// [fuss link="https://aachen50plus.de" kfm="" vl=""] --> zeigt immer Bildnachweis, dann Mehr Infos mit dem Link und bei kfm="ja" den Link zu "weiteren Kinderflohmärkten" und bei vl="ja" den Link zu "Weitere Veranstaltungen"
// [fuss kfm=""] --> zeigt immer Bildnachweis, dann "keine Webseite angegeben" und bei kfm="ja" den Link zu "weiteren Kinderflohmärkten"
// [fuss] --> zeigt immer Bildnachweis, dann "keine Webseite angegeben" und keinen Link zu "weiteren Kinderflohmärkten"
// erweitert: hgg, 5.3.2019:
// [fuss ferien=""] --> zeigt immer Bildnachweis, dann "keine Webseite angegeben" und bei ferien="ja" den Link zu "weitere Ferienangebote"
// Formatierung der Buttons geändert: Nicht mehr untereinander, sondern nebeneiander und die Buttons per CSS in der style.css mit einem Rand versehen
// erweitert: hgg, 22.3.2019: il steht für interner Link
// [fuss il="https://aachenerkinder.de/freizeitangebote/"] --> zeigt immer Bildnachweis, dann "keine Webseite angegeben" und bei il="https://aachenerkinder.de/freizeitangebote/" den (internen) Link zu einer anderen Seite
// Formatierung der Buttons geändert: Nicht mehr untereinander, sondern nebeneiander und die Buttons per CSS in der style.css mit einem Rand versehen
// erweitert: hgg, 29.3.2019: zusätzlich kann bei vl die Kategorie angeben werden, so dass bei Klick auf den Link sofort die Veranstaltungen der jeweiligen Kategorie angezeigt werden, z. B.
// [fuss link="http://www.melan.de/go/standort-detail/1-flohmarkt-troedelmarkt-in-aachen-altstadt.html" kfm="ja" vl="Familie" il="https://aachenerkinder.de/service/wetter/"]

/*
function beitrags_fuss($atts) {
  	$werte = shortcode_atts( array(
  	  'link' => '',
      'kfm' => 'nein',
      'vl' => 'nein',
      'ferien' => 'nein',
      'il' => '',
  	  ), $atts);
    $ausgabe = '';
    $veranstaltungen = 'https://aachenerkinder.de/veranstaltungen/kategorie/';
    $kategorien = cliff_get_events_taxonomies();

    if ( trim($werte['link']) != '') {
      $ausgabe = '<br><a href=' . $werte['link'] . ' target="_blank">Mehr Infos</a>';
    }
    $ausgabe = $ausgabe . '<br><br><em>' . get_post(get_post_thumbnail_id())->post_excerpt . '</em><br>';
    if ( $werte['kfm'] != 'nein' ) {
      $ausgabe = $ausgabe . '<p class="button-absatz-fuss"><a class="tribe-events-button-beitrag" href="https://aachenerkinder.de/veranstaltungen/kategorie/flohmarkt/Karte">Weitere Kinderflohmärkte</a></p>';
    }
    if ( $werte['vl'] != 'nein' ) {
      if ( trim($werte['vl']) != '') {
        // Leerzeichen werden ggfs. durch "-" ersetzt (Sicherheitsmaßnahme bei Eingabe von Kategorien, die Leerzeichen enthalten, z. B. "Feiern und Feste") //
        $vergleichswert = $werte['vl'];
        // wenn der Vergleichswert im Array der Kategorien enthalten ist: //
        if (in_array($vergleichswert, $kategorien )){
          // Sonderzeichen ersetzen //
          $werte['vl'] = sonderzeichen ($werte['vl']);
          $veranstaltungen = $veranstaltungen . str_replace(" ", "-", $werte['vl']);
          $vergleichswert = ': ' . $vergleichswert . '';
          }
        else {
          $veranstaltungen = $veranstaltungen . 'terminanzeige';
          $vergleichswert = '';
          }
      }
      $ausgabe = $ausgabe . '<p class="button-absatz-fuss"><a class="tribe-events-button-beitrag" href=' . $veranstaltungen . ' target="_blank">Weitere Veranstaltungen' . $vergleichswert . '</a></p>';
    }

    if ( $werte['ferien'] != 'nein' ) {
      $ausgabe = $ausgabe . '<p class="button-absatz-fuss"><a class="tribe-events-button-beitrag" href="https://aachenerkinder.de/veranstaltungen/kategorie/ferien/">Weitere Ferienangebote</a></p>';
    }
    if ( trim($werte['il']) != '') {
       $ausgabe = $ausgabe . '<p class="button-absatz-fuss"><a class="tribe-events-button-beitrag" href=' . $werte['il'] . ' target="_blank">Mehr Infos auf dieser Seite</a></p><hr>';
    }
    $ausgabe = $ausgabe . '<hr>';
	return $ausgabe;
}
add_shortcode('fuss', 'beitrags_fuss');
/*----------------------------------------------------------------*/
/* Ende: shortcode für Copyright, Link, Link Kinderflohmärkte, Link Veranstaltungsliste, Link Ferien
/* Datum: 23.2.2019
/* Autor: hgg
/*----------------------------------------------------------------*/


/**
  * The Events Calendar: See all Events Categories - var_dump at top of Events archive page
  * Screenshot: https://cl.ly/0Q0B1D0g2a43
  *
  * for https://theeventscalendar.com/support/forums/topic/getting-list-of-event-categories/
  *
  * From https://gist.github.com/cliffordp/36d2b1f5b4f03fc0c8484ef0d4e0bbbb
  */
/*
add_action( 'tribe_events_before_template', 'cliff_get_events_taxonomies' );
function cliff_get_events_taxonomies(){
	if( ! class_exists( 'Tribe__Events__Main' ) ) {
		return false;
	}

	$tecmain = Tribe__Events__Main::instance();

	// https://developer.wordpress.org/reference/functions/get_terms/
	$cat_args = array(
		'hide_empty' => true,
	);
	$events_cats = get_terms( $tecmain::TAXONOMY, $cat_args );

	if( ! is_wp_error( $events_cats ) && ! empty( $events_cats ) && is_array( $events_cats) ) {
		$events_cats_names = array();
		foreach( $events_cats as $key => $value ) {
			$events_cats_names[] = $value->name;
		}

	   // var_dump( $events_cats_names );  Anzeige der Kategorien //
	}
  return $events_cats_names;
}

/* Umlaute umwandeln, damit z. B. Führung in Fuehrung umgewandelt wird, weil sonst die Kategorieliste nicht gefunden wird. */
/*
function sonderzeichen($string)
{
   $string = str_replace("ä", "ae", $string);
   $string = str_replace("ü", "ue", $string);
   $string = str_replace("ö", "oe", $string);
   $string = str_replace("Ä", "Ae", $string);
   $string = str_replace("Ü", "Ue", $string);
   $string = str_replace("Ö", "Oe", $string);
   $string = str_replace("ß", "ss", $string);
   $string = str_replace("´", "", $string);
return $string;
}



/*----------------------------------------------------------------*/
/* Start: Wartungsmodus
/* Datum: 26.12.2018
/* Autor: hgg
/*----------------------------------------------------------------*/
/*
function wpr_maintenance_mode() {
 if ( !current_user_can( 'edit_themes' ) || !is_user_logged_in() ) {
  ?><div style="width: 100%; height: 100%; overflow: hidden; background-image: url(http://aachener-senioren.de/_test_/wp-content/uploads/2016/07/platzhalter_ferien_ocean-1149981_1280.jpg)">
  <?php
  $meldung = "<h1 style=\"text-align: center\">aachenerkinder.de</h1><p style=\"text-align: center\">Sorry, die Webseite befindet sich zur Zeit im Wartungsmodus.<br>Wir ändern gerade die Optik der Seite, aber außer der Optik ändert sich nichts.<br><br>Es wird leider noch ein wenig dauern, bis die Seite wieder zur Verfügung steht.<br>Wir gehen davon aus, dass aachenerkinder.de um ca. 6.30 Uhr wieder online ist.<br>Danke für Dein Verständnis.<br><br>Foto: pixabay.com</div>";
  wp_die($meldung);
 }
}
add_action('get_header', 'wpr_maintenance_mode');
*/
/*----------------------------------------------------------------*/
/* Ende: Wartungsmodus
/* Datum: 26.12.2018
/* Autor: hgg
/*----------------------------------------------------------------*/


/* nicht genutzte (ng) oder nicht funktionierende (nf) Snippets */



/* nf */
function wp_change_date($content) {
if (is_single() && get_post_type() == 'post') {
	$article_made = get_the_date('U');
	$article_updated = get_post_modified_time('U');

	// Nur anzeigen, wenn Aktualisierung nach mehr als drei Tagen erfolgte
	if (($article_updated - $article_made) > 259200)
	{
		$content = 'Artikel aktualisiert am ' . get_the_modified_date('d.m.Y') . $content;
	}
}
return $content;
}
add_filter('the_content', 'wp_change_date');



/* Anzeige des Datums bei Beitr�gen */
/* nf */
add_filter( 'tc_date_meta' , 'display_the_update_date');
function display_the_update_date() {
	return sprintf( '<a href="%1$s" title="updated %2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a>' ,
        esc_url( get_day_link( get_the_time( 'Y' ), get_the_time( 'm' ), get_the_time( 'd' ) ) ),
        esc_attr( get_the_modified_date('F j, Y') ),
        esc_attr( get_the_modified_date('c') ),
      	get_the_modified_date('F j, Y')
    );
}

/* nf */
function add_publish_dates( $the_date, $d, $post ) {
if ( is_int( $post) ) {
    $post_id = $post;
} else {
    $post_id = $post->ID;
}

return 'Posted on '. date( 'Y-d-m - h:j:s', strtotime( $the_date ) );
}
add_action( 'get_the_date', 'add_publish_dates', 10, 3 );


/*----------------------------------------------------------------*/
/* Start: Ver�ffentlichungsdatum bei der Einzelansicht
/* Datum: 22.12.2018
/* Autor: hgg
/* funktioniert zwar, aber die Ausgabe erfolgt zus�tzlich oben im Men�
/*----------------------------------------------------------------*/
function loop_mit_datum( $query ) {
  echo 'Ver�ffentlicht: ' . get_the_date();
}


add_action( 'pre_get_posts', 'loop_mit_datum' );
/*----------------------------------------------------------------*/
/* Start: Ver�ffentlichungsdatum bei der Einzelansicht
/* Datum: 22.12.2018
/* Autor: hgg
/*----------------------------------------------------------------*/


/*----------------------------------------------------------------*/
/* Start: Ver�ffentlichungsdatum und -autor bei der Einzelansicht
/* Datum: 22.12.2018
/* Autor: hgg
/* funktioniert zwar, aber die Ausgabe erfolgt zus�tzlich oben im Men�
/* https://themecoder.de/2017/11/02/datum-und-autor-von-beitraegen-im-wordpress-theme-anzeigen/
/*----------------------------------------------------------------*/
function loop_mit_datum( $query ) {
	$postmeta = theme_slug_entry_date();
	$postmeta .= theme_slug_entry_author();
	echo '<div class="entry-meta">' . $postmeta . '</div>';
}
add_action( 'pre_get_posts', 'loop_mit_datum' );


if ( ! function_exists( 'theme_slug_entry_date' ) ) :
	/**
	* Displays the post date
	*/
	function theme_slug_entry_date() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">;  (Aktualisiert: ' . '%4$s</time>) --- ';
		}
		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);
		$posted_on = sprintf(
			esc_html_x( 'Ver�ffentlicht am %s', 'post date', 'theme-slug' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);
    return '<span class="meta-date">' . $posted_on . '</span>';
	}
endif;

if ( ! function_exists( 'theme_slug_entry_author' ) ) :
	/**
	 * Displays the post author
	 */
	function theme_slug_entry_author() {
		$author = sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" rel="author">%2$s</a></span>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_html( get_the_author() )
		);
		$posted_by = sprintf( esc_html_x( 'Ver�ffentlicht von %s', 'post author', 'theme-slug' ), $author );
		return '<span class="meta-author"> ' . $posted_by . '</span>';
	}
endif;


/*----------------------------------------------------------------*/
/* Start: Ver�ffentlichungsdatum bei der Einzelansicht
/* Datum: 22.12.2018
/* Autor: hgg
/*----------------------------------------------------------------*/


/*----------------------------------------------------------------*/
/* Start: eigenes Anzahl Veranstaltungen-Widget
/* Datum: 18.12.2018
/* Autor: hgg
/*----------------------------------------------------------------*/
class anzahl_widget extends WP_Widget {

    function __construct() {
        parent::__construct(
                'anzahl-widget', // Base ID
                'Anzahl Events', // Name
                array('description' => __('eigenes Widget Anzahl Veranstaltungen / Freizeitmöglichkeiten (hgg)'),) // Args
        );
    }

    public function widget($args, $instance) {
        extract($args);

        /* Display Widget */
        /* $anzahl_events = ! empty( $instance['anzahl_events'] ) ? $instance['anzahl_events'] : wp_count_posts('tribe_events'); */
        /* die Schleife ist eigentlich nur notwendig, wenn das Widget noch nicht eingerichtet war */
        if (empty($instance['anzahl_freizeit'])) {
          $anzahl_events = wp_count_posts('tribe_events');
          $anzahl_events = $anzahl_events->publish;
          $instance['anzahl_events'] = $anzahl_events;
          $anzahl_posts = wp_count_posts('post');
          $anzahl_posts = $anzahl_posts->publish;
          $instance['anzahl_posts'] = $anzahl_posts;
          $instance['anzahl_freizeit'] = 407;
        }

        ?>

        <hr>
        <div class="sidebar_widget">
          <span class="gross"><?php echo $instance['anzahl_events']; ?>
          </span> Termine und Veranstaltungen<br>
          <span class="gross"><?php echo $instance['anzahl_posts']; ?></span> Artikel<br>
          <span class="gross"><?php echo $instance['anzahl_freizeit']; ?></span> Freizeitangebote
           <!-- Your Content goes here -->
        </div>
        <hr>

        <?php

    }

    public function update($new_instance, $old_instance) {

        $instance = $old_instance;
        $anzahl_events = wp_count_posts('tribe_events');
        $anzahl_events = $anzahl_events->publish;
        $anzahl_posts = wp_count_posts('post');
        $anzahl_posts = $anzahl_posts->publish;

        /* Strip tags to remove HTML (important for text inputs). */
        $instance['anzahl_events'] = ( ! empty( $new_instance['anzahl_events'] ) ) ? sanitize_text_field( $new_instance['anzahl_events'] ) : $anzahl_events;
        $instance['anzahl_posts'] = ( ! empty( $new_instance['anzahl_posts'] ) ) ? sanitize_text_field( $new_instance['anzahl_posts'] ) : $anzahl_posts;
        $instance['anzahl_freizeit'] = ( ! empty( $new_instance['anzahl_freizeit'] ) ) ? sanitize_text_field( $new_instance['anzahl_freizeit'] ) : 407;

        /* No need to strip tags for.. */

        return $instance;
    }

    public function form($instance) {

        $anzahl_freizeit = ! empty( $instance['anzahl_freizeit'] ) ? $instance['anzahl_freizeit'] : esc_html__( '407', 'text_domain' );

        ?>

        <!-- Title: Text Input -->
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'anzahl_freizeit' ) ); ?>"><?php esc_attr_e( 'Anzahl Freizeitmöglichkeiten:', 'text_domain' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'anzahl_freizeit' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'anzahl_freizeit' ) ); ?>" type="text" value="<?php echo esc_attr( $anzahl_freizeit ); ?>">
        </p>

        <!-- more Settings goes here! -->

        <?php
    }

}

add_action('widgets_init', create_function('', 'register_widget( "anzahl_widget" );'));

/*----------------------------------------------------------------*/
/* Ende: eigenes Anzahl Veranstaltungen-Widget
/* Datum: 18.12.2018
/* Autor: hgg
/*----------------------------------------------------------------*/

?>
