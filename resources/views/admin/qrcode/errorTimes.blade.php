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


  <style type="text/css">

  @font-face {
    font-family: Lora;
    src: '../fonts/lora-v12-latin-regular.woff)';        
  }

  body{
   font-family: "Lora";
   background-color: white;
   color: #000000;
   text-align: justify;
   width: 100%;
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
 margin: 0 auto;
 border-radius: 5%;
}
.content {    
  width: 100%;
}

.x_panel{
  border: none !important;
}
.btn{
  margin-right: 0px !important;
}
#ScanError{
  border-radius: 2px solid red;
  height: 200px
}

iframe{
  width: 100%;
  margin: 0 auto;
  padding: 0 auto;
}
/* lora-regular - latin */


</style>
</head>

<body>

  <!--<div class="x_panel">-->
  <!--  <img class="imageProduct" src="{{asset('public/image/logo.jpg')}}" alt="">-->
  <!--  <br>-->
  <!--  <p style="text-align: center">-->
  <!--    HỆ THỐNG TRUY XUẤT NGUỒN GỐC HÀNG HÓA-->
  <!--  </p>-->
  <!--</div>-->
<div id="">
  <img class="imageProduct" src="{{asset('public/image/warningSMC.png')}}" alt="">
</div>

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