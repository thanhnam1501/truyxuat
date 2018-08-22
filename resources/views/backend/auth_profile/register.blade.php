{{-- <!DOCTYPE html>
<html lang="en" class="body-full-height">
    <head>
        <!-- META SECTION -->
        <title>NATEC | HỆ THỐNG QUẢN LÝ NHIỆM VỤ KHOA HỌC VÀ CÔNG NGHỆ CẤP QUỐC GIA</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <meta name="website" content="{{ asset('') }}">

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
		            <form class="form-horizontal" method="POST" action="{{ route('profile.register.submit') }}">
		            	{{ csrf_field() }}
						<legend class="form-title">Đăng ký tài khoản</legend>
		            	<div class="form-group">
			                <div class="col-md-12">
			                    <input type="text" class="form-control" placeholder="MST / Mã quan hệ ngân sách nhà nước" id="tax_code" name="tax_code" value="{{ old("tax_code") }}" />

			                    @if ($errors->has('tax_code'))
		                            <span class="help-block">
		                                <div style="color:red;"><strong>{{ $errors->first('tax_code') }}</strong></div>
		                            </span>
		                        @endif
			                </div>
			            </div>

		            	<div class="form-group">
			                <div class="col-md-12">
			                    <input type="text" class="form-control" placeholder="Tên đơn vị (trùng với tên trên con dấu)" id="name" name="name" value="{{ old("name") }}" />
			                    @if ($errors->has('name'))
		                            <span class="help-block">
		                                <div style="color:red;"><strong>{{ $errors->first('name') }}</strong></div>
		                            </span>
		                        @endif
			                </div>
			            </div>


						<div class="form-group">
			                <div class="col-md-12">
			                    <input type="text" class="form-control" placeholder="Người liên hệ" id="representative" name="representative" value="{{ old("representative") }}" />

			                    @if ($errors->has('representative'))
		                            <span class="help-block">
		                                <div style="color:red;"><strong>{{ $errors->first('representative') }}</strong></div>
		                            </span>
		                        @endif
			                </div>
			            </div>

						<div class="form-group">
			                <div class="col-md-12">
			                    <input type="text" class="form-control" placeholder="Số điện thoại" id="mobile" name="mobile" value="{{ old("mobile") }}" />

			                    @if ($errors->has('mobile'))
		                            <span class="help-block">
		                                <div style="color:red;"><strong>{{ $errors->first('mobile') }}</strong></div>
		                            </span>
		                        @endif
			                </div>
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
			                <div class="col-md-12">
			                    <input type="password" class="form-control" placeholder="Xác nhận mật khẩu" id="password_confirmation" name="password_confirmation" value="{{ old("password_confirmation") }}"/>

			                    @if ($errors->has('password_confirmation'))
		                            <span class="help-block">
		                                <div style="color:red;"><strong>{{ $errors->first('password_confirmation') }}</strong></div>
		                            </span>
		                        @endif
			                </div>
			            </div>

			            <div class="form-group">
			            	<div class="col-md-6">
			                </div>

			            	<div class="col-md-6">
			                    <button type="submit" class="btn btn-info btn-block">Đăng ký</button>
			                </div>

							<div class="col-md-12">
								<hr>
				                <div class="col-md-6 btn-fogot">
				                	<a href="{{ route('profile.login') }}" class="btn btn-link btn-block dt-right">Đăng nhập</a>
				                </div>
				                <div class="col-md-6 btn-register">
									<a data-toggle="modal" href='#register-guide' class="btn btn-link btn-block dt-right">Hướng dẫn đăng ký</a>
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

		<div class="modal fade" id="register-guide">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title">Hướng dẫn đăng ký</h4>
					</div>
					<div class="modal-body">
						<ul>
							<li><b>Mã số thuế:</b> mỗi đơn vị có một tài khoản duy nhất, mã số thuế trùng với mã doanh nghiệp đã đăng ký.</li>
							<li><b>Tên đơn vị:</b> tên đơn vị trùng với tên trên con dấu.</li>
							<li><b>Email:</b> địa chỉ email cần chính xác để có thể xác nhận tài khoản đăng ký.<br><b>(*)</b> Vui lòng kiểm tra email để kích hoạt tài khoản.</li>
						</ul>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
					</div>
				</div>
			</div>
		</div>

	<!-- START SCRIPTS -->
        <!-- START PLUGINS -->
        <script type="text/javascript" src="{{asset('js/plugins/jquery/jquery.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/plugins/jquery/jquery-ui.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/plugins/bootstrap/bootstrap.min.js')}}"></script>
        <!-- END PLUGINS -->

        <!-- START THIS PAGE PLUGINS-->
        <script type='text/javascript' src='{{asset('js/plugins/icheck/icheck.min.js')}}'></script>

        <script type="text/javascript" src="{{asset('js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/plugins/scrolltotop/scrolltopcontrol.js')}}"></script>

        <script type="text/javascript" src="{{asset('js/plugins/morris/raphael-min.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/plugins/morris/morris.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/plugins/rickshaw/d3.v3.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/plugins/rickshaw/rickshaw.min.js')}}"></script>
        <script type='text/javascript' src='{{asset('js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}'></script>
        <script type='text/javascript' src='{{asset('js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}'></script>
        <script type='text/javascript' src='{{asset('js/plugins/bootstrap/bootstrap-datepicker.js')}}'></script>
        <script type="text/javascript" src="{{asset('js/plugins/owl/owl.carousel.min.js')}}"></script>

        <script type="text/javascript" src="{{asset('js/plugins/moment.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/plugins/daterangepicker/daterangepicker.js')}}"></script>

        <script type="text/javascript" src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>

 		<script type="text/javascript" src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap.min.js"></script>

        <!-- END THIS PAGE PLUGINS-->

        <script type="text/javascript" src="{{asset('js/plugins.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/actions.js')}}"></script>

		<script type="text/javascript" src="{{mix('build/js/global.js')}}"></script>

        <!-- END TEMPLATE -->
    <!-- END SCRIPTS -->
    <script type="text/javascript" id="theme" src="{{mix('build/js/register.js')}}"></script>

    </body>

    </html> --}}

