<?php


/* Problem mit Enfold: */

  require_once 'library/inc.kundenfunktionen.php';
  require_once 'library/inc.overwrite_plugin.php';
  require_once 'library/inc.disable_tribe_js.php';


/* https://theeventscalendar.com/support/forums/topic/counting-posts/ */
function tribe_count_by_cat ( $event_category_slug ) {

    if ( ! class_exists('Tribe__Events__Main') ) return false;


    $tax_query = array(    'taxonomy'    => Tribe__Events__Main::TAXONOMY,
                        'field'        => 'slug',
                        'terms'        => $event_category_slug );

      $args = array( 'post_type' => Tribe__Events__Main::POSTTYPE, 'post_status' => 'publish', 'tax_query' => array( $tax_query ), 'posts_per_page' => -1);

    $query = new WP_Query( $args );

    return $query->found_posts;
}



/**
 * Test if the current widget is an Advanced List Widget and fix the event limit if it is.
 */
function increase_event_widget_limit(array $instance, $widget) {
    if (is_a($widget, 'Tribe__Events__Pro__Advanced_List_Widget'))
        $instance['limit'] = 30;

    return $instance;
}
add_filter('avf_title_args', 'fix_blog_page_title', 10, 2);




/* eingefügt am 8.3.2017: */
function wpb_remove_version() {
return '';
}
add_filter('the_generator', 'wpb_remove_version');




/*----------------------------------------------------------------*/
/* Start: PHP in Text-Widget nutzen
/* Datum: 05.04.2018
/* Autor: hgg
/*----------------------------------------------------------------*/
add_filter('widget_text', 'gibmirphp', 99);
function gibmirphp($text) {
  if (strpos($text, '<' . '?') !== false) {
    ob_start();
     eval('?' . '>' . $text);
     $text = ob_get_contents();
    ob_end_clean();
  }
  return $text;
}
/*----------------------------------------------------------------*/
/* Ende: PHP in Text-Widget nutzen
/* Datum: 05.04.2018
/* Autor: hgg
/*----------------------------------------------------------------*/


/*----------------------------------------------------------------*/
/* Start: eigenes Schlagwörter-Widget mit weiteren Parametern nutzen
/* Datum: 17.12.2018
/* Autor: hgg
/*----------------------------------------------------------------*/
class Schlagwort_widget extends WP_Widget {

    function __construct() {
        parent::__construct(
                'Schlagwort-widget', // Base ID
                'Schlagwort-Wolke', // Name
                array('description' => __('eigene Schlagwort-Wolke (hgg) mit mehreren Parametern'),) // Args
        );
    }

    public function widget($args, $instance) {
        extract($args);

        /* Display Widget */
        $kleinste = ! empty( $instance['smallest'] ) ? $instance['smallest'] : 8;
        $groesste = ! empty( $instance['largest'] ) ? $instance['largest'] : 22;
        $titel = ! empty( $instance['title'] ) ? $instance['title'] : 'Schlagwörter';
        $anzahl = ! empty( $instance['number'] ) ? $instance['number'] : 35;
        $einheit = ! empty( $instance['unit'] ) ? $instance['unit'] : 'pt';
        $sortiert = ! empty( $instance['orderby'] ) ? $instance['orderby'] : 'name';
        ?>
        <div class="sidebar_widget">
           <?php
           echo '<h3 class="widget-title">' . $titel . '</h3>';
           wp_tag_cloud('smallest=' . $kleinste . '&largest=' . $groesste . '&unit=' . $einheit . '&number=' . $anzahl . '&orderby=' . $sortiert);
           ?>
           <!-- Your Content goes here -->

        </div>

        <?php

    }

