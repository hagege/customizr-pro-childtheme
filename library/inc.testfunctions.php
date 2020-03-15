<?php

/*----------------------------------------------------------------*/
/* Start: Meta-Boxen für Revisionen und Kommentare ausblenden 
/* Datum: 22.11.2019
/* Autor: hgg
/*----------------------------------------------------------------*/

function remove_meta_boxes() {
  # Removes meta from Posts #
  remove_meta_box('commentstatusdiv','post','normal');
  remove_meta_box('commentsdiv','post','normal');
  remove_meta_box('revisionsdiv', 'post', 'normal' );
}
add_action('admin_init','remove_meta_boxes');
/*----------------------------------------------------------------*/
/* Ende: Meta-Boxen für Revisionen und Kommentare ausblenden 
/* Datum: 22.11.2019
/* Autor: hgg
/*----------------------------------------------------------------*/


?>