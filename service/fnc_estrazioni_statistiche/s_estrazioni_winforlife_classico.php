<?php
require_once ("funzioni/global.php");

if (isset ( $_GET ['numero'] )) {
	$numero_estrazione = $_GET ['numero'];
} else {
	$numero_estrazione = 6; // numero di date da prendere
}

if (isset ( $_GET ['num_estrazioni'] )) {
	$num_estrazioni = $_GET ['num_estrazioni'];
} else {
	$num_estrazioni = 10; // numero di estrazioni da prendere
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
// ---------------------------------------------- PRENDE DATE -------------------------------------------
$g_sql = "select EsData from es_winforlife_classico group by esdata order by esdata desc limit $numero_estrazione;";
$data = new MysqlClass ();
$data->connetti ();
$estrazione = $data->query ( $g_sql );
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
				echo "<li role=\"presentation\" class=\"active\"><a href=\"#estwflc$rowcont\" aria-controls=\"estwflc$rowcont\" role=\"tab\" data-toggle=\"tab\">$newDate</a></li>";
			} else {
				echo "<li role=\"presentation\"><a href=\"#estwflc$rowcont\" aria-controls=\"estwflc$rowcont\" role=\"tab\" data-toggle=\"tab\">$newDate</a></li>";
			}
			$rowcont = $rowcont + 1;
		}
		
		echo "</ul>";
	}
}
// ------------------------------------------------------ PRENDE ESTRAZIONI --------------------------------------------------
$conta = 0;
if ($solo_estrazioni == 1) {
	echo '<div class="tab-content">';
	
	$estrazione = $data->query ( $g_sql );
	while ( $rows = $data->estrai ( $estrazione ) ) {
		$conta = $conta + 1;
		$es_data = $rows->EsData;
		// $estrazi = $rows->diecielotto;
		// $arrE = explode ( ",", $estrazi );
		
		$originalDate = $es_data;
		setlocale ( LC_TIME, 'it_IT' );
		$newDate = strftime ( "%A %d %B %Y", strtotime ( $es_data ) );
		$newDate = str_replace ( "ì", "&igrave", $newDate );
		
		if ($conta == 1) {
			$active = " active ";
		} else {
			$active = "";
		}
		
		echo '<div role="tabpanel" class="tab-pane' . $active . '" id="estwflc' . $conta . '">';
		echo '<div class="row">';
		echo '<div class="col-sm-12 text-center"><h2 class="titolo row">Estrazioni Win For Life Classico <br /> ' . $newDate . '</h2></div>';
		// --------------------------------------------- contenuto tab ---------------------------------------------
		$g_sql = "SELECT num, estrazione, num_one, ora FROM es_winforlife_classico where esdata = '$es_data' order by esdata desc, num desc limit $num_estrazioni;";
		$data2 = new MysqlClass ();
		$data2->connetti ();
		$estrazioni10 = $data2->query ( $g_sql );
		echo '<table class="table table-condensed table-bordered">';
		
		while ( $erow = $data2->estrai ( $estrazioni10 ) ) {
			$num = $erow->num;
			$ora = $erow->ora;
			$est = $erow->estrazione;
			$est = explode ( ",", $est );
			$one = $erow->num_one;
			echo '<tr>';
			echo "<td colspan=\"10\">n. $num - ore $ora</td>";
			echo '</tr>';
			
			echo '<tr>';
			
			foreach ( $est as $key ) {
				echo "<td>";
				echo check_numero ( $key );
				echo "</td>";
			}
			
			echo '<tr>';
			
			echo "<td colspan=\"10\" class=\"oro nowrap\"><b>Numerone: " . check_numero ( $one ) . "</b></td>";
			echo '</tr>';
			echo '</tr>';
		}
		echo '</table>';
		$data2->disconnetti ();
		// echo $conta;
		// --------------------------------------------- / contenuto tab fine / ---------------------------------------------
		echo '</div>'; // row
		echo '</div>'; // tabpanel
	}
	echo '</div>'; // tabcontent
}
$data->disconnetti ();
?>