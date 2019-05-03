<?php 
	header("Content-Type: text\csv");
    header("Content-Disposition: attachment; filename=".$name."_".$guid."_".date('Ymd_his').".csv");  //File name extension was wrong
    header("Pragma: no-cache");
    header("Expires: 0");
    ob_end_clean();
	ob_flush();
?>
STT,Serial,Value
@foreach($data as $item){{$item[0]}},{{$item[1]}},{!!$item[2]!!},
		@endforeach
	