<?php
require_once ("global.php");
class rr_lotto {
	public $att = 0;
	public $sto = 0;
	public $fre = 0;
	/**
	 *
	 * @param unknown $formazione        	
	 * @param unknown $ruote        	
	 * @param unknown $sorte        	
	 * @param string $r_estrazioni        	
	 * @param string $soloATT        	
	 */
	function ricerca($formazione, $ruote, $sorte, $r_estrazioni = "", $soloATT = false) {
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
				"z",
				"d",
				"e", // estrazione 10 e lotto 5
				"o" // oro 10 e lotto 5
		);
		$this->att=0;
		$this->sto=0;
		$this->fre=0;
		if ($r_estrazioni == "") {
			$r_estrazioni = Carica_estrazione_lotto ();
		}
		
		$ruote = "-" . strtolower ( $ruote );
		$formazione = eliminaUltimo ( $formazione );
		$formazione = explode ( ",", $formazione );
		$conta = 0;
		$nsortiti = "";
		$rit = 0;
		$v_att = false;
		// scorre estrazioni
		foreach ( $r_estrazioni as $es ) {
			
			foreach ( $rr_ruote as $sel ) {
				// ------------------------------------------------------------- Se RUORA -------------------------------------------------------------
				// $sel = "b";
				$conta = 0;
				$nsortiti = "";
				if ($pos = strpos ( $ruote, $sel ) > 0) {
					$es_numeri = "," . eliminaUltimo ( $es->$sel );
					$es_numeri = explode ( ",", $es_numeri );
					
					// cerca i numeri
					foreach ( $formazione as $num ) {
						
						$posn = array_search ( $num, $es_numeri );
						if ($posn > 0) {
							$conta += 1;
							$nsortiti .= $es_numeri [$posn] . ",";
						} // end if
					} // next for each
					if ($conta >= $sorte) {
						if ($v_att == false) {
							$v_att = true;
							$this->att = $rit;
							if ($soloATT == true) {
								return;
							}
						} else {
							if ($rit > $this->sto) {
								$this->sto = $rit;
							}
						}
						$this->fre += $this->cnk ( $conta, $sorte );
						$rit = 0;
					}
				} // end if ruota
					  // ------------------------------------------------------------- Se RUOTA -------------------------------------------------------------
			}
			$rit += 1;
		} // scorre estrazioni
	}
	function prodotto($n2, $n1 = 2) {
		$Pr = 1;
		for($i = $n1; $i <= $n2; ++ $i) {
			$Pr = $Pr * $i;
		}
		
		return $Pr;
	}
	function cnk($n, $k) {
		$mycnf = $this->prodotto ( $n, $n - $k + 1 ) / $this->prodotto ( $k );
		return $mycnf;
	}
}

class rr_10elotto5 {
	public $att = 0;
	public $sto = 0;
	public $fre = 0;
	/**
	 *
	 * @param unknown $formazione
	 * @param unknown $ruote
	 * @param unknown $sorte
	 * @param string $r_estrazioni
	 * @param string $soloATT
	 */
	function ricerca($formazione, $ruote, $sorte, $r_estrazioni = "", $soloATT = false) {
		$rr_ruote = array (
				"e", // estrazione 10 e lotto 5
				"o" // oro 10 e lotto 5
		);
		$this->att=0;
		$this->sto=0;
		$this->fre=0;
		if ($r_estrazioni == "") {
			$r_estrazioni = Carica_estrazioni_10elotto5m ();
		}

		$ruote = "-" . strtolower ( $ruote );
		$formazione = eliminaUltimo ( $formazione );
		$formazione = explode ( ",", $formazione );
		$conta = 0;
		$nsortiti = "";
		$rit = 0;
		$v_att = false;
		// scorre estrazioni
		foreach ( $r_estrazioni as $es ) {
				
			foreach ( $rr_ruote as $sel ) {
				// ------------------------------------------------------------- Se RUORA -------------------------------------------------------------
				// $sel = "b";
				$conta = 0;
				$nsortiti = "";
				if ($pos = strpos ( $ruote, $sel ) > 0) {
					$es_numeri = "," . eliminaUltimo ( $es->$sel );
					$es_numeri = explode ( ",", $es_numeri );
						
					// cerca i numeri
					foreach ( $formazione as $num ) {

						$posn = array_search ( $num, $es_numeri );
						if ($posn > 0) {
							$conta += 1;
							$nsortiti .= $es_numeri [$posn] . ",";
						} // end if
					} // next for each
					if ($conta >= $sorte) {
						if ($v_att == false) {
							$v_att = true;
							$this->att = $rit;
							if ($soloATT == true) {
								return;
							}
						} else {
							if ($rit > $this->sto) {
								$this->sto = $rit;
							}
						}
						$this->fre += $this->cnk ( $conta, $sorte );
						$rit = 0;
					}
				} // end if ruota
				// ------------------------------------------------------------- Se RUOTA -------------------------------------------------------------
			}
			$rit += 1;
		} // scorre estrazioni
	}
	function prodotto($n2, $n1 = 2) {
		$Pr = 1;
		for($i = $n1; $i <= $n2; ++ $i) {
			$Pr = $Pr * $i;
		}

		return $Pr;
	}
	function cnk($n, $k) {
		$mycnf = $this->prodotto ( $n, $n - $k + 1 ) / $this->prodotto ( $k );
		return $mycnf;
	}
}

