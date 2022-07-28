<?php

function aps_doch_past_events_page( $content ) {
    if ( get_the_ID() == get_option( 'aps_doch_options' )['aps_past_events_page_id'] ) {
        zobraz_past_events();
    }
    else {
        return $content;
    }
}
add_filter('the_content', 'aps_doch_past_events_page');

function zobraz_past_events() {
?>
  <!-- container -->
  <?php  
    $today = date('Ymd');
    $pastEvents = new WP_Query(array(
      'post_type' => 'event',
      'meta_query' => array(
          'relation' => 'AND',
          'event_date' =>array(
              'key' => 'event_date',
              'compare' => '<',
              'value' => $today,
              'type' => 'numeric'
          ),
          'event_time_from' =>array(
              'key' => 'event_time_from',
              'compare' => 'EXISTS',
              'type' => 'numeric'
          )
      ),
      'paged' => get_query_var('paged', 1), 
      'posts_per_page' => 10,
      'orderby' => array (
          'event_date' => 'DESC',
          'event_time_from' => 'DESC',
          'title' => 'DESC'
          )
    ));

    while($pastEvents->have_posts()) {
      $pastEvents->the_post(); 
      event_content(); ?>
 
      <div class="generic-content">
        <p class="event-list-divider"><a class="ast-button" href="<?php the_permalink(); ?>">Detail akce</a></p>
      </div>
      <?php    }
      echo "<br>" . str_replace( 'page-numbers', 'ast-button', paginate_links(array(
        'total' => $pastEvents->max_num_pages
      )));
}