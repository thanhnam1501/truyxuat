<!DOCTYPE html>
<html lang="en">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SmartCheck | Giải pháp chống giả cho bạn ! </title>

    <!-- Bootstrap core CSS -->
    <link href="{{asset('public/image/favicon.png')}}" rel='shortcut icon' type='image/vnd.microsoft.icon'/>
    <link href="{{asset('public/css/bootstrap.min.css')}}" rel="stylesheet">

    <link href="{{asset('public/fonts/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/css/animate.min.css')}}" rel="stylesheet">


    <!-- Custom styling plus plugins -->
    <link href="{{asset('public/css/custom.css')}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('public/css/maps/jquery-jvectormap-2.0.1.css')}}"/>
    <link href="{{asset('public/css/icheck/flat/green.css')}}" rel="stylesheet"/>
    <link href="{{asset('public/css/floatexamples.css')}}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="{{asset('public/css/datatables.min.css')}}"/>
    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.css">
    <script src="{{asset('public/ckeditor/ckeditor.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{asset('public/css/summernote.css')}}">


    <!--[if lt IE 9]>
    <script src="../assets/js/ie8-responsive-file-warning.js"></script>
    <![endif]-->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body class="nav-md">

<div class="container body">


    <div class="main_container">

        <div class="col-md-3 left_col">
            <div class="left_col scroll-view">

                <div class="navbar nav_title" style="border: 0;">
                    <a href="{{route('admin.user.index')}}" class="site_title">
                        <img class="fa" style="width: 24px;height: 24px; border-radius: 50%;"
                             src="{{asset('public/image/favicon.png')}}" alt="">

                        <span style="color: red">S</span><span>mart<span style="color: red">C</span>heck</span></a>
                </div>
                <div class="clearfix"></div>

                <!-- menu prile quick info -->
                <div class="profile">
                    <div class="profile_pic">
                        <img src="{{asset('public/image/hello.gif')}}" alt="..." class="img-circle profile_img">
                    </div>
                    <div class="profile_info">
                        <span>Chào,</span>
                        <h2>{{Auth::guard('web')->user()->name}}</h2>
                    </div>
                </div>
                <!-- /menu prile quick info -->

                <br/>

                <!-- sidebar menu -->
                <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

                    <div class="menu_section">
                        <div class="clearfix"></div>
                        <ul class="nav side-menu">
                            {{--      <li><a><i class="fa fa-home"></i> HỆ THỐNG <span class="fa fa-chevron-down"></span></a>
                                   <ul class="nav child_menu" style="display: none">
                                     <li><a href="index.html">Cấu hình APP</a>
                                     </li>
                                     <li><a href="index2.html">Quản trị tài khoản</a>
                                     </li>
                                     <li><a href="index3.html">...</a>
                                     </li>
                                   </ul>
                                 </li> --}}
                            <li><a><i class="fa fa-bank"></i> DOANH NGHIỆP <span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu" style="display: none">
                                    <li><a href="{{route('company.ShowFormCreate')}}">Thêm doanh nghiệp</a>
                                    </li>
                                    <li><a href="{{route('company.index')}}">Quản lý doanh nghiệp</a>
                                    </li>

                                </ul>
                            </li>

                            <li><a><i class="fa fa-cubes"></i>SẢN PHẨM<span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu" style="display: none">
                                    <li><a href="{{route('product.index')}}">Tất cả sản phẩm</a>
                                    </li>
                                    <li><a href="{{route('product.ShowFormCreate')}}">Thêm mới sản phẩm</a>
                                    </li>
                                </ul>
                            </li>

                            <li><a><i class="fa fa-users"></i>TÀI KHOẢN<span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu" style="display: none">
                                    <li><a href="{{route('admin.user.index')}}">Quản trị viên</a>
                                    </li>
                                    <li><a href="{{route('profile.index')}}">Người dùng</a>
                                    </li>

                                </ul>
                            </li>

                            <li><a><i class="fa fa-qrcode"></i>IN MÃ QRCODE<span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu" style="display: none">
                                    <li><a href="{{route('qrcode.ShowFormCreate')}}">In mã QR-Code</a>
                                    <li><a href="{{route('qrcode.index')}}">Nhật ký in</a>
                                    <li><a href="{{route('qrcode.getRestore')}}">Khôi phục mã QR-Code</a>
                                    </li>
                                    {{--    <li><a href="{{route('qrcode.ShowFormCreate')}}">Tạo mới khối QR-Code</a>
                                       </li>
                                       <li><a href="{{route('qrcode.index')}}">Danh sách khối</a> --}}

                                    {{--  <li><a href="">Lịch sử quét</a>
                                     </li> --}}

                                </ul>
                            </li>

                            <li><a><i class="fa fa-history"></i>LỊCH SỬ<span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu" style="display: none">
                                    <li><a href="{{route('qrcode.history.index')}}">Lịch sử quét</a>
                                    </li>

                                </ul>
                            </li>

                            <li><a><i class="fa fa-edit"></i>CÁC BƯỚC CẬP NHÂT<span
                                            class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu" style="display: none">
                                    <li><a href="{{route('node.index')}}">DS các bước cập nhật</a>
                                    </li>

                                </ul>
                            </li>
                            <li><a><i class="fa fa-money"></i>GIA HẠN<span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu" style="display: none">
                                    <li><a href="{{route('renewal.index')}}">Doanh nghiệp gia hạn</a>
                                    </li>

                                    <li><a href="{{route('quotes.index')}}">Báo giá</a>
                                    </li>

                                </ul>
                            </li>

                        </ul>
                    </div>
                    <div class="menu_section">
                        <img src="{{asset('public/image/smc.gif')}}" width="100%" alt="">

                    </div>

                </div>
                <!-- /sidebar menu -->

                <!-- /menu footer buttons -->

                <!-- /menu footer buttons -->
            </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">

            <div class="nav_menu">
                <nav class="" role="navigation">
                    <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                    </div>

                    <ul class="nav navbar-nav navbar-right">
                        <li class="">
                            <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown"
                               aria-expanded="false">
                                {{Auth::guard('web')->user()->name}}
                                <span class=" fa fa-angle-down"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-usermenu animated fadeInDown pull-right">
                                <li><a href="{{route('user.change-password')}}"> Đổi mật khẩu</a>
                                </li>

                                <li><a href="{{route('profile.logout')}}"><i class="fa fa-sign-out pull-right"></i> Đăng
                                        xuất</a>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </nav>
            </div>

        </div>
        <!-- /top navigation -->


        <!-- page content -->
        <div class="right_col">
            @yield('content')
        </div>
        <!-- /page content -->
        <footer>
            <div class="">
                <p class="pull-right">Công ty Cổ phần Giải pháp Chống giả An Hà – AnHaCorp |
                    <span class="lead"> <img class="fa" style="width: 24px;height: 24px; border-radius: 50%;"
                                             src="{{asset('image/favicon.png')}}" alt=""> <span
                                style="color: red">S</span><span>mart<span style="color: red">C</span>heck</span></span>
                </p>
            </div>

        </footer>
    </div>

