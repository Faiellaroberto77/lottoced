<?php
require_once ("global.php");
$r = array (
		"B",
		"C",
		"F",
		"G",
		"M",
		"N",
		"P",
		"R",
		"T",
		"V",
		"Nazionale" 
);
$numeruote = array (
		"B",
		"C",
		"F",
		"G",
		"M",
		"N",
		"P",
		"R",
		"T",
		"V",
		"Nazionale" 
);
$StrLogin = "tedesco";
$StrPassword = "fkpwt34";
$StrDestinatari = "";
$StrTesto = "";
$tipo = 1;

$data = new MysqlClass ();
$data->connetti ();
$estrazione = $data->query ( "SELECT * FROM es_lotto order by esdata desc limit 1;" );
if (@mysqli_num_rows ( $estrazione ) > 0) {
	while ( $rows = $data->estrai ( $estrazione ) ) {
		$ruote = array ();
		$es_data = $rows->EsData;
		$ruote [] = $rows->Bari;
		$ruote [] = $rows->Cagliari;
		$ruote [] = $rows->Firenze;
		$ruote [] = $rows->Genova;
		$ruote [] = $rows->Milano;
		$ruote [] = $rows->Napoli;
		$ruote [] = $rows->Palermo;
		$ruote [] = $rows->Roma;
		$ruote [] = $rows->Torino;
		$ruote [] = $rows->Venezia;
		$ruote [] = $rows->Nazionale;
		
		$originalDate = $es_data;
		setlocale ( LC_TIME, 'it_IT' );
		$newDate = strftime ( "%A %d %B %Y", strtotime ( $es_data ) ); // date ( "d.m.Y", strtotime ( $originalDate ) );
		$newDate = str_replace ( "�", "&igrave", $newDate );
		
		for($i = 0; $i <= 9; $i ++) {
			$StrTesto .= $numeruote [$i];
			
			$Num = explode ( ",", $ruote [$i] );
			
			for($i2 = 0; $i2 <= 4; $i2 ++) {
				$Num [$i2] = check_numero ( $Num [$i2] );
				if ($i2 == 4) {
					$StrTesto .= $Num [$i2];
				} else {
					$StrTesto .= $Num [$i2] . ' ';
				}
			} // next for $i2
			$StrTesto .= "\n"; // plglcd_ruote
		} // next for $i
	}
}
$Sql_date = "SELECT * FROM lcd_Abbonati_sms where (categoria ='LottoCED') and (scadenza > curdate()) order by scadenza;";
$q_cellulari = $data->query ( $Sql_date );
if (@mysqli_num_rows ( $q_cellulari ) > 0) {
	while ( $rows = $data->estrai ( $q_cellulari ) ) {
		$StrDestinatari .= trim($rows->cellulare) . ",";
	}
}
//$StrDestinatari = '3492334375,';
$StrTesto = rawurlencode($StrTesto);
$StrSend = sprintf ( "http://www.nsgateway.net/smsscript/sendsms.php?login=%s&password=%s&dest=%s&tipo=%s&mitt=LottoCED&testo=%s", $StrLogin, $StrPassword, $StrDestinatari, $tipo, $StrTesto );
// $httpfile = file_get_contents ( $StrSend );
$data->disconnetti ();
?>