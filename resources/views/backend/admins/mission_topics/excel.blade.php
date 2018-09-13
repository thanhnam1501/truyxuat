<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Đề tài hoặc đề án</title>
	<link rel="icon" href="{{asset('img/icon.png')}}" type="image/x-icon" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<style type="text/css">
		table, table td, table th {
			border: 1px solid #000000;
		}
		table th, table td {
			vertical-align: top;
		}
		table th {
			text-align: center;
			font-size: 14px;
			vertical-align: middle;
			height: 50px;
			background: #f1f5f9;
		}
	</style>
</head>
<body>
	<table>
		<thead>
			<tr>
				<th>STT</th>
				<th>Tên đơn vị</th>
				<th>Người đăng ký - SĐT</th>
				@if (isset($attributes))
					@if ($attributes->count() > 0)
						@foreach ($attributes as $attr)
							<th>{!!$attr->label!!}</th>
						@endforeach
					@endif
				@endif
			</tr>
		</thead>
		<tbody>
			@if (isset($datas))
				@if ($datas->count() > 0)
					@foreach ($datas as $key => $topic)
						<tr>
							<td align="center" width="5">{{$key + 1}}</td>
							<td align="center" width="25">{!! $topic->organization !!}</td>
							<td align="center" width="25">{!! $topic->register !!}</td>
							<td align="left" width="40">{!! $topic->name !!}</td>
							<td align="left" width="60">{!! $topic->propose_base !!}</td>
							<td align="left" width="60">{!! $topic->urgency !!}</td>
							<td align="left" width="60">{!! $topic->target !!}</td>
							<td align="left" width="60">{!! $topic->result_target_requirement !!}</td>
							<td align="left" width="60">{!! $topic->expected_main_content !!}</td>
							<td align="left" width="60">{!! $topic->expected_result_perform !!}</td>
							<td align="left" width="60">{!! $topic->time_result_requirement !!}</td>
							<td align="right" width="30">{!! $topic->expected_fund !!}</td>
						</tr>
					@endforeach
				@endif
			@endif
		</tbody>
	</table>
</body>
</html>