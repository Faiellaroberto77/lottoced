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

$data = new MysqlClass ();
$data->connetti ();
$estrazione = $data->query ( "SELECT * FROM es_superenalotto order by esdata desc limit $numero_estrazione;" );
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
				echo "<li role=\"presentation\" class=\"active\"><a href=\"#estsuper$rowcont\" aria-controls=\"estsuper$rowcont\" role=\"tab\" data-toggle=\"tab\">$newDate</a></li>";
			} else {
				echo "<li role=\"presentation\"><a href=\"#estsuper$rowcont\" aria-controls=\"estsuper$rowcont\" role=\"tab\" data-toggle=\"tab\">$newDate</a></li>";
			}
			$rowcont = $rowcont + 1;
		}
		
		echo "</ul>";
	}
}
$conta = 0;
if ($solo_estrazioni == 1) {
	echo '<div class="tab-content">';
	$estrazione = $data->query ( "SELECT * FROM es_superenalotto order by esdata desc limit $numero_estrazione;" );
	while ( $rows = $data->estrai ( $estrazione ) ) {
		$conta = $conta + 1;
		$es_data = $rows->EsData;
		$estrazi = $rows->estrazione;
		$j = $rows->j;
		$s = $rows->s;
		$jackpot = $rows->jackpot;
		$vincite = json_encode ( $rows->vincite );
		$montepremi = json_encode ( $rows->montepremi );
		$commento = $rows->commento;
		$arrE = explode ( ",", $estrazi );
		
		$originalDate = $es_data;
		setlocale ( LC_TIME, 'it_IT' );
		$newDate = strftime ( "%A %d %B %Y", strtotime ( $es_data ) );
		// $newDate = str_replace ( "�", "&igrave", $newDate );
		$newDate = utf8_encode($newDate);
		// $newDate = date ( "d.m.Y", strtotime ( $originalDate ) );
		
		if ($conta == 1) {
			$active = " active ";
		} else {
			$active = "";
		}
		
		echo '<div role="tabpanel" class="tab-pane' . $active . '" id="estsuper' . $conta . '">';
		echo '<div class="row">';
		echo '<div class="col-sm-12 text-center"><h2 class="titolo row">Estrazione del superenalotto<br /> ' . $newDate . '</h2></div>';
		echo '<table class="table table-condensed table-striped table-bordered"><tr>';
		for($i = 0; $i <= 5; $i ++) {
			$arrE [$i] = check_numero($arrE [$i]);
			echo "<td>$arrE[$i]</td>";
		}
		echo "</tr>";
		
		echo "<tr>";
		echo '<td colspan="5" class="text-right">Jolly</td>';
		echo '<td class="oro">' . check_numero($j);
		echo "</tr>";
		
		echo "<tr>";
		echo '<td colspan="5" class="text-right">Superstar</td>';
		echo '<td class="oro">' . check_numero($s);
		echo '</tr>';
		
		echo "<tr>";
		echo '<td colspan="6">' . $commento . '</td>';
		echo "</tr>";
		
		echo '</table>';
		
		echo '</div>'; // row
		echo '</div>'; // tabpanel
	}
	echo '</div>'; // tabcontent
}
$data->disconnetti ();
?>