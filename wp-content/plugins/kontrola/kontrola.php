<?php
/**
 * Plugin Name: Kontrola
 * Description: Kontrola
 * Version:     1.0.0
 * Author:      Luhas
 * Author URI:  https://www.aps-web.cz
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */


wp_enqueue_style('aps-dochazka', plugin_dir_url( __FILE__ ) . 'css/kontrola.css',false,'1.0.0','all');

function get_html_page($url) {
    $agent='Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_VERBOSE, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, $agent);
    curl_setopt($ch, CURLOPT_URL,$url);
    $result=curl_exec($ch);
    /*
    $result=str_replace('icon_varovani_14.gif', plugin_dir_url( __DIR__ ) . 'images/icon_varovani_14.gif', $result);
    $result=str_replace('table border="0"', 'table class="tabulka-vypis" border="0"', $result);
    $result=str_replace('table border="1"', 'table class="tabulka-vypis-tabulky" border="1"', $result);
    $result=str_replace('table border=1', 'table class="tabulka-vypis-legenda" border="1"', $result);
    $result=iconv("ISO-8859-2", "UTF-8", $result);
    //$result=str_replace('dovolené', '', $result);
    //$result=str_replace('Stav', 'Stav<br><br><br><br><br>dovolené', $result);
    */
    return ($result);
}

// function that runs when shortcode is called

// register shortcode
add_shortcode('kontrola', function () { 

    $chiaHodlWallet = json_decode(get_html_page("https://xchscan.com/api/account/balance?address=xch18nnaw8nmrzaq9chf3gppg4svrh46eyxf8eekgg8eel0yzsnxyemqcj0kn0"));
    $chiaFarmWallet = json_decode(get_html_page("https://xchscan.com/api/account/balance?address=xch1mtvdewhjsyumx3tcrr2gvpr8mz3eq9j76enjscqhlx2yyem7y4rsnduuvg"));

    $return = '<p>HODL (XCH): ' . $chiaHodlWallet->xch . '<br>';
    $return .= '<p>FARM (XCH): ' . $chiaFarmWallet->xch . '<br>';
    $return .= '<p class="total">TOTAL (XCH): ' . $chiaHodlWallet->xch + $chiaFarmWallet->xch;
    // Things that you want to do.

    return $return;
});

?>
