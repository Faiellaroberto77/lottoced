<?php
/*
 * massimi ritardi attuali_lotto
 */
require_once 'funzioni/statistica.php';

if (isset ( $_GET ['force'] )) {
	$force = $_GET ['force'];
} else {
	$force = 0;
}
if (isset ( $_GET ['qr'] )) {
	$qr = $_GET ['qr'];
} else {
	$qr=10;
}

$numeruote = array (
		"Superenalotto",
		"Oro"
);
$rr_ruote = array (
		"e" 
);
// "o"


$tabella = "lotto_maxritardiattuali_superenalotto" . lastdate_superenalotto();
$listAll = application ( $tabella );

if (empty ( $listAll ) || $force == 1) {
	$ricerca = new rr_lotto ();
	$r_estrazioni = Carica_estrazioni_super ();
	if (! empty ( $r_estrazioni )) {
		$v_attuale = array (
				"ruota" => "",
				"num" => "",
				"att" => "",
				"sto" => "",
				"fre" => "" 
		);
		$listrit = array ();
		$listAll = array ();
		
		$idx_cnt = 0;
		foreach ( $rr_ruote as $key ) {
			// ------------------------------------------- RUOTE ---------------------------------------------------->
			for($iloop = 1; $iloop <= 90; ++ $iloop) {
				$selr = substr ( $key, 0, 1 );
				$ricerca->ricerca ( $iloop . ",", $selr, 1, $r_estrazioni);
				$v_attuale ["ruota"] = $numeruote [$idx_cnt];
				$v_attuale ["num"] = $iloop;
				$v_attuale ["att"] = $ricerca->att;
				$v_attuale ["sto"] = $ricerca->sto;
				$v_attuale ["fre"] = $ricerca->fre;
				$listrit [] = $v_attuale;
			}
			$listrit = array_sort ( $listrit, "att", SORT_DESC );
			$listAll [] = $listrit;
			$listrit = array ();
			++ $idx_cnt;
			// ------------------------------------------- RUOTE ---------------------------------------------------->
		}
		$listAll = json_encode ( $listAll );
		$enc_j = addslashes ( $listAll );
		application_set ( $tabella, $enc_j );
	}
}

$max = 0;
$listAll = json_decode ( $listAll );
if (! empty ( $listAll )) {
	foreach ( $listAll as $key1 ) {
		if ($key1 [0]->att > $max) {
			$max = $key1 [0]->att;
		}
	}
	
	echo '<div class="row">';
	echo '<div class="col-sm-12 text-center">';
	echo '<h2 class="titolo row">I numeri piu\' ritardatari<br /> Superenalotto</h2>';
	echo '</div>';
	echo '<table class="table table-condensed table-bordered">';
	
	foreach ( $listAll as $key1 ) {
		for($i = 0; $i <= $qr; ++ $i) {
			$nru = $key1 [$i]->ruota;
			$r = $key1 [$i]->att;
			$n = $key1 [$i]->num;
			$per = round ( (100 * $r) / $max );
			echo '<tr>';
			echo "<td>";
			// echo "<div class=\"progress\">";
			If ($per == "100") {
				echo "<div class=\"progress-bar-success\" role=\"progressbar\" aria-valuenow=\"70\" aria-valuemin=\"0\" aria-valuemax=\"100\" style=\"width: $per%\">$n Rit: $r</div>";
			} else {
				echo "<div class=\"progress-bar\" role=\"progressbar\" aria-valuenow=\"70\" aria-valuemin=\"0\" aria-valuemax=\"100\" style=\"width: $per%\">$n Rit: $r</div>";
			}
			// echo "</div>";
			echo "</td></tr>";
			// echo $arr [0]->ritNumero;
			// echo $arr [0]->Ritardo;
		}
	}
	echo "</table></div>";
}
?>