<?php

add_action( 'admin_init', 'aps_doch_options_init' );
add_action( 'admin_menu', 'aps_doch_options_page' );

function aps_doch_options_init() {
  register_setting(
    'aps_doch_options_group',
    'aps_doch_options',
    'aps_doch_options_validate'
  );
}

function aps_doch_options_page() {
	add_options_page(
    'APS docházka page',
    'APS docházka',
    'manage_options',
    'aps_doch_options',
    'aps_doch_admin_page'
  );
}

function aps_doch_admin_page() {
  ?>
    <div class="wrap">
			<h2><?php _e( "Základní nastavení pro plugin APS Docházka", "aps-doch" ); ?></h2>
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
								  	echo ' value="' . $options['url'].'"';
									?>
                >
              </td>
            </tr>
            <tr valign="top"><th scope="row">Zvolte stránku pro výpisy docházky</th>
              <td>
                <select name="aps_doch_options[aps_dochazka_page_id]">
                    <?php
                    if( $pages = get_pages() ){
                      foreach( $pages as $page ){
                        if ( ! empty ($options['aps_dochazka_page_id'])) {
                          $selected = selected( $page->ID, $options['aps_dochazka_page_id'] );
                        } else {
                          $selected='';
                        }
                          echo '<option value="' . $page->ID . '" ' . $selected . '>' . $page->post_title . '</option>';
                      }
                    }
                    ?>
                </select>
              </td>
            </tr>
            <tr valign="top"><th scope="row">Zvolte stránku pro výpisy přítomnosti</th>
              <td>
                <select name="aps_doch_options[aps_pritomnost_page_id]">
                    <?php
                    if( $pages = get_pages() ){
                      foreach( $pages as $page ){
                        if ( ! empty ($options['aps_pritomnost_page_id'])) {
                          $selected = selected( $page->ID, $options['aps_pritomnost_page_id'] );
                        } else {
                          $selected='';
                        }
                        echo '<option value="' . $page->ID . '" ' . $selected . '>' . $page->post_title . '</option>';
                      }
                    }
                    ?>
                </select>
              </td>    
            </tr>
            <tr valign="top"><th scope="row">Zvolte stránku pro zobrazení kalendáře akcí</th>
              <td>
                <select name="aps_doch_options[aps_kalendar_page_id]">
                    <?php
                    if( $pages = get_pages() ){
                      foreach( $pages as $page ){
                        if ( ! empty ($options['aps_kalendar_page_id'])) {
                          $selected = selected( $page->ID, $options['aps_kalendar_page_id'] );
                        } else {
                          $selected='';
                        }
                          echo '<option value="' . $page->ID . '" ' . $selected . '>' . $page->post_title . '</option>';
                      }
                    }
                    ?>
                </select>
              </td>    
            </tr>
            <tr valign="top"><th scope="row">Zvolte stránku pro zobrazení nadcházejících akcí</th>
              <td>
                <select name="aps_doch_options[aps_events_page_id]">
                    <?php
                    if( $pages = get_pages() ){
                      foreach( $pages as $page ){
                        if ( ! empty ($options['aps_events_page_id'])) {
                          $selected = selected( $page->ID, $options['aps_events_page_id'] );
                        } else {
                          $selected='';
                        }
                          echo '<option value="' . $page->ID . '" ' . $selected . '>' . $page->post_title . '</option>';
                      }
                    }
                    ?>
                </select>
              </td>    
            </tr>
            <tr valign="top"><th scope="row">Zvolte stránku pro zobrazení archivu uskutečněných akcí</th>
              <td>
                <select name="aps_doch_options[aps_past_events_page_id]">
                    <?php
                    if( $pages = get_pages() ){
                      foreach( $pages as $page ){
                        if ( ! empty ($options['aps_past_events_page_id'])) {
                          $selected = selected( $page->ID, $options['aps_past_events_page_id'] );
                        } else {
                          $selected='';
                        }
                          echo '<option value="' . $page->ID . '" ' . $selected . '>' . $page->post_title . '</option>';
                      }
                    }
                    ?>
                </select>
              </td>    
            </tr>
            </table>
                  <p class="submit">
                <input type="submit" class="button-primary" value="<?php _e('Save Changes'); ?>" />
            </p>
        </form>
    </div>
<?php
}

function aps_doch_options_validate( $input ) {
    // do some validation here if necessary
    return $input;
}
/*
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
*/