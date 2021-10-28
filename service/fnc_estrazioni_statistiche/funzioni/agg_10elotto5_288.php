<?php
            require_once ('global.php');
            require_once ('get_estrazioni.php');
            estrazione_288(1);     
function estrazione_288($giorno) {
    $newdate = date('Y-m-d', strtotime('-'.$giorno.' day', strtotime(date('Y-m-d'))));
    $todayLotto = date('Ymd', strtotime('-'.$giorno.' day', strtotime(date('Y-m-d'))));
    $df = date('Ym', strtotime('-'.$giorno.' day', strtotime(date('Y-m-d'))));
    $end = 288;
    $start =287;
    if ($end > $start) {
       
        $outagg = "";
        for($iloop = $start + 1; $iloop <= $end; ++ $iloop) {
            $out = Estrazione10elotto5lottomatica ( $iloop, $todayLotto );
            if ($out == null) {
                break;
            }
            // print_r ( $out );
            $esdata = $newdate;
            echo $esdata . "<br/>\n";
            $estrazione = implode ( $out->numeriEstratti, "," ) . ",";
            $num = $out->progressivoGiornaliero;
            $num_one = $out->numeroSpeciale;
            $num_one2 = $out->doppioNumeroSpeciale;
            // INSERT INTO `lottoced`.`es_10elotto5` (`esdata`, `estrazione`, `num`, `num_oro`) VALUES ('2015-08-14', '1,2,3,', '10', '10');
            
             $MySql = new MysqlClass ();
             $MySql->connetti ();
            $r = "esdata, estrazione, num, num_oro, num_oro2";
            $v = array (
                $esdata,
                $estrazione,
                $num,
                $num_one,
                $num_one2
            );
            $MySql->inserisci ( "es_10elotto5", $v, $r );
        }

    }
}
 
 ?>