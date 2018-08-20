@extends('backend.layouts.master')

@section('header')

<link rel="stylesheet" type="text/css" href="{{mix('build/css/mission-sxtns.css')}}">
  <style type="text/css">
      #mission-sxtns-table .btn {
        margin-bottom: 10px;
        margin-right: 10px;
      }
  </style>
@endsection

@section('breadcrumb')
    <li class="active">Quản lý dự án SXTN</li>
@endsection
@section('content')
  <div class="panel panel-default">
      <div class="panel-body tab-content">
        <div class="button-container" style="margin-bottom: 10px">
        </div>

        <div class="clearfix"></div>

      <div class="table-responsive">

          <table class="table table-bordered table-hover" id="mission-sxtns-table">
              <thead>
                  <tr>
                      <th>STT</th>
                      <th>Mã nhiệm vụ</th>
                      <th width="300px">Tên nhiệm vụ</th>
                      <th>Đơn vị</th>
                      <th>Đợt gọi hồ sơ</th>
                      <th>Ngày tạo</th>
                      <th>Trạng thái</th>
                      <th>Hành động</th>
                  </tr>
              </thead>
          </table>

      </div>
  </div>
</div>


@endsection

@section('footer')
<script type="text/javascript" src='https://cdnjs.cloudflare.com/ajax/libs/autonumeric/4.1.0/autoNumeric.min.js'></script>
{{-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script> --}}
<script type="text/javascript" src="{{mix('build/js/admin_mission_sxtns.js')}}"></script>
@endsection
