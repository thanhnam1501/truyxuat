@extends('backend.layouts.master-profile')

@section('header')
  <style type="text/css">
      #topic-tbl .btn {
        margin-bottom: 10px;
        margin-right: 10px;
      }
  </style>
@endsection

@section('breadcrumb')
  <li class="">Danh sách nhiệm vụ</li>
  <li class="active">Đề tài hoặc đề án</li>
@endsection

@section('page-title')

@endsection

@section('content')

  <div class="panel panel-default">
      <div class="panel-body tab-content">
        <div class="button-container" style="margin-bottom: 10px">
          <a href="javascript:;" style="margin-left: 10px" id="create-topic-mdl-btn" class="btn btn-info"><i class="fa fa-plus"></i> Đăng ký nhiệm vụ mới</a>
        </div>

        <div class="clearfix"></div>

        <div class="table-responsive">
					<table class="table table-bordered table-hover" id="topic-tbl">
						<thead>
							<tr>
								<th>STT</th>
								<th>Mã số nhiệm vụ</th>
                <th>Tên nhiệm vụ</th>
								<th>Loại nhiệm vụ</th>
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

  <div class="modal fade" id="create-topic-mdl" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">ĐĂNG KÝ NHIỆM VỤ MỚI</h4>
        </div>
        <div class="modal-body">
  				<form role="form" enctype="multipart/form-data" id="create-topic-frm">
  						<div class="form-group">
  								<label>Tên nhiệm vụ <span class='error'>(*)</span></label>
  								<textarea id="name" name="name" class="form-control" placeholder="Tên nhiệm vụ" placeholder="Vui lòng nhập tên nhiệm vụ"></textarea>
  						</div>
              <div class="form-group">
                  <label>Đợt gọi hồ sơ <span class='error'>(*)</span></label>
  								<select class="form-control" name="round_collection_id">
                    <option value="-1">--Vui lòng chọn đợt gọi hồ sơ--</option>
                    @if (!empty($datas))
                        @foreach ($datas as $data)
                            <option value="{{$data->id}}">{{$data->year ." - ". $data->name}}</option>
                        @endforeach
                      @else
                      <option value="-1">(Chưa có đợt gọi hồ sơ nào)</option>
                      @endif
                  </select>
  						</div>
              <div class="form-group">
                <label for="type">Loại nhiệm vụ <span class='error'>(*)</span></label><br>
                <label class="radio-inline">
                  <input type="radio" name="type" checked value="0">Đề tài
                </label>
                <label class="radio-inline">
                  <input type="radio" name="type" value="1">Đề án
                </label>
              </div>
  				</form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
          <button type="button" class="btn btn-success" id="create-topic-btn">Đăng ký</button>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('footer')
  <script type="text/javascript" src="{{mix('build/js/mission_topic.js')}}"></script>
@endsection
