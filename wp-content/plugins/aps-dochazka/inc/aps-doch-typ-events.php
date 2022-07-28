<?php

add_action('init', 'speelnet_typ_akce');

function speelnet_typ_akce() {
    
  // Event Post type
  register_post_type('event', array(
    'capability_type' => 'event',
    'map_meta_cap' => true,
    'supports' => array('title', 'editor', 'excerpt', 'thumbnail'),
    'rewrite' => array('slug' => 'events'),
    'has_archive' => true,
    'public' => true,
    'labels' => array(
      'name' => 'Akce',
      'add_new_item' => 'Přidat novou akci',
      'add_new' => 'Přidat novou akci',
      'edit_item' => 'Upravit akci',
      'all_items' => 'Všechny akce',
      'singular_name' => 'Akce'
    ),
    'menu_icon' => 'dashicons-calendar'
  ));
}
