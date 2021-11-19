<?php
/*
SHORTCODE
Lotto
[estrazione_lotto]
*/

function check_numero($num, $lotteria = "") {
	$myckNumeri = "";
	if (isset ( $_REQUEST ['formazione'] )) {
		$myckNumeri = "." . $_REQUEST ['formazione'] . ".";
	}
	
	$myckNumeri = explode ( ".", $myckNumeri );
	if (is_array ( $myckNumeri )) {
		$posa = array_search ( $num, $myckNumeri );
		if ($posa == false) {
		    $num = '<span class="num '.$lotteria.'">' . str_pad ( $num, 2, '0', STR_PAD_LEFT ) . '</span>';
		} else {
			$num = '<span class="num '.$lotteria.' evidenzia'.$lotteria.'">' . str_pad ( $num, 2, '0', STR_PAD_LEFT ) . '</span>';
		}
	} else {
		$num = str_pad ( $num, 2, '0', STR_PAD_LEFT );
	}
	return $num;
}

require_once("tb_estrazioni_lotto.php");
?>