class rr_superenalotto {
	public $att = 0;
	public $sto = 0;
	public $fre = 0;
	/**
	 *
	 * @param unknown $formazione
	 * @param unknown $ruote
	 * @param unknown $sorte
	 * @param string $r_estrazioni
	 * @param string $soloATT
	 */
	function ricerca($formazione, $ruote, $sorte, $r_estrazioni = "", $soloATT = false) {
		$rr_ruote = array (
				"e"
		);
		$this->att=0;
		$this->sto=0;
		$this->fre=0;
		if ($r_estrazioni == "") {
			$r_estrazioni = Carica_estrazioni_super ();
		}

		$ruote = "-" . strtolower ( $ruote );
		$formazione = eliminaUltimo ( $formazione );
		$formazione = explode ( ",", $formazione );
		$conta = 0;
		$nsortiti = "";
		$rit = 0;
		$v_att = false;
		// scorre estrazioni
		foreach ( $r_estrazioni as $es ) {

			foreach ( $rr_ruote as $sel ) {
				// ------------------------------------------------------------- Se RUORA -------------------------------------------------------------
				// $sel = "b";
				$conta = 0;
				$nsortiti = "";
				if ($pos = strpos ( $ruote, $sel ) > 0) {
					$es_numeri = "," . eliminaUltimo ( $es->$sel );
					$es_numeri = explode ( ",", $es_numeri );

					// cerca i numeri
					foreach ( $formazione as $num ) {

						$posn = array_search ( $num, $es_numeri );
						if ($posn > 0) {
							$conta += 1;
							$nsortiti .= $es_numeri [$posn] . ",";
						} // end if
					} // next for each
					if ($conta >= $sorte) {
						if ($v_att == false) {
							$v_att = true;
							$this->att = $rit;
							if ($soloATT == true) {
								return;
							}
						} else {
							if ($rit > $this->sto) {
								$this->sto = $rit;
							}
						}
						$this->fre += $this->cnk ( $conta, $sorte );
						$rit = 0;
					}
				} // end if ruota
				// ------------------------------------------------------------- Se RUOTA -------------------------------------------------------------
			}
			$rit += 1;
		} // scorre estrazioni
	}
	function prodotto($n2, $n1 = 2) {
		$Pr = 1;
		for($i = $n1; $i <= $n2; ++ $i) {
			$Pr = $Pr * $i;
		}

		return $Pr;
	}
	function cnk($n, $k) {
		$mycnf = $this->prodotto ( $n, $n - $k + 1 ) / $this->prodotto ( $k );
		return $mycnf;
	}
}

