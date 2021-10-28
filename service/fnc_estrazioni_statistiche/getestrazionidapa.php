<?php

// $link = "http://www.lottologia.com/10elotto5minuti/?do=archivio-estrazioni&tab=&as=TXT&date=01-01-2013&group_num_selector=selected&numbers_selector_mode=add&numbers_selected=#main";
// $testo = file_get_contents ( $link );
// echo $testo;
// 01-01-2013
$start = '01-01-2013';

for($i = 0; $i <= 1017 ; ++ $i) {
	$date = $start;
	// echo $i . " - " . $date . '<br />';
	$link = "http://www.lottologia.com/10elotto5minuti/?do=archivio-estrazioni&tab=&as=TXT&date=$date&group_num_selector=selected&numbers_selector_mode=add&numbers_selected=#main";
	echo $link . '<br />';
	$newdate = strtotime ( '+1 day', strtotime ( $date ) ); // facciamo l'operazione
	$newdate = date ( 'd-m-Y', $newdate ); // trasformiamo la data nel formato accettato dal db YYYY-MM-DD
	$start = $newdate;
}

?>