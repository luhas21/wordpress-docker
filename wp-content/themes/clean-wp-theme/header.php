<!DOCTYPE html>
<html>
    <head>
        <?php wp_head(); ?>
    </head>
    <body>
        <header class="site-header">
            <div class="container">
            <h1 class="school-logo-text float-left"><a href="<?php echo site_url('') ?>"><strong><?php echo get_bloginfo('name') ?></strong></a></h1>
            <span class="js-search-trigger site-header__search-trigger"><i class="fa fa-search" aria-hidden="true"></i></span>
            <i class="site-header__menu-trigger fa fa-bars" aria-hidden="true"></i>
            <div class="site-header__menu group">
                <nav class="main-navigation">
                <ul>
                    <li><a href="#">Nabídka 1</a></li>
                    <li><a href="#">Nabídka 2</a></li>
                    <li><a href="#">Nabídka 3</a></li>
                    <li><a href="#">Nabídka 4</a></li>
                </ul>
                </nav>
            </div>  
            </div>
        </header>

<h1>Tady je header.php!</h1>