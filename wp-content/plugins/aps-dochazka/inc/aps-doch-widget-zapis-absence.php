
<?php
// zapis-absence.php
// Register and load the widget
function aps_load_widget_zapis() {
    register_widget( 'aps_widget_zapis' );
}
add_action( 'widgets_init', 'aps_load_widget_zapis' );

// Creating the widget
class aps_widget_zapis extends WP_Widget {

    function __construct() {
        parent::__construct(

        // Base ID of your widget
        'aps_widget_zapis',

        // Widget name will appear in UI
        __('APS Docházka - Zápis absence', 'aps_widget_zapis_domain'),

        // Widget description
        array( 'description' => __( 'Zápis nebo mazání celodenní absence v docházce.', 'aps_widget_zapis_domain' ), )
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
        ?>
        <div class="zapis-absence doch-widget doch-widget-inside-blue">
        <form action="<?php echo $aps_doch_url ?>">DATUM OD<br>
            <input type="date" id="start" name="datum" value="<?php echo date("Y"); ?>-<?php echo date("m"); ?>-<?php echo date("d"); ?>">
            <br>POČET DNŮ<br>
            <input type="number" name="pocetdnu" min="1" max="30" value="1">
            <br>POZNÁMKA<br>
            <input class="poznamka event-list-divider" type="text" name="poznamka" size="70" placeholder="Text poznámky">
            <p class="dochazka-divider"></p>
            DŮVOD
            <div class="duvod_absence">
                <input name="absence" type="radio" value="1" required> Dovolená<br>
                <input name="absence" type="radio" value="2"> Nemoc<br>
                <input name="absence" type="radio" value="3"> Služební cesta<br>
                <input name="absence" type="radio" value="4"> OČR<br>
                <input name="absence" type="radio" value="5"> Překážka<br>
                <input name="absence" type="radio" value="6"> Návštěva lékaře<br>
                <input name="absence" type="radio" value="8"> Náhradní volno<br>
                <input name="absence" type="radio" value="9"> Omluvená absence<br>
                <input name="absence" type="radio" value="10"> Mateřská dovolená<br>
                <input name="absence" type="radio" value="11"> Vojenské cvičení<br>
                <input name="absence" type="radio" value="12"> Home Office
                <p class="dochazka-divider"></p>
                <p class="cervena dochazka-divider"><input name="absence" type="radio" value="0"> SMAZAT ABSENCI</p>
            </div>
            <input type="hidden" id="switchID" name="switch" value="99">
            <input type="hidden" id="poznID" name="pozn" value="1">
            <input type="submit" value="ULOŽIT/SMAZAT ABSENCI" class="tlacitko"></form>
        </div>
        <?php
        echo $args['after_widget'];
    }

    // Widget Backend
    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        } else {
            $title = __( 'Zápis celodenní absence', 'aps_widget_zapis_domain' );
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
} // Class wpb_widget ends here
// End zapis-absence.php
?>

