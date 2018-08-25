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
@endsection

@section('breadcrumb')
	<li class="active">Quản lý nhóm hội đồng</li>
@endsection

@section('page-title')
  {{-- <h2>Danh sách nhóm hội đồng</h2> --}}
@endsection

@section('content')

  <div class="panel panel-default">
      	<div class="panel-body tab-content">
		    <div class="button-container" style="margin-bottom: 10px">
		      	<a class="btn btn-info" id="btn-add"><i class="fa fa-plus"></i> Thêm mới</a>
		    </div>

		    <div class="clearfix"></div>

		    <div class="table-responsive">
				<table class="table table-bordered table-hover" id="group-council-tbl">
					<thead>
						<tr>
							<th>STT</th>
							<th>Tên nhóm hội đồng</th>
							<th>Trạng thái</th>
							<th>Hành động</th>
						</tr>
					</thead>
				</table>
			</div>
      	</div>
  </div>

<div class="modal fade" id="create-group-mdl" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Thêm nhóm hội đồng</h4>
      </div>
      <div class="modal-body">
			<form role="form" enctype="multipart/form-data" id="create-group-frm">
				<div class="form-group">
					<label>Tên nhóm hội đồng <span class='error'>(*)</span></label>
					<textarea  id="name" name="name" class="form-control" required="required"></textarea>
					{{-- <input type="text" id="name" name="name" class="form-control"/> --}}
					<span class='control-label red-noti' id="name-error-custom"></span>
				</div>

				<div class="form-group">
					<label for="">Chức năng <span class='error'>(*)</span></label>
					<select class="form-control" name="type" id="type">
		                <option value="-1">--Vui lòng chọn chức năng--</option>
		                @if ($optionValues != null)
		                	@foreach ($optionValues as $optionValue)
		                		<option value="{{$optionValue->value}}">{{$optionValue->name}}</option>
		                	@endforeach
		                @endif
		            </select>
				</div>

			</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
        <button type="button" class="btn btn-primary" id="create-group-btn">Lưu</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="edit-group-mdl" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Sửa nhóm hội đồng</h4>
      </div>
      <div class="modal-body">
			<form role="form" enctype="multipart/form-data" id="edit-group-frm">

				<div class="form-group">
					<label>Đợt thu hồ sơ <span class='error'>(*)</span></label>
					<textarea  id="edit-name" name="edit-name" class="form-control" required="required"></textarea>
					{{-- <input type="text" id="name" name="name" class="form-control"/> --}}
					<span class='control-label red-noti' id="edit-name-error-custom"></span>
				</div>

				<div class="form-group">
					<label for="">Chức năng <span class='error'>(*)</span></label>
					<select class="form-control" name="edit-type" id="edit-type">
		                <option value="-1">--Vui lòng chọn chức năng--</option>
		                @if ($optionValues != null)
		                	@foreach ($optionValues as $optionValue)
		                		<option value="{{$optionValue->value}}">{{$optionValue->name}}</option>
		                	@endforeach
		                @endif
		            </select>
				</div>

			</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
        <button type="button" class="btn btn-primary" id="edit-group-btn">Lưu</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="detail-group-mdl" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Chi tiết nhóm hội đồng</h4>
      </div>
      <div class="modal-body">
				<div class="form-group">
					<div class="input-group input-group-lg">
							<span class="input-group-addon"><i class="fa fa-globe"></i></span>
							<span class="form-control" id="detail-name"></span>
					</div>
				</div>
				<div class="form-group">
					<div class="input-group input-group-lg">
							<span class="input-group-addon"><i class="fa fa-adjust"></i></span>
							<span class='form-control' id="detail-status"></span>
					</div>
				</div>
				<div class="form-group">
					<div class="input-group input-group-lg">
							<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
							<span class='form-control' id="detail-created_at"></span>
					</div>
				</div>

				<div class="form-group">
					<div class="input-group input-group-lg">
							<span class="input-group-addon"><i class="fa fa-cog"></i></span>
							<span class='form-control' id="detail-type"></span>
					</div>
				</div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('footer')
<script type="text/javascript" src="{{mix('build/js/group_council.js')}}"></script>
@endsection
