{{-- <!DOCTYPE html>
<html lang="en" class="body-full-height">
    <head>
        <!-- META SECTION -->
        <title>NATEC | HỆ THỐNG QUẢN LÝ NHIỆM VỤ KHOA HỌC VÀ CÔNG NGHỆ CẤP QUỐC GIA</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <link rel="icon" href="{{asset('img/icon.png')}}" type="image/x-icon" />
		<link rel="stylesheet" type="text/css" id="theme" href="{{mix('build/css/theme-white.css')}}"/>
		<link rel="stylesheet" type="text/css" id="theme" href="{{mix('build/css/scientist/login.css')}}"/>
    </head>
    <body>
		<div class="login-container">
		    <div class="login-box animated fadeInDown">
		        <div class="login-logo">
		        	<img src="{{ asset('img/logo.png') }}" alt="loading...">
		        </div>
		        <div class="login-body">
		            <form class="form-horizontal" method="POST" action="{{ route('profile.login.submit') }}">
		            	{{ csrf_field() }}
		            	<div class=form-group>
		            		@if (session('register-success'))
							    <div class="col-md-12">
							    	<div class="alert alert-success">
								        {{ session('register-success') }}
								    </div>
							    </div>
							@endif

							@if (session('confirm-register-success'))
							    <div class="col-md-12">
							    	<div class="alert alert-success">
								        {{ session('confirm-register-success') }}
								    </div>
							    </div>
							@endif

							@if (session('confirm-register-error'))
							    <div class="col-md-12">
							    	<div class="alert alert-danger">
								        {{ session('confirm-register-error') }}
								    </div>
							    </div>
							@endif
		            	</div>
			            <div class="form-group">
			                <div class="col-md-12">
			                    <input type="text" class="form-control" placeholder="Email" id="email" name="email" value="{{ old("email") }}" />

			                    @if ($errors->has('email'))
		                            <span class="help-block">
		                                <div style="color:red;"><strong>{{ $errors->first('email') }}</strong></div>
		                            </span>
		                        @endif
			                </div>
			            </div>

			            <div class="form-group">
			                <div class="col-md-12">
			                    <input type="password" class="form-control" placeholder="Mật khẩu" id="password" name="password" value="{{ old("password") }}"/>

			                    @if ($errors->has('password'))
		                            <span class="help-block">
		                                <div style="color:red;"><strong>{{ $errors->first('password') }}</strong></div>
		                            </span>
		                        @endif
			                </div>
			            </div>

			            <div class="form-group">
			                <div class="col-md-6 remember-checkbox">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        Ghi nhớ mật khẩu
                                    </label>
			                </div>

			            	<div class="col-md-6">
			                    <button type="submit" class="btn btn-info btn-block">Đăng nhập</button>
			                </div>

							<div class="col-md-12">
								<hr>
				                <div class="col-md-6 btn-fogot">
				                    <a href="{{ route('profile.password.request') }}" class="btn btn-link btn-block dt-right">Quên mật khẩu?</a>
				                </div>
				                <div class="col-md-6 btn-register">
									<a href="{{ route('profile.register') }}" class="btn btn-link btn-block dt-right">Đăng ký tài khoản</a>
				                </div>
							</div>
			            </div>
		            </form>
		        </div>
		        <div class="login-footer">
		            <div class="pull-left">
		                &copy; 2018 Zent Software
		            </div>
		        </div>
		    </div>

		</div>
    </body>
</html>
--}}
@extends('backend.layouts.auth')

<style>

	.note-register {

    color: white;

    border-bottom: 1px white solid;

    padding-bottom: 15px;

}



.note-register a {

	font-size: 14px;

	font-weight: 400;

}


</style>

@section('content')
<div class="logo">
	<h1 class="logo-caption">Đăng nhập</h1>
</div><!-- /.logo -->
<div class="controls">
	<form class="form-horizontal" method="POST" action="{{ route('profile.login.submit') }}">
		{{ csrf_field() }}
		<div class=form-group>
			@if (session('register-success'))
			<div class="col-md-12">
				<div class="alert alert-success">
					{{ session('register-success') }}
				</div>
			</div>
			@endif

			@if (session('confirm-register-success'))
			<div class="col-md-12">
				<div class="alert alert-success">
					{{ session('confirm-register-success') }}
				</div>
			</div>
			@endif

			@if (session('confirm-register-error'))
			<div class="col-md-12">
				<div class="alert alert-danger">
					{{ session('confirm-register-error') }}
				</div>
			</div>
			@endif
		</div>
		<div class="form-group">
			<div class="col-md-12">
				<input type="text" class="form-control" placeholder="Email" id="email" name="email" value="{{ old("email") }}" />

				@if ($errors->has('email'))
				<span class="help-block">
					<div style="color:red;"><strong>{{ $errors->first('email') }}</strong></div>
				</span>
				@endif
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-12">
				<input type="password" class="form-control" placeholder="Mật khẩu" id="password" name="password" value="{{ old("password") }}"/>

				@if ($errors->has('password'))
				<span class="help-block">
					<div style="color:red;"><strong>{{ $errors->first('password') }}</strong></div>
				</span>
				@endif
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-6 remember-checkbox">
				<input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

				<label class="form-check-label" for="remember">
					Ghi nhớ mật khẩu
				</label>
			</div>

			<div class="col-md-6">
				<button type="submit" class="btn login-btn btn-block">Đăng nhập</button>
			</div>
			<br>
			<br>
			<div class="col-md-12">
				
				<h6 class="note-register">Nếu chưa có tài khoản, vui lòng <a class="btn-link" href="{{ route('profile.register') }}">Đăng ký tài khoản</a></h6>

				<div class="col-md-6 btn-fogot custom-col-left">
					<a href="{{ route('profile.password.request') }}" class="btn-link">Quên mật khẩu?</a>
				</div>
				<div class="col-md-6 btn-register custom-col-right">
					{{-- <a href="{{ route('profile.register') }}" class="btn-link">Đăng ký tài khoản</a> --}}
				</div>
				<br>
				
			</div>

			<div class="col-md-12" style="margin-top: 10px">
				<h6 class="" style="color: white;">Hotline hỗ trợ kỹ thuật: <a href="tel:0918010473" style="font-size: 14px">0918010473</a> (Mr. Hiệp)</h6>
			</div>

		</div>
	</form>
</div>
<div class="login-footer">
	<center>&copy; 2018 Zent Software</center>
</div>
</div><!-- /.controls -->
@endsection
