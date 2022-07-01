<?php get_header();

while(have_posts()) {
  the_post(); ?>
  <h1 class="page-banner__title"><?php the_title(); ?></h1>
  <div class="generic-content">
    <?php the_content(); ?>
  </div>
  <?php    }

  get_footer();
?>
