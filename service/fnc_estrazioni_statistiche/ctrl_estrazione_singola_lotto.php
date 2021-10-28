
<?php
require_once ("funzioni/global.php");
// (select * from es_lotto where esdata < '2015-09-29' order by EsData desc limit 1) UNION (select * from es_lotto where esdata > '2015-09-29' order by EsData asc limit 1)

if (isset ( $_GET ['estrazione_lotto'] )) {
	$estrazione_lotto = $_GET ['estrazione_lotto'];
} else {
	$estrazione_lotto = '';
}

$data = new MysqlClass ();
$data->connetti ();

$i_prec = $data->query ( "select EsData from es_lotto where esdata < '$estrazione_lotto' order by EsData desc limit 1" );
if (mysqli_num_rows ( $i_prec ) > 0) {
	$prec = $data->estrai ( $i_prec );
} else {
	$prec = 0;
}

$i_succ = $data->query ( "select EsData from es_lotto where esdata > '$estrazione_lotto' order by EsData asc limit 1" );
if (mysqli_num_rows ( $i_succ ) > 0) {
	$succ = $data->estrai ( $i_succ );
} else {
	$succ = 0;
}

if ($estrazione_lotto != '') {
	$estrazione = $data->query ( "SELECT * FROM es_lotto where EsData = '$estrazione_lotto';" );
} else {
	$estrazione = $data->query ( "SELECT * FROM es_lotto order by EsData desc limit 1;" );
}

if (@mysqli_num_rows ( $estrazione ) > 0) {
	$numeruote = array (
			"Bari",
			"Cagliari",
			"Firenze",
			"Genova",
			"Milano",
			"Napoli",
			"Palermo",
			"Roma",
			"Torino",
			"Venezia",
			"Nazionale" 
	);
	
	$conta = 0;
	
	echo '<div class="tab-content">';
	// $estrazione = $data->query ( "SELECT * FROM es_lotto order by esdata desc limit $numero_estrazione;" );
	
	$index_numeri = 0;
	while ( $rows = $data->estrai ( $estrazione ) ) {
		$ruote = array ();
		$conta = $conta + 1;
		$es_data = $rows->EsData;
		$ruote [] = $rows->Bari;
		$ruote [] = $rows->Cagliari;
		$ruote [] = $rows->Firenze;
		$ruote [] = $rows->Genova;
		$ruote [] = $rows->Milano;
		$ruote [] = $rows->Napoli;
		$ruote [] = $rows->Palermo;
		$ruote [] = $rows->Roma;
		$ruote [] = $rows->Torino;
		$ruote [] = $rows->Venezia;
		$ruote [] = $rows->Nazionale;
		
		$originalDate = $es_data;
		setlocale ( LC_TIME, 'it_IT' );
		$newDate = strftime ( "%A %d %B %Y", strtotime ( $es_data ) ); // date ( "d.m.Y", strtotime ( $originalDate ) );
		$newDate = str_replace ( "ì", "&igrave", $newDate );
		if ($conta == 1) {
			$active = " active ";
		} else {
			$active = "";
		}
		echo '<div role="tabpanel" class="tab-pane' . $active . '" id="estlotto' . $conta . '">';
		echo '<div class="row">';
		
		echo '<div class="col-sm-12 text-center">'; 
		echo '<h2 class="titolo row">Estrazione del lotto<br />' . $newDate . '</h2>';
		$html = '';
		$html .= '<ul class="pager">';
		if ($prec != 0) {
			$html .= '<li class="previous"><a href="?estrazione_lotto=' . ($prec->EsData) . '"><< ' . data_estesa(($prec->EsData)) . '</a></li>';
		}
		if ($succ != 0) {
		
			$html .= '<li class="next" ><a href="?estrazione_lotto=' . ($succ->EsData) . '">' . data_estesa($succ->EsData) . ' >></a></li>';
		}
		echo $html;
		echo '</div>';
		// echo '<div class="col-md-7">';
		
		echo '<table class="table table-condensed table-bordered table-striper table-striped" style="font-size: 1.3em;">';
		// echo '<tr><td colspan="6">Estrazione del ' . $newDate . '<td></tr>';
		for($i = 0; $i <= 10; $i ++) {
			echo '<tr>';
			echo '<td class="ruotestyle text-left nowrap ruo">' . $numeruote [$i] . '</td>';
			
			$Num = explode ( ",", $ruote [$i] );
			
			for($i2 = 0; $i2 <= 4; $i2 ++) {
				$Num [$i2] = check_numero ( $Num [$i2] );
				echo "<td id=\"numes$index_numeri\">$Num[$i2]</td>";
				$index_numeri = $index_numeri + 1;
			} // next for $i2
			echo "</tr>"; // plglcd_ruote
		} // next for $i
		echo "</table>"; // plglcd_estrazioni
		                 // echo "</div>"; // col-md-7
		echo "</div>"; // row
		echo "</div>"; // tabpanel
	} // end while
	
	echo "</div>"; // tab-content
}

$data->disconnetti ();
?>
