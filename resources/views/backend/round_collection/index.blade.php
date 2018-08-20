@extends('backend.layouts.master')

@section('header')
	<style media="screen">
		.btn {
			margin-right: 10px;
		}
		.red-noti{
			color: red;
		}
	</style>
    <link rel="alternate" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/3.1.4/css/bootstrap-datetimepicker.min.css">
@endsection

@section('breadcrumb')
	<li class="active">Quản lý đợt thu hồ sơ</li>
@endsection

@section('page-title')
  {{-- <h2>Danh sách đợt thu hồ sơ</h2> --}}
@endsection

@section('content')

  <div class="panel panel-default">
      	<div class="panel-body tab-content">
		    <div class="button-container" style="margin-bottom: 10px">
		      	<a class="btn btn-info" id="btn-add"><i class="fa fa-plus"></i> Thêm mới</a>
		    </div>

		    <div class="clearfix"></div>

		    <div class="table-responsive">
				<table class="table table-bordered table-hover" id="round-collection-tbl">
					<thead>
						<tr>
							<th>STT</th>
							<th>Đợt thu hồ sơ</th>
							<th>Năm</th>
							<th>Trạng thái</th>
							<th>Thời điểm hết hạn</th>
							<th>Hành động</th>
						</tr>
					</thead>
				</table>
			</div>
      	</div>
  </div>

<div class="modal fade" id="create-collection-mdl" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Thêm đợt thu hồ sơ</h4>
      </div>
      <div class="modal-body">
				<form role="form" enctype="multipart/form-data" id="create-collection-frm">
						<div class="form-group">
								<label>Đợt thu hồ sơ <span class='error'>(*)</span></label>
								<textarea  id="name" name="name" class="form-control" rows="3" required="required"></textarea>
								{{-- <input type="text" id="name" name="name" class="form-control"/> --}}
								<span class='control-label red-noti' id="name-error-custom"></span>
						</div>
						<div class="form-group">
								<label class='control-label'>Năm <span class='error'>(*)</span></label>
					            <div class='input-group date' id='year'>
					                <input type='text' class="form-control" />
					                <span class="input-group-addon">
					                    <span class="glyphicon glyphicon-calendar">
					                    </span>
					                </span>
					            </div>
								<span class='control-label red-noti' id="year-error-custom"></span>
						</div>
						<div class="form-group">
								<label class='control-label'>Thời điểm hết hạn <span class='error'>(*)</span></label>
				                <div class='input-group date' id='expiration_time'>
				                    <input type='text' class="form-control" />
				                    <span class="input-group-addon">
				                        <span class="glyphicon glyphicon-calendar"></span>
				                    </span>
				                </div>
								<span class='control-label red-noti' id="expiration-time-error-custom"></span>
						</div>
				</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
        <button type="button" class="btn btn-primary" id="create-collection-btn">Lưu</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="edit-collection-mdl" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Sửa đợt thu hồ sơ</h4>
      </div>
      <div class="modal-body">
				<form role="form" enctype="multipart/form-data" id="edit-collection-frm">
						<div class="form-group">
								<label>Đợt thu hồ sơ <span class='error'>(*)</span></label>
								<textarea  id="edit-name" name="edit-name" class="form-control" rows="3" required="required"></textarea>
								{{-- <input type="text" id="name" name="name" class="form-control"/> --}}
								<span class='control-label red-noti' id="edit-name-error-custom"></span>
						</div>
						<div class="form-group">
								<label class='control-label'>Năm <span class='error'>(*)</span></label>
					            <div class='input-group date' id='edit-year'>
					                <input type='text' class="form-control" />
					                <span class="input-group-addon">
					                    <span class="glyphicon glyphicon-calendar">
					                    </span>
					                </span>
					            </div>
								<span class='control-label red-noti' id="edit-year-error-custom"></span>
						</div>
						<div class="form-group">
								<label class='control-label'>Thời điểm hết hạn <span class='error'>(*)</span></label>
				                <div class='input-group date' id='edit-expiration_time'>
				                    <input type='text' class="form-control" />
				                    <span class="input-group-addon">
				                        <span class="glyphicon glyphicon-calendar"></span>
				                    </span>
				                </div>
								<span class='control-label red-noti' id="edit-expiration-time-error-custom"></span>
						</div>
				</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
        <button type="button" class="btn btn-primary" id="edit-collection-btn">Lưu</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="detail-collection-mdl" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Chi tiết đợt thu hồ sơ</h4>
      </div>
      <div class="modal-body">
				<div class="form-group">
					<div class="input-group input-group-lg">
							<span class="input-group-addon"><i class="fa fa-user"></i></span>
							<span class="form-control" id="detail-name"></span>
					</div>
				</div>
				<div class="form-group">
					<div class="input-group input-group-lg">
							<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
							<span class='form-control' id="detail-year"></span>
					</div>
				</div>
				<div class="form-group">
					<div class="input-group input-group-lg">
							<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
							<span class='form-control' id="detail-expiration_time"></span>
					</div>
				</div>
				<div class="form-group">
					<div class="input-group input-group-lg">
							<span class="input-group-addon"><i id="lock-icon" class=""></i></span>
							<span class='form-control' id="detail-status"></span>
					</div>
				</div>
				<div class="form-group">
					<div class="input-group input-group-lg">
							<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
							<span class='form-control' id="detail-created_at"></span>
					</div>
				</div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('footer')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/3.1.4/js/bootstrap-datetimepicker.min.js" charset="utf-8"></script>
<script type="text/javascript" src="{{mix('build/js/round_collection.js')}}"></script>
@endsection
