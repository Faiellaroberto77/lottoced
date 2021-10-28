<?php

$a = get_lotto();

if ($a->esito == "OK") {
    require_once ("esequiq.php");
    $est = "";
    $tmp = array();
    
    foreach ($a->concorsiEstratti as $estrazione){
        $dataestrazione = new DateTime("@$estrazione->data");
        $dataIestra = date('m/d/Y', );
        $joinEstrazione = implode($estrazione->numeri, ',') . ','; 
        $est .= ", '" . $joinEstrazione . "'";
        $tmp[] = $joinEstrazione;
    }
    $todaym = date("Y-m-d");
    $est .= ", '" . implode(estrazioni10elotto($tmp), ",") . "'";
    
    $query = "INSERT INTO es_lotto (EsData, Bari, Cagliari, Firenze, Genova, Milano, Napoli, Palermo, Roma, Torino, Venezia, Nazionale, diecieLotto) VALUES ('$todaym' $est)";
    
    if (EseguiQuery ( $query ) == TRUE) {
        echo ("Invio SMS lotto \n");
        require_once 'sms_lotto.php';
    } else {
        echo ("10 e lotto Query NON INSERITA" . $a->esito . "\n");
    }
} else {
    echo "Estrazione Lotto non ancora disponibile ...";
}

