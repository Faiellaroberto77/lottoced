<?php
require_once ("../funzioni/global.php");
$data = new MysqlClass ();
$data->connetti ();
$estrazione = $data->query ( "SELECT * FROM LottoCED.es_millionday where EsData = DATE(NOW());");
$qrowest = array();

if (@mysqli_num_rows ( $estrazione ) > 0) {
    while ( $rows = $data->estrai ( $estrazione ) ) {
        $qrowest[] = $rows;
    }
    foreach ($qrowest as $rowest){
	    $arrEst = explode(",", $rowest->estratti)
	    
	    ?>
		<div class="alert alert-info text-center" role="alert">
			<h2>Estrazione di oggi <?php echo dataestesa_million($rowest->esdata)?></h2>
				<div class="container">
				<?php foreach ($arrEst as $num){echo "<li class=\"btn btn-default btn-md\" style=\"margin-right: 5px;\">" . check_numero($num). "</li>";}?>
				</div>
		<?php 
	}
	?>
	</div>
	<?php
    
} else {
    ?> 
        <div class="alert alert-info text-center" role="alert" style="font-size: 1.5em">
        <h2>Prossima estrazione <strong>Million day</strong></h2>
        <h2>oggi <?php echo dataestesa_million(date ("Y-m-d")); ?> <strong>alle 19:00</strong></h2>
			
        </div>
    <?php 
}

$data->disconnetti();

function dataestesa_million($es_data) {
    $originalDate = $es_data;
    setlocale ( LC_TIME, 'it_IT' );
    $newDate = strftime ( "%d %B %Y", strtotime ( $es_data ) ); // date ( "d.m.Y", strtotime ( $originalDate ) );
   
    return $newDate;
}
?>
