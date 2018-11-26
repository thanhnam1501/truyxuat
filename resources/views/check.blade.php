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
        max-width: 100%;
        margin: 0 auto;
        text-align: justify;
      }
      .row {
        max-width: 100%;
      }
      

    </style>
  </head>

  <body class="nav-md">

    @if(!empty($data))
    <div class="x_panel">
      @if($data->image)
      <img class="imageProduct" src="{{asset($data->image)}}" alt="">
      @else
      <img class="imageProduct" src="{{ asset('image/noimage.png')}}" alt="">
      @endif
    </div>


    <div class="x_panel">
      <h3 style="color: red;text-align: center;"><strong>{{$data->name}}</strong></h3>
    </div>

    <div class="row">
      <legend class="panel-heading" style="background-color: red;">
       <a href="#sort-content" style="background-color: red; width: 100%"  class="btn panel-title fieldset-legend collapse-link" data-toggle="collapse" aria-expanded="true"><span class="fieldset-legend-prefix element-invisible""></span><span style="color: #fff !important; "><strong style="float: left;">THÔNG TIN SẢN PHẨM</strong><i class="fa fa-chevron-down" style="float: right;"></i></span>
       </a>
     </legend>
     <div class="panel-body panel-collapse fade collapse in" id="sort-content" aria-expanded="true" style="">
      <div id="sort-content" class="btn-group ">
        {!!$data->sort_content!!}
      </div>
    </div>
  </div>


  <div class="row">

    <legend class="panel-heading" style="background-color: red;">
      <a href="#content" style="background-color: red; width: 100%"  class="btn panel-title fieldset-legend collapse-link" data-toggle="collapse" aria-expanded="true"><span class="fieldset-legend-prefix element-invisible""></span><span style="color: #fff !important; "><strong style="float: left;">THÔNG TIN CHI TIẾT</strong><i class="fa fa-chevron-down" style="float: right;"></i></span>
      </a>
    </legend>
    <div class="panel-body panel-collapse fade collapse" id="content" aria-expanded="true" style="">
      <div id="content" class="btn-group content ">
        {!!$data->content!!}
      </div>
    </div>
  </div>

  @for($i= 0; $i < $data->node ; $i++)
  @foreach($nodes as $key => $value)
  @if($key == $i && $value['status'] == 1)
  <div class="row">
    <legend class="panel-heading" style="background-color: red;">
      <a href="#content{{$i}}" style="background-color: red; width: 100%"  class="btn panel-title fieldset-legend collapse-link" data-toggle="collapse" aria-expanded="true"><span class="fieldset-legend-prefix element-invisible""></span><span style="color: #fff !important; "><strong style="float: left;">{{mb_strtoupper($value->name,'utf8')}}</strong><i class="fa fa-chevron-down" style="float: right;"></i></span>
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
  @endif


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