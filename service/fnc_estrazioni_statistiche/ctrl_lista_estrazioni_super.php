
<?php
require_once 'funzioni/statistica.php';
$this_y = date ( 'Y' );

if (isset ( $_REQUEST ['anno'] )) {
	$g_giorno = $_REQUEST ['anno'];
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

if (empty ( $listAll ) || $force == 1) {
	$rr_ruote = array (
			"e",
			"j",
			"s" 
	);
	$r_estrazioni = Carica_estrazioni_super ('', 2, $g_giorno );
}
// print_r($Tabellone);
// ---------------------------------- COMPONI TABELLONE ANALITICO -----------------------------

$numeruote = array (
		"Estratti",
		"Jolly",
		"Superstar" 
);
// ------------------------------------- TESTATA --------------------------------------
$name_t = "lista_estrazioni_superenalotto";
$html = "";
$html .= script_tabella_dinamica($name_t);

$html .= '<span id="estrazione"></span>';

$html .= '<div class="col-sm-12 text-center">';
$html .= '<h2  class="titolo row">Estrazioni superenalotto<br /> dell\'anno ' . $g_giorno . '</h2>';
$html .= '<ul class="pager">';
if ($g_giorno != 1871) {
	$html .= '<li class="previous"><a href="?anno=1871"><< Primo</a></li>';
	$html .= '<li class="previous"><a href="?anno=' . ($g_giorno - 1) . '"><< ' . ($g_giorno - 1) . '</a></li>';
}
if ($g_giorno != $this_y) {
	$html .= '<li class="next" ><a href="?anno=' . (date ( 'Y' )) . '">Ultimo >></a></li>';
	$html .= '<li class="next" ><a href="?anno=' . ($g_giorno + 1) . '">' . ($g_giorno + 1) . ' >></a></li>';
}
$html .= '</ul>';
$html .= '</div>';
$html .= '<div class="col-sm-12 text-center">';
$html .= '<div class="table-responsive tableh">';
$html .= '<table id="' . $name_t . '" class="table table-condensed table-striped">';
$html .= '<thead><tr>';
$html .= '<th>Data</th>';
foreach ( $numeruote as $key ) {
	
	$html .= '<th colspan="1" >' . $key . '</th><th></th>';
}
$html .= '</tr></thead>';
// ------------------------------------- CORPO TABELLA -------------------------

foreach ( $r_estrazioni as $est ) {
	$html .= '<tr>';
	$html .= '<td class="nowrap firstcol text-left"><a class="lbp_secondary" rel="lightbox[secondary]" href="/superenalotto/estrazione/?estrazione_super=' . $est->es_data . '" style="color: white;"><span class="glyphicon glyphicon-new-window"></span>  ' . data_estesa ( $est->es_data ) . '</a></td>';
	foreach ( $rr_ruote as $key ) {
		$arr_t = $est->$key;
		$nru = eliminaUltimo ( $arr_t );
		$nru = str_replace ( ',', '.', $nru );
		$html .= givemetd ( $nru, "." );
	}
	$html .= '</tr>';
}
$html .= '</table></div>';
$html .= '</div>';
echo $html;
// -------------------------------------- FUNZIONI VARIE --------------------------------
function givemetd($string, $delimeter = ",") {
	$tmp_array = explode ( $delimeter, $string );
	$rets = "<td>";
	foreach ( $tmp_array as $tk ) {
		if (! empty ( $tk )) {
			$rets .= check_numero ( $tk ) . '.';
			$agg = true;
		} else {
			$rets .= ".";
		}
	}
	return $rets . '</td><td></td>';
}
function azzera() {
	for($i = 1; $i <= 90; ++ $i) {
		$arr_n [] = 0;
	}
	return $arr_n;
}
?>