<?php
require_once ('get_estrazioni.php');

$test = new superenalotto ();
if ($test->esito == "ok") {
	require_once ("esequiq.php");
	$query = "INSERT INTO es_superenalotto (EsData, estrazione, j, s, jackpot, vincite, montepremi, commento) VALUES ('$test->dt','$test->estrazione','$test->j','$test->s','$test->jeckpot','$test->vincite','$test->montepremio','$test->commento')";
	if (EseguiQuery ( $query ) == TRUE) {
		echo "invio SMS Superenalotto\n";
		require_once 'sms_superenalotto.php';
		// echo ("Query inserita");
		// echo $test->commento;
	} else {
		echo ("Superenalotto Query NON INSERITA" . $test->esito . "\n");
	}
	// echo $test->commento;
	// var_dump ( $test );
}
?>