</div>

<div id="custom_notifications" class="custom-notifications dsp_none">
    <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
    </ul>
    <div class="clearfix"></div>
    <div id="notif-group" class="tabbed_notifications"></div>
</div>
<!-- /footer content -->
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script src="{{asset('public/js/jquery.min.js')}}"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="{{asset('public/js/nprogress.js')}}"></script>
<script>
    NProgress.start();
</script>
<script src="{{asset('public/js/bootstrap.min.js')}}"></script>
<script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.js"></script>

<!-- gauge js -->
{{--   <script type="text/javascript" src="{{asset('public/js/gauge/gauge.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('public/js/gauge/gauge_demo.js')}}"></script> --}}
<!-- chart js -->
<script src="{{asset('public/js/chartjs/chart.min.js')}}"></script>
<!-- bootstrap progress js -->
<script src="{{asset('public/js/progressbar/bootstrap-progressbar.min.js')}}"></script>
<script src="{{asset('public/js/nicescroll/jquery.nicescroll.min.js')}}"></script>
<!-- icheck -->
<script src="{{asset('public/js/icheck/icheck.min.js')}}"></script>
<!-- daterangepicker -->
<script type="text/javascript" src="{{asset('public/js/moment.min.js')}}"></script>
<script type="text/javascript" src="{{asset('public/js/datepicker/daterangepicker.js')}}"></script>

<script src="{{asset('public/js/custom.js')}}"></script>
<script type="text/javascript" src="{{asset('public/js/summernote.js')}}"></script>

