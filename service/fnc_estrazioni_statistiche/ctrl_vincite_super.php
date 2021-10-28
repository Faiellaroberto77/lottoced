<?php
if (isset ( $_GET ['mon'] )) {
	$m = $_GET ['mon'];
} else {
	$m = 1;
}

if (isset ( $_GET ['quo'] )) {
	$q = $_GET ['quo'];
} else {
	$q = 1;
}

require_once 'funzioni/global.php';

$data = new MysqlClass ();
$data->connetti ();
$formazione = $data->query ( "SELECT * FROM es_superenalotto order by esdata desc limit 1" );
if (mysqli_num_rows ( $formazione ) > 0) {
	$estrai = $data->estrai ( $formazione );
	$montepremi = json_decode ( $estrai->montepremi );
	$vincite = json_decode ( $estrai->vincite );
	$es_data = $estrai->EsData;
	
}
$originalDate = $es_data;
setlocale ( LC_TIME, 'it_IT' );
$newDate = strftime ( "%A %d %B %Y", strtotime ( $es_data ) );
$newDate = str_replace ( "?", "&igrave", $newDate );

$html = "";
$mc = $montepremi->montepremiConcorso;
$mp = $montepremi->riportoMontepremiPrecedente;
$mt = $montepremi->montepremiTotale;
if ($m == 1) {
	$html .= '<div class="row">';
	$html .= '<div class="col-sm-12 text-center">';
	$html .= '<h2 class="titolo row">Montepremi <br />' . $newDate .'</h2>';
	$html .= '</div>';
	$html .= '<div class="table table-responsive">';
	$html .= '<table class="table table-condensed table-striped table-bordered">';
// 	$html .= '<thead><tr>';
// 	$html .= '<th colspan="2"> Montepremi </th>';
// 	$html .= '</tr></thead>';
	$html .= '<tr>';
	$html .= '<td>Del concorso</td><td>' . convertinumero ( $mc ) . ' Euro</td>';
	$html .= '</tr>';
	$html .= '<tr>';
	$html .= '<td>Jackpot concorso precedente</td><td>' . convertinumero ( $mp ) . ' Euro</td>';
	$html .= '</tr>';
	$html .= '<tr>';
	$html .= '<td>Montepremi totale del concorso</td><td>' . convertinumero ( $mt ) . ' Euro</td>';
	$html .= '</tr>';
	$html .= '</table>';
	$html .= '</div>';
	$html .= '</div>';

}
if ($q == 1) {
	$html .= '<div class="row">';
	$html .= '<div class="col-sm-12 text-center">';
	$html .= '<h2 class="titolo row">Quote superenalotto <br />' . $newDate .'</h2>';
	$html .= '</div>';
	$html .= '<div class="col-sm-6 text-center">';
	$html .= '<div class="table table-responsive">';
	$html .= '<table class="table table-condensed table-striped table-bordered">';
// 	$html .= '<thead><tr>';
// 	$html .= '<th colspan ="2">Quote superenalotto</th>';
// 	$html .= '</tr></thead>';
	$cntr = 0;
	if (is_array($vincite)) {
		foreach ( $vincite as $key ) {
			$quant = $key->numero;
			$descr = $key->quota->categoriaVincita->descrizione;
			$intro ="";
			if ($quant == 0){
				$intro = "nessun ";
			}
			if ($quant == 1){$intro = "all'unico ";}
			if ($quant > 1){$intro = "ai " . $quant . " ";}
			$intro .= "\"$descr\"";
			$vinc = convertinumero ($key->quota->importo);
			$html .= '<tr>';
			$html .= '<td class="text-left"><strong>'. $intro .'</strong></td><td class="text-left">Euro ' . $vinc . '</td>';
			$html .= '</tr>';
			++$cntr;
			if ($cntr == 5){
				$html .= '</table></div></div>';
				$html .= '<div class="col-sm-6 text-center">';
				$html .= '<div class="table table-responsive">';
				$html .= '<table class="table table-condensed table-striped table-bordered">';			
			}
		}
	}
	$html .= '</table></div>';
	$html .= '</div>';
	$html .= '</div>';
	//$html .= '</div>';
}

$data->disconnetti ();
echo $html;
$html = '';
function convertinumero($numero) {
	$last2 = substr ( $numero, strlen ( $numero ) - 2 );
	$numero = substr ( $numero, 0, strlen ( $numero ) - 2 ) . "." . $last2;
	return number_format ( $numero, 2, ',', '.' );
}

?>