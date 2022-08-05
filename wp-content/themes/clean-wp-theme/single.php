
<?php get_header(); ?>

<?php while(have_posts()) {
    the_post(); ?>

    <div class="content-area group section">
      <!-- container -->
      <div class="container">
        <!-- row -->
        <div class="row">
          <!-- col -->
          <div class="col col-md-8 push-down-sm">
            <h2><?php the_title(); ?></h2>

            <!-- row -->
            <div class="row">
              <!-- col -->
              <div class="col col-xs-12">
                <p><?php the_content(); ?></p>
              </div>
              <!-- /col -->
            </div>
            <!-- /row -->
          </div>
          <!-- /col -->

          <!-- col -->
          <div class="col col-md-4 sidebar">
            <!-- <h3>Sidebar Heading</h3> -->
            <?php echo get_the_post_thumbnail(); ?>
            <!-- <p>Sidebar Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod.</p>

            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>

            <p>Dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod.</p> -->
          </div>
          <!-- /col -->
        </div>
        <!-- /row -->
      </div>
      <!-- /container -->
    </div>
    
<?php } ?>

<?php get_footer(); ?>
