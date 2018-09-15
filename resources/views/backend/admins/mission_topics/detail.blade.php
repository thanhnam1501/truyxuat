@extends('backend.layouts.master')

@section('breadcrumb')
<li class="">Danh sách nhiệm vụ</li>
<li><a href="{{ route('admin.mission-topics.index') }}">Đề tài hoặc đề án</a></li>
<li class="active">Xem chi tiết</li>
@endsection

@section('page-title')

@endsection

@section('content')

  <div class="panel panel-default">
    <div class="panel-body">
      <div class="col-md-12">
        <h3><i class="fa fa-book" aria-hidden="true"></i> CHI TIẾT NHIỆM VỤ DÙNG CHO ĐỀ TÀI HOẶC ĐỀ ÁN</h3> <br>
      </div>

      <div class="clearfix"></div>

      <div class="panel-body tab-content">
        <div class="tab-pane active" id="tab-form">
          <div class="col-md-12">
            <center>
              <br>
              <h3>PHIẾU ĐỀ XUẤT ĐẶT HÀNG NHIỆM VỤ</h3>
              <h3>KHOA HỌC VÀ CÔNG NGHỆ CẤP QUỐC GIA</h3>
              <h4><i>(Dùng cho đề tài hoặc đề án)</i></h4>
            </center>
            <br>
          </div>
          <div class="col-md-12">
              @if (isset($data) && !empty($data))
                  @foreach ($data as $key => $value)
                 <div class='form-group'>
                   @if ($value["column"] == "expected_effect")
                     <h5><b>{{ $value["order"] }}. {!! $value["label"] !!}</b></h5>
                   @elseif ($value['column'] != "evaluation_form_01" && $value['column'] != "evaluation_form_02")
                     <h5><b>{{ $value["order"] }}. {!! $value["label"] !!}</b></h5>
                     <h5 class='text_value' style="text-align: justify;">{!! nl2br(e($value["value"])) !!}</h5>
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
            <a href="{{ route('admin.mission-topics.print', $topic->key) }}"class="btn btn-success" style="float: right;" target="_blank"><i class='fa fa-print'></i> In phiếu đề xuất</a>
        </div>
      </div>
    </div>
  </div>
</form>
@endsection

@section('footer')
<script type="text/javascript" src="{{mix('build/js/mission_topic.js')}}"></script>
@endsection
