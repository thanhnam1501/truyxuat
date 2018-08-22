@extends('backend.layouts.master-profile')

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
  <li class="">Danh sách nhiệm vụ</li>
  <li class="active">
    <a href="{{ route('missionScienceTechnology.index') }}">Dự án khoa học và công nghệ</a>
  </li>
@endsection

@section('page-title')
  {{-- <h2>Danh sách phiếu đề xuất</h2> --}}
@endsection

@section('content')

  <div class="panel panel-default">
      <div class="panel-body tab-content">
        <div class="button-container" style="margin-bottom: 10px">
          <a href="#create-science-technology-mdl" data-toggle="modal" class="btn btn-info" id="register-mission-btn"><i class="fa fa-plus"></i> Đăng ký nhiệm vụ mới</a>
        </div>

        <div class="clearfix"></div>

        <div class="table-responsive">
					<table class="table table-bordered table-hover" id="science-technology-tbl">
						<thead>
							<tr>
								<th>STT</th>
								<th>Mã nhiệm vụ</th>
								<th>Tên nhiệm vụ</th>
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

  
@endsection

@section('footer')
  <script type="text/javascript" src="{{mix('build/js/mission_science_technology/mission_science_technology.js')}}"></script>
@endsection
