<?php
function EseguiQuery($StrQuery) {
	// esecuzione di query con mysqli_query
	
	// connessione al DBMS
	$link = @mysqli_connect ( "mailced.com", "lottoced", "WP_991107", "LottoCED" );
	
	// controllo sullo stato della connessione
	if (mysqli_connect_errno ()) {
		echo "Connessione fallita: " . die ( mysqli_connect_error () );
		return FALSE;
	}
	
	// query per la creazione di una tabella
	if ($result = @mysqli_query ( $link, $StrQuery )) {
		return TRUE;
	} else {
		return FALSE;
	}
	
	// liberazione della memoria dal risultato della query
	@mysqli_free_result ( $result );
	
	// chiusura della connessione
	@mysqli_close ( $link );
}
?>