<?php
/**
 * The template for displaying the 404 content
 */
?>
<header class="entry-header text-center" <?php czr_fn_echo('element_attributes') ?>>
  <h1 class="entry-title big-text-10 m-t-05"><?php _e( '404', 'customizr-pro') ?></h1>
  <h2><?php _e('Ooops, page not found', 'customizr-pro') ?></h2>
</header>
<hr class='featurette-divider'>
<article id="post-0" class="post error404 no-results not-found row text-center">
  <div class="tc-content col-12">
    <div class="entry-content">
      <!-- <p><?php _e( 'Sorry, but the requested page is not found. You might try a search below.' , 'customizr-pro' ) ?></p> -->
      <h2>Dieser Beitrag oder diese Veranstaltung existiert leider nicht mehr</h2>
      <p>Sorry - leider war der Beitrag schon sehr alt und wir haben den Beitrag daher gelöscht.<br>
        Im Interesse der Aktualität macht es bei manchen Beiträgen oder Veranstaltungen wenig Sinn, diese Beiträge oder Veranstaltungen ewig "mitzuschleppen".<br>
        Daher bist du jetzt auf dieser Seite gelandet.<br>
        Allerdings kannst du über die Suche ja mal einen Begriff eingeben, der mit der Thematik der gelöschten Seite zu tun hatte.<br>
        Möglicherweise erhältst du dann Treffer zu aktuelleren Beiträgen zu diesem Thema.
      </p>
      <!-- <a href="https://aachenerkinder.de/beitrag-existiert-nicht-mehr/?s=">Zur Suche</a> -->
      <?php get_search_form() ?>
    </div>
  </div>
</article>
