<?php
/*
 * massimi ritardi attuali_lotto
 */
require_once 'funzioni/statistica.php';

if (isset ( $_GET ['force'] )) {
	$force = $_GET ['force'];
} else {
	$force = 0;
}
$b_mobile = isset ($_GET ['mobile']) ? $_GET ['mobile'] : 0;
$numeruote = array (
		"Bari",
		"Cagliari",
		"Firenze",
		"Genova",
		"Milano",
		"Napoli",
		"Palermo",
		"Roma",
		"Torino",
		"Venezia",
		"Nazionale" 
);
$rr_ruote = array (
		"b",
		"c",
		"f",
		"g",
		"m",
		"n",
		"p",
		"r",
		"t",
		"v",
		"z" 
);
$ultimadata = lastdate();
$tabella = "lotto_maxritardiattuali" . $ultimadata;
$listAll = application ( $tabella );

if (empty ( $listAll ) || $force == 1) {
	$ricerca = new rr_lotto ();
	$r_estrazioni = Carica_estrazione_lotto ();
	$v_attuale = array (
			"ruota" => "",
			"num" => "",
			"att" => "",
			"sto" => "",
			"fre" => "" 
	);
	$listrit = array ();
	$listAll = array ();
	
	$idx_cnt = 0;
	foreach ( $rr_ruote as $key ) {
		// ------------------------------------------- RUOTE ---------------------------------------------------->
		for($iloop = 1; $iloop <= 90; ++ $iloop) {
			$selr = substr ( $key, 0, 1 );
			$ricerca->ricerca ( $iloop . ",", $selr, 1, $r_estrazioni );
			$v_attuale ["ruota"] = $numeruote [$idx_cnt];
			$v_attuale ["num"] = $iloop;
			$v_attuale ["att"] = $ricerca->att;
			$v_attuale ["sto"] = $ricerca->sto;
			$v_attuale ["fre"] = $ricerca->fre;
			$listrit [] = $v_attuale;
		}
		$listrit = array_sort ( $listrit, "att", SORT_DESC );
		$listAll [] = $listrit;
		$listrit = array ();
		++ $idx_cnt;
		// ------------------------------------------- RUOTE ---------------------------------------------------->
	}
	$listAll = json_encode ( $listAll );
	$enc_j = addslashes ( $listAll );
	application_set ( $tabella, $enc_j );
}

$max = 0;
$listAll = json_decode ( $listAll );
foreach ( $listAll as $key1 ) {
	if ($key1 [0]->att > $max) {
		$max = $key1 [0]->att;
	}
}

echo '<div class="row">';
echo '<div class="col-sm-12 text-center">';
echo '<h2 class="titolo row">I numeri piu\' frequenti<br /> gioco del lotto</h2><b>' . $ultimadata;
echo '</div>';
echo '<table class="table table-condensed table-striped table-bordered">';
echo '<tr>';
echo '<th>-</th><th>Posizione</th><th>1</th><th>2</th><th>3</th><th>4</th><th>5</th><th>6</th><th>7</th><th>8</th><th>9</th><th>10</th><th>11</th><th>12</th><th>13</th><th>14</th><th>15</th>';
echo '</tr>';
$cont = 0;
foreach ( $listAll as $key1 ) {
	$key1 = array_sort ( $key1, "fre", SORT_DESC);
	$cont++;
	if ($cont == 6 && $b_mobile == 1) {
		$ret ="<div class=\"text-left\">";
		$ret .= "<!-- box -->";
		$ret .= "<div id='div-gpt-ad-1454418627035-0'>";
		$ret .= "<script type='text/javascript'>";
		$ret .= "googletag.cmd.push(function() { googletag.display('div-gpt-ad-1454418627035-0'); });";
		$ret .= "</script>";
		$ret .= "</div>";
		$ret .= "</div>";
		echo '<tr><td colspan="17">'. $ret . '</td></tr>';
	}
	echo '<tr>';
	echo '<td rowspan="2">'. $key1 [0]->ruota. '</td>';
	$r ='';
	$n ='';
	for($i = 0; $i <= 14; ++ $i) {
		$r .= '<td>' . $key1 [$i]->fre . '</td>';
		$n .= '<td>' .$key1 [$i]->num . '</td>';		
	}
	$r = '<td>Fre.</td>' . $r;
	$n = '<td>Num.</td>' . $n;
			
	echo  $n . '</tr>';
	echo '<tr>' . $r . '</tr>';
	// echo $arr [0]->ritNumero;
	// echo $arr [0]->Ritardo;
}
echo "</table></div>";
?>
