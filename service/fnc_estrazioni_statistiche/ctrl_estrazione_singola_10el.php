
<?php
require_once ("funzioni/global.php");
// (select * from es_lotto where esdata < '2015-09-29' order by EsData desc limit 1) UNION (select * from es_lotto where esdata > '2015-09-29' order by EsData asc limit 1)

if (isset ( $_GET ['estrazione_10_e_lotto'] )) {
	$estrazione_lotto = $_GET ['estrazione_10_e_lotto'];
} else {
	$estrazione_lotto = '';
}

if (isset ( $_GET ['group'] )) {
	$group = $_GET ['group'];
} else {
	$group = 5;
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
$conta = 0;
if (@mysqli_num_rows ( $estrazione ) > 0) {
	echo '<div class="tab-content">';
	while ( $rows = $data->estrai ( $estrazione ) ) {
		$conta = $conta + 1;
		$es_data = $rows->EsData;
		$estrazi = $rows->diecieLotto;
		$arrE = explode ( ",", $estrazi );
	
		$originalDate = $es_data;
		setlocale ( LC_TIME, 'it_IT' );
		$newDate = strftime ( "%A %d %B %Y", strtotime ( $es_data ) );
		$newDate = str_replace ( "�", "&igrave", $newDate );
	
		if ($conta == 1) {
			$active = " active ";
		} else {
			$active = "";
		}
	
		echo '<div role="tabpanel" class="tab-pane' . $active . '" id="est10lotto' . $conta . '">';
		echo '<div class="row">';
		echo '<div class="col-sm-12 text-center"><h2 class="titolo row">Estrazione 10 e lotto<br /> ' . $newDate . '</h2>';
		$html = '';
		$html .= '<ul class="pager">';
		if ($prec != 0) {
			$html .= '<li class="previous"><a href="?estrazione_10_e_lotto=' . ($prec->EsData) . '"><< ' . data_estesa(($prec->EsData)) . '</a></li>';
		}
		if ($succ != 0) {
		
			$html .= '<li class="next" ><a href="?estrazione_10_e_lotto=' . ($succ->EsData) . '">' . data_estesa($succ->EsData) . ' >></a></li>';
		}
		echo $html;
		echo '</div>';
		
		echo '<table class="table table-condensed table-bordered table-striped" style="font-size: 1.6em;">';
	
		for($g = 1; $g <= 20; $g += $group) {
			echo '<tr>';
			for($i = $g; $i <= $g + $group - 1; $i ++) {
				$arrE [$i] = check_numero ( $arrE [$i] );
				echo "<td>$arrE[$i]</td>";
			}
			echo "</tr>";
		}
	
		// echo "<tr>";
		// for($i = 11; $i <= 20; $i ++) {
		// $arrE [$i] = check_numero ( $arrE [$i] );
		// echo "<td>$arrE[$i]</td>";
		// }
		// echo '</tr>';
	
		echo '<tr>';
		$arrE [21] = check_numero ( $arrE [21] );
		echo "<td colspan=\"($group/2) \" class=\"middle oro\">numero oro: $arrE[21]</td>";
		$arrE [22] = check_numero ( $arrE [22] );
		echo "<td colspan=\"($group/2) \" class=\"middle oro\">doppio oro: $arrE[22]</td>";
		echo '</tr>';
		echo '</table>';
		echo '</div>'; // row
		echo '</div>'; // tabpanel
	}
	echo '</div>'; // tabcontent
}

$data->disconnetti ();
?>