    public function update($new_instance, $old_instance) {

        $instance = $old_instance;

        /* Strip tags to remove HTML (important for text inputs). */
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : 'Schlagwörter';
        $instance['smallest'] = ( ! empty( $new_instance['smallest'] ) ) ? sanitize_text_field( $new_instance['smallest'] ) : 10;
        $instance['largest'] = ( ! empty( $new_instance['largest'] ) ) ? sanitize_text_field( $new_instance['largest'] ) : 25;
        $instance['number'] = ( ! empty( $new_instance['number'] ) ) ? sanitize_text_field( $new_instance['number'] ) : 50;
        $instance['unit'] = ( ! empty( $new_instance['unit'] ) ) ? sanitize_text_field( $new_instance['unit'] ) : 'pt';
        $instance['orderby'] = ( ! empty( $new_instance['orderby'] ) ) ? sanitize_text_field( $new_instance['orderby'] ) : 'name';

        /* No need to strip tags for.. */

        return $instance;
    }

    public function form($instance) {

        $title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Schlagwörter', 'text_domain' );
        $number = ! empty( $instance['number'] ) ? $instance['number'] : esc_html__( '40', 'text_domain' );
        $smallest = ! empty( $instance['smallest'] ) ? $instance['smallest'] : esc_html__( '10', 'text_domain' );
        $largest = ! empty( $instance['largest'] ) ? $instance['largest'] : esc_html__( '25', 'text_domain' );
        $unit = ! empty( $instance['unit'] ) ? $instance['unit'] : esc_html__( 'pt', 'text_domain' );
        $orderby = ! empty( $instance['orderby'] ) ? $instance['orderby'] : esc_html__( 'name', 'text_domain' );

        ?>

        <!-- Title: Text Input -->
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Titel:', 'text_domain' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php esc_attr_e( 'Anzahl Schlagwörter:', 'text_domain' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'smallest' ) ); ?>"><?php esc_attr_e( 'Kleinste Schriftgröße:', 'text_domain' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'smallest' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'smallest' ) ); ?>" type="text" value="<?php echo esc_attr( $smallest ); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'largest' ) ); ?>"><?php esc_attr_e( 'Größte Schriftgröße:', 'text_domain' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'largest' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'largest' ) ); ?>" type="text" value="<?php echo esc_attr( $largest ); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'unit' ) ); ?>"><?php esc_attr_e( 'Einheit (pt, px, em, %):', 'text_domain' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'unit' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'unit' ) ); ?>" type="text" value="<?php echo esc_attr( $unit ); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>"><?php esc_attr_e( 'Sortiert (name, count):', 'text_domain' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'orderby' ) ); ?>" type="text" value="<?php echo esc_attr( $orderby ); ?>">
        </p>

        <!-- more Settings goes here! -->

        <?php
    }

}

add_action('widgets_init', create_function('', 'register_widget( "Schlagwort_widget" );'));
/*----------------------------------------------------------------*/
/* Ende: Schlagwörter-Widget nutzen
/* Datum: 17.12.2018
/* Autor: hgg
/*----------------------------------------------------------------*/




/*----------------------------------------------------------------*/
/* Start: shortcodes für Anzahl Veranstaltungen und Beiträge
/* Datum: 18.12.2018
/* Autor: hgg
/*----------------------------------------------------------------*/

// Display the total number of published posts using the shortcode [published-posts-count]
function customprefix_total_number_published_posts($atts) {
    return wp_count_posts('post')->publish;
}
add_shortcode('published-posts-count', 'customprefix_total_number_published_posts');


// Display the total number of published events using the shortcode [published-events-count]
function customprefix_total_number_published_events($atts) {
    return wp_count_posts('tribe_events')->publish;
}
add_shortcode('published-events-count', 'customprefix_total_number_published_events');
/*----------------------------------------------------------------*/
/* Ende: shortcodes für Anzahl Veranstaltungen und Beiträge
/* Datum: 18.12.2018
/* Autor: hgg
/*----------------------------------------------------------------*/

