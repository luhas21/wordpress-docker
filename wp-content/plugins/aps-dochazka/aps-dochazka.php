  <?php
/**
 * Plugin Name: APS-Docházka
 * Description: Plugin, který spolupracuje se systémem DOCHÁZKA 3000. Plugin zobrazuje náhledy na docházku (týden, měsíc, do dnešního dne), zobrazuje archiv docházky (ve stránce i jako widget) a umožňuje zápis celodenní absence. To vše pro uživatele, který je přihlášen a označen ID ze systému.
 * Version:     2.0.0
 * Author:      Luhas
 * Author URI:  https://www.aps-web.cz
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

wp_enqueue_style('aps-dochazka', plugin_dir_url( __FILE__ ) . 'css/aps-dochazka.css',false,'1.0.0','all');
wp_enqueue_script('moje-hlavni-js', plugin_dir_url( __FILE__ ) . 'js/script.js', NULL, microtime(), '1.0', true);

$codeset = "UTF8"; setlocale(LC_ALL, "cs_CZ.UTF-8", "Czech", "cs_CZ");
require plugin_dir_path( __FILE__ ) . 'inc/aps-doch-options.php';
require plugin_dir_path( __FILE__ ) . 'inc/aps-doch-user-customize.php';
require plugin_dir_path( __FILE__ ) . 'inc/aps-doch-typ-events.php';
require plugin_dir_path( __FILE__ ) . 'inc/aps-doch-vypis-pritomnost.php';
require plugin_dir_path( __FILE__ ) . 'inc/aps-doch-vypis-dochazka.php';
require plugin_dir_path( __FILE__ ) . 'inc/aps-doch-vypis-events.php';
require plugin_dir_path( __FILE__ ) . 'inc/aps-doch-vypis-past-events.php';
require plugin_dir_path( __FILE__ ) . 'inc/aps-doch-vypis-kalendar.php';
require plugin_dir_path( __FILE__ ) . 'inc/aps-doch-widget-next-events.php';
require plugin_dir_path( __FILE__ ) . 'inc/aps-doch-widget-archiv.php';
require plugin_dir_path( __FILE__ ) . 'inc/aps-doch-widget-prihlaseni.php';
require plugin_dir_path( __FILE__ ) . 'inc/aps-doch-widget-zapis-absence.php';
require plugin_dir_path( __FILE__ ) . 'inc/aps-doch-widget-svatek.php';
require plugin_dir_path( __FILE__ ) . 'inc/aps-doch-widget-pocasi.php';
require plugin_dir_path( __FILE__ ) . 'inc/private-site.php';

//require plugin_dir_path( __FILE__ ) . 'inc/add_data.php';

?>
