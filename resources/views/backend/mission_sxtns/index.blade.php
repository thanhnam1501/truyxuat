@extends('backend.layouts.master-company')

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
    <li class="">Danh sách nhiệm vụ</li>
    <li class="active">Dự án SXTN</li>
@endsection
@section('content')
  <div class="panel panel-default">
      <div class="panel-body tab-content">
        <div class="button-container" style="margin-bottom: 10px">
          <a href="#create-topic-mdl" class="btn btn-info addSxtn"><i class="fa fa-plus"></i> Đăng ký nhiệm vụ mới</a>
        </div>

        <div class="clearfix"></div>

    	<div class="table-responsive">

    	    <table class="table table-bordered table-hover" id="mission-sxtns-table">
    	        <thead>
    	            <tr>
                      <th>STT</th>
                      <th>Mã nhiệm vụ</th>
                      <th width="300px">Tên nhiệm vụ</th>
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

<div class="modal fade" id="create-sxtn-mdl" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">ĐĂNG KÝ NHIỆM VỤ MỚI</h4>
        </div>
        <div class="modal-body">
                <form role="form" enctype="multipart/form-data" id="create-sxtn-frm">

                    <div class="form-group">
                        <label>Tên nhiệm vụ <span class='error'>(*)</span></label>
                        <textarea id="sxtn_name" name="sxtn_name" class="form-control" placeholder="Vui lòng nhập tên nhiệm vụ"></textarea>
                    </div>

                    <div class="form-group">
                      <label>Đợi gọi hồ sơ: <span class='error'>(*)</span></label>

                      <select id="round_collection_id" name="round_collection_id" class="form-control">

                          @if (!empty($round_collections) && $round_collections != null)
                          <option value="-1">--Lựa chọn đợt gọi hồ sơ--</option>
                          @foreach ($round_collections as $round_collection)

                            <option value="{{$round_collection->id}}">{{$round_collection->year}} - {{$round_collection->name}}</option>

                          @endforeach
                          @else
                          <option value="-1">(Chưa có đợt gọi hồ sơ nào)</option>
                          @endif
                      </select>
                    </div>
                </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
          <button type="submit" class="btn btn-success" id="create-sxtn-btn">Đăng ký</button>
        </div>
      </div>
    </div>
  </div>


@endsection

@section('footer')
<script type="text/javascript" src='https://cdnjs.cloudflare.com/ajax/libs/autonumeric/4.1.0/autoNumeric.min.js'></script>
{{-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script> --}}
<script type="text/javascript" src="{{mix('build/js/mission_sxtns.js')}}"></script>
@endsection
