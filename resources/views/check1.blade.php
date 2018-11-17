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
          width: 100%;
          height: 300px; 
          margin: 0 auto;
        }
        .tab-content img{
          max-width: 100%;
          height: 300px;
        }
      </style>
    </head>


    <body class="nav-md">
     <div >
      <div class="x_panel">
        <h3 style="color: red; font-weight: bold; text-align: center" align="justify">{{$data->name}}</h3>
      </div>
    </div>

    <div class="clearfix"></div>
    <div class="">
      <div class="x_panel">
        <div class="x_title">
          <h2><i class="fa fa-bars"></i> Thông tin</h2>

          <div class="clearfix"></div>
        </div>
        <div class="x_content">

          <div class="col-md-6 col-xs-12" style="margin-bottom: 10%;">
            <!-- required for floating -->
            <!-- Nav tabs -->
            @if($data->image)
            <img class="imageProduct" src="{{asset($data->image)}}" alt="">
            @else
            <img style="width: 100%;" src="{{ asset('image/noimage.png')}}" alt="">
            @endif

          </div>
          <div class="clearfix"></div>
          <div class="col-md-6 col-xs-12">
            <!-- Tab panes -->
            <div class="tab-content">
             {!!$data->sort_content!!}
           </div>
         </div>
       </div>
     </div>
   </div>

   <div class="">
    <div class="x_panel">
      <div class="x_title">
        <h2><i class="fa fa-bars"></i> Mô tả</h2>

        <div class="clearfix"></div>
      </div>
      <div class="x_content">

        <div class=" col-xs-12">
          <!-- Tab panes -->
          <div class="tab-content">

            <p>{!!$data->content!!}</p>

          </div>
        </div>
      </div>
    </div>
  </div>



  <div>
    <div class="x_panel">
      <div class="x_title">
        <h2><i class="fa fa-bars"></i> Quy trình</h2>

        <div class="clearfix"></div>
      </div>
      <div class="x_content">

        <div class="col-md-3 col-xs-12">
          <!-- required for floating -->
          <!-- Nav tabs -->
          <ul class="nav nav-tabs tabs-left">
            @for($i= 0; $i < $data->node ; $i++)
            @foreach($nodes as $key => $value)
            @if($key == $i)
            <li  role="presentation" class="@if($i==0)active @endif col-xs-12"><a href="#tab_content{{$i}}" role="tab" id="profile-tab" data-toggle="tab"  aria-expanded="false">{{$value->name}}</a>

            </li>
            @endif
            @endforeach
            @endfor
          </ul>
        </div>

        <div>
          <!-- Tab panes -->
          <div class="tab-content">
           @for($i= 0; $i < $data->node ; $i++)
           @foreach($nodes as $key => $value)
           @if($key === $i)
           <div role="tabpanel" class="tab-pane @if($i==0)active @endif fade in" id="tab_content{{$i}}" aria-labelledby="home-tab">
            <p style="max-width: auto;overflow: auto;">{!!$value->content!!}</p>
          </div>
          @endif
          @endforeach
          @endfor
        </div>
      </div>
    </div>
  </div>
</div>





      {{-- <div class="container body">
        <style>
        li {
          list-style: none;
          float: left;
        }
        .imageProduct{
         max-width: 100%;
         max-height: 400px;

       </style>

       <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="page-title">
          <div class="title_left">
            <h3>General Elements</h3>
          </div>


        </div>
        <div >
          <div class="x_panel">
            <div class="x_title">
              <h2><i class="fa fa-bars"></i> Thông tin sản phẩm</h2>

              <div class="clearfix"></div>
            </div>
            <div class="x_content">

              <div class="col-xs-12">
                <!-- required for floating -->
                <!-- Nav tabs -->
                <img class="imageProduct" src="{{asset($data->image)}}" alt="">
              </div>

              <div class="col-xs-12">
                <!-- Tab panes -->
                <div class="tab-content">
                  <div class="tab-pane active" id="home">
                    <p>
                      {!!$data->sort_content!!}
                    </p>
                  </div>
                </div>
              </div>

              <div class="clearfix"></div>

            </div>
          </div>
        </div>


  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2><i class="fa fa-bars"></i> Mô tả</h2>

        <div class="clearfix"></div>
      </div>
      <div class="x_content">

      

        <div class="col-xs-12">
          <!-- Tab panes -->
          <div class="" role="tabpanel" data-example-id="togglable-tabs">
            <p>{!!$data->content!!}</p>
          </div>
      </div>

      <div class="clearfix"></div>

    </div>
  </div>

  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2><i class="fa fa-bars"></i> Quy trình</h2>

        <div class="clearfix"></div>
      </div>
      <div class="x_content">

        <div class="col-md-3 col-xs-12">
          <!-- required for floating -->
          <!-- Nav tabs -->
          <ul class="nav nav-tabs tabs-left">
            @for($i= 0; $i < $data->node ; $i++)
            @foreach($nodes as $key => $value)
            @if($key == $i)
            <li role="presentation" class="@if($i==0)active @endif col-xs-12"><a href="#tab_content{{$i}}" role="tab" id="profile-tab" data-toggle="tab"  aria-expanded="false">{{$value->name}}</a>

            </li>
            @endif
            @endforeach
            @endfor
          </ul>
        </div>

        <div class="col-md-9 col-xs-12">
          <!-- Tab panes -->
          <div class="tab-content">
           @for($i= 0; $i < $data->node ; $i++)
           @foreach($nodes as $key => $value)
           @if($key === $i)
           <div role="tabpanel" class="tab-pane @if($i==0)active @endif fade in" id="tab_content{{$i}}" aria-labelledby="home-tab">
            <p>{{$value->content}}</p>
          </div>
          @endif
          @endforeach
          @endfor
        </div>
      </div>

      <div class="clearfix"></div>

    </div>
  </div>
</div>
</div>
</div>
</div>
</div>

</div> --}}
<!-- /page content -->



<script src="{{asset('js/bootstrap.min.js')}}"></script>

<!-- chart js -->
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