<?php
/**
 * @author Faiella
 * dt = data estrazione 
 * ru = estrazione delle 11 ruote
 * dl = estrazioni 10elotto
 */
class estrazioni_televideo {
	public $esito = "ok";
	public $dt = ""; // Data estrazione
	public $ru = array (); // 11 ruote
	public $dl = ""; // dieci e lotto
	public function __construct() {
		// SCARICA L'ESTRAZIONE DA TELEVIDEO
		$InData = $this->get_estrazione_lotto ();
		
		if ($InData == FALSE) {
			$this->esito = "ko";
			return FALSE;
		}
		$tmp = explode ( "\n", $InData );
		$this->dt = $tmp [0]; // assegna data
		for($i = 1; $i <= 11; ++ $i) {
			$this->ru [] = $this->solonumeri ( $tmp [$i] ); // dieci ruote solo numeri
		}
		$this->dl = $this->estrazioni10elotto ( $this->ru );
	}
	private function estrazioni10elotto($inEstrazioneLotto) {
		$alln = array ();
		
		for($i = 0; $i <= 9; ++ $i) {
			$alln [] = explode ( ",", $this->ru [$i] );
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
					$numeri [] = $numeropreso;
					$conferma = TRUE;
				}
			}
		}
		
		sort ( $numeri, SORT_NUMERIC );
		$numeri [] = $alln [0] [0];
		
		return $numeri;
	}
	private function solonumeri($InStr) {
		// elimina la descrizione delle ruote
		$posizione = strpos ( $InStr, "," );
		return substr ( $InStr, $posizione + 1 );
	}
	private function get_estrazione_lotto() {
		$R_Pagina = "";
		$pagina = file_get_contents ( "http://www.servizitelevideo.rai.it/televideo/pub/solotesto.jsp?pagina=591" );
// 		$pagina = "       ESTRAZIONE DEL  
//         17/12/2015    

//       BARI      81  39  20  44  76    
//       CAGLIARI  79  70  25  41  60    
//       FIRENZE   16  24  87  54  23    
//       GENOVA    43  30  10  41  67    
//       MILANO    12  73  47  44  76    
//       NAPOLI    74  23  48  73  52    
//       PALERMO   50  17  75  33  28    
//       ROMA      32  63  72  15  16    
//       TORINO    29  60  43  45  13    
//       VENEZIA   45  60  38  90  73    
//       NAZIONALE 85  50  34  29  74    
// 		";
		// $pagina = file_get_contents("http://www.servizitelevideo.rai.it");
		if ($pagina == false) {
			return FALSE;
		}
		
		$ruote = array (
				"BARI",
				"CAGLIARI",
				"FIRENZE",
				"GENOVA",
				"MILANO",
				"NAPOLI",
				"PALERMO",
				"ROMA",
				"TORINO",
				"VENEZIA",
				"NAZIONALE" 
		);
		
		// Acquisisce data
		$selData = $pagina;
		$posizione = strpos ( $selData, "ESTRAZIONE DEL" );
		
		if ($posizione == false) {
			return FALSE;
		}
		
		$selData = substr ( $selData, $posizione );
		$posizione = strpos ( $selData, "\n" );
		$selData = substr ( $selData, $posizione + 1 );
		$posizione = strpos ( $selData, "\n" );
		$selData = trim ( substr ( $selData, 0, $posizione ) );
		
		$selData = substr ( $selData, 6, 4 ) . "/" . substr ( $selData, 3, 2 ) . "/" . substr ( $selData, 0, 2 );
		// $datatoday = date("d/m/Y");
		// $posizione = strpos($pagina, $datatoday);
		
		if ($posizione > 0) {
			foreach ( $ruote as $nr ) {
				$Ruota = $pagina;
				$posizione = strpos ( $Ruota, $nr );
				$Ruota = substr ( $Ruota, $posizione );
				$posizione = strpos ( $Ruota, "\n" );
				$Ruota = substr ( $Ruota, 0, $posizione );
				$Ruota = str_replace ( " ", ",", $Ruota );
				
				$Ruota = doppi_pulisci ( $Ruota, "," );
				$R_Pagina = $R_Pagina . $Ruota . "\n";
			}
			return $selData . "\n" . $R_Pagina;
		} else {
			return FALSE;
		}
	}
}
class superenalotto {
	public $esito = "ok";
	public $dt = ""; // Data estrazione
	public $estrazione = ""; // ESTRAZIONE DEI SEI NUMERI
	public $j = ""; // NUMERO JOLLY
	public $s = ""; // NUMERO SUPERSTAR
	public $montepremio = ""; // MONTEPREMI
	public $vincite = ""; // Vincite
	public $jeckpot = "";
	public $commento = "";
	public function __construct() {
		// SCARICA L'ESTRAZIONE DA SUPERENALOTTO.IT
		$InData = $this->get_superenalotto_online ();
	}
	private function get_superenalotto_online() {
		$pagina = file_get_contents ( "https://www.gntn-pgd.it/gntn-info-web/rest/gioco/superenalotto/estrazioni/ultimoconcorso?idPartner=vetrina" );
		
		$pagina_js = json_decode ( $pagina );
		if ($pagina_js == NULL) {
			$this->esito = "ko";
			return;
		}
		$this->dt = converti_data_json ( $pagina_js->dataEstrazione );
		$this->estrazione = implode ( $pagina_js->combinazioneVincente->estratti, "," ) . ",";
		$this->j = $pagina_js->combinazioneVincente->numeroJolly;
		$this->s = $pagina_js->combinazioneVincente->superstar;
		$this->montepremio = json_encode ( $pagina_js->montepremi );
		$this->vincite = json_encode ( $pagina_js->dettaglioVincite->vincite );
		if  ($this->j == NULL) {
			$this->esito = "ko";
			return;
		}
// 		if ($pagina_js->dettaglioDisponibile = 0){
// 		    $this->esito = 'ko';
// 		}
		//$pagina = file_get_contents ( "https://www.gntn-pgd.it/gntn-info-web/rest/gioco/superenalotto/concorsoufficiale?idPartner=vetrina" );
		// $pagina = file_get_contents ( "http://www.superenalotto.it/");
		//$posizione = strpos ( $pagina, "<ns2:jackpot>" );
// 		//if ($posizione == 0) {
// 			$this->esito = "ko";
// 			return;
// 		}
		$this->jeckpot = number_format ($pagina_js->jackpot, 2, ',', '.' );
		if ($this->jeckpot == 0) {
			$this->esito = "ko";
			return;
		}
		if ($pagina_js->dettaglioDisponibile != 0){
		    $this->commento = $this->commentoSuper ( $this->vincite );
		}
		//$this->commento = $this->commentoSuper ( $this->vincite );
	}
	private function commentoSuper($in_vincite) {
		require_once ("spell_my_int.php");
		$in_vincite = json_decode ( $in_vincite );
		$return_var = "";
		$out_titolo = "";
		$outCommento = "";
		for($i = 0; $i <= 2; ++ $i) {
			$n = (( int ) $in_vincite [$i]->numero);
			$d = $in_vincite [$i]->quota->categoriaVincita->descrizione;
			$v = substr ( $in_vincite [$i]->quota->importo, 0, strlen ( $in_vincite [$i]->quota->importo ) - 2 );
			switch ($i) {
				case 0 :
				case 1 :
					switch ($n) {
						case 0 :
							$out_titolo .= "NESSUN $d";
							break;
						case 1 :
							$out_titolo .= "UN SOLO $d";
							break;
						default :
							$out_titolo .= "SONO $n i $d";
							break;
					}
					if ($i < 1) {
						$out_titolo .= ", ";
					} // end if
					break;
				case 2 :
					$outCommento = "$out_titolo al Superenalotto. ";
					switch ($n) {
						case 0 :
							$outCommento .= "Nessun vincitore per il cinque in questa estrazione. ";
							break;
						case 1 :
							
							$outCommento .= "Un solo vincitore per il cinque che porta a casa oltre " . ( int ) ($v / 1000) . " Mila euro. ";
							break;
						default :
							$outCommento .= "Sono $n i vincitori del cinque che portano a casa oltre " . ( int ) ($v / 1000) . " Mila euro. ";
							break;
					}
			} // swith $i
		} // next
		$return_var = $out_titolo . "<br />\n <span class=\"text-justify\">" . $outCommento . "Per il prossimo concorso il sei vale " . $this->jeckpot . ". (C) <a target=\"_top\" href=\"http://www.lottoced.com\">lottoced.com</a></span>";
		$return_var = addslashes ( $return_var );
		return $return_var;
	}
}
function doppi_pulisci($in_str, $in_find) {
	$in_find_d = $in_find . $in_find;
	for($i = 1; $i <= 16; $i ++) {
		$in_str = str_replace ( $in_find_d, $in_find, $in_str );
	}
	return $in_str;
}
function converti_data_json($js_data) {
	$date = substr ( '/Date(' . $js_data . ')/', 6, - 5 );
	$date = date ( 'Y/m/d', $date + date ( 'Z', $date ) );
	return $date;
}
function EstrazioneLottoLottoMatica() {
	$url = "http://www.lottomaticaitalia.it/gdl/estrazioni-e-vincite/estrazioni-del-lotto.json";
	$page = "/gdl/estrazioni-e-vincite/estrazioni-del-lotto.json";
	$headers = array (
			"POST " . $page . " HTTP/1.0",
			"Host: www.lottomaticaitalia.it",
			"User-Agent: Mozilla/5.0 (Windows NT 6.3; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0",
			"Accept: application/json",
			"Content-Type: application/json; charset=UTF-8",
			"X-Requested-With: XMLHttpRequest",
			"Referer: http://www.lottomaticaitalia.it/lotto/risultatieconcorsi/estrazioni_ultime.html",
			"Content-length: 19" 
	);
	
	$ch = curl_init ();
	curl_setopt ( $ch, CURLOPT_URL, $url );
	curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
	curl_setopt ( $ch, CURLOPT_TIMEOUT, 30 );
	curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
	// curl_setopt($ch, CURLOPT_USERAGENT, $defined_vars['HTTP_USER_AGENT']);
	
	// Apply the XML to our curl call
	curl_setopt ( $ch, CURLOPT_POST, 1 );
	curl_setopt ( $ch, CURLOPT_POSTFIELDS, "{\"data\":\"20150704\"}" );
	
	$data = curl_exec ( $ch );
	
	if (curl_errno ( $ch )) {
		print "Error: " . curl_error ( $ch );
	} else {
		// Show me the result
		// var_dump($data);
		$jsond = json_decode ( $data );
		curl_close ( $ch );
		// var_dump($jsond);
	}
	return $jsond;
}
// ----------------------------------------- ESTRAZIONE 10 E LOTTO 5 MIN LOTTOMATICA --------------------------
function Estrazione10elotto5lottomatica($numest10l, $today) {
	//$today = date ( "Ymd" );
	if ($numest10l < 10) {
		$contentL = 48;
	} elseif ($numest10l < 100) {
		$contentL = 49;
	} else {
		$contentL = 50;
	}
	$data = array("data" => "$today", "progressivoGiornaliero" => $numest10l);
	$data_string = json_encode($data);
	
	$ch = curl_init('https://www.lottomaticaitalia.it/del/estrazioni-e-vincite/10-e-lotto-estrazioni-ogni-5.json');
	                 
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Content-Length: ' . strlen($data_string))
			);
	
	$data = curl_exec ( $ch );
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
	return $jsond;
}
function get_progressivo_10elotto($year, $mount) {
// 	$year = date ( "Y" );
// 	$mount = date ( "m" );
	$data = array("anno" => "$year", "mese" => "$mount");
	$data_string = json_encode($data);
	
	$ch = curl_init('https://www.lottomaticaitalia.it/del/estrazioni-e-vincite/10-e-lotto-calendario-estrazioni-ogni-5.json');
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Content-Length: ' . strlen($data_string))
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
	return $jsond->giorniRaccolte [0]->progressivoGiornaliero;
}
// ----------------------------------------- ESTRAZIONE 10 E LOTTO 5 MIN LOTTOMATICA --------------------------

// ----------------------------------------- ESTRAZIONE WIN FOR LIFE CLASSICO --------------------------
function Estrazione_winforlife_classico( $today) {
	//$today = date ( "Ymd" );
	$url = "http://www.winforlife.it/sisal-gn-proxy-servlet-web/proxy/gntn-info-web/rest/gioco/winforlifeclassico/estrazioni/archivioconcorso/$today";
	$httpfile = file_get_contents($url);
	$jsond = json_decode($httpfile);
	return $jsond;
}

// ----------------------------------------- ESTRAZIONE WIN FOR LIFE GRATTACIELO --------------------------
function Estrazione_winforlife_grattacielo( $today, $ora) {
	//$today = date ( "Ymd" );
	$url = "http://www.gntn-pgd.it/gntn-info-web/rest/gioco/winforlifegrattacieli/estrazioni/archivioconcorso/$today/$ora?idPartner=123456789";
	$httpfile = file_get_contents($url);
	$jsond = json_decode($httpfile);
	return $jsond;
}


// ----------------------------------------- ESTRAZIONE WIN FOR LIFE GRATTACIELO --------------------------
?>