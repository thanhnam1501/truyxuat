<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            margin: 0 0 0 0;
            padding: 0 0 0 0;
            /*	background-image: url("public/image/aaa.jpg");
                background-repeat: no-repeat;
                background-size: 397px 83px;*/
        }

        img {
            margin-left: {{$data['stampWidth'] . "%"}};
            margin-top: {{$data['stampHeight'] . "%"}};
        }

    </style>
</head>
<body onload="window.print()">
<div id="view-print" style="float: left;width: 98px;height: 68px;">
    <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')
			->size(48)
			->generate($data['url'])) !!} ">
</div>

<div id="view-print" style="float: left;width: 98px;height: 68px;">
    <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')
			->size(48)
			->generate($data['url'])) !!} ">
</div>
<div id="view-print" style="float: left;width: 98px;height: 68px;">
    <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')
			->size(48)
			->generate($data['url'])) !!} ">
</div>
</body>
</html>