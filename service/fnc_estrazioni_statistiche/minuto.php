<?php
date_default_timezone_set('Europe/Rome');
echo date ( "d-m-Y H:i:s" ) . " ->";
if (date ( "H" ) == "19" && date ( "i" ) >= 1 && date ( "i" ) <= 10) {
    require_once 'funzioni/agg_millionday.php';
    echo "OK !\n";
} else {
    echo "KO !\n";
}
?>