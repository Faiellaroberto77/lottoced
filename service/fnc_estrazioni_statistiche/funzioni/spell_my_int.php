<?php
function numero_lettere($numero) {
	if (($numero < 0) || ($numero > 999999999)) {
		return "$numero";
	}
	
	$milioni = floor ( $numero / 1000000 ); // Milioni
	$numero -= $milioni * 1000000;
	$migliaia = floor ( $numero / 1000 ); // Migliaia
	$numero -= $migliaia * 1000;
	$centinaia = floor ( $numero / 100 ); // Centinaia
	$numero -= $centinaia * 100;
	$decine = floor ( $numero / 10 ); // Decine
	$unita = $numero % 10; // Unità
	
	$cifra_lettere = "";
	
	if ($milioni) {
		if ($milioni == 1)
			$cifra_lettere .= numero_lettere ( $milioni ) . "milione ";
		else
			$cifra_lettere .= numero_lettere ( $milioni ) . "milioni ";
	}
	
	if ($migliaia) {
		if ($migliaia == 1)
			$cifra_lettere .= numero_lettere ( $migliaia ) . "mille ";
		else
			$cifra_lettere .= numero_lettere ( $migliaia ) . "mila ";
	}
	
	if ($centinaia) {
		$cifra_lettere .= numero_lettere ( $centinaia ) . "cento ";
	}
	
	$array_primi = array (
			"",
			"uno",
			"due",
			"tre",
			"quattro",
			"cinque",
			"sei",
			"sette",
			"otto",
			"nove",
			"dieci",
			"undici",
			"dodici",
			"tredici",
			"quattordici",
			"quindici",
			"sedici",
			"diciassette",
			"diciotto",
			"diciannove" 
	);
	$array_decine = array (
			"",
			"",
			"venti",
			"trenta",
			"quaranta",
			"cinquanta",
			"sessanta",
			"settanta",
			"ottanta",
			"novanta" 
	);
	
	if ($decine || $unita) {
		if ($decine < 2) {
			$cifra_lettere .= $array_primi [$decine * 10 + $unita];
		} else {
			$cifra_lettere .= $array_decine [$decine];
			
			if ($unita) {
				$cifra_lettere .= $array_primi [$unita];
			}
		}
	}
	
	if (empty ( $cifra_lettere )) {
		$cifra_lettere = "zero";
	}
	
	return $cifra_lettere;
}
?>
