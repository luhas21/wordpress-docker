<?php get_header(); ?>

<?php while(have_posts()) {
  the_post(); ?>
  <h2 class="page-banner__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
  <div class="generic-content">
    <?php the_content(); ?>
  </div>
  <?php } ?>

<?php get_footer();

?>

