<!DOCTYPE html>
<html lang="en">
<head>
    <!-- META SECTION -->
    <title>2075 | Chương trình phát triển thị trường</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="website" content="{{ asset('') }}">

    <link rel="icon" href="{{asset('img/icon.png')}}" type="image/x-icon" />
    <!-- END META SECTION -->

    <!-- CSS INCLUDE -->
    <link rel="stylesheet" type="text/css" id="theme" href="{{mix('build/css/theme-blue.css')}}"/>
    <link rel="stylesheet" type="text/css" id="theme" href="{{asset('css/toastr.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="{{mix('build/css/customer.css')}}">

    @yield('header')
    <style media="screen">
    .error{
        color:red;
    }
    .table>caption+thead>tr:first-child>th, .table>colgroup+thead>tr:first-child>th, .table>thead:first-child>tr:first-child>th, .table>caption+thead>tr:first-child>td, .table>colgroup+thead>tr:first-child>td, .table>thead:first-child>tr:first-child>td {
        text-align: center !important;
    }
    #cover {
      position: fixed;
      width: 100%;
      min-height: 100%;
      z-index: 999999;
      background: rgba(255, 255, 255, 0.3);
      text-align: center;
      display: none;
  }
  #cover img {
      margin-top: 23%;
  }

  #avatar-profile{
    position: relative;
    width: 100px;
    height: 100px;
}
.profile-image:hover #change-avatar {
    display: block;

}
#change-avatar{
   width: 100px;
   height: 100px;
   background: rgba(0,0,0,0.7);
   display: none;
   position: absolute;
   left: 27.05%;
   top: 9.1%;
   border-radius: 19%;
   opacity: 50%;

}

.change-avatar{
    color: rgba(255,255,255,1);
    text-decoration: none;

}

