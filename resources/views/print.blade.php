<!DOCTYPE html>
<html>
<head>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
          integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
            crossorigin="anonymous"></script>
    <style>
        body {
            margin: 0 0 0 0;
            padding: 0 0 0 0;
            /*	background-image: url("public/image/aaa.jpg");
                background-repeat: no-repeat;
                background-size: 397px 83px;*/
        }

        #view-print {
            margin: 0 auto;
            padding: 0 auto;
        }

        img {
            margin-left: {{$data['stampWidth'] . "%"}};
            margin-top: {{$data['stampHeight'] . "%"}};
        }

    </style>
</head>
<body onload="window.print()">
<div id="view-print" style="float: left;width: 33.3%;height: 100%;">
    <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')
			->size(48)
			->generate($data['url'])) !!} ">
</div>

<div id="view-print" style="float: left;width: 33.3%;height: 100%;">
    <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')
			->size(48)
			->generate($data['url'])) !!} ">
</div>
<div id="view-print" style="float: left;width: 33.3%;height: 100%;">
    <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')
			->size(48)
			->generate($data['url'])) !!} ">
</div>
</body>
</html>
{{--<!DOCTYPE html>--}}
{{--<html>--}}
{{--<head>--}}
{{--    <!-- Latest compiled and minified CSS -->--}}
{{--    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"--}}
{{--          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">--}}

{{--    <!-- Optional theme -->--}}
{{--    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"--}}
{{--          integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">--}}

{{--    <!-- Latest compiled and minified JavaScript -->--}}
{{--    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"--}}
{{--            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"--}}
{{--            crossorigin="anonymous"></script>--}}
{{--    <style>--}}
{{--        body {--}}
{{--            margin: 0 0 0 0;--}}
{{--            padding: 0 0 0 0;--}}
{{--            /*	background-image: url("public/image/aaa.jpg");--}}
{{--                background-repeat: no-repeat;--}}
{{--                background-size: 397px 83px;*/--}}
{{--        }--}}

{{--        #view-print {--}}
{{--            margin: 0 auto;--}}
{{--            padding: 0 auto;--}}
{{--        }--}}

{{--        .qr-code {--}}
{{--            margin-left: {{$data['stampWidth'] . "%"}};--}}
{{--            margin-top: {{$data['stampHeight'] . "%"}};--}}
{{--        }--}}

{{--    </style>--}}


{{--</head>--}}
{{--<body >--}}

{{--<div id="view-print" style="float: left;width: 33.3%;height: 100%;">--}}
{{--    <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')--}}
{{--                        ->size(50)->errorCorrection('L')--}}
{{--                        ->generate($data['url'])); !!} ">--}}
{{--</div>--}}

{{--<div id="view-print" style="float: left;width: 33.3%;height: 100%;">--}}
{{--    <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')--}}
{{--                        ->size(50)->errorCorrection('L')--}}
{{--                        ->generate($data['url'])); !!} ">--}}
{{--</div>--}}

{{--<div id="view-print" style="float: left;width: 33.3%;height: 100%;">--}}
{{--    <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')--}}
{{--                        ->size(50)->errorCorrection('L')--}}
{{--                        ->generate($data['url'])); !!} ">--}}
{{--</div>--}}

{{--</body>--}}
{{--</html>--}}
