<?php
// aps-doch-vypisdochazky.php


function aps_doch_vypis_page( $content ) {
  if ( get_the_ID() == get_option( 'aps_doch_options' )['aps_dochazka_page_id'] ) {
    global $current_user;
    get_currentuserinfo();
  
    if (!$current_user->osobni_cislo) {
    echo "<h4 class='centered'>Chyba!</h4><p class='centered'>Není zadáno osobní číslo uživatele.<br>Kontaktujte, prosím, administrátora.</p>";
    }
    else {
      ?> <div class="tlacitko-ovladani"> <?php
        aps_doch_ovladani();
      ?></div><?php
      ?> <div class="tab-dochazky" with="100%"> <?php
        aps_doch_vypis($current_user);
      ?></div><?php
    }
  }
  else {
    return $content;
  }
}
add_filter('the_content', 'aps_doch_vypis_page');


// Vrátí název měsíce v češtině
function mesic_cesky($mesic) {
  static $nazvy = array(1 => 'leden', 'únor', 'březen', 'duben', 'květen', 'červen', 'červenec', 'srpen', 'září', 'říjen', 'listopad', 'prosinec');
  return $nazvy[$mesic];
}
  
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

// Vypíše ovládání výpisu docházky
function aps_doch_ovladani() {
  $aps_doch_url = get_permalink(get_the_ID());
  if (isset($_GET['rok'])) $rok=$_GET['rok']; else $rok=date("Y");
  $y=date("Y");
  echo '<div class="tit-dochazky"><p class="centered">Rok ' . $y . '<br>Vyberte požadovaný týden nebo měsíc.<p></div>';
  echo '<p class="centered">';
  for($m=1; $m<=12;$m++){
      echo '<a class="tlacitko male centered" href="' . $aps_doch_url . '?switch=4&mesic=' . $m . '&rok=' . $y . '" >' . $m . '</a>';
  }
  echo '</p>';
  echo '<p class="centered">';
  echo '<a href="' . $aps_doch_url . '?switch=1" class="tlacitko velke">Tento týden</a>';
  echo '<a href="' . $aps_doch_url . '?switch=2" class="tlacitko velke">Minulý týden</a>';
  echo '<a href="' . $aps_doch_url . '" class="tlacitko velke">Tento měsíc</a>';
  echo '<a href="' . $aps_doch_url . '?switch=3" class="tlacitko velke">Minulý měsíc</a>';
  echo '</p>';
}

