<!DOCTYPE html>
<html>
<head>

	<style>
	body{
		margin: 0 0 0 0;
		padding: 0 0 0 0;
	/*	background-image: url("public/image/aaa.jpg");
		background-repeat: no-repeat;
		background-size: 397px 83px;*/
	}
	img{
		margin-left: {{$data['stampWidth'] . "%"}};
		margin-top: {{$data['stampHeight'] . "%"}};
	}
	
</style>
</head>
<body>
	<div id="demo">

		<div id="view-print" style="float: left;width: 95px;height: 68px;">
			<img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')
			->size(45)
			->generate($data['url'])) !!} ">
		</div>

		<div id="view-print" style="float: left;width: 95px;height: 68px;">
			<img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')
			->size(45)
			->generate($data['url'])) !!} ">
		</div>
		<div id="view-print" style="float: left;width: 95px;height: 68px;">
			<img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')
			->size(45)
			->generate($data['url'])) !!} ">
		</div>
	</div>
</body>



	</html>