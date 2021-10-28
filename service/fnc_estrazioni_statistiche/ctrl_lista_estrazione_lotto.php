<?php
require_once 'funzioni/statistica.php';
$this_y = date ( 'Y' );
if (isset ( $_REQUEST ['anno'] )) {
	$g_anno = $_REQUEST ['anno'];
} else {
	$g_anno = $this_y -1;
}
$b_mobile = isset ($_GET ['mobile']) ? $_GET ['mobile'] : 0;
$tabella = "tabelloneanalitico_lotto_" . lastdate ();
// $listAll = application ( $tabella );
class type_Tabellone {
	public $b = array ();
	public $c = array ();
	public $f = array ();
	public $g = array ();
	public $m = array ();
	public $n = array ();
	public $p = array ();
	public $r = array ();
	public $t = array ();
	public $v = array ();
	public $z = array ();
	public $d = array ();
}

if (empty ( $listAll ) || $force == 1) {
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
	$r_estrazioni = Carica_estrazione_lotto ( '', 2, $g_anno );
}
// print_r($Tabellone);
// ---------------------------------- COMPONI TABELLONE ANALITICO -----------------------------

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





// ------------------------------------- inizio estrazioni TABELLA -------------------------



?>
<div class="col-sm-12 text-center">
<ul class="pager">

<?php if ($g_anno != 1871) { ?>
    <li class="previous"><a href="?anno=1871"><< Primo</a></li>
    <li class="previous"><a href="?anno=<?php echo ($g_anno - 1) ?>"><< <?php echo ($g_anno - 1) ?></a></li>
<?php }
if ($g_anno != $this_y) {?>
    <li class="next" ><a href="?anno=<?php echo (date ( 'Y' )) ?>">Ultimo >></a></li>
    <li class="previous"><a href="?anno=<?php echo ($g_anno + 1) ?>"><?php echo ($g_anno + 1) ?>>></a></li>
<?php }?>
</ul>
<h2  class="row">Risultati Estrazioni del lotto anno <?php echo $g_anno ?></h2>
</div>
<?php 
$cont = 0;
foreach ( $r_estrazioni as $est ) {
	?>

	<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
    	<table>
    
    	<thead>
    		<tr>
    			<th>RUOTA</th>
    			<th colspan="5"><strong><?php echo data_estesa ( $est->es_data ); ?></strong></th>
    		</tr>
    	</thead>
    
    	<tbody>
    	<?php 
    	   $contr =0;
    	 	foreach ( $rr_ruote as $key ) {
    	 	    $arr_t = $est->$key;
    	 	    $nru = eliminaUltimo ( $arr_t );
    	 	    $nru = str_replace ( ',', '.', $nru );
    	 	    ?> 
    	 	    <tr>
    				<td class="ruotestyle text-left nowrap ruo"><?php echo strtoupper( $numeruote[$contr]) ;?></td>
    				<?php echo givemetd ( $nru, "." );?>
    			</tr>
    			<?php 
    		  $contr +=1;
    	    }
    	 	    ?>
    	</tbody>
    
    	</table>
	</div>
	<?php 
    $cont++;
	if ($cont == 1 && $b_mobile == 1) {
		?> 
		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
			<div id="div-gpt-ad-box_mobile_inside_top" class="mp-code box-mobile-inside-top"></div> 
			<br />
			<br />
		</div>
		
		<?php 
	}
}

// -------------------------------------- FUNZIONI VARIE --------------------------------
function givemetd($string, $delimeter = ",") {
	$tmp_array = explode ( $delimeter, $string );
	$rets = "";
	foreach ( $tmp_array as $tk ) {
		if (! empty ( $tk )) {
			$rets .= '<td>' . check_numero ( $tk ) . '</td>';
			$agg = true;
		} else {
			$rets .= ".";
		}
	}
	return $rets;
}
function azzera() {
	for($i = 1; $i <= 90; ++ $i) {
		$arr_n [] = 0;
	}
	return $arr_n;
}
?>