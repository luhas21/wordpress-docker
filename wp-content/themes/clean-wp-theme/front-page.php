<?php get_header(); ?>

<div class="content-area group section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
        <!-- col -->
        <div class="col col-md-9 push-down-sm">
            <h2>Vítejte na stránce eČasopisu Luhas.cz</h2>

            <h2>Nejnovější příspěvky</h2>

            <!-- row -->
            <div class="row">

                        <?php
                        $the_query = new WP_Query([
                            'post_type' => 'post',
                            'posts_per_page' => 4
                        ]);
                        if ($the_query->have_posts()) { 
                            while ($the_query->have_posts()) {
                                $the_query->the_post(); ?>
                                <!-- col -->
                                <div class="col col-xs-6">
                                    <div class="frontpage">
                                            <a href="<?php the_permalink(); ?>"><?php echo get_the_post_thumbnail(); ?>
                                            <p><?php the_title(); ?></p>
                                            <p><?php echo "<br><br>" . substr(wp_strip_all_tags(get_the_content()), 0, 210) . "...";?></p></a>
                                    </div>
                                </div>
                                <!-- /col -->
                            <?php }
                        } else {
                            echo 'no pages found';
                        }
                        wp_reset_postdata(); ?>
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
