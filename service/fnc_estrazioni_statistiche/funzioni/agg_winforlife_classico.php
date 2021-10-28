<?php
require_once ('global.php');
require_once ('get_estrazioni.php');

$year = date ( "Y" );
$mount = date ( "m" );
$today = date ( "Y/m/d" );
$todayLotto = date ( "Ymd" );


$start = lastdate_winforlife_classico($today);
$cnt = 1;


	$outagg = "";
	//for($iloop = $start + 1; $iloop <= $end; ++ $iloop) {
		$out = Estrazione_winforlife_classico($today );
		
		$esdata = date ( "Y-m-d" );
		$contaora = 6;
		foreach ($out->listaConcorsi as $key1){
			$contaora +=1;
			$estrazione = implode ($key1->combinazioneVincente->estratti,",");
			$num_one = $key1->combinazioneVincente->numerone;
			$num = $key1->concorso->numero;
			$ora = str_pad ($contaora, 2, '0', STR_PAD_LEFT ) . ":00";
			if ($num > $start && !empty($estrazione)){
				$MySql = new MysqlClass ();
				$MySql->connetti ();
				$r = "esdata, estrazione, num, num_one, ora";
				$v = array (
						$esdata,
						$estrazione,
						$num,
						$num_one,
						$ora
				);
				$MySql->inserisci ( "es_winforlife_classico", $v, $r );
				$outagg .= $num . " - ";
				$MySql->disconnetti();
			}
		}
		
		
		
		
		// INSERT INTO `lottoced`.`es_10elotto5` (`esdata`, `estrazione`, `num`, `num_oro`) VALUES ('2015-08-14', '1,2,3,', '10', '10');
		

		// ( "es_10elotto4", $v, $r );
	//}
	echo date ( "d-m-Y H:i:s" ) . " ->";
	echo "AGG winforlife classico $outagg \n";

?>