<?php
require_once 'funzioni/statistica.php';

$today = date ( "Y-m-d" );
$tabella = "tabelloneanalitico_10el_" . lastdate();
$listAll = application ( $tabella );
class type_Tabellone {
	public $d = array ();
}

if (empty ( $listAll ) || $force == 1) {
	$rr_ruote = array (
			"d" 
	);
	$r_estrazioni = Carica_estrazione_lotto ();
	
	$Tabellone = new type_Tabellone ();
	$max = 0;
	foreach ( $rr_ruote as $ruota ) {
		$arr_n = azzera ();
		$conta = 0;
		$riga = 0;
		foreach ( $r_estrazioni as $r ) {
			
			// echo "$riga)";
			++ $riga;
			
			$n = explode ( ",", eliminaUltimo ( $r->$ruota ) );
			$tmp = "";
			foreach ( $n as $kn ) {
				if ($arr_n [$kn - 1] == 0) {
					++ $conta;
					$arr_n [$kn - 1] = 1;
					$tmp .= check_numero ( $kn ) . ".";
				} else {
					$tmp .= ".";
				}
			}
			array_push ( $Tabellone->$ruota, eliminaUltimo($tmp) );
			
			if ($conta >= 90) {
				if (count ( $Tabellone->$ruota ) > $max) {
					$max = count ( $Tabellone->$ruota );
				}
				break;
			}
		}
	}
}
// print_r($Tabellone);
// ---------------------------------- COMPONI TABELLONE ANALITICO -----------------------------

$numeruote = array (
		"Estratti" 
);
// ------------------------------------- TESTATA --------------------------------------
$colonne = 20;
$html = aggiungi_titolo('Tabellone analitico<br /> 10 e lotto del ' . data_estesa(lastdate()));
$html .= '<div class="table-responsive">';
$html .= '<table class="table table-condensed table-striped table-bordered">';
$html .= '<thead><tr>';
$html .= '<th>Rit.</th>';
foreach ( $numeruote as $key ) {
	
	$html .= '<th colspan="' . ($colonne + 1) . '">' . $key . '</th>';
}
$html .= '</tr></thead>';
// ------------------------------------- CORPO TABELLA -------------------------

for($i = $max; $i >= 1; -- $i) {
	
	$agg = false;
	$t_html = '<tr>';
	$t_html .= '<td>' . ($i - 1) . '</td>';
	foreach ( $rr_ruote as $key ) {
		$arr_t = $Tabellone->$key;
		if ($i <= count ( $arr_t )) {
			$t_html .= givemetd ( eliminaUltimo ( $arr_t [$i - 1] ) );
		} else {
			for($iloop = 1; $iloop <= $colonne; ++ $iloop) {
				$t_html .= '<td></td>'; // colonne
			}
		}
	}
	$t_html .= '</tr>';
	if ($agg == true) {
		$html .= $t_html;
		// $agg = false;
	}
}
$html .= '</table></div>';
echo $html;
// -------------------------------------- FUNZIONI VARIE --------------------------------
function givemetd($string, $delimeter = ".") {
	global $agg;
	
	$tmp_array = explode ( $delimeter, $string );
	$rets = "";
	foreach ( $tmp_array as $tk ) {
		if (! empty ( $tk )) {
			$rets .= "<td>" . $tk . '</td>';
			$agg = true;
		} else {
			$rets .= "<td></td>";
		}
	}
	return $rets; // . '<td></td>';
}
function azzera() {
	for($i = 1; $i <= 90; ++ $i) {
		$arr_n [] = 0;
	}
	return $arr_n;
}
?>