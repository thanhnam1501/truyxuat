<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>SmartCheck | Giải pháp chống giả cho bạn ! </title>

  <!-- Bootstrap core CSS -->
  <link href="{{asset('public/image/favicon.png')}}" rel='shortcut icon' type='image/vnd.microsoft.icon' />
  <link href="{{asset('public/css/bootstrap.min.css')}}" rel="stylesheet">

  <link href="{{asset('public/fonts/css/font-awesome.min.css')}}" rel="stylesheet">
  <link href="{{asset('public/css/animate.min.css')}}" rel="stylesheet">

  <!-- Custom styling plus plugins -->
  <link href="{{asset('public/css/custom.css')}}" rel="stylesheet">
  <link href="{{asset('public/css/icheck/flat/green.css')}}" rel="stylesheet" />


  <script src="{{asset('public/js/jquery.min.js')}}"></script>

  <style>
  body{
    font-family: "Lora";
    background-color: white;
    color: #000000;
    text-align: justify;
    width: 97.5%;
    margin:0 auto;
    padding: 0 auto;

  }
  .imageProduct{
    width: 100%;
    height: 100%; 
    display: block;
    margin-left: auto;
    margin-right: auto;
  }
  .content img{
   max-width: 100%;
   max-height: 100%;
 }
</style>
</head>

<body>

  {{-- giới thiệu --}}
  <div>
   <img class="imageProduct" src="{{asset('public/image/logo.jpg')}}" alt="">
   <br>

   <p style="text-align: center">
    HỆ THỐNG TRUY XUẤT NGUỒN GỐC HÀNG HÓA
  </p>
</div>

{{-- ảnh và tên sản phẩm --}}
<div style="">
 @if($data->image)
 <img class="imageProduct" src="{{asset('public/'.$data->image)}}" alt="">
 @else
 <img class="imageProduct" src="{{ asset('public/image/noimage.png')}}" alt="">
 @endif
 <h4 style="text-align: center; "><strong>{{$data->name}}</strong></h4>
</div>
{{-- END --}}

{{-- Thông tin sản phẩm --}}
<div >
  <div>
   <a href="#sort-content" style="background-color: #338841; width: 100%; margin: 0 auto !important; padding: auto; float: left"  class="btn panel-title fieldset-legend collapse-link" data-toggle="collapse" aria-expanded="true">
    <i class="fa fa-qrcode" style="color: #fff; float: left; margin-left: 5%; margin-right: 5%; margin-top: 1%"></i>

    <span style="color: #fff !important; ">
      <strong style="float: left;">THÔNG TIN SẢN PHẨM</strong>
      <i class="ChangeIcon fa fa-chevron-up" style="float: right; margin-right: 5%;"></i>
    </span>
  </a>

</div>
<div class="panel-body panel-collapse fade collapse in" id="sort-content" aria-expanded="true" style="">
  <div id="sort-content" class="btn-group content">

   <p class="standard">{!!$data->sort_content!!}</p>
 </div>
</div>
</div>
{{-- End --}}

{{-- Thông tin chi tiết --}}
@if($data->content !== null)
<div >
  <a href="#content" style="background-color: #338841; width: 100%"  class="btn panel-title fieldset-legend collapse-link" data-toggle="collapse" aria-expanded="true">
    <span class="fieldset-legend-prefix element-invisible""></span>
    <i class="fa fa-search" style="color: #fff; float: left; margin-left: 5%; margin-right: 5%; margin-top: 1%"></i>
    <span style="color: #fff !important; ">
      <strong style="float: left;">THÔNG TIN CHI TIẾT</strong>
      <i class=" ChangeIcon fa fa-chevron-down" style="float: right;margin-right: 5%;"></i></span>
    </a>

    <div class="panel-body panel-collapse fade collapse" id="content" aria-expanded="true" style="">
      <div id="content" class="btn-group content ">
       <p> {!!$data->content!!}</p>
     </div>
   </div>
 </div>
</div>
@endif
{{-- End --}}

{{-- Tag --}}
@for($i= 0; $i < $data->node ; $i++)
@foreach($nodes as $key => $value)
@if($key == $i && $value['status'] == 1)
<div style="width: 100%;">
  <a href="#content{{$i}}" style="background-color: #338841; width: 100%"  class="btn panel-title fieldset-legend collapse-link" data-toggle="collapse" aria-expanded="true">
    <span class="fieldset-legend-prefix element-invisible""></span>
    <i class="fa fa-tag" style="color: #fff; float: left; margin-left: 5%; margin-right: 5%; margin-top: 1%"></i>
    <span style="color: #fff !important; ">
      <strong style="float: left;">{{mb_strtoupper($value->name,'utf8')}}</strong>
      <i class=" ChangeIcon fa fa-chevron-down" style="float: right;margin-right: 5%;"></i></span>
    </a>
    <div class="panel-body panel-collapse fade collapse" id="content{{$i}}" aria-expanded="true" style="">
      <div id="content" class="btn-group content ">
       <p> {!!$value->content!!}</p>
     </div>
   </div>
 </div>
</div>
@endif
@endforeach
@endfor




<script src="{{asset('public/js/bootstrap.min.js')}}"></script>
<script src="{{asset('public/js/chartjs/chart.min.js')}}"></script>
<!-- bootstrap progress js -->
<script src="{{asset('public/js/progressbar/bootstrap-progressbar.min.js')}}"></script>
<script src="{{asset('public/js/nicescroll/jquery.nicescroll.min.js')}}"></script>
<!-- icheck -->
<script src="{{asset('public/js/icheck/icheck.min.js')}}"></script>

<script src="{{asset('public/js/custom.js')}}"></script>

<!-- /footer content -->
</body>

</html>