<!-- flot js -->
<!--[if lte IE 8]>
<script type="text/javascript" src="js/excanvas.min.js"></script><![endif]-->
<script type="text/javascript" src="{{asset('public/js/flot/jquery.flot.js')}}"></script>
<script type="text/javascript" src="{{asset('public/js/flot/jquery.flot.pie.js')}}"></script>
<script type="text/javascript" src="{{asset('public/js/flot/jquery.flot.orderBars.js')}}"></script>
<script type="text/javascript" src="{{asset('public/js/flot/jquery.flot.time.min.js')}}"></script>
<script type="text/javascript" src="{{asset('public/js/flot/date.js')}}"></script>
<script type="text/javascript" src="{{asset('public/js/flot/jquery.flot.spline.js')}}"></script>
<script type="text/javascript" src="{{asset('public/js/flot/jquery.flot.stack.js')}}"></script>
<script type="text/javascript" src="{{asset('public/js/flot/curvedLines.js')}}"></script>
<script type="text/javascript" src="{{asset('public/js/flot/jquery.flot.resize.js')}}"></script>

<script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
{!! Toastr::render() !!}

<script type="text/javascript" src="{{asset('public/js/datatables.min.js')}}"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
<script>
    $(document).ready(function () {
        // [17, 74, 6, 39, 20, 85, 7]
        //[82, 23, 66, 9, 99, 6, 2]
        var data1 = [[gd(2012, 1, 1), 17], [gd(2012, 1, 2), 74], [gd(2012, 1, 3), 6], [gd(2012, 1, 4), 39], [gd(2012, 1, 5), 20], [gd(2012, 1, 6), 85], [gd(2012, 1, 7), 7]];

        var data2 = [[gd(2012, 1, 1), 82], [gd(2012, 1, 2), 23], [gd(2012, 1, 3), 66], [gd(2012, 1, 4), 9], [gd(2012, 1, 5), 119], [gd(2012, 1, 6), 6], [gd(2012, 1, 7), 9]];
        $("#canvas_dahs").length && $.plot($("#canvas_dahs"), [
            data1, data2
        ], {
            series: {
                lines: {
                    show: false,
                    fill: true
                },
                splines: {
                    show: true,
                    tension: 0.4,
                    lineWidth: 1,
                    fill: 0.4
                },
                points: {
                    radius: 0,
                    show: true
                },
                shadowSize: 2
            },
            grid: {
                verticalLines: true,
                hoverable: true,
                clickable: true,
                tickColor: "#d5d5d5",
                borderWidth: 1,
                color: '#fff'
            },
            colors: ["rgba(38, 185, 154, 0.38)", "rgba(3, 88, 106, 0.38)"],
            xaxis: {
                tickColor: "rgba(51, 51, 51, 0.06)",
                mode: "time",
                tickSize: [1, "day"],
                //tickLength: 10,
                axisLabel: "Date",
                axisLabelUseCanvas: true,
                axisLabelFontSizePixels: 12,
                axisLabelFontFamily: 'Verdana, Arial',
                axisLabelPadding: 10
                //mode: "time", timeformat: "%m/%d/%y", minTickSize: [1, "day"]
            },
            yaxis: {
                ticks: 8,
                tickColor: "rgba(51, 51, 51, 0.06)",
            },
            tooltip: false
        });

        function gd(year, month, day) {
            return new Date(year, month - 1, day).getTime();
        }
    });
</script>

<!-- worldmap -->
<script type="text/javascript" src="{{asset('public/js/maps/jquery-jvectormap-2.0.1.min.js')}}"></script>
<script type="text/javascript" src="{{asset('public/js/maps/gdp-data.js')}}"></script>
<script type="text/javascript" src="{{asset('public/js/maps/jquery-jvectormap-world-mill-en.js')}}"></script>
<script type="text/javascript" src="{{asset('public/js/maps/jquery-jvectormap-us-aea-en.js')}}"></script>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript " src="{{asset('public/ckeditor/ckeditor.js')}}">
</script>
<script>
    var options = {
        filebrowserImageBrowseUrl: '{{ asset('public/laravel-filemanager?type=Images')}}',
        filebrowserImageUploadUrl: '{{ asset('public/laravel-filemanager/upload?type=Images&_token=')}}',
        filebrowserBrowseUrl: '{{ asset('public/laravel-filemanager?type=Files')}}',
        filebrowserUploadUrl: '{{ asset('public/laravel-filemanager/upload?type=Files&_token=')}}'
    };