function get_lotto() {
    $todaym = date("Ymd");
    $data_string = '{"data":"'. $todaym .'"}'; // json_encode($data);
    
    $ch = "curl 'https://www.lotto-italia.it/gdl/estrazioni-e-vincite/estrazioni-del-lotto.json' -H 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:88.0) Gecko/20100101 Firefox/88.0' -H 'Accept: application/json, text/plain, */*' -H 'Accept-Language: it-IT,it;q=0.8,en-US;q=0.5,en;q=0.3' --compressed -H 'Content-Type: application/json' -H 'Origin: https://www.lotto-italia.it' -H 'Connection: keep-alive' -H 'Referer: https://www.lotto-italia.it/lotto/estratti-ruote' -H 'Cookie: AMCV_123C38B3527845020A490D4C%40AdobeOrg=1585540135%7CMCIDTS%7C18691%7CMCMID%7C29231027864214089614339722471276303218%7CMCAAMLH-1615486627%7C6%7CMCAAMB-1615486627%7C6G1ynYcLPuiQxYZrsz_pkqfLG9yMXBpb2zX5dvJdYQJzPXImdj0y%7CMCOPTOUT-1614889027s%7CNONE%7CMCAID%7CNONE%7CMCSYNCSOP%7C411-18693%7CvVersion%7C4.4.0; _ga=GA1.2.1196809325.1591350106; drawgames_user=2:lotto=1:10elotto=1:mday=0:gev=0; cl-advertising=1; modal_0=1595604947000; LTSCO_accept_cookies=true; cto_bundle=pTgUjV93dXZVUGUwbkJMS0QwNVEyM3dmeVNxOEdDamZpQmM2U3ZKb28xSiUyQlNQZE4wYzJSJTJCeGdRTktSaEF2RGI2RUJyVHpBYm1LUFNaQnRTemVFMUFEUThDRU9mbXpSSW1QVjJPJTJGQUtGMGdhbUJ6SHY1WjMwSGlpOEtORnZGUkg1MjZhQnd0RkhJZ01VUHhQOGZMa1BoOTdNcnNydG4wTWd6cUoyZUVSZzJtJTJCQjNkQSUzRA; _hjid=216cf74e-e7d2-472b-9ea8-351f76615f0f; _hjMinimizedPolls=; _hjDonePolls=661537; AMCV_689D61235EF3D4280A495C88%40AdobeOrg=-1124106680%7CMCIDTS%7C18765%7CMCMID%7C87363355348916353571155307786491986265%7CMCAAMLH-1621849995%7C7%7CMCAAMB-1621849995%7C6G1ynYcLPuiQxYZrsz_pkqfLG9yMXBpb2zX5dvJdYQJzPXImdj0y%7CMCOPTOUT-1621252395s%7CNONE%7CMCAID%7CNONE%7CMCSYNCSOP%7C411-18772%7CvVersion%7C5.2.0; _gid=GA1.2.1501838437.1621245196; AMCVS_689D61235EF3D4280A495C88%40AdobeOrg=1; _hjTLDTest=1; _hjAbsoluteSessionInProgress=1; _gat_ec71ddc85179474fb907230ae8e47dc8=1; s_cc=true' --data-raw '{\"data\":\"$todaym\"}'";
    //echo $ch;
    $ch = "curl 'https://vetrina.giocodellotto.it/serviziFE/lotto/estrazioniMensile.json' -X POST -H 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:92.0) Gecko/20100101 Firefox/92.0' -H 'Accept: application/json, text/javascript, */*; q=0.01' -H 'Accept-Language: it-IT,it;q=0.8,en-US;q=0.5,en;q=0.3' --compressed -H 'Referer: https://vetrina.giocodellotto.it/vetrinaLotto/home.htm?idRivenditore=LI0009&clearCache=5' -H 'Content-Type: application/json' -H 'X-Requested-With: XMLHttpRequest' -H 'Origin: https://vetrina.giocodellotto.it' -H 'Connection: keep-alive' -H 'Cookie: AMCV_689D61235EF3D4280A495C88%40AdobeOrg=-1124106680%7CMCIDTS%7C18896%7CMCMID%7C80918345661835234502667103170231382222%7CMCAAMLH-1633200381%7C6%7CMCAAMB-1633200381%7C6G1ynYcLPuiQxYZrsz_pkqfLG9yMXBpb2zX5dvJdYQJzPXImdj0y%7CMCOPTOUT-1632602781s%7CNONE%7CMCAID%7CNONE%7CvVersion%7C5.2.0; checkCookie=\"checkCookie\"; LOLCOOKIE-f58645ee2037b97cafe446819b418b80=\"m6RRxhWgO0EpzT0YsRBjKV0cnpSsTzK4iuXVhf265wZ+aZt3qpVBsBsTJUB95F0QMSChV0oMTgj8NmOOzsyUpg==\"; AMCVS_689D61235EF3D4280A495C88%40AdobeOrg=1; _ga=GA1.2.1570983181.1632595582; _gid=GA1.2.462667218.1632595582; s_cc=true' -H 'Sec-Fetch-Dest: empty' -H 'Sec-Fetch-Mode: no-cors' -H 'Sec-Fetch-Site: cross-site' -H 'Pragma: no-cache' -H 'Cache-Control: no-cache' --data-raw '{\"anno\":\"2021\",\"mese\":\"10\"}'";
    $data = shell_exec($ch);
    $data = '{"esito":"OK","messaggio":null,"concorsiEstratti":[{"data":1633125600000,"ruotaConSimbolotto":true,"ruote":[{"nome":"bari","numeriEstratti":[12,61,87,15,32]},{"nome":"cagliari","numeriEstratti":[44,68,24,35,19]},{"nome":"firenze","numeriEstratti":[68,86,75,5,57]},{"nome":"genova","numeriEstratti":[6,21,54,68,60]},{"nome":"milano","numeriEstratti":[21,46,13,5,23]},{"nome":"napoli","numeriEstratti":[19,35,89,61,56]},{"nome":"palermo","numeriEstratti":[21,69,33,15,71]},{"nome":"roma","numeriEstratti":[13,78,21,42,87]},{"nome":"torino","numeriEstratti":[78,57,34,17,43]},{"nome":"venezia","numeriEstratti":[80,38,78,51,37]},{"nome":"nazionale","numeriEstratti":[83,39,15,3,16]}],"simbolotto":{"ruota":"roma","simboli":[3,27,7,32,29]}},{"data":1633384800000,"ruotaConSimbolotto":true,"ruote":[{"nome":"bari","numeriEstratti":[46,19,12,16,7]},{"nome":"cagliari","numeriEstratti":[74,25,21,44,77]},{"nome":"firenze","numeriEstratti":[83,5,41,40,71]},{"nome":"genova","numeriEstratti":[68,69,72,24,44]},{"nome":"milano","numeriEstratti":[54,76,17,60,81]},{"nome":"napoli","numeriEstratti":[20,48,7,4,85]},{"nome":"palermo","numeriEstratti":[12,19,56,59,34]},{"nome":"roma","numeriEstratti":[66,42,79,72,30]},{"nome":"torino","numeriEstratti":[45,69,20,56,18]},{"nome":"venezia","numeriEstratti":[76,31,65,89,90]},{"nome":"nazionale","numeriEstratti":[32,65,67,70,62]}],"simbolotto":{"ruota":"roma","simboli":[7,42,6,21,15]}},{"data":1633557600000,"ruotaConSimbolotto":true,"ruote":[{"nome":"bari","numeriEstratti":[56,62,66,53,24]},{"nome":"cagliari","numeriEstratti":[49,43,89,66,27]},{"nome":"firenze","numeriEstratti":[11,20,36,27,28]},{"nome":"genova","numeriEstratti":[79,40,36,48,89]},{"nome":"milano","numeriEstratti":[30,15,28,78,86]},{"nome":"napoli","numeriEstratti":[29,34,64,24,51]},{"nome":"palermo","numeriEstratti":[1,58,54,72,20]},{"nome":"roma","numeriEstratti":[70,33,48,67,52]},{"nome":"torino","numeriEstratti":[1,74,78,64,76]},{"nome":"venezia","numeriEstratti":[5,10,1,31,23]},{"nome":"nazionale","numeriEstratti":[27,82,75,33,78]}],"simbolotto":{"ruota":"roma","simboli":[28,32,30,20,26]}}]}';
    $jsond = json_decode ( $data );
    return  $jsond; 
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
?>