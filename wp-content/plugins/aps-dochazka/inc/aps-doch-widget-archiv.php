<?php
// Register and load the widget
function aps_load_widget_archiv() {
    register_widget( 'aps_widget_archiv' );
}
add_action( 'widgets_init', 'aps_load_widget_archiv' );

// Creating the widget
class aps_widget_archiv extends WP_Widget {

function __construct() {
parent::__construct(

// Base ID of your widget
'aps_widget_archiv',

// Widget name will appear in UI
__('APS Docházka - Archiv', 'aps_widget_archiv_domain'),

// Widget description
array( 'description' => __( 'Zobrazení archivu docházky', 'aps_widget_archiv_domain' ), )
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
$aps_doch_url = get_permalink( get_option( 'aps_doch_options' )['aps_dochazka_page_id']);

$odroku=date("Y")-2;

//echo "<div style=\"width:270px;display:inline-block;position:relative;\">";

for($rok=date("Y")-1;$rok>=$odroku;$rok--){ ?>
	<div class="zapis-absence doch-widget doch-widget-inside-blue">
	<?php echo "<span>Rok " . $rok . "</span><br>"; ?>
	<?php
	if($rok==2017) {
		for($m=7; $m<=12;$m++){
			echo "<a href=\"" . $aps_doch_url . "?switch=4&mesic=" . $m . "&rok=" . $rok . "\" class=\"tlacitko\" style=\"width:36px;\">" . $m . "</a>";
			}
		}
	else {
		for($m=1; $m<=12;$m++){
			echo "<a href=\"" . $aps_doch_url . "?switch=4&mesic=" . $m . "&rok=" . $rok . "\" class=\"tlacitko\" style=\"width:36px;\">" . $m . "</a>";
			}
		}
	?>
	</div>
	<?php
	}
	echo '<br><p class="centered"><a href="' . $aps_doch_url . '?switch=5" class="ast-button">CELÝ ARCHIV</a></p>';
	echo $args['after_widget'];
}

// Widget Backend
public function form( $instance ) {
if ( isset( $instance[ 'title' ] ) ) {
$title = $instance[ 'title' ];
}
else {
$title = __( 'Archiv docházky', 'aps_widget_archiv_domain' );
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
