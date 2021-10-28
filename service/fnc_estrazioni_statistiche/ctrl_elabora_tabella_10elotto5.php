<?php
if (isset ( $_REQUEST ['tabella'] )) {
	$tabella = $_REQUEST ['tabella'];
} else {
	$tabella = "Gemelli";
}
if (isset ( $_REQUEST ['sorte'] )) {
	$sorte = $_REQUEST ['sorte'];
} else {
	$sorte = 0;
}

if (isset ( $_REQUEST ['vd'] )) {
	$v_desc = $_REQUEST ['vd'];
} else {
	$v_desc = 1;
}

if (isset ( $_REQUEST ['vt'] )) {
	$v_tab = $_REQUEST ['vt'];
} else {
	$v_tab = 1;
}
$this_y = date ( 'Y-m-d' );
require_once 'funzioni/statistica.php';

$numeruote = array (
		"Bari" 
);
$rr_ruote = array (
		"e" 
);
$rr_sorte = array (
		" ",
		"Ambata",
		"Ambo",
		"Terno",
		"Quaterna",
		"Cinquina" 
);

$data_newsletter = new MysqlClass ();
$data_newsletter->connetti ();
if (isset ( $_REQUEST ['id'] )) {
	$myid = $_REQUEST ['id'];
	$formazione = $data_newsletter->query ( "SELECT * FROM es_tabelle where id = $myid;" );
} else {
	$formazione = $data_newsletter->query ( "SELECT * FROM es_tabelle where titolo = '$tabella';" );
}

if (mysqli_num_rows ( $formazione ) > 0) {
	$estrai = $data_newsletter->estrai ( $formazione );
	$formazioni = explode ( ";", $estrai->formazioni );
	$titolo = $estrai->titolo;
	$descrizione = $estrai->descrizione;
	$sorte_default = $estrai->sorte_d;
	if ($sorte == 0) {
		$sorte = $sorte_default;
	}
	// -------------------------------------------- NOME DELLA TABELLA ------------------------------
	$lst = lastdate10el5 ( $this_y );
	$n_tabella = '10elotto5-tab-' . $titolo . '-' . $sorte . '-' . $lst . '-' . $this_y;
	if ($v_desc == 1) {
		$htmlv = '<div class="well">';
		// $htmlv .= '<div class = "row"';
		// $htmlv .= '<div class="col-xs-12">';
		$htmlv .= '<h1>Statistiche della tabella ' . $titolo . ' per la sorte di ' . $rr_sorte [$sorte] . '</h1>';
		$htmlv .= "<p>$descrizione</p>";
		//
		// $htmlv .= '</div>';
		// $htmlv .= '</div>';
		$htmlv .= '</div>';
		echo $htmlv;
	}
	$name_t = "tabella_statistica";
	$html = application ( $n_tabella );
	// ----------------------------------------------------------------------------------------------
	if (empty ( $html )) {
		if (application ( 'elab' ) == 0) {
			application_set ( 'elab', '1' );
			$html .= '<div class="table-responsive tableh">';
			$html .= '<table id="' . $name_t . '" class="table table-condensed table-striped table-bordered">';
			// ------------------------------------- TESTATA --------------------------------------
			$html .= '<thead><tr>';
			$html .= '<th>formazioni</th>';
			foreach ( $numeruote as $key ) {
				
				$html .= '<th>' . $key . '</th>';
			}
			// $html .= '<th>Tutte</th>';
			$html .= '</tr>';
			$html .= '</thead>';
			// ------------------------------------------------------------------------------------
			$this_y = date ( 'Y-m-d' );
			$g_giorno = $this_y;
			$estrazionilotto = Carica_estrazioni_10elotto5m ( $g_giorno );
			// --------------------------------------- // CORPO // --------------------------------
			
			foreach ( $formazioni as $key ) {
				$html .= '<tr>';
				$html .= '<td class="nowrap firstcol text-left">' . $key . '</td>';
				foreach ( $rr_ruote as $r ) {
					$ritardi = new rr_10elotto5 ();
					$key = str_replace ( ".", ",", $key );
					$ritardi->ricerca ( $key, $r, $sorte, $estrazionilotto, false );
					$stile = "";
					if ($ritardi->att > $ritardi->sto) {
						$stile = "ev";
					}
					$html .= "<td class=\"nowrap text-center $stile\"><span class=\"lcd_a\">$ritardi->att</span><span class=\"lcd_s\">$ritardi->sto</span><span class=\"lcd_f\">$ritardi->fre</span></td>";
				}
				// $stile = "";
				// if ($ritardi->att > $ritardi->sto) {
				// $stile = "ev";
				// }
				// $ritardi->ricerca ( $key, "bcfgmnprtv", $sorte, $estrazionilotto, false );
				// $stile = "";
				// if ($ritardi->att > $ritardi->sto) {
				// $stile = "ev";
				// }
				// $html .= "<td class=\"nowrap text-center $stile\"><span class=\"lcd_a\">$ritardi->att</span><span class=\"lcd_s\">$ritardi->sto</span><span class=\"lcd_f\">$ritardi->fre</span></td>";
				// $html .= '</tr>';
			}
			
			// ----------------------------------------- CORPO ------------------------------------
			$html .= '</table>';
			
			$html .= '</div>';
			application_set ( $n_tabella, addslashes ( $html ) );
			application_set ( 'elab', '0' );
		} else {
			$htmlv = '<div class="well">';
			// $htmlv .= '<div class = "row"';
			// $htmlv .= '<div class="col-xs-12">';
			$htmlv .= '<h1>Tabella in aggiornamento ...</h1>';
			$htmlv .= "<p>$descrizione</p>";
			//$htmlv .= '<p>Aggiorna dal browser</p>';
			//
			// $htmlv .= '</div>';
			// $htmlv .= '</div>';
			$htmlv .= '</div>';
			echo $htmlv;
		}
	}
} else {
	$html = "<h1>La tabella $tabella non esiste. </h1> ";
}
if ($v_tab == 1) {
	// echo '<h2>Leggenda:</h2> <span class="lcd_a">Ritardo attuale</span><span class="lcd_s">Ritardo storico</span><span class="lcd_f">Frequenza</span>';
	echo $html;
	echo script_tabella_dinamica ( $name_t );
}

?>