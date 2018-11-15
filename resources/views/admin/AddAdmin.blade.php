@extends('layouts.master')
@section('content')
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">						
	<div class="card mb-3">
		<div class="card-header">
			<h3><i class="fa fa-check-square-o"></i> Thêm quản trị viên</h3>
			
		</div>
		@if ($errors->any())
		<div class="alert alert-danger">{{ implode('', $errors->all(':message')) }}</div>
		@endif
		<br>
		<div class="clearfix"></div>
		<div class="card-body">
			<form action="{{route('user.create')}}" method="POST">

				<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
					<input type="text" class="form-control has-feedback-left" id="name" name="name" placeholder="Họ và Tên" required>
					<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
				</div>

				<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
					<input type="email" class="form-control has-feedback-left" id="email" name="email" placeholder="Email" required>
					<span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
				</div>

				<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
					<input type="phone" class="form-control has-feedback-left" id="mobile" name="mobile" placeholder="Số điện thoại" required>
					<span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
					<input type="password" class="form-control has-feedback-left" id="password" name="password" placeholder="Mật khẩu" required>
					<span class="fa fa-lock form-control-feedback left" aria-hidden="true"></span>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
					<input type="password" class="form-control has-feedback-left" id="password_confirmation" name="password_confirmation" placeholder="Xác nhận mật khẩu" required>
					<span class="fa fa-lock form-control-feedback left" aria-hidden="true"></span>
				</div>
				{{ csrf_field() }}

				<button type="submit" class="btn btn-primary">Tạo mới</button>
			</form>

		</div>
	</div>
</div>

@endsection