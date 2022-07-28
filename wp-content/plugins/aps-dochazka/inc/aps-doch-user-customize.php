<?php

add_action( 'show_user_profile', 'extra_user_profile_fields' );
add_action( 'edit_user_profile', 'extra_user_profile_fields' );

function extra_user_profile_fields( $user ) { ?>
    <h3><?php _e("Doplňkové informace pro systém Docházka 3000", "aps-doch"); ?></h3>

    <table class="form-table">
    <tr>
        <th><label for="osobni_cislo"><?php _e("Osobní číslo", "aps-doch"); ?></label></th>
        <td>
            <strong><?php echo esc_attr( get_the_author_meta( 'osobni_cislo', $user->ID ) ); ?></strong><br />
            <span class="description"><?php _e("Toto je Vaše osobní číslo v systému Docházka 3000.", "aps-doch"); ?></span>
        </td>
    </tr>
    <tr>
        <th><label for="osobni_cislo"><?php _e("Osobní číslo (editace)", "aps-doch"); ?></label></th>
        <td>
            <input type="text" name="osobni_cislo" id="osobni_cislo" value="<?php echo esc_attr( get_the_author_meta( 'osobni_cislo', $user->ID ) ); ?>" class="regular-text" /><br />
            <span class="description"><?php _e("Zde zadejte osobní číslo.", "aps-doch"); ?></span>
        </td>
    </tr>
    </table>
<?php
}

add_action( 'personal_options_update', 'save_extra_user_profile_fields' );
add_action( 'edit_user_profile_update', 'save_extra_user_profile_fields' );

function save_extra_user_profile_fields( $user_id ) {
    if ( !current_user_can( 'edit_user', $user_id ) ) {
        return false;
    }
    update_user_meta( $user_id, 'osobni_cislo', $_POST['osobni_cislo'] );
}

//==========================================================================================

add_action('manage_users_custom_column', 'mysite_custom_columns', 15, 3);
add_filter('manage_users_columns', 'mysite_columns', 15, 1);

function mysite_custom_define() {
  $custom_meta_fields = array();
  $custom_meta_fields['osobni_cislo'] = 'Osobní číslo';
  return $custom_meta_fields;
}

function mysite_columns($defaults) {
  $meta_number = 0;
  $custom_meta_fields = mysite_custom_define();
  foreach ($custom_meta_fields as $meta_field_name => $meta_disp_name) {
    $meta_number++;
    $defaults[('mysite-usercolumn-' . $meta_number . '')] = __($meta_disp_name, 'user-column');
  }
  return $defaults;
}

function mysite_custom_columns($value, $column_name, $id) {
  $meta_number = 0;
  $custom_meta_fields = mysite_custom_define();
  foreach ($custom_meta_fields as $meta_field_name => $meta_disp_name) {
    $meta_number++;
    if( $column_name == ('mysite-usercolumn-' . $meta_number . '') ) {
      return get_the_author_meta($meta_field_name, $id );
    }
  }
}



add_filter( 'get_the_archive_title', function ( $title ) {
  if( $title == 'Archivy: <span>Akce</span>' ) {
      $title = 'Přehled nadcházejících akcí';
  } 
  if( $title == 'Archivy: <span>Činnosti</span>' ) {
      $title = 'Přehled činností';
  }
  if( $title == 'Archivy: <span>Komponenty</span>' ) {
      $title = 'Přehled komponent';
  }
  if( $title == 'Archivy: <span>Typy komponent</span>' ) {
      $title = 'Přehled typů komponent';
  }
  if( $title == 'Archivy: <span>Závady</span>' ) {
      $title = 'Přehled závad';
  }
  if( $title == 'Archivy: <span>Výr. postupy</span>' ) {
      $title = 'Přehled výrobních postupů';
  }
  if( $title == 'Archivy: <span>Typy činností</span>' ) {
      $title = 'Přehled typů činností';
  }
  if( $title == 'Archivy: <span>Výr. dokumentace</span>' ) {
      $title = 'Přehled výrobní dokumentace';
  }
  if( $title == 'Archivy' ) {
      $title = 'Archiv';
  }
  return $title;
});

