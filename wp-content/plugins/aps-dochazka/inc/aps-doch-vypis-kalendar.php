<?php


function aps_doch_kalendar_page( $content ) {
    if ( get_the_ID() == get_option( 'aps_doch_options' )['aps_kalendar_page_id'] ) {
        zobraz_kalendar();
    }
    else {
        return $content;
    }
}
add_filter('the_content', 'aps_doch_kalendar_page');

function zobraz_kalendar() {

    $calmesicfull = array(
        '1' => 'Leden', '2' => 'Únor', '3' => 'Březen', '4' => 'Duben',
        '5' => 'Květen', '6' => 'Červen', '7' => 'Červenec', '8' => 'Srpen',
        '9' => 'Září', '10' => 'Říjen', '11' => 'Listopad', '12' => 'Prosinec'
    );
    
    if (isset($_GET['rok'])) $calrok=$_GET['rok']; else $calrok = date('Y');
    if (isset($_GET['mesic'])) $calmesic= $_GET['mesic']; else $calmesic = date('n');
    
    $calmesicprev = $calmesic;
    $calmesicnext = $calmesic;
    $calrokprev = $calrok;
    $calroknext = $calrok;

    if ($calmesic == 1) {
        $calmesicprev = 12;
        $calmesicnext = 2;
        $calrokprev--;
    } elseif ($calmesic == 12) {
        $calmesicnext = 1;
        $calmesicprev = 11;
        $calroknext++;
    } else {
        $calmesicprev--;
        $calmesicnext++;
    }
    ?>

<div class="posun-mesice">
    <div class="posun-mesice-box-left">
        <a class="tlacitko" href="<?php echo get_permalink(get_the_ID()) . '?rok=' . $calrokprev . '&mesic=' . $calmesicprev ?>"><<</a>
    </div>
    <div class="posun-mesice-box-center">
        <span><?php echo $calmesicfull[$calmesic] . ' ' . $calrok?></span>
    </div>
    <div class="posun-mesice-box-right">
        <a class="tlacitko" href="<?php echo get_permalink(get_the_ID()) . '?rok=' . $calroknext . '&mesic=' . $calmesicnext ?>">>></a>
    </div>
</div>

<?php 

$dnes = date('j');
$tentoRok = date('Y');
$tentoMesic = date('n');

$den = new DateTime($calrok . '-' . $calmesic);

$den->modify('first day of this month');
$prvniDen = $den->format('w');

$den->modify('last day of this month');
$pocetDnuVMesici = $den->format('j');

$pocetTydnu = ceil(($pocetDnuVMesici + $prvniDen - 1) / 7);
if($prvniDen == 0) $pocetTydnu++;
$pocetTydnu;

?>
<table id="event-calendar" class="event-calendar-table">
<thead>
<tr>
    <th scope="col" title="Pondělí">Po</th>
    <th scope="col" title="Úterý">Út</th>
    <th scope="col" title="Středa">St</th>
    <th scope="col" title="Čtvrtek">Čt</th>
    <th scope="col" title="Pátek">Pá</th>
    <th scope="col" title="Sobota">So</th>
    <th scope="col" title="Neděle">Ne</th>
</tr>
</thead>
<tbody>
<?php 
$i = $pocetTydnu;
$k = $pocetDnuVMesici;
$l = $prvniDen;
$m = 1;
if($l == 0) $l = 7;

while ($i--) {
    echo '<tr>';
    $j = 7;
    while ($j--) {
        if (($m - $l + 1) == $dnes AND (int)$calmesic == (int)$tentoMesic AND (int)$calrok == (int)$tentoRok) {
            echo '<td id="today">';
        } else {
            echo '<td>';
        }
        if ($m >= $l AND $m < ($k + $l)) {
            echo $n = $m - $l + 1;
            echo '</br>';
        } else {
            $n = 0;
        }

        if($n < 10) $n = '0' . $n;
        $requiredDay = $den->format('Ym') . $n;
        $eventsForRequiredDay = new WP_Query(array(
            'post_type' => 'event',
            'meta_query' => array(
                'relation' => 'AND',
                'event_date' =>array(
                    'key' => 'event_date',
                    'compare' => '=',
                    'value' => $requiredDay,
                    'type' => 'numeric'
                ),
                'event_time_from' =>array(
                    'key' => 'event_time_from',
                    'compare' => 'EXISTS',
                    'type' => 'numeric'
                )
            ),
            'posts_per_page' => 7,
            'orderby' => array (
                'event_date' => 'ASC',
                'event_time_from' => 'ASC',
                'title' => 'ASC'
                )
        ));
        ?>
        <div class="event-cal__title">
        <?php
        while($eventsForRequiredDay->have_posts()) {
            $eventsForRequiredDay->the_post(); 
        ?>
        <a href="<?php the_permalink(); ?>">>
        <?php the_title(); ?></a></br>
        <?php
        }
        ?></div><?php
        $m++;
        echo '</td>';
    }
    echo '</tr>';
}
?>
	</tbody>
	</table>
    <br>
<?php
}

?>