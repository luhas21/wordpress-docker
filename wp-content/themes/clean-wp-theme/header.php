<!DOCTYPE html>
<html>
    <head>
        <?php wp_head(); ?>
    </head>
    <body>
        <header class="site-header">
            <div class="container">
            <h1 class="school-logo-text float-left"><a href="<?php //echo site_url('') ?>"><strong><?php //echo get_bloginfo('name') ?></strong></a></h1>
            <span class="js-search-trigger site-header__search-trigger"><i class="fa fa-search" aria-hidden="true"></i></span>
            <i class="site-header__menu-trigger fa fa-bars" aria-hidden="true"></i>
            <div class="site-header__menu group">
                <nav class="main-navigation">
                    <?php wp_nav_menu(['theme_location' => 'mainMenuLocation', 'menu_class' => 'main-wp-menu']); ?>
                </nav>
            </div>  
            </div>
        </header>
