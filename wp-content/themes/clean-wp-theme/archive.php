
<?php get_header(); ?>

    <div class="content-area group section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <!-- col -->
                <div class="col col-md-9 push-down-sm">

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
                            <div class="col col-xxs-12 col-xs-6 col-sm-4 col-md-6 col-lg-4 push-down-sm">
                                <div class="frontpage-container">
                                    <div class="frontpage">
                                        <a href="<?php the_permalink(); ?>"><?php echo get_the_post_thumbnail(); ?>
                                        <p><?php the_title(); ?></p>
                                        <p><?php echo substr(wp_strip_all_tags(get_the_content()), 0, 150) . "...";?></p></a>
                                    </div>
                                </div>
                            </div>
                            <!-- /col -->
                        <?php } ?>
                    </div>
                    <!-- /row -->

                </div>
                <!-- /col -->

                <!-- col -->
                <div class="col col-md-3 sidebar">
                    <?php dynamic_sidebar( 'primary' ); ?>
                </div>
                <!-- /col -->

            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>

<?php get_footer(); ?>
