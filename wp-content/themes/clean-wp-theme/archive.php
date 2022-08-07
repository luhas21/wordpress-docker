
<?php get_header(); ?>

    <div class="content-area group section">
        <!-- container -->
        <div class="container">

        <?php
        // Display optional category description
        if (category_description()) { ?>
            <div class="archive-meta"><h2><?php echo category_description(); ?></h2></div>
        <?php } ?>

            <!-- row -->
            <div class="row">

                <?php
                while (have_posts()) {
                    the_post(); ?>

                    <!-- col -->
                    <div class="col col-xs-4">
                        <div class="frontpage">
                            <a href="<?php the_permalink(); ?>"><?php echo get_the_post_thumbnail(); ?>
                            <p><?php the_title(); ?></p>
                            <p><?php echo "<br><br>" . substr(wp_strip_all_tags(get_the_content()), 0, 210) . "...";?></p></a>
                        </div>
                    </div>
                    <!-- /col -->                
                <?php } ?>

            </div>
            <!-- /row -->

        </div>
        <!-- /container -->
    </div>

<?php get_footer(); ?>
