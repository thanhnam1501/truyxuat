<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SmartCheck | Giải pháp truy xuất nguồn gốc hàng hóa </title>

    <!-- Bootstrap core CSS -->
    <link href="{{asset('public/image/favicon.png')}}" rel='shortcut icon' type='image/vnd.microsoft.icon'/>
    <link href="{{asset('public/css/bootstrap.min.css')}}" rel="stylesheet">

    <link href="{{asset('public/fonts/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/css/animate.min.css')}}" rel="stylesheet">

    <!-- Custom styling plus plugins -->
    <link href="{{asset('public/css/custom.css')}}" rel="stylesheet">
    <link href="{{asset('public/css/translateelement.css')}}" rel="stylesheet">
    <link href="{{asset('public/css/icheck/flat/green.css')}}" rel="stylesheet"/>


    <script src="{{asset('public/js/jquery.min.js')}}"></script>


    <style type="text/css">

        body {
            font-family: "Lora";
            background-color: white;
            color: #000000;
            text-align: justify;
            width: 100%;
            margin: 0 auto;
            padding: 0 auto;
            font-size: 14px;
        }

        .imageProduct {
            width: 100%;
            height: 100%;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        .imageSuccess {
            width: 30%;
            height: 30%;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        .imageLogo {
            width: 50%;
            height: 50%;
            display: block;
            margin-left: auto;
            margin-right: auto;
            margin-bottom: 3%;
            margin-top: 3%;
        }

        .content img {
            max-width: 100%;
            max-height: 100%;
            margin: 0 auto;
            border-radius: 5%;
        }

        .content {
            width: 100%;
        }

        .x_panel {
            border: none !important;
        }

        .btn {
            margin-right: 0px !important;
        }

        iframe {
            width: 100%;
            margin: 0 auto;
            padding: 0 auto;
        }

        /* lora-regular - latin */

        .goog-te-gadget span{
            display: none;
        }
        .gadget-te-gadget{
            color: white !important;
          }
        .goog-te-combo{
            color: #0c0c0c;
        }
    </style>
</head>

<body>
<center> <div id="translate_select"></div></center>

@if(!empty($data) && $data->status == 1)

    @if($type == 1)
        <div class="x_panel">
            <img class="imageSuccess" src="{{asset('public/image/check.svg')}}" alt="">
            <br>
            <p style="text-align: center;color: #049514;">
                <span style='font-weight: bold;'>SẢN PHẨM CHÍNH HÃNG</span> <br>
                Xin cảm ơn bạn đã mua hàng!
            </p>
            @if(!empty($serial))
                <p style="text-align: center;color: #ff0000;font-size: 24px">
                    Serial:{{$serial}}
                </p>
            @endif
            @if(!empty($time_scans))
                <p style="text-align: center;color: #ff0000;font-size: 12px">
                    (Số lần quét:{{$time_scans}})
                </p>
            @endif
        </div>
    @else
        <div class="x_panel">
            <img class="imageSuccess" src="{{asset('public/image/logo.jpg')}}" alt="">
            <h6 style="text-align: center;margin-right: auto;margin-left: auto;">HỆ THỐNG TRUY XUẤT NGUỒN GỐC HÀNG
                HÓA</h6>
        </div>
    @endif
    <div class="x_panel">
        <h4 style="text-align: center; "><strong>{{$data->name}}</strong></h4>
    </div>

    <div class="x_panel">
        @if($data->image)
            <img class="imageProduct" src="{{asset('public/'.$data->image)}}" alt="">
        @else
            <img class="imageProduct" src="{{ asset('public/image/noimage.png')}}" alt="">
        @endif
    </div>

    <div>
        <div>
            <a href="#sort-content" style="background-color: #338841; width: 100%"
               class="btn panel-title fieldset-legend collapse-link" data-toggle="collapse" aria-expanded="true">
                <i class="fa fa-qrcode"
                   style="color: #fff; float: left; margin-left: 5%; margin-right: 5%; margin-top: 1%"></i>

                <span style="color: #fff !important; ">
      <strong style="float: left;">THÔNG TIN CHUNG</strong>
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



    @if($data->content !== null)
        <div>
            <a href="#content" style="background-color: #338841; width: 100%"
               class="btn panel-title fieldset-legend collapse-link" data-toggle="collapse" aria-expanded="true">
                <span class="fieldset-legend-prefix element-invisible"></span>
                <i class="fa fa-search"
                   style="color: #fff; float: left; margin-left: 5%; margin-right: 5%; margin-top: 1%"></i>
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
    @endif


    @for($i= 0; $i < $data->node ; $i++)
        @foreach($nodes as $key => $value)
            @if($key == $i && $value['status'] == 1)
                <div>
                    <a href="#content{{$i}}" style="background-color: #338841; width: 100%"
                       class="btn panel-title collapse-link" data-toggle="collapse" aria-expanded="true">
                        <div class="iconfirst"><span><i class="fa fa-tag"
                                                        style="color: #fff; float: left; margin-left: 5%; margin-right: 5%; margin-top: 1%"></i></span>
                        </div>
                        <span style="color: #fff !important; "><strong
                                    style="float: left;">{{mb_strtoupper($value->name,'utf8')}}</strong><i
                                    class="ChangeIcon fa fa-chevron-down"
                                    style="float: right; margin-right: 5%;"></i></span>
                    </a>
                    <div class="panel-body panel-collapse fade collapse " id="content{{$i}}" aria-expanded="true"
                         style="">
                        <div id="content" class="btn-group content">
                            <p> {!!$value->content!!}</p>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    @endfor

    <!--{{--  nhật ký sản xuất --}}-->
    <!--<div >-->
    <!--  <a href="#process" style="background-color: #338841; width: 100%"  class="btn panel-title fieldset-legend collapse-link" data-toggle="collapse" aria-expanded="true">-->
    <!--   <div class="iconfirst">  <span><i class="fa fa-tag" style="color: #fff; float: left; margin-left: 5%; margin-right: 5%; margin-top: 1%"></i></span></div>-->
    <!--   <span style="color: #fff !important; "><strong style="float: left;">NHẬT KÝ SẢN XUẤT</strong><i class="ChangeIcon fa fa-chevron-down" style="float: right; margin-right: 5%;"></i></span>-->
    <!-- </a>-->

    <!-- <div class="panel-body panel-collapse fade collapse " id="process" aria-expanded="true" style="">-->
    <!--  <div id="process" class="btn-group content">-->

    <!--    @foreach($process as $key => $value)-->
    <!--    @if($value['status'] == 1)-->
    <!--    <legend style="color: #fff;background-color: #7fbe42;padding: 0 auto;"><strong>{{$value->name}}</strong></legend>-->
    <!--    <div><p>{!!$value->content!!} </p></div>-->
    <!--    @endif-->
    <!--    @endforeach-->

    <!--  </div>-->
    <!--</div>-->
    <!--</div>-->



    <!--{{-- end --}}-->


    @else
        <div class="x_panel">
            <img class="imageProduct" src="{{ asset('public/image/noimage.png')}}" alt="">
        </div>
        <h4 style="text-align: center;color: red;">Sản phẩm không có trong hệ thống của chúng tôi!</h4>
    @endif


    <div class="footer">
        <img class="imageLogo" src="{{asset('public/image/logo.jpg')}}" alt="" width=80%>

        <ul style="list-style: none;">
            <li>
                <p><strong>Hệ thống truy xuất nguồn gốc hàng hóa và xác thực điện tử</strong></p>
            </li>
            <li>
                <i class="fa fa-map-marker" style="float: left; margin-left: 5%; margin-right: 5%; margin-top: 1%"></i>
                <p>P207, Tòa nhà Khách sạn Thể thao, <br>
                    Số 15 Lê Văn Thiêm, Quận Thanh Xuân, Hà Nội</p>
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
    <script>
        function activated(id) {
            $.ajax({
                url: '{{ route('user.product.activated') }}',
                type: 'POST',
                data: {id: id},

                success: function success(res) {

                    if (res.status == true) {

                        toastr.success(res.message);
                        $('#product-list').DataTable().ajax.reload();
                    } else {

                        toastr.success(res.message);
                    }
                },
                error: function error(xhr, ajaxOptions, thrownError) {

                    toastr.error("Lỗi! Không thể sửa! <br>Vui lòng thử lại hoặc liên lạc với IT");
                }

            });
        }
    </script>

    <!-- /footer content -->
</body>




<script type="text/javascript"
        src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit">
</script>
<script type="text/javascript">
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({pageLanguage: 'vi'}, 'translate_select');
    }
</script>

</html>