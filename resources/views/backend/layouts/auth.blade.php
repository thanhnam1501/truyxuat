<!DOCTYPE html>
<html lang="en" class="body-full-height">
    <head>        
        <!-- META SECTION -->
        <title>2075 | Chương trình phát triển thị trường</title>            
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <link rel="icon" href="{{asset('img/icon.png')}}" type="image/x-icon" />
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
		{{-- <link rel="stylesheet" type="text/css" id="theme" href="{{mix('build/css/theme-white.css')}}"/> --}}
		<link rel="stylesheet" type="text/css" id="theme" href="{{mix('build/css/admin/login.css')}}"/>
		
		@yield('header')
    </head>
    <body>
		<!-- Load Facebook SDK for JavaScript -->
		<div id="fb-root"></div>
		<script>(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = 'https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js#xfbml=1&version=v2.12&autoLogAppEvents=1';
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>

		<!-- Your customer chat code -->
		<div class="fb-customerchat"
		  attribution=setup_tool
		  page_id="217093748844415"
		  theme_color="#0074ba"
		  logged_in_greeting="Xin chào! Bạn cần trợ giúp?"
		  logged_out_greeting="Xin chào! Bạn cần trợ giúp?">
		</div>

		<div class="container-fluid">
			<div class="row" id="header">
				<div class="col-md-3">
					<div class="left-logo">
						<center><img src="{{asset('img/quoc-huy.png')}}" alt="Loading.." class="img-responsive"></center>
					</div>
				</div>
				<div class="col-md-6">
					<div class="content">
						<p>bộ khoa học và công nghệ</p><span>chương trình phát triển thị trường 2075</span>
					</div>
				</div>
				<div class="col-md-3">
					<div class="right-logo">
						<img src="{{ asset('img/logo.png') }}" alt="loading...">
					</div>
				</div>
			</div>
			<div id="login-box">
				@yield('content')
			</div><!-- /#login-box -->
		</div><!-- /.container -->
		<div id="particles-js"></div>
    </body>

	<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="{{mix('build/js/login.js')}}"></script>

	@yield('footer')
</html>