</style>
<!-- EOF CSS INCLUDE -->
</head>
<body>
    <!-- START PAGE CONTAINER -->
    <div class="page-container">
        <div id="cover" class=""><img src="{{ asset('img/load.svg') }}"></div>
        <!-- START PAGE SIDEBAR -->
        <div class="page-sidebar">
            <!-- START X-NAVIGATION -->
            <ul class="x-navigation">
                <li class="xn-logo">
                    <a href="{{ route('profile') }}">2075</a>
                    <a href="#" class="x-navigation-control"></a>
                </li>
                <li class="xn-profile">
                    <a href="" class="profile-mini">
                        <img src="{{ asset('img/icon.png') }}" alt="Admin"/>
                    </a>
                    <div class="profile">
                        <div class="profile-image">
                            @if(Auth::guard('profile')->user()->avatar == null)
                                <img id="avatar-profile" src="{{ asset('img/avatar/default.jpg')}}" alt="Admin"/>
                            @else
                            <img id="avatar-profile" src="{{ asset("storage/".Auth::guard('profile')->user()->avatar) }}" alt="Admin"/>

                            @endif
                            <div id="change-avatar">
                                <form id="img-upload-form" enctype="multipart/form-data" role="form">
                                    <a href="#" onclick="document.getElementById('add-new-logo').click();" class="change-avatar"><span style="margin-top: 30%;" class="fa fa-camera" ></span><p >Cập nhật</p></a>
                                    <input type="file" style="display: none" id="add-new-logo" name="file" accept="image/*"/>
                                </form>
                            </div>
                        </div>
                        <div class="profile-data">
                            <div class="profile-data-name">{{(Auth::guard('profile')->user()->representative != null) ? Auth::guard('profile')->user()->representative : "Chưa cập nhật"}}</div>
                        </div>
                        <div class="profile-controls">
                            <a href="{{route('profile.change-password')}}" class="profile-control-left"><span class="fa fa-info"></span></a>
                            <a href="#" class="profile-control-right"><span class="fa fa-envelope"></span></a>
                        </div>
                    </div>
                </li>
                {{-- <li class="xn-title">Navigation</li> --}}
                {{-- <li class="@if(Request::is('*/')) active @endif">
                    <a href="{{asset('')}}"><span class="fa fa-desktop"></span> <span class="xn-text">Bảng điều khiển</span></a>
                </li> --}}

                <li class=" @if(Request::is('*mission*')) active @endif" >
                    <a href="{{ route('home.list-missions') }}" ><span class="fa fa-list-ul"></span><span>Danh sách nhiệm vụ</span></a>

                    {{-- <ul>
                        <li class="@if(Request::is('*mission-topics*')) active @endif">
                            <a href="{!! route('missionTopic.index') !!}"><span>A1</span><span class="xn-text">. Đề tài hoặc đề án</span></a>
                        </li>

                        <li class="@if(Request::is('*mission-sxtn*')) active @endif">
                            <a href="{{ route('mission-sxtn.index') }}"><span>A2</span><span class="xn-text">. Dự án SXTN</span></a>

                        </li>
                        <li class="@if(Request::is('*mission-science-technology*')) active @endif">
                            <a href="{{ route('missionScienceTechnology.index') }}"> <span>A3</span><span class="xn-text">. Dự án khoa học và công nghệ</span></a>
                        </li>
                    </ul> --}}
                </li>


            </ul>
            <!-- END X-NAVIGATION -->
        </div>
        <!-- END PAGE SIDEBAR -->

        <!-- PAGE CONTENT -->
        <div class="page-content">

            <!-- START X-NAVIGATION VERTICAL -->
            <ul class="x-navigation x-navigation-horizontal x-navigation-panel">
             <li class="xn-icon-button pull-right">
                <a href="#" class="mb-control" data-box="#mb-signout"><span class="fa fa-sign-out"></span></a>
            </li>
            <!-- END SIGN OUT -->
            <!-- MESSAGES -->
            {{-- <li class="xn-icon-button pull-right">
                <a href="#"><span class="fa fa-comments"></span></a>
                <div class="informer informer-danger">4</div>
                <div class="panel panel-primary animated zoomIn xn-drop-left xn-panel-dragging">
                    <div class="panel-heading">
                        <h3 class="panel-title"><span class="fa fa-comments"></span> Tin nhắn</h3>
                        <div class="pull-right">
                            <span class="label label-danger">4 tin mới</span>
                        </div>
                    </div>
                    <div class="panel-body list-group list-group-contacts scroll" style="height: 200px;">
                        <a href="#" class="list-group-item">
                            <div class="list-group-status status-online"></div>
                            <img src="assets/images/users/user2.jpg" class="pull-left" alt="John Doe"/>
                            <span class="contacts-title">Thông báo</span>
                            <p>Thúc đẩy sự phát triển của hệ sinh thái khởi nghiệp sáng tạo quốc gia</p>
                        </a>
                        <a href="#" class="list-group-item">
                            <div class="list-group-status status-away"></div>
                            <img src="assets/images/users/user.jpg" class="pull-left" alt="Dmitry Ivaniuk"/>
                            <span class="contacts-title">Thông báo</span>
                            <p>Cải thiện Chỉ số đổi mới sáng tạo toàn cầu (GII)</p>
                        </a>
                        <a href="#" class="list-group-item">
                            <div class="list-group-status status-away"></div>
                            <img src="assets/images/users/user3.jpg" class="pull-left" alt="Nadia Ali"/>
                            <span class="contacts-title">Thông báo</span>
                            <p>Cải thiện môi trường kinh doanh của doanh nghiệp</p>
                        </a>
                        <a href="#" class="list-group-item">
                            <div class="list-group-status status-offline"></div>
                            <img src="assets/images/users/user6.jpg" class="pull-left" alt="Darth Vader"/>
                            <span class="contacts-title">Thông báo</span>
                            <p>Tăng cường năng lực tiếp cận cuộc Cách mạng công nghiệp lần thứ tư</p>
                        </a>
                    </div>
                    <div class="panel-footer text-center">
                        <a href="#">Hiển thị tất cả các tin nhắn</a>
                    </div>
                </div>
            </li> --}}
            <!-- END MESSAGES -->
            <!-- TASKS -->
            {{-- <li class="xn-icon-button pull-right">
                <a href="#"><span class="fa fa-tasks"></span></a>
                <div class="informer informer-warning">3</div>
                <div class="panel panel-primary animated zoomIn xn-drop-left xn-panel-dragging">
                    <div class="panel-heading">
                        <h3 class="panel-title"><span class="fa fa-tasks"></span> Nhiệm vụ</h3>
                        <div class="pull-right">
                            <span class="label label-warning">3 Nhiệm vụ</span>
                        </div>
                    </div>
                    <div class="panel-body list-group scroll" style="height: 200px;">
                        <a class="list-group-item" href="#">
                            <strong>Triển khai thực hiện các giải pháp để tháo gỡ khó khăn, vướng mắc trong thủ tục, hồ sơ đăng ký doanh nghiệp KH&CN</strong>
                            <div class="progress progress-small progress-striped active">
                                <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%;">50%</div>
                            </div>
                            <small class="text-muted">John Doe, 25 Sep 2014 / 50%</small>
                        </a>
                        <a class="list-group-item" href="#">
                            <strong>Thực hiện đồng bộ các giải pháp nâng cao năng suất, chất lượng sản phẩm, hàng hóa</strong>
                            <div class="progress progress-small progress-striped active">
                                <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%;">80%</div>
                            </div>
                            <small class="text-muted">Dmitry Ivaniuk, 24 Sep 2014 / 80%</small>
                        </a>
                        <a class="list-group-item" href="#">
                            <strong>Chủ động triển khai các nhiệm vụ, giải pháp cụ thể để tăng cường năng lực tiếp cận xu hướng công nghệ tiên tiến, hiện đại của cuộc CMCN4.0</strong>
                            <div class="progress progress-small progress-striped active">
                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100" style="width: 95%;">95%</div>
                            </div>
                            <small class="text-muted">John Doe, 23 Sep 2014 / 95%</small>
                        </a>
                        <a class="list-group-item" href="#">
                            <strong> Tiếp tục triển khai chính sách sử dụng, trọng dụng cá nhân hoạt động KH&CN</strong>
                            <div class="progress progress-small">
                                <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">100%</div>
                            </div>
                            <small class="text-muted">John Doe, 21 Sep 2014 /</small><small class="text-success"> Done</small>
                        </a>
                    </div>
                    <div class="panel-footer text-center">
                        <a href="#">Hiển thị tất cả</a>
                    </div>
                </div>
            </li> --}}

        </ul>
        <!-- END X-NAVIGATION VERTICAL -->

        <!-- START BREADCRUMB -->
            <ul class="breadcrumb">
                <li><a href="#">Bảng điều khiển</a></li>

                @yield('breadcrumb')

            </ul>
            <!-- END BREADCRUMB -->

            <!-- PAGE TITLE -->
            <div class="page-title">
                @yield('page-title')
            </div>
            <!-- END PAGE TITLE -->

            <!-- PAGE CONTENT WRAPPER -->
            <div class="page-content-wrap">

                <!-- START WIDGETS -->
                <div class="row">
                 {{-- <div class="col-xs-12"> --}}
                  @yield('content')
              {{-- </div> --}}
          </div>

          <!-- END DASHBOARD CHART -->

      </div>
      <!-- END PAGE CONTENT WRAPPER -->
  </div>
  <!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->

