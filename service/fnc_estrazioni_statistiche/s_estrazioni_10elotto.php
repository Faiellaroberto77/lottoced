<?php
require_once ("funzioni/global.php");

if (isset ( $_GET ['numero'] )) {
	$numero_estrazione = $_GET ['numero'];
} else {
	$numero_estrazione = 6;
}

if (isset ( $_GET ['onlytab'] )) {
	$solo_tab = $_GET ['onlytab'];
} else {
	$solo_tab = 1;
}

if (isset ( $_GET ['onlyestrazioni'] )) {
	$solo_estrazioni = $_GET ['onlyestrazioni'];
} else {
	$solo_estrazioni = 1;
}

if (isset ( $_GET ['group'] )) {
	$group = $_GET ['group'];
} else {
	$group = 20;
}

$data = new MysqlClass ();
$data->connetti ();
$estrazione = $data->query ( "SELECT EsData, diecielotto FROM es_lotto order by esdata desc limit $numero_estrazione;" );
if (@mysqli_num_rows ( $estrazione ) > 0) {
	if ($solo_tab == 1) {
		echo '<ul class="nav nav-tabs" role="tablist">';
		// echo'<ul class="pagination" role="tablist">';
		
		// for($rowcont = 1; $rowcont <= mysql_num_rows ( $estrazione ); $rowcont ++) {
		$rowcont = 1;
		while ( $rows = $data->estrai ( $estrazione ) ) {
			$es_data = $rows->EsData;
			$originalDate = $es_data;
			$newDate = date ( "d.m.Y", strtotime ( $originalDate ) );
			
			if ($rowcont == 1) {
				echo "<li role=\"presentation\" class=\"active\"><a href=\"#est10lotto$rowcont\" aria-controls=\"est10lotto$rowcont\" role=\"tab\" data-toggle=\"tab\">$newDate</a></li>";
			} else {
				echo "<li role=\"presentation\"><a href=\"#est10lotto$rowcont\" aria-controls=\"est10lotto$rowcont\" role=\"tab\" data-toggle=\"tab\">$newDate</a></li>";
			}
			$rowcont = $rowcont + 1;
		}
		
		echo "</ul>";
	}
}
$conta = 0;
if ($solo_estrazioni == 1) {
	echo '<div class="tab-content">';
	$estrazione = $data->query ( "SELECT EsData, diecielotto FROM es_lotto order by esdata desc limit $numero_estrazione;" );
	while ( $rows = $data->estrai ( $estrazione ) ) {
		$conta = $conta + 1;
		$es_data = $rows->EsData;
		$estrazi = $rows->diecielotto;
		$arrE = explode ( ",", $estrazi );
		
		$originalDate = $es_data;
		setlocale ( LC_TIME, 'it_IT' );
		$newDate = strftime ( "%A %d %B %Y", strtotime ( $es_data ) );
		// $newDate = str_replace ( "�", "&igrave", $newDate );
		$newDate = utf8_encode($newDate);
		if ($conta == 1) {
			$active = " active ";
		} else {
			$active = "";
		}
		
		echo '<div role="tabpanel" class="tab-pane' . $active . '" id="est10lotto' . $conta . '">';
		echo '<div class="row">';
		echo '<div class="col-sm-12 text-center"><h2 class="titolo row">Estrazione 10 e lotto<br /> ' . $newDate . '</h2></div>';
		echo '<table class="table table-condensed table-bordered table-striped">';
		
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
		$cold = intval($group) /2;
		
		$arrE [21] = check_numero ( $arrE [21] );
		echo "<td colspan=\"$cold\" class=\"middle oro\">numero oro: $arrE[21]</td>";
		$arrE [22] = check_numero ( $arrE [22] );
		echo "<td colspan=\"$cold\" class=\"middle oro\">doppio oro: $arrE[22]</td>";
		echo '</tr>';
		echo '</table>';
		echo '</div>'; // row
		echo '</div>'; // tabpanel
	}
	echo '</div>'; // tabcontent
}
$data->disconnetti ();
?>