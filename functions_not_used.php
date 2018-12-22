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



/* Anzeige des Datums bei Beiträgen */ 
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
/* Start: Veröffentlichungsdatum bei der Einzelansicht
/* Datum: 22.12.2018
/* Autor: hgg
/* funktioniert zwar, aber die Ausgabe erfolgt zusätzlich oben im Menü
/*----------------------------------------------------------------*/
function loop_mit_datum( $query ) {
  echo 'Veröffentlicht: ' . get_the_date();
}


add_action( 'pre_get_posts', 'loop_mit_datum' );
/*----------------------------------------------------------------*/
/* Start: Veröffentlichungsdatum bei der Einzelansicht
/* Datum: 22.12.2018
/* Autor: hgg
/*----------------------------------------------------------------*/


/*----------------------------------------------------------------*/
/* Start: Veröffentlichungsdatum und -autor bei der Einzelansicht
/* Datum: 22.12.2018
/* Autor: hgg
/* funktioniert zwar, aber die Ausgabe erfolgt zusätzlich oben im Menü
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
			esc_html_x( 'Veröffentlicht am %s', 'post date', 'theme-slug' ),
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
		$posted_by = sprintf( esc_html_x( 'Veröffentlicht von %s', 'post author', 'theme-slug' ), $author );
		return '<span class="meta-author"> ' . $posted_by . '</span>';
	}
endif;


/*----------------------------------------------------------------*/
/* Start: Veröffentlichungsdatum bei der Einzelansicht
/* Datum: 22.12.2018
/* Autor: hgg
/*----------------------------------------------------------------*/

?>

