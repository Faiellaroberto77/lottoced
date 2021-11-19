<?php
require_once ("funzioni/global.php");

if (isset ( $_GET ['numero'] )) {
    $numero_estrazione = $_GET ['numero'];
} else {
    $numero_estrazione = 6;
}

if (isset ( $_GET ['onlytab'] )) {
    $solo_tab = $_GET ['onlytab'];
} else {
    $solo_tab = 1;
}

if (isset ( $_GET ['onlyestrazioni'] )) {
    $solo_estrazioni = $_GET ['onlyestrazioni'];
} else {
    $solo_estrazioni = 1;
}



$data = new MysqlClass ();
$data->connetti ();

$estrazione = $data->query ( "SELECT * FROM es_lotto order by esdata desc limit $numero_estrazione;" );

if (@mysqli_num_rows ( $estrazione ) > 0) {
    $numeruote = array (
        "BARI",
        "CAGLIARI",
        "FIRENZE",
        "GENOVA",
        "MILANO",
        "NAPOLI",
        "PALERMO",
        "ROMA",
        "TORINO",
        "VENEZIA",
        "NAZIONALE"
    );
    $numeruotes = array (
        "BA"=>"Bari",
        "CA"=>"Cagliari",
        "FI"=>"Firenze",
        "GE"=>"Genova",
        "MI"=>"Milano",
        "NA"=>"Napoli",
        "PA"=>"Palermo",
        "RO"=>"Roma",
        "TO"=>"Torino",
        "VE"=>"Venezia",
        "RN"=>"Nazionale"
    );
    
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
                echo "<li role=\"presentation\" class=\"active\"><a href=\"#estlotto$rowcont\" aria-controls=\"estlotto$rowcont\" role=\"tab\" data-toggle=\"tab\">$newDate</a></li>";
            } else {
                echo "<li role=\"presentation\"><a href=\"#estlotto$rowcont\" aria-controls=\"estlotto$rowcont\" role=\"tab\" data-toggle=\"tab\">$newDate</a></li>";
            }
            $rowcont = $rowcont + 1;
        }
        
        echo "</ul>";
    }
    
    $conta = 0;
    if ($solo_estrazioni == 1) {
        echo '<div class="tab-content">';
        $estrazione = $data->query ( "SELECT * FROM es_lotto order by esdata desc limit $numero_estrazione;" );
        $index_numeri = 0;
        while ( $rows = $data->estrai ( $estrazione ) ) {
            $ruote = array ();
            $conta = $conta + 1;
            $es_data = $rows->EsData;
            $ruote [] = $rows->Bari;
            $ruote [] = $rows->Cagliari;
            $ruote [] = $rows->Firenze;
            $ruote [] = $rows->Genova;
            $ruote [] = $rows->Milano;
            $ruote [] = $rows->Napoli;
            $ruote [] = $rows->Palermo;
            $ruote [] = $rows->Roma;
            $ruote [] = $rows->Torino;
            $ruote [] = $rows->Venezia;
            $ruote [] = $rows->Nazionale;
            $simbolotto = $rows->simbolotto;
            
            $originalDate = $es_data;
            setlocale ( LC_TIME, 'it_IT' );
            $newDate = strftime ( "%A %d %B %Y", strtotime ( $es_data ) ); // date ( "d.m.Y", strtotime ( $originalDate ) );
            // $newDate = str_replace ( "ì", "&igrave", $newDate );
            $newDate = utf8_encode($newDate);
            if ($conta == 1) {
                $active = " active ";
            } else {
                $active = "";
            }
            echo '<div role="tabpanel" class="tab-pane' . $active . '" id="estlotto' . $conta . '">';
            echo '<div class="row">';
            echo '<div class="col-sm-12 text-center"><h2 class="titolo row">Estrazione del lotto<br />' . $newDate . '</h2></div>';
            // echo '<div class="col-md-7">';
            
            echo '<table class="table table-condensed table-bordered table-striper table-striped">';
            // echo '<tr><td colspan="6">Estrazione del ' . $newDate . '<td></tr>';
            for($i = 0; $i <= 10; $i ++) {
                echo '<tr>';
                echo '<td class="ruotestyle text-left nowrap ruo">' . $numeruote [$i] . '</td>';
                
                $Num = explode ( ",", $ruote [$i] );
                
                for($i2 = 0; $i2 <= 4; $i2 ++) {
                    $Num [$i2] = check_numero($Num [$i2]);
                    echo "<td id=\"numes$index_numeri\">$Num[$i2]</td>";
                    $index_numeri = $index_numeri + 1;
                } // next for $i2
                echo "</tr>"; // plglcd_ruote
            } // next for $i
            echo "</table>"; // plglcd_estrazioni
            $Num = explode ( ",", $simbolotto );
            ?>
            <div class="plglcd_estrazioni">
	<div class="plglcd_data">Estrazione Simbolotto<br><?php echo $numeruotes[$Num[5]]; ?></div>
	
	<div class="plglcd_ruote">
		
<?php for($i2 = 0; $i2 <= 4; $i2 ++) {
    $Num [$i2] = check_numero ( $Num [$i2] );
    ?>
    <div class="plglcd_num"> 
    <img src="https://www.lottoced.com/img/simbolotto/<?php echo (int) $Num[$i2]?>.png" class="m-auto" style="height: 25px">
    </div>
    <?php 
    $index_numeri = $index_numeri + 1;
}?>
	</div>



	<div class="plglcd_ruote">
<?php 
for($i2 = 0; $i2 <= 4; $i2 ++) {
    $Num [$i2] = check_numero ( $Num [$i2] );
    echo '<div class="plglcd_num">'. $Num[$i2] .'</div>';
    $index_numeri = $index_numeri + 1;
}
?>
	</div>
</div>
            <?php 
            // echo "</div>"; // col-md-7
            echo "</div>"; // row
            echo "</div>"; // tabpanel
        } // end while
        
        echo "</div>"; // tab-content
        
    }
}
$data->disconnetti ();
?>
