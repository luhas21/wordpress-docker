<?php

function aps_doch_events_page( $content ) {
    if ( get_the_ID() == get_option( 'aps_doch_options' )['aps_events_page_id'] ) {
        zobraz_events();
    }
    else {
        return $content;
    }
}
add_filter('the_content', 'aps_doch_events_page');

function zobraz_events() {
    ?>

<!-- container -->
<div>     
    <?php 
    $today = date('Ymd');
    $futureEvents = new WP_Query(array(
        'post_type' => 'event',
        'meta_query' => array(
            'relation' => 'AND',
            'event_date' =>array(
                'key' => 'event_date',
                'compare' => '>=',
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
            'event_date' => 'ASC',
            'event_time_from' => 'ASC',
            'title' => 'ASC'
            )
    ));
    if($futureEvents->have_posts()) {
    while($futureEvents->have_posts()) {
        $futureEvents->the_post(); 
        ?>
        <div class="generic-content">
        <?php event_content(); ?>
        <p class="event-list-divider"><a class="ast-custom-button" href="<?php the_permalink(); ?>">Detail akce</a></p>
        </div>
        <?php    }
    echo "<br>" . str_replace( 'page-numbers', 'ast-button', paginate_links(array(
        'total' => $futureEvents->max_num_pages
    )));
    } else { ?>
    <p>Nejsou naplánovány žádné nadcházející akce.</p><hr>
    <?php } ?>
    <br><p>Chcete zobrazit dřívější akce? <a class="ast-button" href="<?php  echo get_permalink( get_option( 'aps_doch_options' )['aps_past_events_page_id']) ?>"> Projděte si archiv akcí</a></p>
</div>

<?php
}

// Výpis single event

function add_event_content() {
  // bail if this current post type is different.
  if ( 'event' !== get_post_type() ) {
      return;
  }
  
  if ( is_search() ) {
    //echo '<div style="position: absolute; top: 0; left: 7px;">';
    date_icon();
    //echo '</div>';
    return;
  }
  ?>
  <!-- Tabulka v single event page -->
<div class="event-detail">
<table class="event-detail__table">
<tr>
  <td>
  <?php event_content(); ?>
  </td>
  <td>
  <?php
    $eventDate = new DateTime(get_field('event_date'));
    echo 'Datum: <strong>';
    echo $eventDate->format('j') . '.';
    echo $eventDate->format('n') . '.';
    echo $eventDate->format('Y');
  ?></strong></br>
  <?php if(get_field('event_time_from')) { ?>
  <span class="event-detail__time"><?php 
    $eventTime = new DateTime(get_field('event_time_from'));
    echo 'Čas: <strong>';
    echo $eventTime->format('G') . ':';
    echo $eventTime->format('i');
  ?></strong></span>
  <?php } ?>
  <?php if(get_field('event_time_to')) { ?>
  <span class="event-detail__time"><?php 
    $eventTime = new DateTime(get_field('event_time_to'));
    echo '<strong> - ';
    echo $eventTime->format('G') . ':';
    echo $eventTime->format('i');
  ?></strong></span>
  <?php } ?>
  </td>
  <td>
  <span class="event-detail__date"><?php
    echo 'Místo: <strong>';
    echo get_field('event_place');
  ?></strong></span></br>
  <span class="event-detail__organizer"><?php
    echo 'Organizuje: <strong>';
    echo get_field('event_organizer');
  ?></strong></span>
  </td>
</tr>
</table>
</div>
<?php
}
add_action( 'astra_entry_content_before', 'add_event_content' );

function event_content() {?>  
  <div class="event-summary">
  <div class="event-text">
  <?php
  if(!is_single() && !is_search()) {  
  date_icon();?>
  <div class="event-summary__text">
    <a href="<?php the_permalink(); ?>"><h3 class="entry-title next-closer">
        <?php the_title(); ?></h3></a>
        <?php event_drobne_pismo(); ?>
    <div class="event-summary__content">
        <p><?php if (has_excerpt()) {
            echo get_the_excerpt();
          } else {
            echo wp_trim_words(get_the_content(), 18);
          } ?></p>
    </div>
  </div>
  <div class="event-summary__picture">
  <a href="<?php the_permalink(); ?>">
  <?php the_post_thumbnail('medium'); ?>
  </a>
  </div>
  
  <?php 
  } else {
    date_icon();
  } 
  ?>
  </div>
  </div>
  <?php
}

function date_icon() {
  
  $mes = array(
    'JAN' => 'LED', 'FEB' => 'ÚNO', 'MAR' => 'BŘE', 'APR' => 'DUB',
    'MAY' => 'KVĚ', 'JUN' => 'ČER', 'JUL' => 'ČVC', 'AUG' => 'SRP',
    'SEP' => 'ZÁŘ', 'OCT' => 'ŘÍJ', 'NOV' => 'LIS', 'DEC' => 'PRO'
  )
  ?>
  <div class="event-summary__date t-center">
    <span class="event-summary__month"><?php
      $eventDate = new DateTime(get_field('event_date'));
      echo $mes[strtoupper($eventDate->format('M'))];
    ?></span>
    <span class="event-summary__day"><?php echo $eventDate->format('j') ?></span>
    <span class="event-summary__time">
    <?php if(get_field('event_time_from')) { 
      $eventTime = new DateTime(get_field('event_time_from'));
      echo $eventTime->format('G') . ':';
      echo $eventTime->format('i');
    } else {
      echo '---';
    } ?></span>
  </div>
<?php 
}

function event_drobne_pismo() { ?>
  <i class="event-drobne-pismo">
  <?php
      $eventDate = new DateTime(get_field('event_date'));
      echo $eventDate->format('j') . '.';
      echo $eventDate->format('n') . '.';
      echo $eventDate->format('Y');
      ?></i>
  <?php if(get_field('event_time_from')) { ?>
      <i class="event-drobne-pismo"><?php 
      $eventTime = new DateTime(get_field('event_time_from'));
      echo '/ ';
      echo $eventTime->format('G') . ':';
      echo $eventTime->format('i');
  ?></i>
  <?php } ?>
  <?php if(get_field('event_time_to')) { ?>
  <i class="event-drobne-pismo"><?php 
      $eventTime = new DateTime(get_field('event_time_to'));
      echo ' - ';
      echo $eventTime->format('G') . ':';
      echo $eventTime->format('i');
  ?></i>
  <?php }
}
?>
