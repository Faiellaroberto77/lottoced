<?php 
function fnc_estrazione_lotto(){
    if (isset ( $_REQUEST ['numero'] )) {
        $numero_estrazione = $_REQUEST ['numero'];
    } else {
        $numero_estrazione = 6;
    }
    
    if (isset ( $_REQUEST ['onlytab'] )) {
        $solo_tab = $_REQUEST ['onlytab'];
    } else {
        $solo_tab = 1;
    }
    
    if (isset ( $_REQUEST ['onlyestrazioni'] )) {
        $solo_estrazioni = $_REQUEST ['onlyestrazioni'];
    } else {
        $solo_estrazioni = 1;
    }
    $numeruote = array ("BARI", "CAGLIARI", "FIRENZE", "GENOVA", "MILANO", "NAPOLI", "PALERMO", "ROMA", "TORINO", "VENEZIA", "NAZIONALE");
	$vsimbolotto = array ("1"=>"1-ITALIA", "2"=>"2-MELA", "3"=>"3-GATTA", "4"=>"4-MAIALE", "5"=>"5-MANO", "6"=>"6-LUNA", "7"=>"7-VASO", "8"=>"8-BRAGHE", "9"=>"9-CULLA", "10"=>"10-FAGIOLI", "11"=>"11-TOPI", "12"=>"12-SOLDATO", "13"=>"13-RANA", "14"=>"14-BAULE", "15"=>"15-RAGAZZO", "16"=>"16-NASO", "17"=>"17-SFORTUNA", "18"=>"18-CERINO", "19"=>"19-RISATA", "20"=>"20-FESTA", "21"=>"21-LUPO", "22"=>"22-BALESTRA", "23"=>"23-AMO", "24"=>"24-PIZZA", "25"=>"25-NATALE", "26"=>"26-ELMO", "27"=>"27-SCALA", "28"=>"28-OMBRELLO", "29"=>"29-DIAMANTE", "30"=>"30-CACIO", "31"=>"31-ANGURIA", "32"=>"32-DISCO", "33"=>"33-ELICA", "34"=>"34-TESTA", "35"=>"35-UCCELLO", "36"=>"36-NACCHERE", "37"=>"37-PIANO", "38"=>"38-PIGNA", "39"=>"39-FORBICI", "40"=>"40-QUADRO", "41"=>"41-BUFFONE", "42"=>"42-CAFFÈ", "43"=>"43-FUNGHI", "44"=>"44-PRIGIONE", "45"=>"45-RONDINE");
	
    global $wpdb;
    
    $estrazione = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix ."es_lotto order by esdata desc limit 1;");
    if ($estrazione){
        $conta=0;
       ?>
       <div class="tab-content"><?php 
		$index_numeri = 0;
		foreach ($estrazione as $rows) {
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
			
			
			$originalDate = $es_data;
			setlocale ( LC_TIME, 'it_IT' );
			$newDate = strftime ( "%A %d %B %Y", strtotime ( $es_data ) ); // date ( "d.m.Y", strtotime ( $originalDate ) );
			// $newDate = str_replace ( "ì", "&igrave", $newDate );
			$newDate = utf8_encode($newDate);
			if ($conta == 1) {
				$active = " show active ";
			} else {
				$active = "";
			}?>
    
        <div class="row mb-3">
        <div class="border-call-out w-100">
            <h2 class="titolo">Estrazione del Lotto e Simbolotto</h2>
        </div>
            <div class="col-lg-9 p-1">
                <div class ="card text-center h-100" style="min-height: 160px;">
                <div class="card-header bg-lotto"><span class="datatitolo"><?php echo $newDate ?></span></div>
                    <div class="h-100">
                        
                            <table class="table table-hover h-100 text-center">
                            <?php 
                            for($i = 0; $i <= 10; $i ++) {
                            ?>
                                <tr>
                                <td class="ruotestyle text-left nowrap ruo"><?php echo $numeruote [$i]; ?></td>
                                <?php 
                                    $Num = explode ( ",", $ruote [$i] );
                                    for($i2 = 0; $i2 <= 4; $i2 ++) {
                                        $Num [$i2] = check_numero($Num [$i2], '_lotto');?>
                                        <td id="numes<?php echo $index_numeri;?>"><?php echo $Num[$i2]?></td>
                                        <?php 
                                        $index_numeri = $index_numeri + 1;
                                    } 
                                ?>
                                </tr>
                            <?php } ?>
                            </table>
                       
                    </div>
                </div>
            </div>
            <div class ="col-lg-3 p-1">
                <div class ="card text-center h-100" style="min-height: 160px;">
                    <div class="card-header bg-simbolotto"><span class="datatitolo">Simbolotto</span></div>
                    <div class="h-100">
                        <div class="mcard-columns mt-3">

                        <?php 
                        $simbolotto = $Num = explode ( ",", $rows->simbolotto );
                        for ($i = 0; $i <= 4; $i++){
                        ?> 
                            <div class="card mt-0 mb-1 border-0" style="height: calc((100%  / 5) - 7px)">
                            <div Style="min-height:60px">
                                <img src="https://www.lottoced.com/img/simbolotto/<?php echo $simbolotto[$i]?>.png" class="m-auto" alt="<?php echo $vsimbolotto[$simbolotto[$i]] ?>" style="height: 50px">
                            </div>
                            <div class="ni-simbolotti"><?php echo $vsimbolotto[$simbolotto[$i]] ?></div>
                            </div>
                        <?php 
                        } 
                        ?>
                        </div>
                    </div>
                </div>
            </div>
        
    </div>
    <?php 
    //if ($rowcont == 10){break;}
    //$rowcont +=1;
		} ?>
    
</div>
       <?php
    }
}
add_shortcode("estrazione_lotto", "fnc_estrazione_lotto")
?>