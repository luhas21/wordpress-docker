<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title><?php echo get_bloginfo('name') ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <?php wp_head(); ?>
    </head>

    <body>
        <header class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <!-- col -->
                <div class="col col-md-3 push-down-sm">
                    <h1><a href="<?php echo site_url('') ?>"><?php echo get_bloginfo('name') ?></a></h1>
                    <p class="hide-small"><a href="<?php echo site_url('') ?>"><?php echo get_bloginfo('description') ?></a></p>
                </div>
                <div class="col col-md-9 push-down-sm">
                    <nav class="site-nav"><?php wp_nav_menu(['theme_location' => 'mainMenuLocation', 'menu_class' => 'main-wp-menu']); ?>
                    </nav>
                </div>
            </div>
            <!-- /col -->
        </div>
        <!-- /row -->
        </div>
        <!-- /container -->
        </header>
