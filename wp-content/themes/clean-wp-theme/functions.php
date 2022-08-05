<?php 

$codeset = "UTF8"; setlocale(LC_ALL, "cs_CZ.UTF-8", "Czech", "cs_CZ");

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('style', get_stylesheet_uri(), NULL, microtime());
    wp_enqueue_script('moje-hlavni-js', get_theme_file_uri('/js/script.js'), NULL, microtime(), '1.0', true);
/*    wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    wp_enqueue_style('font-awsome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'); */
});

add_action('after_setup_theme', function() {
    // Main menu
    register_nav_menu('mainMenuLocation', 'Main Menu Location');
    // Title tag
    add_theme_support('title-tag');
    // Post and Pages featured image
    add_theme_support('post-thumbnails');
});

add_action('widgets_init', function () {
    /* Register the 'primary' sidebar. */
    register_sidebar([
            'id'            => 'primary',
            'name'          => __( 'Primary Sidebar' ),
            'description'   => __( 'This is a primary sidebar.' ),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ]
    );
    /* Repeat register_sidebar() code for additional sidebars. */
});
