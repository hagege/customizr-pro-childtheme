<?php
/*
* Template Name: Kategorie-Auswahl
* http://localhost/ackids_50/wp-admin/post.php?post=61562&action=edit
* page-{id}.php siehe https://developer.wordpress.org/themes/template-files-section/page-template-files/
*
/**
 * The main template file. Includes the loop.
 *
 *
 * @package Customizr
 * @since Customizr 1.0
 */
if ( apply_filters( 'czr_ms', false ) ) {
  do_action( 'czr_ms_tmpl' );
  return;
}
?>
<?php do_action( '__before_main_wrapper' ); ##hook of the header with get_header ?>
<div id="main-wrapper" class="<?php echo implode(' ', apply_filters( 'tc_main_wrapper_classes' , array('container') ) ) ?>">

    <?php do_action( '__before_main_container' ); ##hook of the featured page (priority 10) and breadcrumb (priority 20)...and whatever you need! ?>

    <div class="container" role="main">
        <div class="<?php echo implode(' ', apply_filters( 'tc_column_content_wrapper_classes' , array('row' ,'column-content-wrapper') ) ) ?>">

            <?php do_action( '__before_article_container'); ##hook of left sidebar?>

                <div id="content" class="<?php echo implode(' ', apply_filters( 'tc_article_container_class' , array( CZR_utils::czr_fn_get_layout( czr_fn_get_id() , 'class' ) , 'article-container' ) ) ) ?>">

                    <?php do_action ('__before_loop');##hooks the heading of the list of post : archive, search... ?>

                        <?php if ( czr_fn__f('__is_no_results') || is_404() ) : ##no search results or 404 cases ?>

                            <article <?php czr_fn__f('__article_selectors') ?>>
                                <?php do_action( '__loop' ); ?>
                            </article>

                        <?php endif; ?>

                        <?php if ( have_posts() && ! is_404() ) : ?>
                            <?php while ( have_posts() ) : ##all other cases for single and lists: post, custom post type, page, archives, search, 404 ?>
                                <?php the_post(); ?>
                                /* START: Teil mit den eigenen Inhalten: */
                                $url_ordner = "https://aachenerkinder.de/veranstaltungen/kategorie/";
                      					$kategorienlink = array(
                                  array("Aktuell", $url_ordner . "aktuell/", "Aktuelle Veranstaltungen (meist relativ kurzfristig im Kalender)"),
                                  array("Baby", $url_ordner . "baby/", "Alle Veranstaltungen, die für Babys geeignet sind"),
                                  array("Bildung", $url_ordner . "bildung/","Veranstaltungen zur Bildung"),
                                  array("Diverses", $url_ordner . "diverses/","Veranstaltungen, die sonst in keine Kategorie passen"),
                                  array("Eltern-Lehrer-Erzieher", $url_ordner . "eltern-lehrer-erzieher/","Veranstaltungen, die speziell für Eltern, Lehrer und/oder Erzieher vorgesehen sind"),
                                  array("Eltern und Kind", $url_ordner . "eldern-und-kind/","Veranstaltungen für Eltern mit ihren Kindern"),
                      					  array("Familie", $url_ordner . "familie/","Veranstaltungen für die ganze Familie"),
                                  array("Feiern und Feste", $url_ordner . "feiern-und-feste","Veranstaltungen zu Feiern und Festen"),
                                  array("Ferien", $url_ordner . "ferien/","Ferienveranstaltungen"),
                                  array("Flohmarkt", $url_ordner . "flohmarkt/","Flohmarktveranstaltungen"),
                                  array("Jugendliche", $url_ordner . "jugendliche/","Veranstaltungen für Jugendliche"),
                      					  array("Kinder bis 6", $url_ordner . "kinder-bis-6/","Veranstaltungen für Kinder bis 6 Jahre (meistens ohne Eltern)"),
                                  array("Kinderbetreuung", $url_ordner . "kinderbetreuung/","Veranstaltungen zur Kinderbetreuung"),
                                  array("Kindertheater", $url_ordner . "kindertheater/","Veranstaltungen zu Kindertheater, oder Puppentheater"),
                                  array("Kochen und Backen", $url_ordner . "kochen-und-backen/","Veranstaltungen zum Kochen und/oder Backen für Kinder"),
                                  array("Kunst und Kultur", $url_ordner . "kunst-und-kultur/","Veranstaltungen zur Kunst oder Kultur"),
                      					  array("Laufend", $url_ordner . "laufend/","Laufende Veranstaltungen (in der Regel Veranstaltungen, die über einen längeren Zeitraum laufen, z. B. auch mehrere Tage oder Wochen)"),
                                  array("Medien", $url_ordner . "medien/","Veranstaltungen zu verschiedenen Medien (Film, Computer, Foto)"),
                      					  array("Musik", $url_ordner . "musik/","Musik - Veranstaltungen"),
                      					  array("Natur", $url_ordner . "natur/","Veranstaltungen in der Natur"),
                      					  array("Programme", $url_ordner . "programme/","Veranstaltungsprogramme (Mehrere Veranstaltungen eines Veranstalters z. B. währende des Monats"),
                      					  array("Schulkinder", $url_ordner . "schulkinder/","Veranstaltungen für Schulkinder (in der Regel ohne Eltern)"),
                      					  array("Spiele", $url_ordner . "spiele/","Veranstaltungen zu Spielen"),
                      					  array("Ständig", $url_ordner . "staending/","Ständige Veranstaltungen, die z. B. über einen längeren Zeitraum in der Woche immer zu einem bestimmten Zeitpunkt (z. B. montags um 16 bis 17 Uhr) stattfinden"),
                      					  array("Werken", $url_ordner . "werken/","Veranstaltungen mit Bastelangeboten, etc."),
                      					  array("XXL", $url_ordner . "xxl/","Besonders interessante Veranstaltungen"),
                      					  array("XXL Premium", $url_ordner . "premium/","Besonders interessante Veranstaltungen"),
                      					);
                      					/* nach Zuweisung das Array nach Bezeichung sortieren*/
                                /* ist bereits sortiert, daher nicht nötig */
                      					/* sort($kategorienlink); */

                      					/* Daten ausgeben */
                                $anzahl_array = count ( $kategorienlink );
                                ?>
                                <br><br>
                                <h4> <?php echo $anzahl_array; ?> Kategorien: </h4>
                                <table class="wp-block-table"><tbody>
                      					<?php
                                for($v=0; $v < $anzahl_array; $v++) {
                      					?>
                                  <tr><td>
                        					<a href=<?php echo $kategorienlink[$v][1];?> target="_blank" rel="noopener"><?php echo $kategorienlink[$v][0];?></a><br>
                                  </td><td>
                                  <?php echo $kategorienlink[$v][2];?>
                                  </td></tr>
                      					<?php
                                }
                                ?>
                                </tbody></table>
                                <br><br>
                                <!--
                        				<a href=<?php echo $kategorienlink[1][1];?> target="_blank" rel="noopener"><?php echo $kategorienlink[1][0];?></a><br>
                      					<a href=<?php echo $kategorienlink[2][1];?> target="_blank" rel="noopener"><?php echo $kategorienlink[2][0];?></a><br>
                      					-->

                      					/* ENDE: Teil mit den eigenen Inhalten: */
/*
                                <?php do_action ('__before_article') ?>
                                    <article <?php czr_fn__f('__article_selectors') ?>>
                                        <?php do_action( '__loop' ); ?>
                                    </article>
                                <?php do_action ('__after_article') ?>
*/
                            <?php endwhile; ?>

                        <?php endif; ##end if have posts ?>

                    <?php do_action ('__after_loop');##hook of the comments and the posts navigation with priorities 10 and 20 ?>

                </div><!--.article-container -->

           <?php do_action( '__after_article_container'); ##hook of left sidebar ?>

        </div><!--.row -->
    </div><!-- .container role: main -->

    <?php do_action( '__after_main_container' ); ?>

</div><!-- //#main-wrapper -->

<?php do_action( '__after_main_wrapper' );##hook of the footer with get_footer ?>
