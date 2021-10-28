<?php
require_once ("esequiq.php");


$a = get_millionday('30');
// INSERT INTO `lottoced`.`es_millionday` (`id`, `estratti`, `esdata`) VALUES ('20180207', '7,16,43,44,51', '07/02/2018');
foreach ($a as $estM) {
    $estM->data = substr($estM->data, 0, 10);
    $mydate = new DateTime("@$estM->data");
    $estrazione = join(",", $estM->numeriEstratti);
    $db_data = $mydate->format("Y-m-d");
    $query = "INSERT INTO es_millionday (id, estratti, esdata) VALUES ('$estM->progressivo', '$estrazione', '$db_data')";    
    if (EseguiQuery ( $query ) == TRUE) {
        echo 'OK' . $mydate->format("Y-m-d") . "\n";
    } else {
        echo 'KO' . $mydate->format("Y-m-d") . "\n";
    }
}


function get_millionday($numest='1') {
    // 	$year = date ( "Y" );
    // 	$mount = date ( "m" );
    
    //$data = array("anno" => "$year", "mese" => "$mount");
    $todaym = date("Ymd");
    $data_string = '{"numeroEstrazioni":"'. $numest .'","data":"'. $todaym .'"}'; // json_encode($data);
    
    $ch = curl_init('https://www.lotto-italia.it/md/estrazioni-e-vincite/ultime-estrazioni-millionDay.json');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json')
        );
    
    $data = curl_exec($ch);
    //echo "<br/>output" . $data;
    // echo $data;
    if (curl_errno ( $ch )) {
        print "Error: " . curl_error ( $ch );
    } else {
        // Show me the result
        // var_dump($data);
        $jsond = json_decode ( $data );
        curl_close ( $ch );
        // var_dump($jsond);
    }
    return  $jsond; //$jsond->giorniRaccolte [0]->progressivoGiornaliero;
}

function get_lotto() {
    // 	$year = date ( "Y" );
    // 	$mount = date ( "m" );
    
    //$data = array("anno" => "$year", "mese" => "$mount");
    $todaym = date("Ymd");
    $data_string = '{"data":"'. $todaym .'"}'; // json_encode($data);
    
    $ch = curl_init('https://www.lottomaticaitalia.it/gdl/estrazioni-e-vincite/estrazioni-del-lotto.json');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json')
        );
    
    $data = curl_exec($ch);
    //echo "<br/>output" . $data;
    // echo $data;
    if (curl_errno ( $ch )) {
        print "Error: " . curl_error ( $ch );
    } else {
        // Show me the result
        // var_dump($data);
        $jsond = json_decode ( $data );
        curl_close ( $ch );
        // var_dump($jsond);
    }
    return  $jsond; //$jsond->giorniRaccolte [0]->progressivoGiornaliero;
}