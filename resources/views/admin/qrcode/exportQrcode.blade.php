<?php 
	header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=".$name."_".$guid."_".date('Ymd_his').".xls");  //File name extension was wrong
    header("Pragma: no-cache");
    header("Expires: 0");
    ob_end_clean();
	ob_flush();
?>
<table border="1">
	<thead>
		<tr>
			<th width="5%" valign="middle" align="center">STT</th>
			<th width="15%" valign="middle" align="center">Serial</th>
			<th width="35%" valign="middle" align="center">Value QR Code</th>
		</tr>
	</thead>
	<tbody>
		@foreach($data as $item)
		<tr>
			<td>{{$item[0]}}</td>
			<td>{{$item[1]}}</td>
			<td>{{$item[2]}}</td>
		</tr>
		@endforeach
	</tbody>
</table>