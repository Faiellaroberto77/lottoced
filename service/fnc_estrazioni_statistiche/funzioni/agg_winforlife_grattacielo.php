<?php
// http://www.gntn-pgd.it/gntn-info-web/rest/gioco/winforlifegrattacieli/estrazioni/archivioconcorso/2015/8/19/13?idPartner=123456789
require_once ('global.php');
require_once ('get_estrazioni.php');

$year = date ( "Y" );
$mount = date ( "m" );
$today = date ( "Y/m/d" );
$todayLotto = date ( "Ymd" );
$inora = date ( "H" );
$start = lastdate_winforlife_grattacielo ( $today );
$cnt = 1;

$outagg = "";

for($i = $inora - 1; $i <= $inora; ++ $i) {
	$out = Estrazione_winforlife_grattacielo ( $today, $i );
	// print_r ( $out );
	$min = 0;
	foreach ( $out->listaConcorsi as $key ) {
		$esdata = date ( "Y-m-d" );
		$estrazione = implode ( $key->combinazioneVincente->estratti, "," ) ;
		$num = $key->concorso->numero;
		$num_one = $key->combinazioneVincente->numerone;
		$ora = $inora . ":" . str_pad ( $min, 2, '0', STR_PAD_LEFT );
		// INSERT INTO `lottoced`.`es_10elotto5` (`esdata`, `estrazione`, `num`, `num_oro`) VALUES ('2015-08-14', '1,2,3,', '10', '10');
		if ($num > $start && !empty($estrazione)) {
			$MySql = new MysqlClass ();
			$MySql->connetti ();
			$r = "esdata, estrazione, num, num_one, ora";
			$v = array (
					$esdata,
					$estrazione,
					$num,
					$num_one,
					$ora 
			);
			$MySql->inserisci ( "es_winforlife_grattacielo", $v, $r );
			$outagg .= $num . " - ";
		}
		$min += 5;
	}
}
$outagg .= " - ";
// ( "es_10elotto4", $v, $r );

echo date ( "d-m-Y H:i:s" ) . " ->";
echo "AGG winfor life grattacielo $outagg \n";

?>