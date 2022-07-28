
<?php
// aps-doch-widget-pocasi.php
// Register and load the widget
function aps_load_widget_pocasi() {
    register_widget( 'aps_widget_pocasi' );
}
add_action( 'widgets_init', 'aps_load_widget_pocasi' );

// Creating the widget
class aps_widget_pocasi extends WP_Widget {

function __construct() {
parent::__construct(

// Base ID of your widget
'aps_widget_pocasi',

// Widget name will appear in UI
__('Počasí v Praze', 'aps_widget_pocasi_domain'),

// Widget description
array( 'description' => __( 'Zobrazení počasí v Praze', 'aps_widget_pocasi_domain' ), )
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
<a href="https://www.in-pocasi.cz/predpoved-pocasi/cz/praha/praha-324/" target="_blank" title="In-počasí">
<div class="pocasi centered">
<script type="text/javascript" src="https://www.in-pocasi.cz/pocasi-na-web/pocasi-na-web.php?typ=light&amp;layout=pruh&amp;region=14&amp;barva-den=5f76d3&amp;barva-teplota=1b2a64&amp;dni=5">
</script>	
</div>
</a>
<?php
echo $args['after_widget'];
}

// Widget Backend
public function form( $instance ) {
    if ( isset( $instance[ 'title' ] ) ) {
    $title = $instance[ 'title' ];
    }
    else {
    $title = __( 'Počasí v Praze', 'aps_widget_pocasi_domain' );
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
    } // Class aps_widget ends here
    
    // End widget-pocasi.php
    ?>
