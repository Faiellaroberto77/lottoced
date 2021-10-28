<?php
require_once ("global.php");
$r = array (
		"Superenalotto" 
);
$numeruote = array (
		"Superenalotto" 
);
$StrLogin = "tedesco";
$StrPassword = "fkpwt34";
$StrDestinatari = "";
$StrTesto = "";
$tipo = 1;

$data = new MysqlClass ();
$data->connetti ();
$estrazione = $data->query ( "SELECT * FROM es_superenalotto order by esdata desc limit 1;" );
if (@mysqli_num_rows ( $estrazione ) > 0) {
	while ( $rows = $data->estrai ( $estrazione ) ) {
		$ruote = array ();
		$es_data = $rows->EsData;
		$ruote [] = $rows->estrazione;
		$ruote [] = $rows->j;
		$ruote [] = $rows->s;
		
		$originalDate = $es_data;
		setlocale ( LC_TIME, 'it_IT' );
		$newDate = strftime ( "%d.%m.%Y", strtotime ( $es_data ) ); // date ( "d.m.Y", strtotime ( $originalDate ) );
		
		$newDate = str_replace ( "ì", "&igrave", $newDate );
		
		$StrTesto = $newDate . ' ';
		// 12.05.2015 Superenalotto 10 19 48 78 85 90 Jolly 22 SuperStar 42 Ruota Nazionale 55 04 68 82 01
		
		$StrTesto .= 'Superenalotto ';
		
		$Num = explode ( ',', $ruote [0] );
		// $StrTesto .= $Num;
		for($i2 = 0; $i2 <= 5; $i2 ++) {
			$Num [$i2] = check_numero ( $Num [$i2] );
			$StrTesto .= $Num [$i2] . ' ';
		} // next for $i2
		$StrTesto .= 'Jolly ' . $ruote[1];
		$StrTesto .= ' SuperStar ' . $ruote[2];
		$StrTesto .= "\n"; // plglcd_ruote
	}
}
$Sql_date = "SELECT * FROM lcd_Abbonati_sms where (categoria ='EnaCED') and (scadenza > curdate()) order by scadenza;";
$q_cellulari = $data->query ( $Sql_date );
if (@mysqli_num_rows ( $q_cellulari ) > 0) {
	while ( $rows = $data->estrai ( $q_cellulari ) ) {
		$StrDestinatari .= $rows->cellulare . ",";
	}
}
$estrazione = $data->query ( "SELECT Nazionale FROM es_lotto order by esdata desc limit 1;" );
if (@mysqli_num_rows ( $estrazione ) > 0) {
	$rows = $data->estrai($estrazione);
	$Nazionale = $rows->Nazionale;
	$StrTesto .= 'Ruota Nazionale ' . str_replace(',', ' ', $Nazionale);
}


//$StrDestinatari = '3492334375,';
$StrTesto = rawurlencode ( $StrTesto );
$StrSend = sprintf ( "http://www.nsgateway.net/smsscript/sendsms.php?login=%s&password=%s&dest=%s&tipo=%s&mitt=LottoCED&testo=%s", $StrLogin, $StrPassword, $StrDestinatari, $tipo, $StrTesto );
// $httpfile = file_get_contents ( $StrSend );
$data->disconnetti ();
?>