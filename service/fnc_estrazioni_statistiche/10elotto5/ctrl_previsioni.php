<?php
require_once __DIR__.('/../funzioni/global.php');
require_once __DIR__.('/../funzioni/get_estrazioni.php');
$year = date ( "Y" );
$mount = date ( "m" );
$today = date ( "Y-m-d" );
$today = date("Y-m-d");

$this_y = date ( 'Y-m-d' );
$g_giorno = isset($_REQUEST['giorno']) ? $_REQUEST['giorno'] : $this_y;
$n_for = isset ($_REQUEST['formazione']) ? $_REQUEST['formazione']: 2;
$n_sorte = isset ($_REQUEST['sorte']) ? $_REQUEST['sorte']: 1;

$n_sorte_ck = isset ($_REQUEST['sorte_ck']) ? $_REQUEST['sorte_ck']:2;
 
$end = lastdate10el5 ($today);
$previsione = previsionetab($g_giorno, $n_for, $n_sorte);
controlla_previsione($n_sorte_ck,$g_giorno);



if ($previsione != ""){
     $database = new MysqlClass();
     $query = "INSERT INTO previsioni_10elotto5 (es_num, formazione, attivo, es_data) VALUES ($end, '$previsione', 1, '$today')";
     $database->connetti();
     $formazione = $database->query($query);
     $database->disconnetti();
}
function previsionetab($g_giorno, $n_for, $n_sorte) {
    require_once __DIR__.('/../funzioni/statistica.php');
    $ricerca = new rr_10elotto5();
    
    $r_estrazioni = Carica_estrazioni_10elotto5m ( $g_giorno );
    $database = new MysqlClass();
    $database->connetti();
    $formazione = $database->query("SELECT id,titolo, formazioni FROM es_tabelle where num_x_form = $n_for;");
    $database->disconnetti();
    $frequenza = 0;
    $previsione = "";
    $previsione_t = "";
    if (mysqli_num_rows ( $formazione ) > 0) {
        while ( $estrai = $database->estrai ( $formazione ) ) {
            $formazioni = explode ( ";", $estrai->formazioni );
            $titolo = $estrai->titolo;
            foreach ( $formazioni as $key ) {
                $key = str_replace ( ".", ",", $key );
                $key = str_replace ( "\r\n", "", $key );
                $ricerca->ricerca($key, "e", $n_sorte, $r_estrazioni);
                if ($ricerca->att > $ricerca ->sto && $ricerca->fre > $frequenza) {
                    $previsione = $key = str_replace ( ",", ".", $key );
                    $previsione_t = $titolo;
                    $frequenza = $ricerca->fre;
                }

//                 if ($ricerca->fre > $frequenza && $ricerca->att > 10) {
//                     $previsione = $key = str_replace ( ",", ".", $key );
//                     $previsione_t = $titolo;
//                     $frequenza = $ricerca->fre;
//                 }
                
            }
        }
    }
    
//     echo  $previsione_t . ' - ' . $previsione . "<br> \n\r";
//     echo date('h:i') . '<br>';
//     echo $n_for . ' - ' . $n_sorte;
    return $previsione;
}

function controlla_previsione($n_sorte_ck, $g_giorno) {
    require_once __DIR__.('/../funzioni/statistica.php');
    $ricerca = new rr_10elotto5();
    
    $r_estrazioni = Carica_estrazioni_10elotto5m ( $g_giorno );
    $database = new MysqlClass();
    $database->connetti();
    $formazione = $database->query("SELECT formazione FROM previsioni_10elotto5 where attivo = 1 group by formazione;");
    $database->disconnetti();
    $frequenza = 0;
    $previsione = "";
    $previsione_t = "";
    if (mysqli_num_rows ( $formazione ) > 0) {
        while ( $estrai = $database->estrai ( $formazione ) ) {
            $formazioni = explode ( ";", $estrai->formazione );
            foreach ( $formazioni as $key ) {
                $formazionewin = $key;
                $key = str_replace ( ".", ",", $key );
                $ricerca->ricerca($key, "e", $n_sorte_ck, $r_estrazioni);
                if ($ricerca->att == 0) { 
                    $today = date ( "Y-m-d" );
                    $endl = lastdate10el5 ($today);
                    $query = "UPDATE previsioni_10elotto5 SET attivo='0', es_sorte = '$endl' WHERE formazione ='$formazionewin' and attivo ='1'";
                    
                    $database->connetti();
                    $formazione = $database->query($query);
                    $database->disconnetti();
                }
                
            }
        }
    }
    
    //     echo  $previsione_t . ' - ' . $previsione . "<br> \n\r";
    //     echo date('h:i') . '<br>';
    //     echo $n_for . ' - ' . $n_sorte;
    return $previsione;
}




