@extends('layouts.master_user')
@section('content')
    <form action="{{route('getViewPrint')}}" method="POST" id="formPrint" style="width: 30%;margin-left: 35%">
        <div class="slidecontainer">
            <p>Value: <span id="demo">%</span></p>
            <input type="range" min="-10" max="70" value="33" name="stampWidth" class="slider"
                   id="stampWidth" onchange="myFunction()">
        </div>

        <div id="view-print"
             style="width: 294px;height: 204px; border: 1px solid black;margin-right: auto;margin-left: auto;">
            <img id="qr-code" style="border: 1px solid black;margin-left: 33%;margin-top: 15%; "
                 src="data:image/png;base64, {!! base64_encode(QrCode::format('png')
							->size(102)
							->generate($url)) !!} ">
        </div>

        <div class="slidecontainer">
            <p>Value: <span id="demo2">%</span></p>
            <input type="range" min="-10" max="40" value="17" name="stampHeight" class="slider"
                   id="stampHeight" onchange="myFunction2()">
        </div>
        <div>
            <input type="hidden" name="url" value="{{$url}}">
        </div>
        <button type="submit" class="btn btn-primary" form="formPrint" value="submit">In ngay</button>
        {{ csrf_field() }}
    </form>

@endsection
@section('script')
    <script>
        function printDiv() {

            var divToPrint = document.getElementById('DivIdToPrint');

            var newWin = window.open('', 'Print-Window');

            newWin.document.open();

            newWin.document.write('<html><body onload="window.print()">' + printQrcode.innerHTML + '</body></html>');

            newWin.document.close();

            setTimeout(function () {
                newWin.close();
            }, 10);

        }
    </script>

    <script>
        var slider = document.getElementById("stampWidth");
        var output = document.getElementById("demo");
        output.innerHTML = slider.value;

        slider.oninput = function () {
            output.innerHTML = this.value;
        }
    </script>
    <script>
        var slider2 = document.getElementById("stampHeight");
        var output2 = document.getElementById("demo2");
        output2.innerHTML = slider2.value;

        slider2.oninput = function () {
            output2.innerHTML = this.value;
        }
    </script>

    <script>
        function testView() {
            var x = document.getElementById("stampWidth").value;
            var y = document.getElementById("stampHeight").value;
            document.getElementById("view-print").innerHTML = '<img style="border: 1px solid black;margin-left: ' + x + '%;margin-top: ' + y + '%;" src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(102)->generate($url)) !!} ">';

        }
    </script>

    <script>
        function myFunction() {
            var x = document.getElementById("stampWidth").value;
            var y = document.getElementById("stampHeight").value;
            document.getElementById("view-print").innerHTML = '<img style="border: 1px solid black;margin-left: ' + x + '%;margin-top: ' + y + '%;" src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(102)->generate($url)) !!} ">';
        }
    </script>

    <script>
        function myFunction2() {
            var y = document.getElementById("stampHeight").value;
            var x = document.getElementById("stampWidth").value;
            document.getElementById("view-print").innerHTML = '<img style="border: 1px solid black;margin-left: ' + x + '%;margin-top: ' + y + '%;" src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(102)->generate($url)) !!} ">';
        }
    </script>

@endsection