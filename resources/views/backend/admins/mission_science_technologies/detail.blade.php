@extends('backend.layouts.master')

@section('breadcrumb')
  <li class="">Danh sách nhiệm vụ</li>
  <li class=""><a href="{{ route('admin.mission-science-technologies.index') }}">Dự án khoa học và công nghệ</a></li>
  <li class="active">Xem chi tiết</li>
@endsection

@section('page-title')
@endsection

@section('content')
  <div class="panel panel-default">
    <div class="panel-body">
      <div class="col-md-12">
        <h3><i class="fa fa-book" aria-hidden="true"></i> CHI TIẾT NHIỆM VỤ DÙNG CHO DỰ ÁN KHOA HỌC VÀ CÔNG NGHỆ</h3> <br>
      </div>

      <div class="clearfix"></div>

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
                        <h5 class='text_value' style="text-align: justify;">{!! nl2br(e($value["value"])) !!}</h5>
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
    </div>
  </div>
@endsection

@section('footer')
@endsection
