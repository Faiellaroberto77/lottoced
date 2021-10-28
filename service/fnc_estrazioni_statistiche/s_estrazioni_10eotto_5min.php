<?php
require_once ("funzioni/global.php");

if (isset ( $_GET ['numero'] )) {
    $numero_estrazione = $_GET ['numero'];
} else {
    $numero_estrazione = 1; // numero di date da prendere
}

if (isset ( $_GET ['num_estrazioni'] )) {
    $num_estrazioni = $_GET ['num_estrazioni'];
} else {
    $num_estrazioni = 1; // numero di estrazioni da prendere
}

if (isset ( $_GET ['onlytab'] )) {
    $solo_tab = $_GET ['onlytab'];
} else {
    $solo_tab = 0;
}

if (isset ( $_GET ['onlyestrazioni'] )) {
    $solo_estrazioni = $_GET ['onlyestrazioni'];
} else {
    $solo_estrazioni = 1;
}
if (isset ( $_GET ['group'] )) {
    $group = $_GET ['group'];
} else {
    $group = 4;
}
// ---------------------------------------------- PRENDE DATE -------------------------------------------
$g_sql = "select EsData from es_10elotto5 group by esdata order by esdata desc limit $numero_estrazione;";
$data = new MysqlClass ();
$data->connetti ();
$estrazione = $data->query ( $g_sql );
if (@mysqli_num_rows ( $estrazione ) > 0) {
    if ($solo_tab == 1) {
        echo '<ul class="nav nav-tabs" role="tablist">';
        // echo'<ul class="pagination" role="tablist">';
        
        // for($rowcont = 1; $rowcont <= mysql_num_rows ( $estrazione ); $rowcont ++) {
        $rowcont = 1;
        while ( $rows = $data->estrai ( $estrazione ) ) {
            $es_data = $rows->EsData;
            $originalDate = $es_data;
            $newDate = date ( "d.m.Y", strtotime ( $originalDate ) );
            
            if ($rowcont == 1) {
                echo "<li role=\"presentation\" class=\"active\"><a href=\"#est10lotto5M$rowcont\" aria-controls=\"est10lotto5M$rowcont\" role=\"tab\" data-toggle=\"tab\">$newDate</a></li>";
            } else {
                echo "<li role=\"presentation\"><a href=\"#est10lotto5M$rowcont\" aria-controls=\"est10lotto5M$rowcont\" role=\"tab\" data-toggle=\"tab\">$newDate</a></li>";
            }
            $rowcont = $rowcont + 1;
        }
        
        echo "</ul>";
    }
}
// ------------------------------------------------------ PRENDE ESTRAZIONI --------------------------------------------------
$conta = 0;
if ($solo_estrazioni == 1) {
    echo '<div class="tab-content">';
    
    $estrazione = $data->query ( $g_sql );
    while ( $rows = $data->estrai ( $estrazione ) ) {
        $conta = $conta + 1;
        $es_data = $rows->EsData;
        // $estrazi = $rows->diecielotto;
        // $arrE = explode ( ",", $estrazi );
        
        $originalDate = $es_data;
        setlocale ( LC_TIME, 'it_IT' );
        $newDate = strftime ( "%A %d %B %Y", strtotime ( $es_data ) );
        // $newDate = str_replace ( "�", "&igrave", $newDate );
        $newDate = utf8_encode($newDate);
        if ($conta == 1) {
            $active = " active ";
        } else {
            $active = "";
        }
        
        echo '<div role="tabpanel" class="tab-pane' . $active . '" id="est10lotto5M' . $conta . '">';
        echo '<div class="row">';
        if ($num_estrazioni > 1) {
            echo '<div class="col-sm-12 text-center"><h2 class="titolo row">Ultime ' . $num_estrazioni . ' Estrazioni del 10 e lotto 5 min <br /> ' . $newDate . '</h2></div>';
        } else {
            echo '<div class="col-sm-12 text-center"><h2 class="titolo row">Estrazione 10 e lotto 5 minuti <br /> ' . $newDate . '</h2></div>';
        }
        // --------------------------------------------- contenuto tab ---------------------------------------------
        $g_sql = "SELECT * FROM es_10elotto5 where esdata = '$es_data' order by esdata desc, num desc limit $num_estrazioni;";
        $data2 = new MysqlClass ();
        $data2->connetti ();
        $estrazioni10 = $data2->query ( $g_sql );
        echo '<table class="table table-condensed table-bordered table-striped">';
        
        while ( $erow = $data2->estrai ( $estrazioni10 ) ) {
            $num = $erow->num;
            $ora = ora10l5 ( $erow->num );
            $est = eliminaUltimo ( $erow->estrazione );
            $est = explode ( ",", $est );
            $one = $erow->num_oro;
            $one2 = $erow->num_oro2;
            $extra = json_decode($erow->estrazione_j);
            // ------------------- UNA LINEA --------------------------
            if ($group == 20) {
                echo '<tr>';
                echo "<td>n. $num - ore $ora</td>";
                
                foreach ( $est as $key ) {
                    echo "<td>";
                    echo check_numero ( $key );
                    echo "</td>";
                }
                echo "<td><b>" . check_numero ( $one ) . "</b></td>";
                echo '</tr>';
            } else {
                // --------------------------------- SINGOLA ---------------------------------------
                echo '<tr>';
                echo "<td colspan=\"$group\">n. $num - ore $ora</td>";
                echo "</tr>";
                for($g = 1; $g <= 20; $g += $group) {
                    echo '<tr>';
                    for($i = $g; $i <= $g + $group - 1; $i ++) {
                        $sel_n = $est [$i-1];
                        $sel_n = check_numero ( $sel_n );
                        echo "<td>$sel_n</td>";
                    }
                    echo "</tr>";
                }
                echo '<tr>';
                $one = check_numero ( $one );
				$one2 = check_numero ( $one2 );
                $orog = $group/2;
                echo "<td colspan=\"$orog\" class=\"middle oro\">numero oro: $one</td>";
                echo "<td colspan=\"$orog\" class=\"middle oro\">doppio oro: $one2</td>";
                echo '</tr>';
                // 10 e lotto EXTRA
                echo '<tr>';
                echo "<td colspan=\"$group\"><b>10eLotto EXTRA</b></td>";
                echo '</tr>';
				if (is_array($extra->numeriOvertime)){
                	sort($extra->numeriOvertime, SORT_NUMERIC);
				}
                for($g = 1; $g <= 14; $g += $group) {
                    echo '<tr>';
                    for($i = $g; $i <= $g + $group - 1; $i ++) {
                        $sel_n = $extra->numeriOvertime [$i-1];
                        $sel_n = check_numero ( $sel_n );
                        echo "<td>$sel_n</td>";
                    }
                    echo "</tr>";
                }
            
            }
        }
        echo '</table>';
        $data2->disconnetti ();
        // echo $conta;
        // --------------------------------------------- / contenuto tab fine / ---------------------------------------------
        echo '</div>'; // row
        echo '</div>'; // tabpanel
    }
    echo '</div>'; // tabcontent
}
$data->disconnetti ();
?>