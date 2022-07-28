<?php

if ($_POST['aps_doch_options_url'] != get_option('aps_doch_options_url'))
	update_option('aps_doch_options_url', $_POST['aps_doch_options_url']);

if ($_POST['aps_doch_options_page_id'] != get_option('aps_doch_options_page_id'))
	update_option('aps_doch_options_page_id', $_POST['aps_doch_options_page_id']);



	function aps_doch_register() {
		add_option('aps_doch_options_url', 'https://domenadochazky.cz:443');
		add_option('aps_doch_options_page_id', 0);
	}
	register_activation_hook( __FILE__ ), 'aps_doch_register' );

	function aps_doch_deregister() {
		delete_option('aps_doch_options_url');
		delete_option('aps_doch_options_page_id');
	}
	register_deactivation_hook( __FILE__ ), 'aps_doch_deregister' );



//--------------------------------------------------------------------------

function aps_admin_settings_setup() {
	add_options_page('APS Docházka', 'APS Docházka', 'manage_options', 'aps-settings', 'aps_admin_settings_page');
}

add_action('admin_menu', 'aps_admin_settings_setup');

function aps_admin_settings_page(){
	global $aps_active_tab;
	$aps_active_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : 'aps_tab01'; ?>

	<h2 class="nav-tab-wrapper">
	<?php
		do_action( 'aps_settings_tab' );
	?>
	</h2>
	<?php
		do_action( 'aps_settings_content' );
}

add_action( 'aps_settings_tab', 'aps_tab01', 1 );

function aps_tab01(){
	global $aps_active_tab; ?>
	<a class="nav-tab <?php echo $aps_active_tab == 'aps_tab01' || '' ? 'nav-tab-active' : ''; ?>" href="<?php echo admin_url( 'options-general.php?page=aps-settings&tab=aps_tab01' ); ?>"><?php _e( 'Základní nastavení', 'aps' ); ?> </a>
	<?php
}

add_action( 'aps_settings_content', 'aps_tab01_render_options_page' );

