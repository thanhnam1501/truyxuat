@extends('layouts.master')
@section('content')
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">						
	<div class="card mb-3">
		<div class="card-header">
			<h3><i class="fa fa-check-square-o"></i> Thêm báo giá</h3>
			
		</div>
		<a href=""></a>
		@if ($errors->any())
		<div class="alert alert-danger">{{ implode('', $errors->all(':message')) }}</div>
		@endif
		<br>
		<div class="clearfix"></div>
		<div class="card-body">
			<form action="{{route('quotes.create')}}" method="POST">

				<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
					<input type="text" class="form-control has-feedback-left" id="name" name="name" placeholder="Tên gói cước" required>
					<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
				</div>

				<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
					<select type="email" class="form-control has-feedback-left" id="time_limit" name="time_limit" placeholder="Thời hạn sử dụng" required>
						<option value="">Chọn thời gian sử dụng</option>
						<option value="12">1 năm</option>
						<option value="24">2 năm</option>
						<option value="36">3 năm</option>
						<option value="48">4 năm</option>
						<option value="64">5 năm</option>
					</select>
					<span class="fa fa-clock-o form-control-feedback left" aria-hidden="true"></span>
				</div>

				<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
					<input type="number" class="form-control has-feedback-left" id="account_limit" name="account_limit" placeholder="Giới hạn tài khoản" required>
					<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
					<input type="number" class="form-control has-feedback-left" id="product_limit" name="product_limit" placeholder="Giới hạn sản phẩm" required>
					<span class="fa fa-gift form-control-feedback left" aria-hidden="true"></span>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
					<input type="number" class="form-control has-feedback-left" id="price" name="price" placeholder="Đơn giá" required>
					<span class="fa fa-money form-control-feedback left" aria-hidden="true"></span>
				</div>
				{{ csrf_field() }}

				<button type="submit" class="btn btn-primary">Tạo mới</button>
			</form>

		</div>
	</div>
</div>

@endsection