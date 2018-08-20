<!DOCTYPE html>
<html lang="en" class="body-full-height">
    <head>
        <!-- META SECTION -->
        <title>NATEC | HỆ THỐNG QUẢN LÝ NHIỆM VỤ KHOA HỌC VÀ CÔNG NGHỆ CẤP QUỐC GIA</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <link rel="icon" href="{{asset('img/icon.png')}}" type="image/x-icon" />
		<link rel="stylesheet" type="text/css" id="theme" href="{{mix('build/css/theme-white.css')}}"/>
    </head>
    <body>
		<div class="login-container">
		    <div class="login-box animated fadeInDown">
		        <div class="login-logo">
		        	<img src="{{ asset('img/logo.png') }}" alt="loading...">
		        </div>
		        <div class="login-body">
		            <form class="form-horizontal" method="post">
		            <div class="form-group">
		                <div class="col-md-12">
		                    <input type="text" class="form-control" placeholder="Nhập email"/>
		                </div>
		            </div>
		            <div class="form-group">
		                <div class="col-md-12">
		                    <input type="password" class="form-control" placeholder="Mật khẩu"/>
		                </div>
		            </div>
		            <div class="form-group">
		                <div class="col-md-6">
		                    <a href="#" class="btn btn-link btn-block dt-right">Quên mật khẩu?</a>
		                </div>
		                <div class="col-md-6">
		                    <button class="btn btn-info btn-block">Đăng nhập</button>
		                </div>
		            </div>
		            </form>
		        </div>
		        <div class="login-footer">
		            <div class="pull-left">
		                &copy; 2018 Natec
		            </div>
		        </div>
		    </div>

		</div>
    </body>
</html>
