<?php

function aps_doch_admin_sub_page_02() {
  ?>
      <div class="wrap">
        <h2><?php _e( 'Informace ze systému Docházka 3000', 'aps' ); ?></h2>

  <?php

    $doch_page_odd = get_dochazka( get_option( 'aps_doch_options' )['url'] . "/dochazka2001/webapi.php?firma=1&prikaz=2" );
    echo "<center><h3>Výpis oddělení</h3></center><div style=\"width: 50%; margin: 0 auto;\"><table><tr><td>";
    $počet = strlen ( $doch_page_odd );
    for ($a=0; $a < $počet; $a++) {
      if ($doch_page_odd[$a] == ";") echo "</td><td>";
      if( $doch_page_odd[$a] == "\n") echo "</td></tr><tr><td>";
      if ( $doch_page_odd[$a] != "\n" && $doch_page_odd[$a] != ";" ) echo $doch_page_odd[$a];
    }
    echo "</td></tr></table></div>";

    $doch_page_csv = get_dochazka( get_option( 'aps_doch_options' )['url'] . "/dochazka2001/webapi.php?firma=1&prikaz=1" );
    echo "<center><h3>Výpis zaměstnanců</h3></center><div style=\"width: 50%; margin: 0 auto;\"><table><tr><td>";
    $počet = strlen ( $doch_page_csv );
    for ($a=0; $a < $počet; $a++) {
      if ($doch_page_csv[$a] == ";") echo "</td><td>";
      if( $doch_page_csv[$a] == "\n") echo "</td></tr><tr><td>";
      if ( $doch_page_csv[$a] != "\n" && $doch_page_csv[$a] != ";" ) echo $doch_page_csv[$a];
    }
    echo "</td></tr></table></div><hr>";

}