class rr_wflc {
	public $att = 0;
	public $sto = 0;
	public $fre = 0;
	/**
	 *
	 * @param unknown $formazione
	 * @param unknown $ruote
	 * @param unknown $sorte
	 * @param string $r_estrazioni
	 * @param string $soloATT
	 */
	function ricerca($formazione, $ruote, $sorte, $r_estrazioni = "", $soloATT = false) {
		$rr_ruote = array (
				"e", // estrazione 10 e lotto 5
				"o" // oro 10 e lotto 5
		);
		$this->att=0;
		$this->sto=0;
		$this->fre=0;
		if ($r_estrazioni == "") {
			$r_estrazioni = Carica_estrazioni_wfl_classico ();
		}

		$ruote = "-" . strtolower ( $ruote );
		$formazione = eliminaUltimo ( $formazione );
		$formazione = explode ( ",", $formazione );
		$conta = 0;
		$nsortiti = "";
		$rit = 0;
		$v_att = false;
		// scorre estrazioni
		foreach ( $r_estrazioni as $es ) {

			foreach ( $rr_ruote as $sel ) {
				// ------------------------------------------------------------- Se RUORA -------------------------------------------------------------
				// $sel = "b";
				$conta = 0;
				$nsortiti = "";
				if ($pos = strpos ( $ruote, $sel ) > 0) {
					$es_numeri = "," . eliminaUltimo ( $es->$sel );
					$es_numeri = explode ( ",", $es_numeri );

					// cerca i numeri
					foreach ( $formazione as $num ) {

						$posn = array_search ( $num, $es_numeri );
						if ($posn > 0) {
							$conta += 1;
							$nsortiti .= $es_numeri [$posn] . ",";
						} // end if
					} // next for each
					if ($conta >= $sorte) {
						if ($v_att == false) {
							$v_att = true;
							$this->att = $rit;
							if ($soloATT == true) {
								return;
							}
						} else {
							if ($rit > $this->sto) {
								$this->sto = $rit;
							}
						}
						$this->fre += $this->cnk ( $conta, $sorte );
						$rit = 0;
					}
				} // end if ruota
				// ------------------------------------------------------------- Se RUOTA -------------------------------------------------------------
			}
			$rit += 1;
		} // scorre estrazioni
	}
	function prodotto($n2, $n1 = 2) {
		$Pr = 1;
		for($i = $n1; $i <= $n2; ++ $i) {
			$Pr = $Pr * $i;
		}

		return $Pr;
	}
	function cnk($n, $k) {
		$mycnf = $this->prodotto ( $n, $n - $k + 1 ) / $this->prodotto ( $k );
		return $mycnf;
	}
}






class rr_wflg {
	public $att = 0;
	public $sto = 0;
	public $fre = 0;
	/**
	 *
	 * @param unknown $formazione
	 * @param unknown $ruote
	 * @param unknown $sorte
	 * @param string $r_estrazioni
	 * @param string $soloATT
	 */
	function ricerca($formazione, $ruote, $sorte, $r_estrazioni = "", $soloATT = false) {
		$rr_ruote = array (
				"e", // estrazione 10 e lotto 5
				"o" // oro 10 e lotto 5
		);
		$this->att=0;
		$this->sto=0;
		$this->fre=0;
		if ($r_estrazioni == "") {
			$r_estrazioni = Carica_estrazioni_wfl_grattacielo ();
		}

		$ruote = "-" . strtolower ( $ruote );
		$formazione = eliminaUltimo ( $formazione );
		$formazione = explode ( ",", $formazione );
		$conta = 0;
		$nsortiti = "";
		$rit = 0;
		$v_att = false;
		// scorre estrazioni
		foreach ( $r_estrazioni as $es ) {

			foreach ( $rr_ruote as $sel ) {
				// ------------------------------------------------------------- Se RUORA -------------------------------------------------------------
				// $sel = "b";
				$conta = 0;
				$nsortiti = "";
				if ($pos = strpos ( $ruote, $sel ) > 0) {
					$es_numeri = "," . eliminaUltimo ( $es->$sel );
					$es_numeri = explode ( ",", $es_numeri );

					// cerca i numeri
					foreach ( $formazione as $num ) {

						$posn = array_search ( $num, $es_numeri );
						if ($posn > 0) {
							$conta += 1;
							$nsortiti .= $es_numeri [$posn] . ",";
						} // end if
					} // next for each
					if ($conta >= $sorte) {
						if ($v_att == false) {
							$v_att = true;
							$this->att = $rit;
							if ($soloATT == true) {
								return;
							}
						} else {
							if ($rit > $this->sto) {
								$this->sto = $rit;
							}
						}
						$this->fre += $this->cnk ( $conta, $sorte );
						$rit = 0;
					}
				} // end if ruota
				// ------------------------------------------------------------- Se RUOTA -------------------------------------------------------------
			}
			$rit += 1;
		} // scorre estrazioni
	}
	function prodotto($n2, $n1 = 2) {
		$Pr = 1;
		for($i = $n1; $i <= $n2; ++ $i) {
			$Pr = $Pr * $i;
		}

		return $Pr;
	}
	function cnk($n, $k) {
		$mycnf = $this->prodotto ( $n, $n - $k + 1 ) / $this->prodotto ( $k );
		return $mycnf;
	}
}
?>