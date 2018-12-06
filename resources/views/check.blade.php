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

  <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">

  <link href="{{asset('fonts/css/font-awesome.min.css')}}" rel="stylesheet">
  <link href="{{asset('css/animate.min.css')}}" rel="stylesheet">

  <!-- Custom styling plus plugins -->
  <link href="{{asset('css/custom.css')}}" rel="stylesheet">
  <link href="{{asset('css/icheck/flat/green.css')}}" rel="stylesheet" />


  <script src="{{asset('js/jquery.min.js')}}"></script>

    <!--[if lt IE 9]>
        <script src="../assets/js/ie8-responsive-file-warning.js"></script>
      <![endif]-->

      <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <style type="text/css">
        .imageProduct{
          width: 50%;
          height: 50%; 
          display: block;
          margin-left: auto;
          margin-right: auto;
        }
        .content img{
         max-width: 100%;
         max-height: 300px;
       }
       body{
        background-color: white;
        text-align: justify;
        max-width: 100%;
      }
      .FirstContent{
        height: 100%;
        max-width: 100%;
       
        z-index: 1;
        top: 0;
        overflow-x: hidden;
        padding-top: 20px;
      }
    }
  </style>
</head>

<body >

 <div class="FirstContent" style="width: 100%;margin-right: 0 !important;">
  <div class="x_panel">
    <img class="imageProduct" src="{{asset('image/logo.jpg')}}" alt="">
    <br>
    <p style="text-align: center">
      HỆ THỐNG TRUY XUẤT NGUỒN GỐC HÀNG HÓA
    </p>
  </div>
  @if(!empty($data->status == 1))
  <div class="x_panel">
    @if($data->image)
    <img class="imageProduct" src="{{asset($data->image)}}" alt="">
    @else
    <img class="imageProduct" src="{{ asset('image/noimage.png')}}" alt="">
    @endif
  </div>


  <div class="x_panel">
    <h4 style="text-align: center;"><strong>{{$data->name}}</strong></h4>
  </div>

  <div class="row">
    <legend class="panel-heading container" style="background-color: #e0384f; width: 100%; text-align: center; justify-content: center; ">

     <a href="#sort-content" style="background-color: #e0384f; width: 100%; margin: 0 auto !important; padding: auto; float: left"  class="btn panel-title fieldset-legend collapse-link" data-toggle="collapse" aria-expanded="true">
      <i class="fa fa-qrcode" style="color: #fff; float: left; margin-left: 5%; margin-right: 5%; margin-top: 1%"></i>
      {{--   <span class="fieldset-legend-prefix element-invisible"">          
      </span> --}}
      <span style="color: #fff !important; ">
        <strong style="float: left;">THÔNG TIN SẢN PHẨM</strong>
        <i class="ChangeIcon fa fa-chevron-up" style="float: right; margin-right: 5%;"></i>
      </span>
    </a>
  </legend>
  <div class="panel-body panel-collapse fade collapse in" id="sort-content" aria-expanded="true" style="">
    <div id="sort-content" class="btn-group ">

      {!!$data->sort_content!!}
    </div>
  </div>
</div>

@if($data->content !== null)
<div class="row">

  <legend class="panel-heading container" style="background-color: #82898f;">
    <a href="#content" style="background-color: #82898f; width: 100%"  class="btn panel-title fieldset-legend collapse-link" data-toggle="collapse" aria-expanded="true">
      <span class="fieldset-legend-prefix element-invisible""></span>
      <i class="fa fa-search" style="color: #fff; float: left; margin-left: 5%; margin-right: 5%; margin-top: 1%"></i>
      <span style="color: #fff !important; ">
        <strong style="float: left;">THÔNG TIN CHI TIẾT</strong>
        <i class=" ChangeIcon fa fa-chevron-down" style="float: right;margin-right: 5%;"></i></span>
      </a>
    </legend>
    <div class="panel-body panel-collapse fade collapse" id="content" aria-expanded="true" style="">
      <div id="content" class="btn-group content ">
        {!!$data->content!!}
      </div>
    </div>
  </div>
  @endif
  

  @for($i= 0; $i < $data->node ; $i++)
  @foreach($nodes as $key => $value)
  @if($key == $i && $value['status'] == 1)
  <div class="row">
    <legend class="panel-heading container" style="background-color: #82898f; max-width: 100%">
      <a href="#content{{$i}}" style="background-color: #82898f; width: 100%"  class="btn panel-title fieldset-legend collapse-link" data-toggle="collapse" aria-expanded="true">
       <div class="iconfirst">  <span><i class="fa fa-tag" style="color: #fff; float: left; margin-left: 5%; margin-right: 5%; margin-top: 1%"></i></span></div>
       <span style="color: #fff !important; "><strong style="float: left;">{{mb_strtoupper($value->name,'utf8')}}</strong><i class="ChangeIcon fa fa-chevron-down" style="float: right; margin-right: 5%;"></i></span>
     </a>
   </legend>
   <div class="panel-body panel-collapse fade collapse " id="content{{$i}}" aria-expanded="true" style="">
    <div id="content" class="btn-group content">
      {!!$value->content!!}
    </div>
  </div>
</div>
@endif
@endforeach
@endfor
@else
<div class="x_panel">
  <img class="imageProduct" src="{{ asset('image/noimage.png')}}" alt="">
</div>
<h4 style="text-align: center;color: red;">Sản phẩm không có trong hệ thống của chúng tôi!</h4>
@endif

<div class="row">
 <div class="x_panel">
  <ul style="list-style: none;">
    <li>
      <p><strong>Hệ thống truy xuất nguồn gốc hàng hóa - <span style="color: red">S</span>mart<span style="color: red">C</span>heck</strong></p>
    </li>
    <li>
      <i class="fa fa-map-marker" style="float: left; margin-left: 5%; margin-right: 5%; margin-top: 1%"></i>
      <p>P207, Tòa nhà Khách sạn Thể thao, <br>
     Số 15  Lê Văn Thiêm, Quận Thanh Xuân, Hà Nội</p>
    </li>
    <li>
     <i class="fa fa-phone" style="float: left; margin-left: 5%; margin-right: 5%; margin-top: 1%"></i>
     <p> 024.3555.8212 – Fax: 024.3555.8211</p>
   </li>
   <li>
     <i class="fa fa-envelope" style="float: left; margin-left: 5%; margin-right: 5%; margin-top: 1%"></i>
     <p>contact@smartcheck.vn</p>
   </li>
   <li>
     <i class="fa fa-life-saver" style="float: left; margin-left: 5%; margin-right: 5%; margin-top: 1%"></i>
     <a href="https://smartcheck.vn/">https://smartcheck.vn</a>
   </li>

 </ul>
</div>
</div>
</div>

<script src="{{asset('js/bootstrap.min.js')}}"></script>
<script src="{{asset('js/chartjs/chart.min.js')}}"></script>
<!-- bootstrap progress js -->
<script src="{{asset('js/progressbar/bootstrap-progressbar.min.js')}}"></script>
<script src="{{asset('js/nicescroll/jquery.nicescroll.min.js')}}"></script>
<!-- icheck -->
<script src="{{asset('js/icheck/icheck.min.js')}}"></script>

<script src="{{asset('js/custom.js')}}"></script>

<!-- /footer content -->
</body>

</html>