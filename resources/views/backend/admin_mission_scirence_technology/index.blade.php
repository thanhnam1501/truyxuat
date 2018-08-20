@extends('backend.layouts.master')

@section('header')
  <link rel="stylesheet" type="text/css" id="theme" href="{{mix('build/css/mission_science_technology/mission_science_technology.css')}}"/>
    <style type="text/css">
      #science-technology-tbl .btn {
        margin-bottom: 10px;
        margin-right: 10px;
      }
  </style>
@endsection

@section('breadcrumb')
  <li class="active">
    <a href="{{ route('mission-science-technologys.index') }}">Quản lý dự án khoa học và công nghệ</a>
  </li>
@endsection

@section('page-title')
  {{-- <h2>Danh sách phiếu đề xuất</h2> --}}
@endsection

@section('content')

  <div class="panel panel-default">
      <div class="panel-body tab-content">
        <div class="button-container" style="margin-bottom: 10px">
        </div>

        <div class="clearfix"></div>

        <div class="table-responsive">
					<table class="table table-bordered table-hover" id="science-technology-tbl">
						<thead>
							<tr>
								<th>STT</th>
								<th>Mã nhiệm vụ</th>
                <th>Tên nhiệm vụ</th>
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

  <div class="modal fade" id="create-science-technology-mdl" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">ĐĂNG KÝ NHIỆM VỤ MỚI</h4>
        </div>
        <div class="modal-body">
  				<form role="form" enctype="multipart/form-data" id="create-science-technology-frm">
            <div class="form-group">
                <label>Tên nhiệm vụ <span class='error'>(*)</span></label>
                <textarea id="name" name="name" class="form-control" placeholder="Vui lòng nhập tên nhiệm vụ"></textarea>
            </div>
              <div class="form-group">
                  <label>Đợt gọi hồ sơ <span class='error'>(*)</span></label>
  								<select class="form-control" name="round_collection_id" id="round_collection_id">

                    @if (!empty($datas))
                      <option value="-1">-- Lựa chọn đợt gọi hồ sơ --</option>
                      @foreach ($datas as $data)
                          <option value="{{$data->id}}">{{ $data->year }} - {{$data->name}}</option>
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
          <button type="button" class="btn btn-success" id="create-science-technology-btn">Đăng ký</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="approve-mdl" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          {{-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> --}}
          <center><h4 class="modal-title" id="">XÁC NHẬN HỒ SƠ HỢP LỆ</h4> </center>
        </div>
        <div class="modal-body">
          <form enctype="multipart/form-data" id="approve-frm">
            <input type="hidden" name="id" id="id" value="">
            <div class="form-group col-md-12">
              <div class="col-md-3">
                <label for="">Trạng thái <span class="error">(*)</span></label>
              </div>
              <div class="col-md-9">
                <select class="form-control" name="is_performed" id="is_performed">
                  <option value="-1">Chưa cập nhập</option>
                  <option value="1">Được phê duyệt thực hiện</option>
                  <option value="0">Không được phê duyệt thực hiện</option>
                </select>
              </div>
            </div>
            <div class="form-group col-md-12">
                <div class="col-md-3">
                  <label for="">Lý do</label>
                </div>
                <div class="col-md-9">
                  <textarea id="is_unperformed_reason" name="is_unperformed_reason" class='form-control' placeholder='Trường hợp hồ sơ không hợp lệ, vui lòng nhập lý do đầy đủ' rows="5"></textarea>
                  <span class="error"></span>
                </div>
            </div>
            <div class="form-group col-md-12">
                <div class="col-md-3">
                  <label for="">Phê duyệt <span class="error">(*)</span></label>
                </div>
                <div class="col-md-9">
                  <label class="radio-inline">
                    <input type="radio" name="approve_type" value="0" checked>Giao trực tiếp
                  </label>
                  <label class="radio-inline">
                    <input type="radio" name="approve_type" value="1">Tuyển chọn
                  </label>
                </div>
            </div>
            <div class="form-group col-md-12">
                <div class="col-md-8">
                  <label for="">Quyết định danh mục nhiệm vụ được thực hiện <span class="error">(*)</span></label>
                  <br><i><span class="error">Chỉ file *.doc, *.docx, *.pdf và file dưới 5Mb được chấp nhập</span></i>
                </div>
                <div class="col-md-4">
                  <input type="file" name="list_categories" id="list_categories" accept="application/pdf, application/msword">
                </div>
            </div>
            <div class="form-group col-md-12">
                <div class="checkbox col-md-12">
                  <label>
                    <input type='checkbox' name='is_send_email' value='is_send_email' id="is_send_email" > &nbsp;Gửi email thông báo
                  </label>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Hủy bỏ</button>
          <button type="button" class="btn btn-success" id="approve-submit-btn" data-id="">Đồng ý</button>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('footer')
  <script type="text/javascript" src="{{mix('build/js/admin_mission_science_technology.js')}}"></script>
@endsection
