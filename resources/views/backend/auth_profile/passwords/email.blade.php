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
                    <form class="form-horizontal" method="post" action="{{ route('profile.password.email') }}" aria-label="">

                    @csrf

                    <div class="form-group">
                        @if (session('status'))
                            <div class="col-md-12">
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div></div>
                        @endif
                    </div>

                    <div class="form-group">
                        <div class="col-md-12">
                            <input id="email" type="text" name="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Vui lòng nhập email" value="{{ old('email') }}" >
                            @if ($errors->has('email'))
                                <span class=“help-block” role="alert">
                                    <div style="color:red"><strong>{{ $errors->first('email') }}</strong></div>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6">
                        </div>

                        <div class="col-md-6">
                            <button type="submit" class="btn btn-info btn-block">Khôi phục mật khẩu</button>
                        </div>
                        <div class="col-md-12">
                            <hr>
                            <div class="col-md-6 btn-fogot">
                                <a href="{{ route('profile.login') }}" class="btn btn-link btn-block dt-right">Đăng nhập</a>
                            </div>
                            <div class="col-md-6 btn-register">
                                <a data-toggle="modal" href='{{ route('profile.register') }}' class="btn btn-link btn-block dt-right">Đăng ký</a>
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
    </html> --}}

@extends('backend.layouts.auth')

@section('content')
    <div class="logo">
        <h1 class="logo-caption">Quên mật khẩu</h1>
    </div><!-- /.logo -->
    <div class="controls">
        <form class="form-horizontal" method="post" action="{{ route('profile.password.email') }}" aria-label="">

            @csrf

            <div class="form-group">
                @if (session('status'))
                <div class="col-md-12">
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div></div>
                    @endif
                </div>

                <div class="form-group">
                    <div class="col-md-12">
                        <input id="email" type="text" name="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Vui lòng nhập email" value="{{ old('email') }}" >
                        @if ($errors->has('email'))
                        <span class=“help-block” role="alert">
                            <div style="color:red"><strong>{{ $errors->first('email') }}</strong></div>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6">
                    </div>

                    <div class="col-md-6">
                        <button type="submit" class="btn login-btn btn-block">Khôi phục mật khẩu</button>
                    </div>
                    <div class="col-md-12">
                        <hr>
                        <div class="col-md-6 btn-fogot custom-col-left">
                            <a href="{{ route('profile.login') }}" class="btn-link">Đăng nhập</a>
                        </div>
                        <div{{--  class="col-md-6 btn-register custom-col-right">
                            <a data-toggle="modal" href='{{ route('profile.register') }}' class="btn-link">Đăng ký</a>
                        </div>
     --}}                </div>
                </div>
                
            </form>
        </div>
        <div class="login-footer">
            <center>&copy; 2018 Zent Software</center>
        </div>
    </div><!-- /.controls -->
@endsection


