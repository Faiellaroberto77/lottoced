<?php
require_once 'funzioni/statistica.php';
$this_y = date ( 'Y-m-d' );

if (isset ( $_REQUEST ['giorno'] )) {
	$g_giorno = $_REQUEST ['giorno'];
} else {
	$g_giorno = $this_y;
}

// $listAll = application ( $tabella );
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
$rr_ruote = array (
		"e",
		"o",
        "oo"
);
$r_estrazioni = Carica_estrazioni_10elotto5m ( $g_giorno );

// print_r($Tabellone);
// ---------------------------------- COMPONI TABELLONE ANALITICO -----------------------------

$numeruote = array (
		"Estratti",
		"Oro",
		"D. Oro"
);
$evidenzia = array (
		"o",
        "oo"
);
// ------------------------------------- TESTATA --------------------------------------
$name_t = "lista_estrazioni_10el5m";
$html = "";
//$html .= script_tabella_dinamica ( $name_t );

$html .= '<span id="estrazione"></span>';

$html .= '<div class="col-sm-12 text-center">';

setlocale ( LC_TIME, 'it_IT' );
$newDate = strftime ( "%A %d %B %Y", strtotime ( $g_giorno ) ); // date ( "d.m.Y", strtotime ( $originalDate ) );
$newDate = utf8_encode($newDate);

$html .= '<h2  class="titolo row">Estrazioni 10 e lotto 5 minuti<br /> ' . $newDate . '</h2>';
// $html .= '<ul class="pager">';
// if ($g_giorno != 1871) {
// 	$html .= '<li class="previous"><a href="?anno=1871"><< Primo</a></li>';
// 	$html .= '<li class="previous"><a href="?anno=' . ($g_giorno - 1) . '"><< ' . ($g_giorno - 1) . '</a></li>';
// }
// if ($g_giorno != $this_y) {
// 	$html .= '<li class="next" ><a href="?anno=' . (date ( 'Y' )) . '">Ultimo >></a></li>';
// 	$html .= '<li class="next" ><a href="?anno=' . ($g_giorno + 1) . '">' . ($g_giorno + 1) . ' >></a></li>';
// }
// $html .= '</ul>';
$html .= '</div>';
$html .= '<div class="col-sm-12 text-center row">';
$html .= '<div class="table-responsive">';
$html .= '<table id="' . $name_t . '" class="table table-condensed table-striped">';
$html .= '<thead><tr>';
$html .= '<th>Est.</th>';
foreach ( $numeruote as $key ) {
	$html .= '<th colspan="1" >' . $key . '</th>';
}
$html .= '</tr></thead>';
// ------------------------------------- CORPO TABELLA -------------------------

foreach ( $r_estrazioni as $est ) {
	$html .= '<tr>';
	//$html .= '<td class="nowrap firstcol text-left"><a class="lbp_secondary" rel="lightbox[secondary]" href="/10elotto/estrazione/?estrazione_10_e_lotto=' . $est->es_data . '" style="color: white;"><span class="glyphicon glyphicon-new-window"></span>' . $est->Num . ' - (' . ora10l5 ( $est->Num ) . ')' . '</a></td>';
	$html .= '<td class="nowrap firstcol">' . $est->Num . ' <br/> (' . ora10l5 ( $est->Num ) . ')' . '</td>';
	//$html .= '<td class="nowrap firstcol text-left">' . $est->Num . '</td>';
	foreach ( $rr_ruote as $key ) {
		$arr_t = $est->$key;
		$nru = eliminaUltimo ( $arr_t );
		$nru = str_replace ( ',', '.', $nru );
		$class = "";
		$finda = array_search ( $key, $evidenzia );
		if ($finda !== false) {
			$class = ' class="oro"';
		}
		
		$html .= givemetd ( $nru, ".", $class );
	}
	
	$html .= '</tr>';
	$class = ' colspan="3" class="10extra"';
	$html .= '<tr>';
	$html .= '<td class="nowrap firstcol">Extra -' . $est->Num . ' <br/> (' . ora10l5 ( $est->Num ) . ')' . '</td>';
	$html .= givemetd ( $est->extra, ",", $class );
	$html .= '</tr>';
}
$html .= '</table></div>';
$html .= '</div>';
echo $html;
// -------------------------------------- FUNZIONI VARIE --------------------------------
function givemetd($string, $delimeter = ",", $class = "") {
	$tmp_array = explode ( $delimeter, $string );
	$rets = "<td$class>";
	$cnt = 0;
	foreach ( $tmp_array as $tk ) {
		$cnt ++;
		if ($cnt == 11) {
			$rets  .="<br/>";
		}
		if (! empty ( $tk )) {
			$rets .= check_numero ( $tk ) . '.';
			$agg = true;
		} else {
			$rets .= ".";
		}
	}
	return $rets . '</td>';
}
function azzera() {
	for($i = 1; $i <= 90; ++ $i) {
		$arr_n [] = 0;
	}
	return $arr_n;
}
?>