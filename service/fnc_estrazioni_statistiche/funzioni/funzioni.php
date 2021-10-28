<?php

/**
 * funzioni short summary.
 *
 * funzioni description.
 *
 * @version 1.0
 * @author Faiella
 */
require_once ("global.php");
class clsEstrazioni {
	public $es_data = "";
	public $b = "";
	public $c = "";
	public $f = "";
	public $g = "";
	public $m = "";
	public $n = "";
	public $p = "";
	public $r = "";
	public $t = "";
	public $v = "";
	public $z = "";
	public $d = "";
}
class clsEstrazioni10l5 {
	public $es_data = "";
	public $Num = "";
	public $e = "";
	public $extra = "";
	public $o = "";
	public $oo = "";
}
class clsEstrazioniwfl {
	public $es_data = "";
	public $Num = "";
	public $ora = "";
	public $e = "";
	public $o = "";
}
class clsEstrazionisuper {
	public $es_data = "";
	public $e = "";
	public $j = "";
	public $s = "";
}
function Carica_estrazione_lotto($from = "1945-01-01", $numest = 0, $anno = "") {
	$tabella = "estrazione_lotto" . $anno . $numest . lastdate ();
	$arrRuote = application ( $tabella );
	$arrRuote = json_decode ( $arrRuote );
	// ------------------------------------ CARICA ESTRAZIONE LOTTO ------------------------------------
	if (empty ( $arrRuote )) {
		$arrRuote = array ();
		$MySql = new MysqlClass ();
		$MySql->connetti ();
		if ($numest == 0) {
			$Estrazioni = $MySql->query ( "SELECT * FROM es_lotto where EsData > '$from' order by EsData desc;" );
		} elseif ($numest == 1) {
			$Estrazioni = $MySql->query ( "SELECT * FROM es_lotto order by EsData desc limit 1500;" );
		} else {
			if (empty ( $anno )) {
				$Estrazioni = $MySql->query ( "SELECT * FROM es_lotto order by EsData;" );
			} else {
				$Estrazioni = $MySql->query ( "SELECT * FROM es_lotto where year(esdata)=$anno order by esdata desc" );
			}
		}
		if (mysqli_num_rows ( $Estrazioni ) > 0) {
			while ( $rows = $MySql->estrai ( $Estrazioni ) ) {
				$tmp = new clsEstrazioni ();
				$tmp->es_data = $rows->EsData;
				$tmp->b = $rows->Bari;
				$tmp->c = $rows->Cagliari;
				$tmp->f = $rows->Firenze;
				$tmp->g = $rows->Genova;
				$tmp->m = $rows->Milano;
				$tmp->n = $rows->Napoli;
				$tmp->p = $rows->Palermo;
				$tmp->r = $rows->Roma;
				$tmp->t = $rows->Torino;
				$tmp->v = $rows->Venezia;
				$tmp->z = $rows->Nazionale;
				$tmp->d = substr ( $rows->diecieLotto, 1 ) . ",";
				$arrRuote [] = $tmp;
			} // end while
			$enc_j = addslashes ( json_encode ( $arrRuote ) );
			application_set ( $tabella, $enc_j );
		}
		$MySql->disconnetti ();
	}
	return $arrRuote;
}
// --------------------------------------------------CARICA ESTRAZIONE 10 e LOTTO 5 M ------------------------------------
function Carica_estrazioni_10elotto5m($today = "") {
	$MySql = new MysqlClass ();
	if (empty ( $today )) {
		$today = date ( "Y-m-d" );
	}
	
	$tabella = "Estazione_10elotto5m" . $today . lastdate10el5 ( $today );
	$arr_estrazioni = application ( $tabella );
	$arr_estrazioni = json_decode ( $arr_estrazioni );
	if (empty ( $arr_estrazioni )) {
		$MySql = new MysqlClass ();
		$MySql->connetti ();
		$Estrazioni = $MySql->query ( "SELECT * FROM es_10elotto5 where EsData = '$today' order by EsData desc, num desc" );
		if (mysqli_num_rows ( $Estrazioni ) > 0) {
			while ( $rows = $MySql->estrai ( $Estrazioni ) ) {
				$tmp = new clsEstrazioni10l5 ();
				$tmp->es_data = $rows->EsData;
				$tmp->e = $rows->estrazione;
				$tmpextra = json_decode ($rows->estrazione_j);
				if (isset($tmpextra->numeriOvertime)){
    				sort($tmpextra->numeriOvertime, SORT_NUMERIC );
    				$tmp->extra = implode(",", $tmpextra->numeriOvertime);
				}
				$tmp->o = $rows->num_oro . ',';
				$tmp->oo = $rows->num_oro2 . ",";
				$tmp->Num = $rows->num;
				$arr_estrazioni [] = $tmp;
			}
			$enc_j = addslashes ( json_encode ( $arr_estrazioni ) );
			application_set ( $tabella, $enc_j );
			$MySql->disconnetti ();
		}
	}
	return $arr_estrazioni;
}
// -------------------------------------------------- CARICA ESTRAZIONE WIN FOR LIFE CLASSICO ------------------------------------
function Carica_estrazioni_wfl_classico($today = "", $all_last = "") {
	$MySql = new MysqlClass ();
	if (empty ( $today )) {
		$today = date ( "Y-m-d" );
	}
	
	$tabella = "Estazione_wfl_classico" . $all_last . $today . lastdate_winforlife_classico ( $today );
	$arr_estrazioni = application ( $tabella );
	$arr_estrazioni = json_decode ( $arr_estrazioni );
	if (empty ( $arr_estrazioni )) {
		$MySql = new MysqlClass ();
		$MySql->connetti ();
		if (empty ( $all_last )) {
			$Estrazioni = $MySql->query ( "SELECT * FROM es_winforlife_classico where EsData = '$today' order by esdata desc, num desc limit 100;" );
		} else {
			$Estrazioni = $MySql->query ( "SELECT * FROM es_winforlife_classico order by esdata desc, num desc limit $all_last;" );
		}
		if (mysqli_num_rows ( $Estrazioni ) > 0) {
			while ( $rows = $MySql->estrai ( $Estrazioni ) ) {
				$tmp = new clsEstrazioniwfl ();
				$tmp->es_data = $rows->EsData;
				$tmp->e = $rows->estrazione;
				$tmp->o = $rows->num_one . ',';
				$tmp->Num = $rows->num;
				$tmp->ora = $rows->ora;
				$arr_estrazioni [] = $tmp;
			}
			$enc_j = addslashes ( json_encode ( $arr_estrazioni ) );
			application_set ( $tabella, $enc_j );
			$MySql->disconnetti ();
		}
	}
	return $arr_estrazioni;
}
// -------------------------------------------------- CARICA ESTRAZIONE WIN FOR LIFE GRATTACIELO ------------------------------------
function Carica_estrazioni_wfl_grattacielo($today = "") {
	$MySql = new MysqlClass ();
	if (empty ( $today )) {
		$today = date ( "Y-m-d" );
	}
	
	$tabella = "Estazione_wfl_grattacielo" . $today . lastdate_winforlife_grattacielo ( $today );
	$arr_estrazioni = application ( $tabella );
	$arr_estrazioni = json_decode ( $arr_estrazioni );
	if (empty ( $arr_estrazioni )) {
		$MySql = new MysqlClass ();
		$MySql->connetti ();
		$Estrazioni = $MySql->query ( "SELECT * FROM es_winforlife_grattacielo where EsData = '$today' order by esdata desc, num desc limit 100;" );
		if (mysqli_num_rows ( $Estrazioni ) > 0) {
			while ( $rows = $MySql->estrai ( $Estrazioni ) ) {
				$tmp = new clsEstrazioniwfl ();
				$tmp->es_data = $rows->EsData;
				$tmp->e = $rows->estrazione;
				$tmp->o = $rows->num_one . ',';
				$tmp->Num = $rows->num;
				$tmp->ora = $rows->ora;
				$arr_estrazioni [] = $tmp;
			}
			$enc_j = addslashes ( json_encode ( $arr_estrazioni ) );
			application_set ( $tabella, $enc_j );
			$MySql->disconnetti ();
		}
	}
	return $arr_estrazioni;
}
// --------------------------------------------------CARICA ESTRAZIONE SUPERENALOTTO ------------------------------------
function Carica_estrazioni_super($from = "1945-01-01", $numest = 0, $anno = 0) {
	$MySql = new MysqlClass ();
	
	$tabella = "Estazione_superenalotto" . $anno . $numest . lastdate_superenalotto ();
	$arr_estrazioni = application ( $tabella );
	$arr_estrazioni = json_decode ( $arr_estrazioni );
	if (empty ( $arr_estrazioni )) {
		$MySql = new MysqlClass ();
		$MySql->connetti ();
		if ($numest == 0) {
			$Estrazioni = $MySql->query ( "SELECT * FROM es_superenalotto where EsData > '$from' order by EsData desc" );
		} elseif ($numest == 1) {
			$Estrazioni = $MySql->query ( "SELECT * FROM es_superenalotto order by EsData desc limit 1500;" );
		} else {
			if (empty ( $anno )) {
				$Estrazioni = $MySql->query ( "SELECT * FROM es_superenalotto order by EsData;" );
			} else {
				$Estrazioni = $MySql->query ( "SELECT * FROM es_superenalotto where year(esdata)=$anno order by esdata desc" );
			}
		}
		// $Estrazioni = $MySql->query ( "SELECT * FROM es_superenalotto where EsData > '$from' order by EsData desc" );
		if (mysqli_num_rows ( $Estrazioni ) > 0) {
			while ( $rows = $MySql->estrai ( $Estrazioni ) ) {
				$tmp = new clsEstrazionisuper ();
				$tmp->es_data = $rows->EsData;
				$tmp->e = $rows->estrazione;
				$tmp->j = $rows->j . ',';
				$tmp->s = $rows->s . ',';
				$arr_estrazioni [] = $tmp;
			}
			$enc_j = addslashes ( json_encode ( $arr_estrazioni ) );
			application_set ( $tabella, $enc_j );
			$MySql->disconnetti ();
		}
	}
	return $arr_estrazioni;
}
// ---------------------------------------------------- FUNZIONI VARIE -------------------------------------------
function eliminaUltimo($stringa) {
	return substr ( $stringa, 0, strlen ( $stringa ) - 1 );
}
function array_sort($array, $on, $order = SORT_ASC) {
	$new_array = array ();
	$sortable_array = array ();
	
	if (count ( $array ) > 0) {
		foreach ( $array as $k => $v ) {
			if (! is_array ( $v )) {
				$v = ( array ) $v;
			}
			if (is_array ( $v )) {
				foreach ( $v as $k2 => $v2 ) {
					if ($k2 == $on) {
						$sortable_array [$k] = $v2;
					}
				}
			} else {
				$sortable_array [$k] = $v;
			}
		}
		
		switch ($order) {
			case SORT_ASC :
				asort ( $sortable_array );
				break;
			case SORT_DESC :
				arsort ( $sortable_array );
				break;
		}
		
		foreach ( $sortable_array as $k => $v ) {
			$new_array [] = $array [$k];
		}
	}
	
	return $new_array;
}
function lastdate() {
	// ultima data presente in archivio lotto
	$mysql = new MysqlClass ();
	$mysql->connetti ();
	$out = $mysql->query ( "SELECT EsData FROM es_lotto order by Esdata desc limit 1;" );
	$return = $mysql->estrai ( $out );
	$nret = $return->EsData;
	$mysql->disconnetti ();
	return $nret;
}
function lastdate_superenalotto() {
	// ultima data presente in archivio lotto
	$mysql = new MysqlClass ();
	$mysql->connetti ();
	$out = $mysql->query ( "SELECT EsData FROM es_superenalotto order by EsData desc limit 1;" );
	$return = $mysql->estrai ( $out );
	$nret = $return->EsData;
	$mysql->disconnetti ();
	return $nret;
}
function lastdate10el5($today) {
	// ultima data presente in archivio 10 e lotto 5 minuti
	$nret = "";
	// $today = date ( "Y-m-d" );
	$mysql = new MysqlClass ();
	$mysql->connetti ();
	$out = $mysql->query ( "SELECT num, esdata FROM es_10elotto5 where esdata = '$today' order by esdata desc, num desc limit 1;" );
	$nrow = @mysqli_num_rows ( $out );
	if ($nrow > 0) {
		$return = $mysql->estrai ( $out );
		$nret = $return->num;
	} else {
		$nret = 0;
	}
	$mysql->disconnetti ();
	return $nret;
}
function lastdate_winforlife_classico($today) {
	// ultima data presente in archivio 10 e lotto 5 minuti
	$nret = "";
	// $today = date ( "Y-m-d" );
	$mysql = new MysqlClass ();
	$mysql->connetti ();
	$out = $mysql->query ( "SELECT num, esdata FROM es_winforlife_classico where esdata = '$today' order by esdata desc, num desc limit 1;" );
	$nrow = @mysqli_num_rows ( $out );
	if ($nrow > 0) {
		$return = $mysql->estrai ( $out );
		$nret = $return->num;
	} else {
		$nret = 0;
	}
	$mysql->disconnetti ();
	return $nret;
}
function lastdate_winforlife_grattacielo($today) {
	// ultima data presente in archivio 10 e lotto 5 minuti
	$nret = "";
	// $today = date ( "Y-m-d" );
	$mysql = new MysqlClass ();
	$mysql->connetti ();
	$out = $mysql->query ( "SELECT num, esdata FROM es_winforlife_grattacielo where esdata = '$today' order by esdata desc, num desc limit 1;" );
	$nrow = @mysqli_num_rows ( $out );
	if ($nrow > 0) {
		$return = $mysql->estrai ( $out );
		$nret = $return->num;
	} else {
		$nret = 0;
	}
	$mysql->disconnetti ();
	return $nret;
}
function ora10l5($num) {
	// calcola l'ora dell'estrazione 10 e lotto
	$m = 0;
	$h = 0;
	for($i = 1; $i <= $num; ++ $i) {
		$m += 5;
		if ($m > 55) {
			$m = 0;
			$h += 1;
			if ($h >= 24) {
				$h = 0;
			}
		}
		
		$h = str_pad ( $h, 2, '0', STR_PAD_LEFT );
		$m = str_pad ( $m, 2, '0', STR_PAD_LEFT );
	}
	return $h . ":" . $m;
}
function check_numero($num) {
	$myckNumeri = "";
	if (isset ( $_GET ['formazione'] )) {
		$myckNumeri = "." . $_GET ['formazione'] . ".";
	}
	
	$myckNumeri = explode ( ".", $myckNumeri );
	if (is_array ( $myckNumeri )) {
		$posa = array_search ( $num, $myckNumeri );
		if ($posa == false) {
			$num = str_pad ( $num, 2, '0', STR_PAD_LEFT );
		} else {
			$num = '<span class="bg_evidenzia">' . str_pad ( $num, 2, '0', STR_PAD_LEFT ) . '</span>';
		}
	} else {
		$num = str_pad ( $num, 2, '0', STR_PAD_LEFT );
	}
	return $num;
}
// ---------------------------------------// DATA ESTESA //---------------------------------------------------------
function data_estesa($es_data) {
	setlocale ( LC_TIME, 'it_IT' );
	// $newDate = strftime ( "%A %d %B %Y", strtotime ( $es_data ) ); // date ( "d.m.Y", strtotime ( $originalDate ) );
	$newDate = strftime ( "%d %B %Y", strtotime ( $es_data ) ); // date ( "d.m.Y", strtotime ( $originalDate ) );
	$newDate = str_replace ( "�", "&igrave", $newDate );
	return $newDate;
}
// -------------------------------------- // FUNZIONI VARIE // --------------------------------------------------------
function script_tabella_dinamica($id) {
	$out = '<script type="text/javascript">';
	$out .= "jQuery(document).ready(function() {";
	$out .= "jQuery('#$id').fixedHeaderTable({ footer: true, cloneHeadToFoot: true, fixedColumns: 1 });";
	$out .= "});";
	$out .= "</script>";
	$out = "";
	return $out;
}
Function aggiungi_titolo($titolo) {
	$out = '<div class="row">';
	$out .= '<div class="col-sm-12 text-center"><h2 class="titolo row">' . $titolo . '</h2></div>';
	$out .= '</div>';
	return $out;
}
?>