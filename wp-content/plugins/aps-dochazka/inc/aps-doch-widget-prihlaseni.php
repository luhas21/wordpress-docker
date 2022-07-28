<?php
// Register and load the widget
function aps_load_widget_prihlaseni() {
    register_widget( 'aps_widget_prihlaseni' );
}
add_action( 'widgets_init', 'aps_load_widget_prihlaseni' );

// Creating the widget
class aps_widget_prihlaseni extends WP_Widget {

function __construct() {
parent::__construct(

// Base ID of your widget
'aps_widget_prihlaseni',

// Widget name will appear in UI
__('APS Docházka - Přihlášení', 'aps_widget_prihlaseni_domain'),

// Widget description
array( 'description' => __( 'Přihlášení do docházky', 'aps_widget_prihlaseni_domain' ), )
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
<div class="zapis-absence doch-widget doch-widget-inside-blue">
Aplikace Docházka 3000<br>
	<em>(otevře se v novém okně)</em>
<br><br>
<a href="<?php echo get_option( 'aps_doch_options' )['url']; ?>/dochazka2001/mezikrok.php?firma=1" class="ast-button" target="_blank">PŘIHLÁŠENÍ</a>
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
    $title = __( 'Přihlášení do docházky', 'aps_widget_prihlaseni_domain' );
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
    