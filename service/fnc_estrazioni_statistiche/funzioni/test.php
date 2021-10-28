<?php 
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
header("Content-type: application/json; charset=utf-8");
require_once ('global.php');
require_once ('get_estrazioni.php');

$year = date ( "Y" );
$mount = date ( "m" );
$today = date ( "Y-m-d" );

$end1 = get_progressivo_10elotto ($year, $mount);
$start = lastdate10el5 ($today);

$end = ((int)$end1 + 1);



$stamp = strtotime(date ( "Y-m-d" )); // get unix timestamp
$time_in_ms = $stamp*1000;
//            https://vetrina.giocodellotto.it/serviziFE/10elotto/raccolteFrequentiV2.json
$cmd = "curl 'https://vetrina.giocodellotto.it/serviziFE/10elotto/raccolteFrequentiV2.json'  -H 'Connection: keep-alive'   -H 'Pragma: no-cache'   -H 'Cache-Control: no-cache'   -H 'sec-ch-ua: \"Google Chrome\";v=\"87\", \" Not;A Brand\";v=\"99\", \"Chromium\";v=\"87\"'   -H 'Accept: application/json, text/javascript, */*; q=0.01'   -H 'X-Requested-With: XMLHttpRequest'   -H 'sec-ch-ua-mobile: ?0'   -H 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.141 Safari/537.36'   -H 'Content-Type: application/json'   -H 'Origin: https://vetrina.giocodellotto.it'   -H 'Sec-Fetch-Site: same-origin'   -H 'Sec-Fetch-Mode: cors'   -H 'Sec-Fetch-Dest: empty'   -H 'Referer: https://vetrina.giocodellotto.it/vetrinaDieciELotto/home.htm?idRivenditore=LI0009&clearCache=7'   -H 'Accept-Language: it-IT,it;q=0.9,en-GB;q=0.8,en;q=0.7,en-US;q=0.6'   -H 'Cookie: checkCookie=\"checkCookie\"; LOLCOOKIE-f5ffe93299b53b3dd361de50adaf655a=\"1tbAt+YzI6mNyZrP9JKsLcIWKbNeQJ/ggicKpCmwvdsn3/AFyfeOFVV0Sn7k4xEJGLKKkXd8nWNnnRH2t9LrNZikwJ2ycVQG1lhYy7CN8Yixz/i9sakfMfOioApAGyFz5o4q9SyYvHiBnHjrht3bfgFuxc4w8d/pOd7xwivZ4+t3WKERiHD5oG7XYZcPPELp\"; LOLCOOKIE-6ac3f5177a95a6c467b2b897130dc463=\"yys9viaX8t+MD7u9x3aTayWZdK8RWc2TPSIEQGCYbLPAJwQtrSNajYU3IzxvrDm50IiGPvZ8/mz4Ml3oJmZIhi7/34qFpJ4/We8yFPz1Wvs=\"; _ga=GA1.2.948391867.1610528180; _gid=GA1.2.1361004537.1610528180; LOLCOOKIE-f58645ee2037b97cafe446819b418b80=\"m6RRxhWgO0EpzT0YsRBjKV0cnpSsTzK4iuXVhf265wZ+aZt3qpVBsBsTJUB95F0QMSChV0oMTgj8NmOOzsyUpg==\"; _hjTLDTest=1; _hjid=22040e2e-a941-4bb9-9365-dbf94c5fc733; _hjIncludedInPageviewSample=1; _hjAbsoluteSessionInProgress=0'   --data-binary '{\"dataEstrazione\":$time_in_ms,\"numeroRaccolte\":$end1,\"progressivoGiornaliero\":$end}'   --compressed";
//echo $cmd;
//'{\"data\":$time_in_ms,\"numeroRaccolte\":$end-1,\"progressivoGiornaliero\":$end}'
echo shell_exec($cmd);
?>