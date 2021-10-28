<?php
require_once 'global.php';
function EseguiQuery($StrQuery) {
	// esecuzione di query con mysqli_query
	
	// connessione al DBMS
	$link = @mysqli_connect ( HOST, USER, PASSWORD, DB );
	
	// controllo sullo stato della connessione
	if (mysqli_connect_errno ()) {
		echo "Connessione fallita: " . die ( mysqli_connect_error () );
		return FALSE;
	}
	
	// query per la creazione di una tabella
	if ($result = @mysqli_query ( $link, $StrQuery )) {
		// liberazione della memoria dal risultato della query
		@mysqli_free_result ( $result );
		
		// chiusura della connessione
		@mysqli_close ( $link );
		return TRUE;
	} else {
		// liberazione della memoria dal risultato della query
		@mysqli_free_result ( $result );
		
		// chiusura della connessione
		@mysqli_close ( $link );
		return FALSE;
	}
}
?>