<!-- MESSAGE BOX-->

<div class="message-box animated fadeIn" data-sound="alert" id="mb-signout">
    <div class="mb-container">
        <div class="mb-middle">
            <div class="mb-title"><span class="fa fa-sign-out"></span> Đăng xuất</div>
            <div class="mb-content">
                <p>Bạn có chắc muốn đăng xuất?</p>

            </div>
            <div class="mb-footer">
                <div class="pull-right">
                    <a href="{{ route('profile.logout') }}" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();"
                    class="btn btn-success btn-lg">Có</a>
                    <form id="logout-form" action="{{ route('profile.logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <button class="btn btn-default btn-lg mb-control-close">Không</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- END MESSAGE BOX-->

<!-- END MESSAGE BOX-->

<!-- START PRELOADS -->
<audio id="audio-alert" src="{{asset('audio/alert.mp3')}}" preload="auto"></audio>
<audio id="audio-fail" src="{{asset('audio/fail.mp3')}}" preload="auto"></audio>
<!-- END PRELOADS -->

<!-- START SCRIPTS -->
<!-- START PLUGINS -->
<script type="text/javascript" src="{{asset('js/plugins/jquery/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/plugins/jquery/jquery-ui.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/plugins/bootstrap/bootstrap.min.js')}}"></script>
<!-- END PLUGINS -->

<!-- START THIS PAGE PLUGINS-->
<script type='text/javascript' src='{{asset('js/plugins/icheck/icheck.min.js')}}'></script>
<script type='text/javascript' src='{{asset('js/plugins/toastr.min.js')}}'></script>
<script type="text/javascript" src="{{asset('js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/plugins/scrolltotop/scrolltopcontrol.js')}}"></script>

<script type="text/javascript" src="{{asset('js/plugins/morris/raphael-min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/plugins/morris/morris.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/plugins/rickshaw/d3.v3.js')}}"></script>

<script type="text/javascript" src="{{asset('js/plugins/rickshaw/rickshaw.min.js')}}"></script>
<script type='text/javascript' src='{{asset('js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}'></script>
<script type='text/javascript' src='{{asset('js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}'></script>
<script type='text/javascript' src='{{asset('js/plugins/bootstrap/bootstrap-datepicker.js')}}'></script>
<script type="text/javascript" src="{{asset('js/plugins/owl/owl.carousel.min.js')}}"></script>

<script type="text/javascript" src="{{asset('js/plugins/moment.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/plugins/daterangepicker/daterangepicker.js')}}"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap.min.js"></script>

<!-- END THIS PAGE PLUGINS-->

<script type="text/javascript" src="{{asset('js/plugins.js')}}"></script>
<script type="text/javascript" src="{{asset('js/actions.js')}}"></script>

<script type="text/javascript" src="{!! asset('js/plugins/autoNumeric-min.js') !!}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.min.js"></script>

<script type="text/javascript" src="{{mix('build/js/global.js')}}"></script>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript" src="{{mix('build/js/change-avatar.js')}}"></script>

<!-- END TEMPLATE -->
<!-- END SCRIPTS -->

<script type="text/javascript">

    $(document).ready(function () {
     $(document).ajaxStart(function () {
       $("#cover").show();
   }).ajaxStop(function () {
       $("#cover").hide();
   });
});


    var max_file_size="{{env('MAX_FILE_SIZE')}}";
// console.log(max_file_size);
</script>


@yield('footer')
</body>
</html>
