<?php

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
