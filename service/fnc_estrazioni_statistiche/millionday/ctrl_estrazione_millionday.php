<?php
require_once ("../funzioni/global.php");
$data = new MysqlClass ();
$data->connetti ();
$estrazione = $data->query ( "SELECT * FROM LottoCED.es_millionday order by esdata desc limit 7;");
$qrowest = array(); 
if (@mysqli_num_rows ( $estrazione ) > 0) {
    while ( $rows = $data->estrai ( $estrazione ) ) {
        $qrowest[] = $rows;
    }
}
?>
<div class="row" style="font-size: 1.3em">
<div class="col-sm-12 text-center">
	<div class="table-responsive">
		<table id="lista_estrazioni_10el5m"
			class="table table-condensed table-striped">
			<col width="30%">
  			
			<thead>
				<tr>
					<th >Data</th>
					<th colspan="5">Estrazione</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($qrowest as $rowest){
			    $arrEst = explode(",", $rowest->estratti)
			?>
			<tr>
					<td class="nowrap firstcol"><?php echo dataestesa_million($rowest->esdata)?></td>
					<?php 
					foreach ($arrEst as $num){
					    echo "<td>" . check_numero($num). "</td>";
					}
					?>
					
				</tr>
			<?php 
			}?>
				
			</tbody>
		</table>
	</div>
</div>
</div>
<?php

$data->disconnetti();

function dataestesa_million($es_data) {
    $originalDate = $es_data;
    setlocale ( LC_TIME, 'it_IT' );
    $newDate = strftime ( "%d %B %Y", strtotime ( $es_data ) ); // date ( "d.m.Y", strtotime ( $originalDate ) );
   
    return $newDate;
}
?>
