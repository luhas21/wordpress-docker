<?php

function aps_doch_pritomnost_page( $content ) {
  if ( get_the_ID() == get_option( 'aps_doch_options' )['aps_pritomnost_page_id'] ) {
    aps_doch_pritomnost();
    }
    else {
        return $content;
    }
}
add_filter('the_content', 'aps_doch_pritomnost_page');

function aps_doch_pritomnost() {

    $dnes = date('Y-m-d', strtotime('today'));

    $d_zam = get_dochazka('http://dochazka.speel.cz/dochazka2001/webapi.php?firma=1&prikaz=1');
    //$d_zam = mb_convert_encoding($d_zam, "UTF-8", "ISO-8859-2"); // převede kódovou tabulku
    $d_zam = substr_replace( $d_zam, ";", 79, 0 ); // oprava výpisu - přidán chybějící ukončení řetězce (;) na konci záhlaví tabulky
    $d_zam = explode(";",$d_zam); // převede řetězec na pole
    $d_zam = array_chunk($d_zam,10); // převede pole na dvourozměrné pole

    $d_pritomnost = get_dochazka('http://dochazka.speel.cz/dochazka2001/webapi.php?firma=1&prikaz=11');
    $d_pritomnost = explode(";",$d_pritomnost); // převede řetězec na pole
    $d_pritomnost = array_chunk($d_pritomnost,2); // převede pole na dvourozměrné pole

    $d_absence = get_dochazka('http://dochazka.speel.cz/dochazka2001/webapi.php?firma=1&prikaz=7&datumod='.$dnes.'&datumdo='.$dnes);
    $d_absence = substr_replace( $d_absence, ";", 26, 0 ); // oprava výpisu - přidán chybějící ukončení řetězce (;) na konci záhlaví tabulky
    $d_absence = explode(";",$d_absence); // převede řetězec na pole
    $d_absence = array_chunk($d_absence,4); // převede pole na dvourozměrné pole

    $d_dnesni_pruchody = get_dochazka('http://dochazka.speel.cz/dochazka2001/webapi.php?firma=1&prikaz=6&datumod='.$dnes.'&datumdo='.$dnes);
    $d_dnesni_pruchody = substr_replace( $d_dnesni_pruchody, ";", 72, 0 ); // oprava výpisu - přidán chybějící ukončení řetězce (;) na konci záhlaví tabulky
    $d_dnesni_pruchody = explode(";",$d_dnesni_pruchody); // převede řetězec na pole
    $d_dnesni_pruchody = array_chunk($d_dnesni_pruchody,7); // převede pole na dvourozměrné pole 

    $d_vypis_prit = $d_zam;
    foreach ($d_vypis_prit as $key => $row) {
      if(!isset($row[2])) $row[2] = '';
      $d_sorting[$key] = $row[2];
    } 

    // Sort the data with wek ascending order, add $mar as the last parameter, to sort by the common key
    array_multisort($d_sorting, SORT_LOCALE_STRING, $d_vypis_prit);
    ?>
    <div class="centered">
      <?php //Výpis počtu přítomných zaměstnanců
      $pritomnych = kde_a_kolik(1, $d_pritomnost,1);
      $doba_odchodu = false;
      
      if (date("w") != 0 AND date("w") != 6 AND date("H") > 10) $doba_odchodu = true;

      if ($pritomnych[1] > 1 AND $pritomnych[1] < 5) {  ?>
        <p <?php if ($doba_odchodu) echo 'class="cervena"'; ?>>Na pracovišti jsou přítomni <?php echo $pritomnych[1]; ?> zaměstnanci!<?php if ($doba_odchodu) echo '<h2 class="cervena">Při odchodu se, prosím, ujistěte, že to tak skutečně je a není tedy potřeba zakódovat a uzamknout budovu a klíče odevzdat na vrátnici.</h2>'; 
      } elseif ($pritomnych[1] == 1) { ?>
        <p <?php if ($doba_odchodu) echo 'class="cervena"'; ?>>Na pracovišti je přítomen <?php echo $pritomnych[1]; ?> zaměstnanec!<?php if ($doba_odchodu) echo '<h2 class="cervena">Při odchodu se, prosím, ujistěte, že to tak skutečně je a není tedy potřeba zakódovat a uzamknout budovu a klíče odevzdat na vrátnici.</h2>'; 
      } elseif ($pritomnych[1] == 0) { 
        if ($doba_odchodu) {
          echo '<h2 class="vystraha">Na pracovišti již nikdo není!<br>Při odchodu zakódujte a uzamkněte budovu a klíče odevzdejte na vrátnici, prosím.</h2>';
        } else {
          echo '<p>Na pracovišti není přítomen žádný zaměstnanec.</p>';
        }
      } else { ?>
        <p>Na pracovišti je přítomno <?php echo $pritomnych[1]; ?> zaměstnanců.</p>
      <?php } ?>

      <!-- Výpis tabulky přítomnosti ze systému-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

        <div class="tabulka">
            <table id="pritomnost" width="100%">
            <th>Os.č.</th>
            <th>Zaměstnanec</th>
            <th>Oddělení</th>
            <th>Telefon</th>
            <th>Pohyb</th>
            <th>Přítomnost</th>
            <?php
            foreach($d_vypis_prit as $row => $val) {
              if(!isset($val[8])) $val[8] = '';
              if($val[8]==1){
                ?>
                  <tr>
                    <td><?php echo $val[0]; ?></td>
                    <td><?php echo $val[2]." ".$val[1]; ?></td>
                    <td><?php
                      $oddeleni = array ("Název","Administrativa","Software","Hardware","Elektrovýroba","Výroba a konstrukce");
                        echo $oddeleni[$val[3]];
                      ?></td>
                    <td><?php echo $val[7]; ?></td>
                    <td><?php
                    //vyhledá výskyty celodenních absencí
                    $vyskyty_absence = kde_a_kolik($val[0], $d_absence,0);
                    $kde_absence = $vyskyty_absence[0];
                    $kolik_absence = $vyskyty_absence[1];
                    //vyhledá výskyty dnešních pohybů
                    $vyskyty_pohybu = kde_a_kolik($val[0], $d_dnesni_pruchody,0);
                    $kde_pohyb = $vyskyty_pohybu[0];
                    $kolik_pohyb = $vyskyty_pohybu[1];
                    //vypíše dnešní pohyby nebo celodenní absence nebo * v případě nepřítomnosti
                    if ($kolik_pohyb) {
                      for ($smycka=0;$smycka<$kolik_pohyb;$smycka++) {
                        echo $d_dnesni_pruchody[$kde_pohyb+$smycka][2];
            //            echo " <i><strong>".$d_dnesni_pruchody[$kde_pohyb+$smycka][3]."</strong></i>";
                        echo " - ".$d_dnesni_pruchody[$kde_pohyb+$smycka][4];
            //            echo " <i><strong>".$d_dnesni_pruchody[$kde_pohyb+$smycka][5]."</strong></i>";
                        echo "<br>";
                      }
                    }else if ($kolik_absence) {
                      $duvod = array ("Důvod","Dovolená","Nemoc","Služební cesta","OČR","Překážka","Návštěva lékaře","Přestávka","Náhradní volno","Omluvená absence","Mateřská dovolená","Vojenské cvičení","Home Office");
                      echo $duvod[$d_absence[$kde_absence][2]];
                    } else echo "*";
                    ?></td>
                    <td><?php        
                    $vyskyty = kde_a_kolik($val[0], $d_pritomnost,0);
                      $kde = $vyskyty[0];
                      $kolik = $vyskyty[1];
                    if($d_pritomnost[$kde][1])
                      echo "&#x2705";
                    else
                      echo "&#x274C";
                    ?></td>
                  </tr>
                <?php
              }
            }
            ?>
            </table>
          </div>
<?php
}
// add_shortcode( 'aps-pritomnost', 'aps_doch_pritomnost' );
/*
  // V průchodech vyhledá číslo řádku s požadovaným
function kde_a_kolik($co, $pole, $sloupec) {
  $kolik = 0;
  $kde =0;
  foreach ($pole as $radek => $hodnota) {
    if(!isset($hodnota[$sloupec])) $hodnota[$sloupec] = '';
    if ($hodnota[$sloupec] == $co) {
      $kolik++;
      if ($kde == 0) $kde = $radek;
    }
  }
  return array($kde, $kolik);
}
*/
?>