@extends('layouts.master')
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
			<form action="{{route('profile.create')}}" method="POST">

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
					<select class="form-control has-feedback-left" name="company_id" id="company_id">
						<option class="active">Chọn doanh nghiệp</option>
						@foreach($companies as $company)
						<option value="{{$company->id}}">{{$company->name}}</option>
						@endforeach
					</select>
					<span class="fa fa-university form-control-feedback left" aria-hidden="true"></span>
					{{-- <input type="s" class="form-control has-feedback-left" id="company_id" name="company_id" placeholder="Số điện thoại" required>
					<span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span> --}}
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