<?php get_header(); ?>

<div class="content-area group section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
        <!-- col -->
        <div class="col col-md-8 push-down-sm">
            <h2>Welcome to the Front page!</h2>

            <!-- row -->
            <div class="row">
                <!-- col -->
                <div class="col col-sm-6 col-lg-3">
                    <!-- box-a -->
                    <div class="box-a">
                    <p>Key feature 1</p>
                    </div>
                    <!-- /box-a -->
                </div>
                <!-- /col -->

                <!-- col -->
                <div class="col col-sm-6 col-lg-3">
                    <!-- box-a -->
                    <div class="box-a">
                    <p>Key feature 2</p>
                    </div>
                    <!-- /box-a -->
                </div>
                <!-- /col -->

                <!-- col -->
                <div class="col col-sm-6 col-lg-3">
                    <!-- box-a -->
                    <div class="box-a">
                    <p>Key feature 3</p>
                    </div>
                    <!-- /box-a -->
                </div>
                <!-- /col -->

                <!-- col -->
                <div class="col col-sm-6 col-lg-3">
                    <!-- box-a -->
                    <div class="box-a">
                    <p>Key feature 4</p>
                    </div>
                    <!-- /box-a -->
                </div>
                <!-- /col -->
            </div>
            <!-- /row -->

            <!-- row -->
            <div class="row">
                <!-- col -->
                <div class="col col-xs-6 frontpage">
                    <?php
                    $the_query = new WP_Query([
                        'post_type' => 'page'
                    ]);
                    if ($the_query->have_posts()) {
                        while ($the_query->have_posts()) {
                            $the_query->the_post();
                        } ?>
                        <a href="<?php the_permalink(); ?>"><?php echo get_the_post_thumbnail(); ?>
                        <p>Last page: <?php the_title(); ?></p></a>
                    <?php
                    } else {
                        echo 'no pages found';
                    }
                    wp_reset_postdata(); ?>
                </div>
                <!-- /col -->

                <!-- col -->
                <div class="col col-xs-6 frontpage">
                    <?php
                    $the_query = new WP_Query([
                        'post_type' => 'post'
                    ]);
                    if ($the_query->have_posts()) {
                        while ($the_query->have_posts()) {
                            $the_query->the_post();
                        } ?>
                        <a href="<?php the_permalink(); ?>"><?php echo get_the_post_thumbnail(); ?>
                        <p>Last post: <?php the_title(); ?></p></a>
                    <?php
                    } else {
                        echo 'no posts found';
                    }
                    wp_reset_postdata(); ?>
                </div>
                <!-- /col -->
            </div>
            <!-- /row -->
        </div>
        <!-- /col -->
            <!-- col -->
            <div class="col col-md-4 sidebar">
                <h3>Sidebar Heading</h3>
                <p>Sidebar Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod.</p>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>

                <p>Dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod.</p>
            </div>
            <!-- /col -->
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>

<?php get_footer(); ?>