/*----------------------------------------------------------------*/
/* Start: shortcode für Copyright, Link, Link Kinderflohmärkte, Link Veranstaltungsliste, Link Ferien
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

function beitrags_fuss($atts) {
  	$werte = shortcode_atts( array(
  	  'link' => 'keine Webseite',
      'kfm' => 'nein',
      'vl' => 'nein',
      'ferien' => 'nein',
      'il' => 'keine Webseite',
  	  ), $atts);
    $ausgabe = '<br><strong>keine Webseite angegeben</strong>';

    if ( $werte['link'] != 'keine Webseite' and trim($werte['link']) != '') {
      $ausgabe = '<br><a href=' . $werte['link'] . ' target="_blank">Mehr Infos</a>';
    }
    $ausgabe = $ausgabe . '<br><br><em>' . get_post(get_post_thumbnail_id())->post_excerpt . '</em><br>';
    if ( $werte['kfm'] != 'nein' ) {
      $ausgabe = $ausgabe . '<p class="button-absatz-fuss"><a class="tribe-events-button-beitrag" href="https://aachenerkinder.de/veranstaltungen/kategorie/flohmarkt/Karte">Weitere Kinderflohmärkte</a></p>';
    }
    if ( $werte['vl'] != 'nein' ) {
      $ausgabe = $ausgabe . '<p class="button-absatz-fuss"><a class="tribe-events-button-beitrag" href="https://aachenerkinder.de/veranstaltungen/kategorie/terminanzeige/">Weitere Veranstaltungen</a></p>';
    }
    if ( $werte['ferien'] != 'nein' ) {
      $ausgabe = $ausgabe . '<p class="button-absatz-fuss"><a class="tribe-events-button-beitrag" href="https://aachenerkinder.de/veranstaltungen/kategorie/ferien/">Weitere Ferienangebote</a></p>';
    }
    if ( $werte['il'] != 'keine Webseite' and trim($werte['il']) != '') {
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


/* Korrektur des Datum-Zeit-Problems bei Veranstaltungen, wenn man den Block (Gutenberg) verwendet */
add_action('admin_head', function(){
    echo "<style>.tribe-editor__date-time .editor-block-list__block > .editor-block-list__insertion-point { top: 50px; }</style>";
});


/*----------------------------------------------------------------*/
/* Start: Text vor dem loop
/* Datum: 22.12.2018
/* Autor: hgg
/*----------------------------------------------------------------*/
// Add some text after the header - für theme customizr
add_action( '__before_loop' , 'add_promotional_text' );
function add_promotional_text() {
  // If we're not on the home page, do nothing
  if ( !is_front_page() )
    return;
  // Echo the html
  echo "<div class='ackids'><strong>aachenerkinder.de</strong> - Internetportal für Familien und Kinder in der Städteregion Aachen und Umgebung mit Freizeitangeboten und Veranstaltungen, Terminen, vielen Infos und Tipps – Online-Familienzeitung.</div><br>";
}
/*----------------------------------------------------------------*/
/* Ende: Text vor dem loop
/* Datum: 22.12.2018
/* Autor: hgg
/*----------------------------------------------------------------*/


/*----------------------------------------------------------------*/
/* Start: Anzeige image in der Beitragsliste
/* Datum: 25.12.2018
/* Autor: hgg
/*----------------------------------------------------------------*/

add_filter('manage_posts_columns', 'add_img_column');
add_filter('manage_posts_custom_column', 'manage_img_column', 10, 2);

function add_img_column($columns) {
  $columns = array_slice($columns, 0, 1, true) + array("img" => "Beitragsbild") + array_slice($columns, 1, count($columns) - 1, true);
  return $columns;
}

function manage_img_column($column_name, $post_id) {
 if( $column_name == 'img' ) {
  echo get_the_post_thumbnail($post_id, 'thumbnail');
 }
 return $column_name;
}

/*----------------------------------------------------------------*/
/* Ende: Anzeige image in der Beitragsliste
/* Datum: 25.12.2018
/* Autor: hgg
/*----------------------------------------------------------------*/

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

?>
