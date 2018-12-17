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
