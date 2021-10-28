<?php
if (isset ( $_GET ['aggiorna10el5m'] )) {
	$aggiorna10el5m = $_GET ['aggiorna10el5m'];
} else {
	$aggiorna10el5m = 'no';
}
date_default_timezone_set('Europe/Rome');
if (date ( "H" ) == "19" && date ( "i" ) >= 1 && date ( "i" ) <= 59) {
	require_once 'funzioni/agg_millionday.php';
}
if (date ( "H" ) == "20" && date ( "i" ) >= 10 && date ( "i" ) <= 59) {
	require_once 'funzioni/agg_lottoe10elotto.php';
	require_once 'funzioni/agg_superenalotto.php';
}
if (date ( "H" ) == "21" && date ( "i" ) >= 10 && date ( "i" ) <= 30) {
	require_once 'funzioni/agg_superenalotto.php';
}
if ($aggiorna10el5m == "si") {
	//require_once 'funzioni/agg_10elotto5.php';
	//require_once 'funzioni/agg_10elotto5_288.php';
	//$link = "http://www.mailced.com/fnc_estrazioni_statistiche/funzioni/agg_10elotto5.php";
	//$httpfile = file_get_contents ( $link );
}
require_once 'funzioni/agg_winforlife_classico.php';
require_once 'funzioni/agg_winforlife_grattacielo.php';
// require_once 'newsletter_Forum.php';

// $aaa = new estrazioni_televideo();
echo "-------------------\n";

// conversione data json
// $date = substr ( '/Date(1436565600000)/', 6, - 5 );
// $date = date ( 'Y/m/d', $date + date ( 'Z', $date ) );
// echo $date . "\n";
?>