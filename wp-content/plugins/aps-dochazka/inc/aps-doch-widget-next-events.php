
<?php
// widget-next-events.php
// Register and load the widget
function load_widget_next_events() {
    register_widget( 'widget_next_events' );
}
add_action( 'widgets_init', 'load_widget_next_events' );

// Creating the widget
class widget_next_events extends WP_Widget {

function __construct() {
parent::__construct(

// Base ID of your widget
'widget_next_events',

// Widget name will appear in UI
__('Nadcházející akce', 'widget_next_events_domain'),

// Widget description
array( 'description' => __( 'Zobrazení nadcházejících akcí', 'widget_next_events_domain' ), )
);
}

// Creating widget front-end
public function widget( $args, $instance ) {
$title = apply_filters( 'widget_title', $instance['title'] );

// before and after widget arguments are defined by themes
echo $args['before_widget'];
if ( ! empty( $title ) )
echo $args['before_title'] . $title . $args['after_title'];

// This is where you run the code and display the output
?>
    <?php  
    $today = date('Ymd');
    $nextEvents = new WP_Query(array(
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
        'posts_per_page' => 5,
        'orderby' => array (
            'event_date' => 'ASC',
            'event_time_from' => 'ASC',
            'title' => 'ASC'
            )
    ));
    while($nextEvents->have_posts()) {
        $nextEvents->the_post(); 

$mes = array(
    'JAN' => 'LED', 'FEB' => 'ÚNO', 'MAR' => 'BŘE', 'APR' => 'DUB',
    'MAY' => 'KVĚ', 'JUN' => 'ČER', 'JUL' => 'ČVC', 'AUG' => 'SRP',
    'SEP' => 'ZÁŘ', 'OCT' => 'ŘÍJ', 'NOV' => 'LIS', 'DEC' => 'PRO'
  )
  ?>
  
    <div class="event-widget">
    <?php event_drobne_pismo(); ?>
        <div class="event-widget__title">
            <a href="<?php the_permalink(); ?>">
            <?php the_title(); ?></a>

        </div>
        
        

        <div class="event-widget__date t-center">
            <span class="event-widget__month"><?php
                $eventDate = new DateTime(get_field('event_date'));
                echo $mes[strtoupper($eventDate->format('M'))];
            ?></span>
            <span class="event-widget__day"><?php echo $eventDate->format('j') ?></span>
        </div>
    </div>
<?php } ?><br>
<div class="uprostred">
    <a class="ast-button" href="<?php echo get_permalink( get_option( 'aps_doch_options' )['aps_events_page_id']) ?>">Všechny akce</a>
</div>
<?php
echo $args['after_widget'];
}

// Widget Backend
public function form( $instance ) {
    if ( isset( $instance[ 'title' ] ) ) {
    $title = $instance[ 'title' ];
    }
    else {
    $title = __( 'Nadcházející akce', 'widget_next_events_domain' );
    }
    
    // Widget admin form
    ?>
    <p>
    <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Název:' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
    </p>
    <?php
    }
    
    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
    return $instance;
    }
    } // Class widget_next_events ends here
    
    // End widget_next_events.php
    ?>
