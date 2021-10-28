<?php
//require_once ("esequiq.php");
$a = get_lotto();
//print_r($a);
// INSERT INTO `lottoced`.`es_millionday` (`id`, `estratti`, `esdata`) VALUES ('20180207', '7,16,43,44,51', '07/02/2018');
if ($a->esito == "OK") {
    require_once ("esequiq.php");
    $est = "";
    $tmp = array();
    foreach ($a->estrazione as $estrazione){
        $joinEstrazione = implode($estrazione->numeri, ',') . ','; 
        $est .= ", '" . $joinEstrazione . "'";
        $tmp[] = $joinEstrazione;
    }
    $todaym = date("Y-m-d");
    $est .= ", '" . implode(estrazioni10elotto($tmp), ",") . "'";
    $est .= ", '" . implode($a->simbolotti->simbolotti,',') . ','. $a->simbolotti->ruota ."'";
    $query = "INSERT INTO es_lotto (EsData, Bari, Cagliari, Firenze, Genova, Milano, Napoli, Palermo, Roma, Torino, Venezia, Nazionale, diecieLotto, simbolotto) VALUES ('$todaym' $est)";
    print_r($query);
    if (EseguiQuery ( $query ) == TRUE) {
        //echo ("Invio SMS lotto \n");
        require_once 'sms_lotto.php';
    } else {
        echo ("10 e lotto Query NON INSERITA" . $a->esito . "\n");
    }
} else {
    echo "Estrazione Lotto non ancora disponibile";
}

function get_lotto() {
    $todaym = date("Ymd");
    $data_string = '{"data":"'. $todaym .'"}'; // 20210515 json_encode($data);
	//$todaym = '20210921';
    $ch = "curl 'https://www.lotto-italia.it/gdl/estrazioni-e-vincite/estrazioni-del-lotto.json' -H 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:88.0) Gecko/20100101 Firefox/88.0' -H 'Accept: application/json, text/plain, */*' -H 'Accept-Language: it-IT,it;q=0.8,en-US;q=0.5,en;q=0.3' --compressed -H 'Content-Type: application/json' -H 'Origin: https://www.lotto-italia.it' -H 'Connection: keep-alive' -H 'Referer: https://www.lotto-italia.it/lotto/estratti-ruote' -H 'Cookie: AMCV_123C38B3527845020A490D4C%40AdobeOrg=1585540135%7CMCIDTS%7C18691%7CMCMID%7C29231027864214089614339722471276303218%7CMCAAMLH-1615486627%7C6%7CMCAAMB-1615486627%7C6G1ynYcLPuiQxYZrsz_pkqfLG9yMXBpb2zX5dvJdYQJzPXImdj0y%7CMCOPTOUT-1614889027s%7CNONE%7CMCAID%7CNONE%7CMCSYNCSOP%7C411-18693%7CvVersion%7C4.4.0; _ga=GA1.2.1196809325.1591350106; drawgames_user=2:lotto=1:10elotto=1:mday=0:gev=0; cl-advertising=1; modal_0=1595604947000; LTSCO_accept_cookies=true; cto_bundle=pTgUjV93dXZVUGUwbkJMS0QwNVEyM3dmeVNxOEdDamZpQmM2U3ZKb28xSiUyQlNQZE4wYzJSJTJCeGdRTktSaEF2RGI2RUJyVHpBYm1LUFNaQnRTemVFMUFEUThDRU9mbXpSSW1QVjJPJTJGQUtGMGdhbUJ6SHY1WjMwSGlpOEtORnZGUkg1MjZhQnd0RkhJZ01VUHhQOGZMa1BoOTdNcnNydG4wTWd6cUoyZUVSZzJtJTJCQjNkQSUzRA; _hjid=216cf74e-e7d2-472b-9ea8-351f76615f0f; _hjMinimizedPolls=; _hjDonePolls=661537; AMCV_689D61235EF3D4280A495C88%40AdobeOrg=-1124106680%7CMCIDTS%7C18765%7CMCMID%7C87363355348916353571155307786491986265%7CMCAAMLH-1621849995%7C7%7CMCAAMB-1621849995%7C6G1ynYcLPuiQxYZrsz_pkqfLG9yMXBpb2zX5dvJdYQJzPXImdj0y%7CMCOPTOUT-1621252395s%7CNONE%7CMCAID%7CNONE%7CMCSYNCSOP%7C411-18772%7CvVersion%7C5.2.0; _gid=GA1.2.1501838437.1621245196; AMCVS_689D61235EF3D4280A495C88%40AdobeOrg=1; _hjTLDTest=1; _hjAbsoluteSessionInProgress=1; _gat_ec71ddc85179474fb907230ae8e47dc8=1; s_cc=true' --data-raw '{\"data\":\"$todaym\"}'";
    //echo $ch;
    $data = shell_exec($ch);
    $jsond = json_decode ( $data );
    return  $jsond; //$jsond->giorniRaccolte [0]->progressivoGiornaliero;
}
function estrazioni10elotto($inEstrazioneLotto) {
    $alln = array ();
    
    for($i = 0; $i <= 9; ++ $i) {
        $alln [] = explode ( ",", $inEstrazioneLotto[$i] );
    }
    
    $EsNumeri = array (
        ""
    );
    
    for($c = 0; $c <= 4; ++ $c) {
        for($r = 0; $r <= 9; ++ $r) {
            $EsNumeri [] = $alln [$r] [$c];
        }
    }
    
    $terza = 21;
    $numeri = array (
        ""
    );
    
    for($i = 1; $i <= 20; ++ $i) {
        $numeropreso = $EsNumeri [$i];
        $conferma = FALSE;
        while ( $conferma == FALSE ) {
            $chiave = in_array ( $numeropreso, $numeri );
            
            if ($chiave) {
                $numeropreso = $EsNumeri [$terza];
                $terza = $terza + 1;
            } else {
                
                $numeri [] = num2cifre($numeropreso);
                $conferma = TRUE;
            }
        }
    }
    
    sort ( $numeri, SORT_NUMERIC );
    $numeri [] = num2cifre($alln [0] [0]);
    $numeri [] = num2cifre($alln [0] [1]);
    
    return $numeri;
}
function num2cifre($n){
    $n = intval($n);
    if ($n < 10 ){
        $n = '0' . $n;
    }
    return $n;
}