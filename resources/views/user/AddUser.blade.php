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
					<input type="text" class="form-control has-feedback-left" id="name" name="name" placeholder="Họ và Tên" required>
					<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
				</div>

				<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
					<input type="email" class="form-control has-feedback-left" id="email" name="email" placeholder="Email" required>
					<span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
				</div>

				{{ csrf_field() }}

				<button type="submit" class="btn btn-primary">Tạo mới</button>
			</form>

		</div>
	</div>
</div>

@endsection