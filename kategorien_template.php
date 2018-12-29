<?php
	/*
	Template Name: Kategorienanzeige und Verlinkung
	*/

	if ( !defined('ABSPATH') ){ die(); }
	/*
	 * get_header is a basic wordpress function, used to retrieve the header.php file in your theme directory.
	 */


	 global $avia_config, $more;
	 get_header();
	 echo avia_title();
	 
	 do_action( 'ava_after_main_title' );
	 ?>



		<div class='container_wrap container_wrap_first main_color <?php avia_layout_class( 'main' ); ?>'>

			<div class='container'>

				<main class='template-archives content <?php avia_layout_class( 'content' ); ?> units' <?php avia_markup_helper(array('context' => 'content'));?>>

                    <div class="entry-content-wrapper entry-content clearfix">

                    <?php
                    //display the actual post content
                    the_post();
                    the_content();

					
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
          					<?php
          					/* ENDE: Teil mit den eigenen Inhalten: */

					
                    ?>


                    </div>

				<!--end content-->
				</main>

				<?php
				wp_reset_query();
				//get the sidebar
				$avia_config['currently_viewing'] = 'page';
				get_sidebar();

				?>

			</div><!--end container-->

		</div><!-- close default .container_wrap element -->




<?php get_footer(); ?>