<?php

// Nastaví site jako privátní - vstup jen po přihlášení
add_action('template_redirect', 'privateSite');

function privateSite() {
  if(!is_user_logged_in()) {
    wp_redirect(esc_url(site_url('/wp-login.php')));
    exit;
  }
}

/*
if(!is_user_logged_in()) {
    wp_redirect(esc_url(get_home_url(get_current_blog_id()).'/wp-login.php'));
    exit;
  }

site_url('/wp-login.php')

die('Konec');
*/


/* Vypnutí REST API pro nepřihlášené */
  add_filter('rest_authentication_errors', 'vypniREST');
  // Vypnutí pro nepřihlášené
  function vypniREST($result) {
    if(!empty($result)) {
      return $result;
    }
    if(!is_user_logged_in()) {
      return new WP_Error('no_data', 'No data submitted.', array('status' => 401));
    }    
/*    // Vypnutí pro všechny kromě administrátory
//    if(!current_user_can('administrator')) {
//      return new WP_Error('rest_not_admin','You are not an administrator.',array('status' => 401));
//    }
*/
    return $result;
  }


// Customize Login Screen
add_filter('login_headerurl', 'ourHeaderUrl');

function ourHeaderUrl() {
  return esc_url(site_url('/'));
}

add_action('login_enqueue_scripts', 'ourLoginCSS');

function ourLoginCSS() {
  wp_enqueue_style('moje_hlavni_styly', get_stylesheet_uri());
}

add_action( 'login_head', 'hide_login_nav' );

function hide_login_nav() { ?>
    <style>/*#nav,*/ #backtoblog{display:none}</style>
    <?php
}

function change_lost_your_password ($text) {

  if ($text == 'Zapomněli jste heslo?'){
      $text = 'Nastavení hesla';

  }
         return $text;
  }
add_filter( 'gettext', 'change_lost_your_password' );


// Redirect subscriber accounts out of admin and onto homepage
add_action('admin_init', 'redirectSubsToFrontend');

function redirectSubsToFrontend() {
  $currentUser = wp_get_current_user();
  if (is_admin() AND $currentUser->roles[0] == 'subscriber') {
    wp_redirect(esc_url(site_url('/')));
    exit;
  }
}
/*
function redirectSubsToFrontend() {
  if(!is_admin()) return;
  $currentUser = wp_get_current_user();
  if (count($currentUser->roles) == 1 AND $currentUser->roles[0] == 'subscriber') {
    wp_redirect(esc_url(site_url('/')));
    exit;
  }
}
*/
// Skrytí admin bar pro Subscribers
add_action('wp_loaded', 'noSubsAdminBar');

function noSubsAdminBar() {
  $ourCurrentUser = wp_get_current_user();
  
  if (count($ourCurrentUser->roles) == 1 AND $ourCurrentUser->roles[0] == 'subscriber') {
    show_admin_bar(false);
  }
}

/**
 * Allows visitors to page forward/backwards in any direction within month view
 * an "infinite" number of times (ie, outwith the populated range of months).
 */
/* 
if ( class_exists( 'Tribe__Events__Main' ) ) {
 
  class ContinualMonthViewPagination {
      public function __construct() {
          add_filter( 'tribe_events_the_next_month_link', array( $this, 'next_month' ) );
          add_filter( 'tribe_events_the_previous_month_link', array( $this, 'previous_month' ) );
      }
 
      public function next_month() {
          $url = tribe_get_next_month_link();
          $text = tribe_get_next_month_text();
          $date = Tribe__Events__Main::instance()->nextMonth( tribe_get_month_view_date() );
          return '<a data-month="' . $date . '" href="' . $url . '" rel="next">' . $text . ' <span>&raquo;</span></a>';
      }
 
      public function previous_month() {
          $url = tribe_get_previous_month_link();
          $text = tribe_get_previous_month_text();
          $date = Tribe__Events__Main::instance()->previousMonth( tribe_get_month_view_date() );
          return '<a data-month="' . $date . '" href="' . $url . '" rel="prev"><span>&laquo;</span> ' . $text . ' </a>';
      }
  }
 
  new ContinualMonthViewPagination;
 
}
*/
?>