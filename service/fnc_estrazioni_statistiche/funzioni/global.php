<?php

require_once ("funzioni.php");
require_once ("funzioni_mysql.php");
setlocale(LC_ALL, 'it_IT.UTF-8');
// -----------------------------> DATABASE PARAMETRI <-------------------------------
define ( 'MY_ROOT_PATH', "http://www.lottoced.eu" );

define ( 'HOST', '127.0.0.1:3306' );
define ( 'USER', 'lottoced' );
define ( 'PASSWORD', 'WP_991107' );
define ( 'DB', 'LottoCED' );

//define ( 'HOST', 'localhost' );
//define ( 'USER', 'root' );
//define ( 'PASSWORD', '991032' );
//define ( 'DB', 'lottoced' );
// ----------------------------- // DATABASE PARAMETRI // -------------------------------

// ----------------------------- FUNZIONI APPLICATION -----------------------------
function application($variabile, $db_application = 'db_application') {
    $mem_var = new Memcached();
    $mem_var->addServer("127.0.0.1", 11211);
    $response = $mem_var->get($variabile);
    if ($response) {
        return stripslashes($response);
    } else { 
        return "";
    }
    
    
//     $mysql = new MysqlClass ();
//     $mysql->connetti ();
//     $out = $mysql->query ( "select db_value from $db_application where db_var ='$variabile';" );
    
//     $return = "";
//     if (mysqli_num_rows ( $out ) > 0) {
//         $return = $mysql->estrai ( $out );
//         $mysql->disconnetti ();
//         return $return->db_value;
//     } else {
//         $mysql->disconnetti ();
//         return "";
//     }
}
function application_set($variabile, $value, $db_application = 'db_application') {
    $mem_var = new Memcached();
    $mem_var->addServer("127.0.0.1", 11211);
    $mem_var->set($variabile, $value);
    
//     $mysql = new MysqlClass ();
//     $mysql->connetti ();
//     $out = $mysql->query ( "select db_value from $db_application where db_var ='$variabile';" );
//     if (mysqli_num_rows ( $out ) > 0) {
//         $mysql->query ( "UPDATE $db_application SET db_value ='$value' WHERE db_var='$variabile';" );
//         $mysql->disconnetti ();
//     } else {
//         $r = "db_var, db_value";
//         $v = array (
//             $variabile,
//             $value
//         );
//         $esito_query = $mysql->inserisci ( "db_application", $v, $r );
//         $mysql->disconnetti ();
//     }
}
// ----------------------------- FUNZIONI APPLICATION -----------------------------









