<?php
ini_set('display_errors','On');
error_reporting(E_ALL);
require_once ('global.php');
require_once ('get_estrazioni.php');

$link = "https://lottoced.com/fnc_estrazioni_statistiche/funzioni/test.php";
$httpfile = json_decode(file_get_contents ( $link ));
sleep(2);
$httpfile = json_decode(file_get_contents ( $link ));

$cnt = 0;
echo date("h:i:sa") . ' - ' . $httpfile->raccolteFrequenti[0]->statoRaccolta . ' ' . $cnt .'<br/>';
ob_flush();
flush();
sleep(50);
while ($httpfile->raccolteFrequenti[0]->statoRaccolta <> "ESTRATTA"){
    sleep(2);
    $httpfile = json_decode(file_get_contents ( $link ));
    echo date("h:i:sa") . ' - ' . $httpfile->raccolteFrequenti[0]->statoRaccolta . ' ' . $cnt . '<br/>';
    //echo date("h:i:sa") . ' - ' . implode($httpfile->raccolteFrequenti[0]->numeriDaEstrarre) .'<br/>';
    ob_flush();
    flush();
    ++ $cnt;
     if ($cnt == 30) {
         $httpfile = json_decode(file_get_contents ( $link ));
         //echo 'out<br>';
         ob_flush();
         flush();
         break;
        }
}
echo date("h:i:sa") . ' - ' . $httpfile->raccolteFrequenti[0]->statoRaccolta . ' ' . $cnt .'<br/>';
$year = date ( "Y" );
$mount = date ( "m" );
$today = date ( "Y-m-d" );
$todayLotto = date ( "Ymd" );

$end = count($httpfile->raccolteFrequenti) + 1;
$start = lastdate10el5 ($today);
$cnt = 1;
echo $end . " " . $start . "<br/>";
if (($end) > $start) {
    $outagg = "";
    for($iloop = 0; $iloop <= $end - $start; ++ $iloop) {
        $out = $httpfile->raccolteFrequenti[$iloop];
		//print_r($httpfile);
        if (isset($out)){
            // print_r ( $out );
            $esdata = date ( "Y-m-d" );
            $mynum = sort($out->numeri);
            $estrazione = implode ( $out->numeri, "," ) . ",";
            $num = $out->progressivoGiornaliero;
            $num_one = $out->numeroSpecialeEstratto;
            $num_one2 = $out->doppioOroEstratto;
            $MySql = new MysqlClass ();
            $MySql->connetti ();
            $r = "esdata, estrazione, num, num_oro, num_oro2, estrazione_j";
			$estrazione_j = json_encode($out);
            $v = array (
                $esdata,
                $estrazione,
                $num,
                $num_one,
                $num_one2,
				$estrazione_j
            );
			//echo "inserisci db<br>";
            $MySql->inserisci ( "es_10elotto5", $v, $r );
			//echo "inseriTO db<br>";
            $outagg .= $num . " - ";
        }
    }
    echo "Previsioni \n";
    require_once __DIR__.('/../10elotto5/ctrl_previsioni.php');
    echo date ( "d-m-Y H:i:s" ) . " ->";
    echo "AGG 10 e lotto 5 $outagg \n";
}
?>