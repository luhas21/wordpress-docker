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
        <h1><a href="<?php echo site_url('') ?>"><?php echo get_bloginfo('name') ?></a></h1>
        <p class="hide-small"><a href="<?php echo site_url('') ?>"><?php echo get_bloginfo('description') ?></a></p>
        <nav class="site-nav"><?php wp_nav_menu(['theme_location' => 'mainMenuLocation', 'menu_class' => 'main-wp-menu']); ?>
        </nav>
      </div>
      <!-- /container -->
    </header>
