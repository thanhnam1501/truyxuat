@extends('layouts.master_user')
@section('content')
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">						
	<div class="card mb-3">
		<div class="card-header">
			<h3><i class="fa fa-check-square-o"></i> Gia hạn tài khoản</h3>
			<a class="btn btn-success" style="float: right" data-toggle="modal" href='#modal-id'>Báo giá</a>
		</div>
		
		@if ($errors->any())
		<div class="alert alert-danger">{{ implode('', $errors->all(':message')) }}</div>
		@endif
		<br>
		<div class="clearfix"></div>
		<div class="card-body">
			<form action="{{route('user.profile.renewalCreate')}}" method="POST">

				<div class="col-md-12 col-sm-12 col-xs-12 form-group ">
					<input type="hidden" class="form-control " id="id" name="id" value="{{ $company->id }}" readonly>
					<label >Tên công ty <span style="color: red">*</span></label>
					<input type="text" class="form-control " id="name" name="name" value="{{ $company->name }}" readonly>
					
				</div>

					<div class="col-md-12 col-sm-12 col-xs-12 form-group ">
					<label >Gói cước <span style="color: red">*</span></label>
					<select type="text" class="form-control " id="quotes_id" name="quotes_id" required>
						@foreach($quotes as $quote)
						<option value="{{$quote->id}}">{{$quote->name}}</option>
						@endforeach
					</select>
					
				</div>
				
				<div class="col-md-12 col-sm-12 col-xs-12 form-group ">
					<label for="">Ghi chú</label>
					<textarea name="content" id="editor1" class="form-control" rows="3" required="required"></textarea>
					
				</div>

				{{ csrf_field() }}

				<button type="submit" class="btn btn-primary">Gia hạn</button>
			</form>

		</div>
	</div>
</div>

<div class="modal fade" id="modal-id">
	<div class="modal-dialog" style="width: 75%">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Báo giá cước gói sử dụng dịch vụ</h4>
			</div>
			<div class="modal-body">
				<table class="table table-hover">
					<thead>
						<tr>
							<th>Tên gói cước</th>
							<th>Thời gian</th>
							<th>Số lượng tài khoản</th>
							<th>Số lượng sản phẩm</th>
							<th>Giá thành</th>
						</tr>
					</thead>
					<tbody>
						@foreach($quotes as $quote)
						<tr>
							<td>{{$quote->name}}</td>
							<td>{{$quote->time_limit}} tháng</td>
							<td>{{$quote->account_limit}} tài khoản</td>
							<td>{{$quote->product_limit}} sản phẩm</td>
							<td>{{Number_format($quote->price)}} VNĐ</td>
						</tr>
						@endforeach
						
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
			
			</div>
		</div>
	</div>
</div>

@endsection