</script>
<script>
    CKEDITOR.replace('editor1', options);
    CKEDITOR.replace('editor2', options);
    CKEDITOR.replace('editor3', options);
    CKEDITOR.replace('editor4', options);
    CKEDITOR.replace('editor5', options);
    CKEDITOR.replace('editor6', options);
    CKEDITOR.replace('editor7', options);
    CKEDITOR.replace('editor8', options);
    CKEDITOR.replace('editor9', options);
    CKEDITOR.replace('editor10', options);
    CKEDITOR.replace('editor11', options);
    CKEDITOR.replace('editor12', options);
    CKEDITOR.replace('editor13', options);
    CKEDITOR.replace('editor14', options);
    CKEDITOR.replace('editor15', options);
</script>
{{--   <script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script> --}}
{{-- <script>
  CKEDITOR.replace( 'article-ckeditor' );
</script> --}}

@yield('script')
<script>
    $(function () {
        $('#world-map-gdp').vectorMap({
            map: 'world_mill_en',
            backgroundColor: 'transparent',
            zoomOnScroll: false,
            series: {
                regions: [{
                    values: gdpData,
                    scale: ['#E6F2F0', '#149B7E'],
                    normalizeFunction: 'polynomial'
                }]
            },
            onRegionTipShow: function (e, el, code) {
                el.html(el.html() + ' (GDP - ' + gdpData[code] + ')');
            }
        });
    });
</script>
<!-- skycons -->
<script src="{{asset('js/skycons/skycons.js')}}"></script>
{{--  <script>
   var icons = new Skycons({
     "color": "#73879C"
   }),
   list = [
   "clear-day", "clear-night", "partly-cloudy-day",
   "partly-cloudy-night", "cloudy", "rain", "sleet", "snow", "wind",
   "fog"
   ],
   i;

   for (i = list.length; i--;)
     icons.set(list[i], list[i]);

   icons.play();
 </script> --}}

<!-- dashbord linegraph -->
{{-- <script>
  var doughnutData = [
  {
    value: 30,
    color: "#455C73"
  },
  {
    value: 30,
    color: "#9B59B6"
  },
  {
    value: 60,
    color: "#BDC3C7"
  },
  {
    value: 100,
    color: "#26B99A"
  },
  {
    value: 120,
    color: "#3498DB"
  }
  ];
  var myDoughnut = new Chart(document.getElementById("canvas1").getContext("2d")).Doughnut(doughnutData);
</script> --}}
<!-- /dashbord linegraph -->
<!-- datepicker -->
<script type="text/javascript">
    $(document).ready(function () {

        var cb = function (start, end, label) {
            console.log(start.toISOString(), end.toISOString(), label);
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            //alert("Callback has fired: [" + start.format('MMMM D, YYYY') + " to " + end.format('MMMM D, YYYY') + ", label = " + label + "]");
        }

        var optionSet1 = {
            startDate: moment().subtract(29, 'days'),
            endDate: moment(),
            minDate: '01/01/2012',
            maxDate: '12/31/2015',
            dateLimit: {
                days: 60
            },
            showDropdowns: true,
            showWeekNumbers: true,
            timePicker: false,
            timePickerIncrement: 1,
            timePicker12Hour: true,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            opens: 'left',
            buttonClasses: ['btn btn-default'],
            applyClass: 'btn-small btn-primary',
            cancelClass: 'btn-small',
            format: 'MM/DD/YYYY',
            separator: ' to ',
            locale: {
                applyLabel: 'Submit',
                cancelLabel: 'Clear',
                fromLabel: 'From',
                toLabel: 'To',
                customRangeLabel: 'Custom',
                daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                firstDay: 1
            }
        };
        $('#reportrange span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
        $('#reportrange').daterangepicker(optionSet1, cb);
        $('#reportrange').on('show.daterangepicker', function () {
            console.log("show event fired");
        });
        $('#reportrange').on('hide.daterangepicker', function () {
            console.log("hide event fired");
        });
        $('#reportrange').on('apply.daterangepicker', function (ev, picker) {
            console.log("apply event fired, start/end dates are " + picker.startDate.format('MMMM D, YYYY') + " to " + picker.endDate.format('MMMM D, YYYY'));
        });
        $('#reportrange').on('cancel.daterangepicker', function (ev, picker) {
            console.log("cancel event fired");
        });
        $('#options1').click(function () {
            $('#reportrange').data('daterangepicker').setOptions(optionSet1, cb);
        });
        $('#options2').click(function () {
            $('#reportrange').data('daterangepicker').setOptions(optionSet2, cb);
        });
        $('#destroy').click(function () {
            $('#reportrange').data('daterangepicker').remove();
        });
    });
</script>
<script>
    NProgress.done();
</script>
<!-- /datepicker -->
<!-- /footer content -->
</body>

</html>