function aps_tab01_render_options_page() {
	global $aps_active_tab;
	if ( '' || 'aps_tab01' != $aps_active_tab )
		return;
	?>
  <div class="wrap">
	<h2><?php _e( 'Základní nastavení pro plugin APS Docházka', 'aps' ); ?></h2>
	<!-- Put your content here -->
  <form method="post" action="options.php">
  <?php // settings_fields( 'myplugin_options_group' ); ?>
  <h3>1. Nastavení adresy serveru Docházka 3000</h3>
  <p>Zde nastavte adresu serveru Docházka 3000 (např.: https://mojedomena.cz:443).</p>
  <table>
  	<tr valign="top">
  		<th scope="row" width="120px"><label for="aps_doch_options[url]">Adresa: </label></th>
  		<td><input type="url" id="aps_doch_options[url]" name="aps_doch_options[url]" value="<?php echo get_option('aps_doch_options[url]'); ?>" size="43" /></td>
  	</tr>
	</table>
  <h3>2. Nastavení stránky pro zobrazení výpisu docházky</h3>  </tr>
  <p>Zde vyberte stránku, na které chcete zobrazovat výpisy docházky.<br><strong><u>Důležité!</u></strong> Ujistěte se, že na vybrané stránce <strong>použijete shortcode [aps-dochazka]</strong>.</p>  </tr>
	<table>
		<tr valign="top"><th scope="row" width="120px"><label for="aps_doch_adresa">Stránka: </label></th>
			<td>
				<select name="aps_doch_options[page_id]">
					<?php
					if( $pages = get_pages() ){
						foreach( $pages as $page ){
							echo '<option value="' . $page->ID . '" ' . selected( $page->ID, $options['page_id'] ) . '>' . $page->post_title . '</option>';
						}
					}
					?>
				</select>
			</td>
		</tr>
  </table>
  <?php  submit_button(); ?>
  </form>
  </div>
	<?php
}

add_action( 'aps_settings_tab', 'aps_tab02' );
function aps_tab02(){
	global $aps_active_tab; ?>
	<a class="nav-tab <?php echo $aps_active_tab == 'aps_tab02' ? 'nav-tab-active' : ''; ?>" href="<?php echo admin_url( 'options-general.php?page=aps-settings&tab=aps_tab02' ); ?>"><?php _e( 'Nastavení uživatelů', 'aps' ); ?> </a>
	<?php
}

add_action( 'aps_settings_content', 'aps_tab02_render_options_page' );

function aps_tab02_render_options_page() {
	global $aps_active_tab;
	if ( 'aps_tab02' != $aps_active_tab )
		return;
	?>
	<div class="wrap">
	<h2><?php _e( 'Nastavení osobních čísel uživatelů pro plugin APS Docházka', 'aps' ); ?></h2>
	<!-- Put your content here -->
	<?php
}


add_action( 'aps_settings_tab', 'aps_tab03' );
function aps_tab03(){
	global $aps_active_tab; ?>
	<a class="nav-tab <?php echo $aps_active_tab == 'aps_tab03' ? 'nav-tab-active' : ''; ?>" href="<?php echo admin_url( 'options-general.php?page=aps-settings&tab=aps_tab03' ); ?>"><?php _e( 'Popis', 'aps' ); ?> </a>
	<?php
}

add_action( 'aps_settings_content', 'aps_tab03_render_options_page' );

function aps_tab03_render_options_page() {
	global $aps_active_tab;
	if ( 'aps_tab03' != $aps_active_tab )
		return;
	?>
	<div class="wrap">
	<h2><?php _e( 'Popis pro plugin APS Docházka', 'aps' ); ?></h2>
	<!-- Put your content here -->
	<h3><span>Účel pluginu</span></h3>
	<div class="inside">
		<p>Tento plugin spolupracuje se systémem Docházka 3000 a umožňuje:</p>
		<ul style="display:block;list-style-type:disc;margin-top:1em;margin-bottom:1em;margin-left:0;margin-right:0;padding-left:40px;">
			<li>výpis docházky pro konkrétního přihlášeného uživatle,</li>
			<li>zápis celodenní docházky včetně vícedenních jako widget v postranním sloupci,</li>
			<li>zobrazení posledních dvou roků jako widget v postranním sloupci,</li>
			<li>výběr roku a měsíce pro výpis docházky z archivu a</li>
			<li>správu uživatelských osobních čísel.</li>
		</ul>
	</div> <!-- .inside -->

	<h3>Jak plugin použít</h3>
  <div class="inside">
  	<p>1. V administrátorské nabídce "Nastavení/APS Docházka/Základní nastavení" nastavte adresu vašeho serveru Docházka 3000, vyberte stránku, kde chcete zobrazovat výpisy docházky a nastavení uložte.</p>
		<p>2. Do obsahu vybrané stránky vložte shortcode [aps_dochazka] a stránku uložte.</p>
		<p>3. Nastavte osobní čísla všech uživatelů a přihlašte se jako jeden z nich.</p>
		<p>A to je vše. Ať vám plugin slouží.</p>
  </div> <!-- .inside -->

  <h3>Autor</h3>
	<div class="inside">
  	<p>Tento plugin vytvořil <a href="https://www.petrsahula.cz" title="Ing. Petr Sahula" target="_blank">Ing. Petr Sahula</a></p>
    </div> <!-- .inside -->
	<?php
}

?>

//  VŠECHNO, BEZ ZÁPISU OSOBNÍCH ČÍSEL
<?php

add_action( 'admin_init', 'aps_doch_options_init' );
add_action( 'admin_menu', 'aps_doch_options_page' );

function aps_doch_options_init(){
    register_setting(
        'aps_doch_options_group',
        'aps_doch_options',
        'aps_doch_options_validate'
    );
}

function aps_doch_options_page() {
    add_options_page(
        'APS docházka',
        'APS docházka',
        'manage_options',
        'aps_doch_options',
        'aps_doch_render_options'
    );
}

function aps_doch_render_options() {
  aps_doch_zam_zap();
  ?>
    <div class="wrap">
			<h2><?php _e( 'Základní nastavení pro plugin APS Docházka', 'aps' ); ?></h2>
        <form method="post" action="options.php">
            <?php
            settings_fields( 'aps_doch_options_group' );
            $options = get_option( 'aps_doch_options' );
            ?>
            <table class="form-table">
	                <tr valign="top"><th scope="row">Vyplňte adresu serveru Docházka 3000</th>
	                    <td>
	                        <input  type="url" name="aps_doch_options[url]" size="66"
													<?php
														echo ' value="' . $options['url'] . '" >';
													?>
	                    </td>
	                </tr>
                <tr valign="top"><th scope="row">Zvolte stránku pro výpisy docházky</th>
                    <td>
                        <select name="aps_doch_options[page_id]">
                            <?php
                            if( $pages = get_pages() ){
                                foreach( $pages as $page ){
                                    echo '<option value="' . $page->ID . '" ' . selected( $page->ID, $options['page_id'] ) . '>' . $page->post_title . '</option>';
                                }
                            }
                            ?>
                        </select>
                      </table>
            <p class="submit">
                <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
            </p>
        </form>
    </div><hr>

      <div class="wrap">
        <h2><?php _e( 'Nastavení osobních čísel uživatelů', 'aps' ); ?></h2>
          <form method="post" action="options.php">
              <?php
              settings_fields( 'aps_doch_options_group' );
              $options = get_option( 'aps_doch_options' );
              ?>
              <table class="form-table">
                <tr valign="top"><th scope="row">Vyplňte osobní čísla uživatelů</th>
                  <td>
                    <?php
                    $blogusers = get_users_of_blog();
                    if ($blogusers) {
                      foreach ($blogusers as $bloguser) {
                        $user = get_userdata($bloguser->user_id);
                        echo $user->user_login . ' (' . $user->user_email . ')</td><td>'
                          . '<input type="text" name="osobni_cislo" id="osobni_cislo" value="'
                          . esc_attr( get_the_author_meta( 'osobni_cislo', $user->ID ) )
                          . '" ></td></tr><tr><td></td><td>';
                        }
                      }
                      ?>
                      </td></tr>
                    </table>
                    <p class="submit">
                    <input type="submit" class="button-primary" value="<?php _e('Uložit osobní čísla') ?>" />
                  </p>
                </form>
              </div><hr>

    <?php

    $doch_page_csv = get_dochazka( get_option( 'aps_doch_options' )['url'] . "/dochazka2001/webapi.php?firma=1&prikaz=1" );

      echo "<center><h3>Výpis zaměstnanců ze systému Docházka 3000</h3></center><div style=\"width: 50%; margin: 0 auto;\"><table><tr><td>";
      $počet = strlen ( $doch_page_csv );
      for ($a=0; $a < $počet; $a++) {
        if ($doch_page_csv[$a] == ";") echo "</td><td>";
        if( $doch_page_csv[$a] == "\n") echo "</td></tr><tr><td>";
        if ( $doch_page_csv[$a] != "\n" && $doch_page_csv[$a] != ";" ) echo $doch_page_csv[$a];
      }
      echo "</td></tr></table></div>";
//    aps_doch_zamestnanci();
}

function aps_doch_options_validate( $input ) {
    // do some validation here if necessary
    return $input;
}

function get_dochazka($url) {
  $agent='Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_VERBOSE, true);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_USERAGENT, $agent);
  curl_setopt($ch, CURLOPT_URL,$url);
  $result=curl_exec($ch);
  $result=iconv("ISO-8859-2", "UTF-8", $result);
  return ($result);
}

function aps_doch_zam_zap(){
  if ( $_POST["osobni_cislo"]) {
    echo "ULOŽENOOOO!";
    $user_id=2;
    update_user_meta( $user_id, 'osobni_cislo', $_POST['osobni_cislo'] );
  }
}
