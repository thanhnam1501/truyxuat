@extends('backend.layouts.master-profile')

@section('header')
    <link rel="stylesheet" type="text/css" id="theme" href="{{mix('build/css/mission_science_technology/mission_science_technology.css')}}"/>
@endsection

@section('breadcrumb')
  <li class=""><a href="{{ route('home.list-missions') }}">Danh sách nhiệm vụ</a></li>
  <li class="">
    <a href="{{ route('missionScienceTechnology.edit',$st_key) }}">Dự án khoa học và công nghệ</a>
  </li>

  <li class="active">Xem chi tiết</li>
@endsection

@section('page-title')
@endsection

@section('content')
  <div class="panel panel-default">
    <div class="panel-body">
      <div class="col-md-12">
        <h3><i class="fa fa-book" aria-hidden="true"></i> ĐĂNG KÝ NHIỆM VỤ DÙNG CHO DỰ ÁN KHOA HỌC VÀ CÔNG NGHỆ</h3> <br>
      </div>

      <div class="clearfix"></div>

      <div class="panel panel-default tabs">
          <ul class="nav nav-tabs" role="tablist">
            <li class="active"><a href="#tab-form" role="tab" data-toggle="tab"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>&nbsp; Xem chi tiết</a></li>
          </ul>
      </div>

      <div class="panel-body tab-content">
        <div class="tab-pane active" id="tab-form">
          <div class="col-md-12">
            <center>
              <br>
              <h3>PHIẾU ĐỀ XUẤT ĐẶT HÀNG NHIỆM VỤ</h3>
              <h3>KHOA HỌC VÀ CÔNG NGHỆ CẤP QUỐC GIA</h3>
              <h4><i>(Dùng cho dự án khoa học và công nghệ)</i></h4>
            </center>
            <br>
          </div>
            <div class="col-md-12">
              @if (isset($data))
                @foreach ($data as $key => $value)
                  <div class="form-group">
                    @php
                      $files = [15, 16];
                      $value['order'] = $value['order'] == 13 ? 12.1 : $value['order'];
                      $value['order'] = $value['order'] == 14 ? 12.2 : $value['order'];
                    @endphp

                    @if (!in_array($value['order'], $files))
                      <h5><b>{{ $value['order'] }}. </b>{!! $value['label'] !!}</h5>
                    @endif

                    @if ($value['order'] != 12)
                      @if (!in_array($value['order'], $files))
                        <h5>{{ $value['value'] }}</h5>
                      @endif
                      <br>
                    @endif
                  </div>
                @endforeach
              @endif
            </div>

            <div class="col-md-12"> <br><br><br>
              <div class="col-md-offset-6 col-md-6 col-xs-12">
                <div style="float: right">
                    <center>
                      <h5>....., ngày {{(!empty($date))?$date['d']:"....."}} tháng {{(!empty($date))?$date['m']:"....."}} năm {{(!empty($date))?$date['y']:"20..."}}</h5> <br>
                      <b><h4>TỔ CHỨC, CÁ NHÂN ĐỀ XUẤT</h4></b>
                      <h4><i>(Họ, tên và chữ ký - đóng dấu đối với tổ chức)</i></h4>
                    </center>
                </div>

                <br><br><br><br><br><br><br><br><br><br><br><br>
              </div>
            </div>
        </div>

        </div>
      </div>
      <div class="panel-footer">
        <div class="col-md-8">
          <h5><span class="error">(*)</span> Ghi chú: <br>- <i>Phiếu đề xuất được trình bày không quá 6 trang giấy khổ A4</i> <br>- <i>Các mục <span class="error">(*)</span> là bắt buộc</i></h5>
        </div>

        <div class="col-md-4" style="text-align: right"> <div class="col-md-12">
          @if ($is_filled)

            @if (!$is_submit_ele_copy)

              <button class="btn btn-info" id="btn_submit_ele_copy" data-key="{{ $st_key }}" data-is_submit_ele_copy="1">

                <i class="fa fa-paper-plane" aria-hidden="true"></i> Nộp bản mềm
              </button>

              {{-- <button class="btn btn-success"id="update-science-technology-btn"><i class="fa fa-floppy-o" aria-hidden="true"></i> Lưu thông tin</button> --}}

            @endif

            @if ($is_submit_ele_copy)
              <a href="javascript:;" class="btn btn-info" id="btn_submit_ele_copy" data-key="{{ $st_key }}" data-is_submit_ele_copy="0">
                <i class="fa fa-pencil" aria-hidden="true"></i>&nbsp; &nbsp; Sửa bản mềm
              </a>

              <a href="{!! route('missionScienceTechnology.print',  $st_key) !!}" class="btn btn-success" target="_blank"><i class='fa fa-print'></i> &nbsp; In phiếu đề xuất</a>
            @endif

          @else
            {{-- <button class="btn btn-success"id="update-science-technology-btn"><i class="fa fa-floppy-o" aria-hidden="true"></i> Lưu thông tin</button> --}}
          @endif

        </div> </div>
      </div>
    </div>
  </div>
@endsection

@section('footer')
  <script type="text/javascript" src="{{mix('build/js/mission_science_technology/mission_science_technology.js')}}"></script>
@endsection
