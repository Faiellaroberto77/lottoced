<?php 
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once ('global.php');
require_once ('get_estrazioni.php');

$year = date ( "Y" );
$mount = date ( "m" );
$today = date ( "Y-m-d" );

$end = get_progressivo_10elotto ($year, $mount);
$start = lastdate10el5 ($today);




$stamp = strtotime(date ( "Y-m-d" )); // get unix timestamp
$time_in_ms = $stamp*1000;

$cmd = "curl 'https://vetrina.giocodellotto.it/serviziFE/10elotto/raccolteFrequenti.json' -H 'Content-Type: application/json' -H 'Connection: keep-alive' -H 'Referer: https://vetrina.giocodellotto.it/vetrinaDieciELotto/home.htm?idRivenditore=LI0009&clearCache=0' -H 'Cookie: LOLCOOKIE-f58645ee2037b97cafe446819b418b80=\"m6RRxhWgO0EpzT0YsRBjKV0cnpSsTzK4iuXVhf265wZ+aZt3qpVBsBsTJUB95F0QMSChV0oMTgj8NmOOzsyUpg==\";' --data '{\"dataEstrazione\":$time_in_ms,\"numeroRaccolte\":1,\"progressivoGiornaliero\":$end}'";
//echo shell_exec($cmd);
echo $cmd;
?>