@extends('backend.layouts.auth')

@section('content')
<div class="logo">
	<h1 class="logo-caption">Đăng nhập</h1>
</div><!-- /.logo -->
<div class="controls">
	<form class="form-horizontal" method="post" action="{{ route('admin_login.submit') }}" aria-label="">

		@csrf

		<div class="form-group">
			<div class="col-md-12">
				<input id="email" type="email" name="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Email" value="{{ old('email') }}" required autofocus>
				@if ($errors->has('email'))
				<span class=“help-block” role="alert">
					<div style="color:red"><strong>{{ $errors->first('email') }}</strong></div>
				</span>
				@endif
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-12">
				<input type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" id="password" placeholder="Mật khẩu"/>
			</div>

			@if ($errors->has('password'))
			<span class=“help-block” role="alert">
				<div style="color:red"><strong>{{ $errors->first('password') }}</strong></div>
			</span>
			@endif

		</div>
		<div class="form-group">
			<div class="col-md-6 remember-checkbox">
				<input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

				<label class="form-check-label" for="remember">
					Ghi nhớ mật khẩu
				</label>
			</div>
			<div class="col-md-6">
				<button class="btn login-btn btn-block" type="submit">Đăng nhập</button>
			</div>
			<div class="col-md-12">
				<hr>
				<a href="{{ route('password.request') }}" class="btn-link">Quên mật khẩu?</a>	
			</div>
		</div>
		<div class="login-footer">
			&copy; 2018 Zent Software
		</div>
	</form>
</div><!-- /.controls -->
@endsection