// Zpracuje parametry z linku a převede do linku, kterým volá docházku pro výpis podle zadání
function aps_doch_vypis($current_user) {
  $pozrok=date("Y");
  $pozmesic=date("m");
  $switch=0;
  $aps_doch3000_url=get_option( 'aps_doch_options' )['url'];
  settype($pozmesic, "integer");

  if (isset($_GET['rok'])) $pozrok=$_GET['rok'];
  if (isset($_GET['mesic'])) $pozmesic= $_GET['mesic'];
  if (isset($_GET['switch'])) $switch=$_GET['switch'];

  if (isset($_GET['datum'])) $datum = $_GET['datum'];
  if (isset($_GET['pocetdnu'])) $pocetdnu = $_GET['pocetdnu'];
  if (isset($_GET['absence'])) $absence = $_GET['absence'];
  if (isset($_GET['poznamka'])){
    $poznamka = $_GET['poznamka'];
    $poznamka=iconv("UTF-8", "ISO-8859-2", $poznamka);
    $poznamka=urlencode ($poznamka);
  } 

  if ($switch==3) {
    if($pozmesic==1) {
      $pozmesic=12;
      $pozrok--;
    } else $pozmesic--;
  }

  if ($switch==99) {
    $d=date_parse_from_format("Y-m-d", $datum);
    $pozmesic=$d["month"];
    $pozrok=$d["year"];

    while($pocetdnu) {
      get_dochazka( $aps_doch3000_url . "/dochazka2001/vypis.php?akce=2&firma=1&os_cis=" . $current_user->osobni_cislo . "&indexza=" . $current_user->osobni_cislo . "&datumod=" . StrFTime("%d.%m.%Y", strtotime($datum)) . "&kod=" . $absence);
      
      get_dochazka( $aps_doch3000_url . "/dochazka2001/vypis.php?firma=1&os_cis=" . $current_user->osobni_cislo . "&indexza=" . $current_user->osobni_cislo . "&datumod=" . StrFTime("%d.%m.%Y", strtotime($datum)) . "&pozntext[2]=" . $poznamka . "&pozndate[2]=$datum" . "&pozn=2&numpozn=2");

      $datum=strftime("%Y-%m-%d", strtotime("$datum +1 day"));
      $pocetdnu--;
    }
  }
  
  if ($switch==1) {
    echo '<div class="tit-dochazky"><p>Docházka tento týden</p></div>';
    echo get_dochazka( $aps_doch3000_url
    . "/dochazka2001/vypis.php?firma=1&os_cis=" . $current_user->osobni_cislo
    . "&indexza=" . $current_user->osobni_cislo
    . "&datumod=" . date('d.m.Y', strtotime('this week Monday'))
    . "&datumdo=" . date('d.m.Y', strtotime('today'))
    . "&pisdov=1&pozn=1" );
  } else if ($switch==2) {
    echo '<div class="tit-dochazky"><p>Docházka minulý týden</p></div>';
    echo get_dochazka( $aps_doch3000_url 
    . "/dochazka2001/vypis.php?firma=1&os_cis=" . $current_user->osobni_cislo
    . "&indexza=" . $current_user->osobni_cislo
    . "&datumod=" . date('d.m.Y', strtotime('last week Monday'))
    . "&datumdo=" . date('d.m.Y', strtotime('last week Sunday'))
    . "&pisdov=1&pozn=1");
  } else if ($switch==3 || $switch==4 || $switch==99) {
    echo '<div class="tit-dochazky"><p>Docházka za měsíc ' .  mesic_cesky($pozmesic) . ' ' . $pozrok . '</p></div>';
    echo get_dochazka( $aps_doch3000_url
    . "/dochazka2001/vypis.php?firma=1"
    . "&os_cis=" . $current_user->osobni_cislo
    . "&indexza=" . $current_user->osobni_cislo
    . "&datumod=1." . $pozmesic . "." . $pozrok
    . "&datumdo="
    . date('t.m.Y', strtotime("1." . $pozmesic . "." . $pozrok))
    . "&pisdov=1&pozn=1" );
  } else if ($switch==5) {
    aps_doch_archiv();
  } else {
    echo '<div class="tit-dochazky"><p>Přehled docházky do dnešního dne</p></div>';
      echo get_dochazka( $aps_doch3000_url
      . "/dochazka2001/vypis.php?firma=1"
      . "&os_cis=" . $current_user->osobni_cislo
      . "&indexza=" . $current_user->osobni_cislo
      . "&datumod=1." . $pozmesic . "." . $pozrok
      . "&datumdo=" . date('d.m.Y', strtotime('today'))
      . "&pisdov=1&pozn=1" );
  }
}

// Vypíše archiv (všechny roky a měsíce od zavedení elektronické docházky SPEEL)
function aps_doch_archiv() {
  $aps_doch_url = get_permalink( get_option( 'aps_doch_options' )['aps_dochazka_page_id']);
  if (isset($_GET['odroku'])) $odroku=isset($_GET['odroku']); else $odroku=2017;
  if ($odroku<2017) $odroku=2017;

  $pocetroku=(date("Y")-$odroku+1);

  for($rok=date("Y")-1;$rok>=$odroku;$rok--){
    echo "<p class='centered'>Rok " . $rok . "</p>";
    echo '<p class="centered">';
    if($rok==2017) {
      for($m=6; $m<=12;$m++){
          echo '<a class="tlacitko male" href="' . $aps_doch_url . '?switch=4&mesic=' . $m . '&rok=' . $rok . '">' . $m . '</a>';
      }
    } else {
      for($m=1; $m<=12;$m++){
        echo '<a class="tlacitko male" href="' . $aps_doch_url . '?switch=4&mesic=' . $m . '&rok=' . $rok . '">' . $m . '</a>';
      }
    }
    echo '</p>';
  }
}

// Vyvolání výpisu ze systému docházky a převod výstupu do požadovaného formátu a jazykové sady
function get_dochazka($url) {
  $agent='Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_VERBOSE, true);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_USERAGENT, $agent);
  curl_setopt($ch, CURLOPT_URL,$url);
  $result=curl_exec($ch);
  $result=str_replace('icon_varovani_14.gif', plugin_dir_url( __DIR__ ) . 'images/icon_varovani_14.gif', $result);
  $result=str_replace('table border="0"', 'table class="tabulka-vypis" border="0"', $result);
  $result=str_replace('table border="1"', 'table class="tabulka-vypis-tabulky" border="1"', $result);
  $result=str_replace('table border=1', 'table class="tabulka-vypis-legenda" border="1"', $result);
  $result=iconv("ISO-8859-2", "UTF-8", $result);
  //$result=str_replace('dovolené', '', $result);
  //$result=str_replace('Stav', 'Stav<br><br><br><br><br>dovolené', $result);

  return ($result);
}

// End aps-doch-vypis-dochazky.php
?>
