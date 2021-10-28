<?php
require_once ('global.php');
require_once ('get_estrazioni.php');

$year = date ( "Y" );
$mount = date ( "m" );
$today = date ( "Y-m-d" );
$todayLotto = date ( "Ymd" );
//sleep ( 10 );
$end = get_progressivo_10elotto ($year, $mount);
$start = lastdate10el5 ($today);
$cnt = 1;
//$start = 0;
//$end = 288;
while ( $start == $end ) {
    $end = get_progressivo_10elotto ($year, $mount);
    $start = lastdate10el5 ($today);
    sleep ( 5 );
    ++ $cnt;
    if ($cnt == 12 * 4) {
        break;
    }
}
//$start = lastdate10el5 ($today);
if ($end > $start) {
    $outagg = "";
    for($iloop = $start + 1; $iloop <= $end; ++ $iloop) {
        $out = Estrazione10elotto5lottomatica ( $iloop, $todayLotto );
        if (isset($out)){
            // print_r ( $out );
            $esdata = date ( "Y-m-d" );
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
            $outagg .= $iloop . " - ";
            // ( "es_10elotto4", $v, $r );
        }
        
    }
    echo "Previsioni \n";
    require_once __DIR__.('/../10elotto5/ctrl_previsioni.php');
    echo date ( "d-m-Y H:i:s" ) . " ->";
    echo "AGG 10 e lotto 5 $outagg \n";
}
?>