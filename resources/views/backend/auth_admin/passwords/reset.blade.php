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
    </head>
    <body>
        <div class="login-container">    
            <div class="login-box animated fadeInDown">
                <div class="login-logo">
                    <img src="{{ asset('img/logo.png') }}" alt="loading...">
                </div>
                <div class="login-body">
                    <form class="form-horizontal" method="post" action="{{ route('password.request') }}" aria-label="{{ __('Login') }}">

                    @csrf
                    
                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group">
                            <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>
                            <div class="col-md-12">
                                <input id="email" type="email" name="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Email" {{ old('email') }} required autofocus>

                                @if ($errors->has('email'))
                                    <span class=“help-block” role="alert">
                                        <div style="color:red"><strong>{{ $errors->first('email') }}</strong></div>
                                    </span>
                                @endif

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Mật khẩu mới</label>
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
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Xác nhận lại</label>

                            <div class="col-md-12">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Xác nhận mật khẩu" required>
                            </div>

                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <button class="btn btn-info btn-block" type="submit">Đăng nhập</button>
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

@section('content')
<div class="logo">
    <h1 class="logo-caption">Thay đổi mật khẩu</h1>
    @endif
</div><!-- /.logo -->
<div class="controls">
    <form class="form-horizontal" method="post" action="{{ route('password.request') }}" aria-label="{{ __('Login') }}">

        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <div class="form-group">
            <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>
            <div class="col-md-12">
                <input id="email" type="email" name="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Email" {{ old('email') }} required autofocus>

                @if ($errors->has('email'))
                <span class=“help-block” role="alert">
                    <div style="color:red"><strong>{{ $errors->first('email') }}</strong></div>
                </span>
                @endif

            </div>
        </div>

        <div class="form-group">
            <label for="password" class="col-md-4 col-form-label text-md-right">Mật khẩu mới</label>
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
            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Xác nhận lại</label>

            <div class="col-md-12">
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Xác nhận mật khẩu" required>
            </div>

        </div>

        <div class="form-group">
            <div class="col-md-12">
                <button class="btn login-btn btn-block" type="submit">Đăng nhập</button>
            </div>
        </div>
        <div class="login-footer">
            <div class="pull-left">
                &copy; 2018 Zent Software
            </div>
        </div>
    </form>
</div><!-- /.controls -->

@endsection
