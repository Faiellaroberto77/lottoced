<?php
require_once '../funzioni/statistica.php';
$numeruote = array (
    "Bari",
    "Cagliari",
    "Firenze",
    "Genova",
    "Milano",
    "Napoli",
    "Palermo",
    "Roma",
    "Torino",
    "Venezia",
    "Nazionale"
);
$rr_ruote = array (
    "b",
    "c",
    "f",
    "g",
    "m",
    "n",
    "p",
    "r",
    "t",
    "v",
    "z"
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
$formazione = $data_newsletter->query ( "SELECT * FROM es_tabelle;" );


if (mysqli_num_rows ( $formazione ) > 0) {
    $estrazionilotto = Carica_estrazione_lotto ();
    while ($estrai = $data_newsletter->estrai ( $formazione )){
        $formazioni = explode ( ";", $estrai->formazioni );
        $titolo = $estrai->titolo;
        $descrizione = $estrai->descrizione;
        $sorte_default = $estrai->sorte_d;
        foreach ( $formazioni as $key ){
            // echo $key . "<br/>";
            foreach ($rr_ruote as $r){
                $ritardi = new rr_lotto ();
                $key = str_replace ( ".", ",", $key );
                $ritardi->ricerca ( $key, $r, 1, $estrazionilotto, false );
                if ($ritardi->att > $ritardi->sto){
                    echo $r . " " . $key . " - " . $titolo . " - " . ($ritardi->att - $ritardi->sto) . "<br>";
                }
            }
        }
        
        
    }
}
   

?>