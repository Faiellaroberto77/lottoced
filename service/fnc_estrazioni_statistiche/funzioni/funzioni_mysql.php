<?php
class MysqlClass {
	// variabili per la connessione al database
	private $nomehost = HOST;
	private $nomeuser = USER;
	private $password = PASSWORD;
	private $nomedb = DB;
	
	// controllo sulle connessioni attive
	private $attiva = false;
	private $connessione = "";
	// funzione per la connessione a MySQL
	public function connetti() {
		if (! $this->attiva) {
			$this->connessione = @mysqli_connect ( $this->nomehost, $this->nomeuser, $this->password, $this->nomedb );
			if (mysqli_connect_errno ()) {
				echo "Connessione fallita: " . die ( mysqli_connect_error () );
				return FALSE;
			}
			// $this->attiva = true;
		} else {
			return true;
		}
	}
	
	// funzione per l'esecuzione delle query
	public function query($sql) {
		if (isset ( $this->attiva )) {
			$sql = @mysqli_query ( $this->connessione, $sql );
			if (mysqli_connect_errno ()) {
				echo "Query fallita: " . die ( mysqli_connect_error () );
				return FALSE;
			}
			return $sql;
		} else {
			return false;
		}
	}
	
	// funzione per l'inserimento dei dati in tabella
	public function inserisci($t, $v, $r = null) {
		if (isset ( $this->attiva )) {
			$istruzione = 'INSERT INTO ' . $t;
			if ($r != null) {
				$istruzione .= ' (' . $r . ')';
			}
			
			for($i = 0; $i < count ( $v ); $i ++) {
				if (is_string ( $v [$i] ))
					$v [$i] = "'" . $v [$i] . "'";
			}
			$v = implode ( ',', $v );
			$istruzione .= ' VALUES (' . $v . ')';
			
			$query = @mysqli_query ( $this->connessione, $istruzione );
			if (mysqli_connect_errno ()) {
				echo "Query insert fallita: " . die ( mysqli_connect_error () );
				return FALSE;
			}
		} else {
			return false;
		}
	}
	// funzione per l'estrazione dei record
	public function estrai($risultato) {
		if (isset ( $this->attiva )) {
			$r = @mysqli_fetch_object ( $risultato );
			return $r;
		} else {
			return false;
		}
	}
	// funzione per la chiusura della connessione
	public function disconnetti() {
		if ($this->attiva) {
			$close = @mysqli_close ( $this->connessione );
			if ($close) {
				$this->attiva = false;
				return true;
			} else {
				return false;
			}
		}
	}
}
?>