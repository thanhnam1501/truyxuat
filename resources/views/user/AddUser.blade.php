@extends('layouts.master_user')
@section('content')
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">						
	<div class="card mb-3">
		<div class="card-header">
			<h3><i class="fa fa-check-square-o"></i> Thêm người dùng</h3>
			
		</div>
		@if ($errors->any())
		<div class="alert alert-danger">{{ implode('', $errors->all(':message')) }}</div>
		@endif
		<br>
		<div class="clearfix"></div>
		<div class="card-body">
			<form action="{{route('user.profile.create')}}" method="POST">

				<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
					<input type="text" class="form-control has-feedback-left" id="name" name="name" placeholder="Họ và Tên" value="{{ old('name') }}" required>
					<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
				</div>

				<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
					<input type="email" class="form-control has-feedback-left" id="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
					<span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
					<select type="number" class="form-control has-feedback-left" id="mobile" name="mobile" placeholder="Số điện thoại" value="{{ old('mobile') }}" required> 
						<option value="">Chọn chức năng</option>
						<option value="2">Quản trị viên</option>
						<option value="3">Biên tập viên</option>
					</select>
					<span class="fa fa-eyedropper form-control-feedback left" aria-hidden="true"></span>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
					<input type="number" class="form-control has-feedback-left" id="mobile" name="mobile" placeholder="Số điện thoại" value="{{ old('mobile') }}" required>
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