@extends('backend.layouts.auth')

@section('content')
    <div class="logo">
    	<h1 class="logo-caption">Đăng ký</h1>
    </div><!-- /.logo -->
    <div class="controls">
    	<form class="form-horizontal" method="POST" action="{{ route('profile.register.submit') }}">
    		{{ csrf_field() }}
    		<div class="form-group">
    			<div class="col-md-12">
    				<input type="text" class="form-control" placeholder="MST / Mã quan hệ ngân sách nhà nước" id="tax_code" name="tax_code" value="{{ old("tax_code") }}" />

    				@if ($errors->has('tax_code'))
    				<span class="help-block">
    					<div style="color:red;"><strong>{{ $errors->first('tax_code') }}</strong></div>
    				</span>
    				@endif
    			</div>
    		</div>

    		<div class="form-group">
    			<div class="col-md-12">
    				<input type="text" class="form-control" placeholder="Tên đơn vị (trùng với tên trên con dấu)" id="name" name="name" value="{{ old("name") }}" />
    				@if ($errors->has('name'))
    				<span class="help-block">
    					<div style="color:red;"><strong>{{ $errors->first('name') }}</strong></div>
    				</span>
    				@endif
    			</div>
    		</div>


    		<div class="form-group">
    			<div class="col-md-12">
    				<input type="text" class="form-control" placeholder="Người đăng ký (*)" id="representative" name="representative" value="{{ old("representative") }}" />

    				@if ($errors->has('representative'))
    				<span class="help-block">
    					<div style="color:red;"><strong>{{ $errors->first('representative') }}</strong></div>
    				</span>
    				@endif
    			</div>
    		</div>

    		<div class="form-group">
    			<div class="col-md-12">
    				<input type="text" class="form-control" placeholder="Số điện thoại (*)" id="mobile" name="mobile" value="{{ old("mobile") }}" />

    				@if ($errors->has('mobile'))
    				<span class="help-block">
    					<div style="color:red;"><strong>{{ $errors->first('mobile') }}</strong></div>
    				</span>
    				@endif
    			</div>
    		</div>


    		<div class="form-group">
    			<div class="col-md-12">
    				<input type="text" class="form-control" placeholder="Email (*)" id="email" name="email" value="{{ old("email") }}" />

    				@if ($errors->has('email'))
    				<span class="help-block">
    					<div style="color:red;"><strong>{{ $errors->first('email') }}</strong></div>
    				</span>
    				@endif
    			</div>
    		</div>


    		<div class="form-group">
    			<div class="col-md-12">
    				<input type="password" class="form-control" placeholder="Mật khẩu (*)" id="password" name="password" value="{{ old("password") }}"/>

    				@if ($errors->has('password'))
    				<span class="help-block">
    					<div style="color:red;"><strong>{{ $errors->first('password') }}</strong></div>
    				</span>
    				@endif
    			</div>
    		</div>

    		<div class="form-group">
    			<div class="col-md-12">
    				<input type="password" class="form-control" placeholder="Xác nhận mật khẩu" id="password_confirmation" name="password_confirmation" value="{{ old("password_confirmation") }}"/>

    				@if ($errors->has('password_confirmation'))
    				<span class="help-block">
    					<div style="color:red;"><strong>{{ $errors->first('password_confirmation') }}</strong></div>
    				</span>
    				@endif
    			</div>
    		</div>

    		<div class="form-group">
    			<div class="col-md-6">
    			</div>

    			<div class="col-md-6">
    				<button type="submit" class="btn login-btn btn-block">Đăng ký</button>
    			</div>

    			<div class="col-md-12">
    				<h6 class="note-register">Nếu đã có tài khoản, vui lòng <a class="btn-link" href="{{ route('profile.login') }}">Đăng nhập</a></h6>

    				
    				<div class="col-md-6 btn-register custom-col-left">
    					<a data-toggle="modal" href='#register-guide' class="btn-link">Hướng dẫn đăng ký</a>
    				</div>
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
</div><!-- /#login-box -->
</div><!-- /.container -->

<div class="modal fade" id="register-guide" style="z-index: 2">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Hướng dẫn đăng ký</h4>
			</div>
			<div class="modal-body">
				<ul>
					<li><b>(*)</b>: là những thông tin bắt buộc phải nhập.</li>
					<li><b>MST / Mã số ngân sách nhà nước:</b> mỗi đơn vị có một tài khoản duy nhất, mã số thuế trùng với mã doanh nghiệp đã đăng ký.</li>
					<li><b>Tên đơn vị:</b> tên đơn vị trùng với tên trên con dấu.</li>
					<li><b>Email:</b> địa chỉ email cần chính xác để có thể xác nhận tài khoản đăng ký.<br><b>Lưu ý:</b> Vui lòng kiểm tra email để kích hoạt tài khoản.</li>
				</ul>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
			</div>
		</div>
	</div>
</div>
@endsection

@section('footer')
<script type="text/javascript" id="theme" src="{{mix('build/js/register.js')}}"></script>
@endsection
