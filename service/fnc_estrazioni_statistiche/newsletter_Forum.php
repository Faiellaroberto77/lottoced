<?php
require_once ("funzioni/global.php");
// variabili per la connessione al database
$nomehost = 'mailced.com';
$nomeuser = 'admin_forum';
$password = 'Eajy720?';
$nomedb = 'Bku';

$conta_forum = application ( 'contaforum' );

if (empty ( $conta_forum )) {
	$conta_forum = 17974;
}

$StrQuery = 'SELECT userid, email, joindate FROM Bku.user where userid > ' . $conta_forum . ' order by joindate asc;';
$data_newsletter = new Mysql_Class ();
$data_newsletter->connetti ( $nomehost, $nomeuser, $password, $nomedb );
$result = $data_newsletter->query ( $StrQuery );
$arrayemail = array ();
if (@mysqli_num_rows ( $result ) > 0) :
	while ( $rows = $data_newsletter->estrai ( $result ) ) :
		$arrayemail [] = $rows->email;
		$conta_forum = $rows->userid;
	endwhile
	;
endif;

$data_newsletter->disconnetti ();

// aggiunge alal newsletter
$data_forum = new MysqlClass ();
$data_forum->connetti ();
foreach ( $arrayemail as $lcdemail ) {
	$now = date ( 'Y-m-d H:i:s' );
	$token = get_token ();
	$r = "email, sex, status, created, token";
	$v = array (
			$lcdemail,
			'n',
			'C',
			$now,
			$token 
	);
	
	$data_forum->inserisci ( 'wp_newsletter', $v, $r );
	echo $lcdemail . '<br />';
}
$data_forum->disconnetti ();
application_set ( 'contaforum', $conta_forum );
function get_token($size = 10) {
	$token = substr ( md5 ( rand () ), 0, $size );
	$ck = controllatoken ( $token );
	if ($ck == TRUE) :
		while ( $ck ) {
			$token = substr ( md5 ( rand () ), 0, $size );
			$ck = controllatoken ( $token );
		}
	
	endif;
	
	return $token;
}
function controllatoken($token) {
	$data_token = new MysqlClass ();
	$data_token->connetti ();
	$nsql = sprintf ( 'SELECT token FROM wp_newsletter where token =\'%s\';', $token );
	$result = $data_token->query ( $nsql );
	if (@mysqli_num_rows ( $result ) > 0) :
		$data_token->disconnetti ();
		return TRUE;
	 else :
		$data_token->disconnetti ();
		return FALSE;
	 // VALIDO
endif;
}
class Mysql_Class {
	
	// controllo sulle connessioni attive
	private $attiva = false;
	private $connessione = "";
	// funzione per la connessione a MySQL
	public function connetti($nomehost, $nomeuser, $password, $nomedb) {
		if (! $this->attiva) {
			$this->connessione = @mysqli_connect ( $nomehost, $nomeuser, $password, $nomedb );
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
					$v [$i] = '"' . $v [$i] . '"';
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