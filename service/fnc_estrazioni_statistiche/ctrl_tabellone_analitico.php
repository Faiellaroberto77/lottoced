<?php
require_once 'funzioni/statistica.php';
$b_mobile = isset ($_GET ['mobile']) ? $_GET ['mobile'] : 0;
$tabella = "tabelloneanalitico_lotto_" . lastdate ();
$listAll = application ( $tabella );
class type_Tabellone {
	public $b = array ();
	public $c = array ();
	public $f = array ();
	public $g = array ();
	public $m = array ();
	public $n = array ();
	public $p = array ();
	public $r = array ();
	public $t = array ();
	public $v = array ();
	public $z = array ();
	public $d = array ();
}

if (empty ( $listAll ) || $force == 1) {
	$rr_ruote = array (
			"b",
			"c",
			"f",
			"g",
			"m",
			"n",
			"p",
			"r",
			"t",
			"v",
			"z" 
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
			array_push ( $Tabellone->$ruota, $tmp );
			
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
// ------------------------------------- TESTATA --------------------------------------
$name_t = 'tabana_lotto';
$html = script_tabella_dinamica ( $name_t );
$html .= '<div class="table-responsive tableh">';
$html .= '<table id = "' . $name_t . '" class="table table-condensed table-striped table-bordered">';
$html .= '<thead><tr>';
$html .= '<th>Rit.</th>';
foreach ( $numeruote as $key ) {
	
	$html .= '<th colspan="6">' . $key . '</th>';
}
$html .= '</tr></thead>';
// ------------------------------------- CORPO TABELLA -------------------------
$count = 0;
for($i = $max; $i >= 1; -- $i) {

	$agg = false;
	$t_html = '<tr>';
	$t_html .= '<td class="firstcol">' . ($i - 1) . '</td>';
	foreach ( $rr_ruote as $key ) {
		$arr_t = $Tabellone->$key;
		if ($i <= count ( $arr_t )) {
			$t_html .= givemetd ( eliminaUltimo ( $arr_t [$i - 1] ) );
		} else {
			$t_html .= '<td></td><td></td><td></td><td></td><td></td><td class="empty_cell"></td>';
		}
	}
	$t_html .= '</tr>';
	if ($agg == true) {
		$cont++;
	if ($cont == 6 && $b_mobile == 1) {
		$ret ="<div class=\"adv-head\">";
		$ret .= "<!-- box -->";
		$ret .= "<div id='div-gpt-ad-1454418627035-0'>";
		$ret .= "<script type='text/javascript'>";
		$ret .= "googletag.cmd.push(function() { googletag.display('div-gpt-ad-1454418627035-0'); });";
		$ret .= "</script>";
		$ret .= "</div>";
		$ret .= "</div>";
		$t_html .= '<tr><td colspan="17">'. $ret . '</td></tr>';
	}		
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
	return $rets . '<td class="empty_cell"></td>';
}
function azzera() {
	for($i = 1; $i <= 90; ++ $i) {
		$arr_n [] = 0;
	}
	return $arr_n;
}
?>