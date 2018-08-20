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
                    <form class="form-horizontal" method="post" action="{{ route('profile.password.request') }}" aria-label="{{ __('Login') }}">

                    @csrf

                        <input type="hidden" name="token" value="{{ $token }}">


                        <div class="form-group">
                            @if (session('status'))
                                <div class="col-md-12">
                                    <div class="alert alert-success">
                                        {{ session('status') }}
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <input id="email" type="text" name="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Email" value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                    <span class=“help-block” role="alert">
                                        <div style="color:red"><strong>{{ $errors->first('email') }}</strong></div>
                                    </span>
                                @endif

                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <input type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" id="password" placeholder="Mật khẩu mới"/>

                                @if ($errors->has('password'))
                                    <span class=“help-block” role="alert">
                                        <div style="color:red"><strong>{{ $errors->first('password') }}</strong></div>
                                    </span>
                                @endif
                            </div>



                        </div>

                        <div class="form-group">

                            <div class="col-md-12">
                                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" placeholder="Xác nhận mật khẩu">
                            </div>

                        </div>

                        <div class="form-group">
                            <div class="col-md-6">
                                <a href="{{ route('profile.login') }}" type="button" class="btn btn-info btn-block"><i class="fa fa-arrow-left" aria-hidden="true"></i> Quay lại</a>
                            </div>
                            <div class="col-md-6">
                                <button class="btn btn-success btn-block" type="submit">Đăng nhập</button>
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
</div><!-- /.logo -->
<div class="controls">
    <form class="form-horizontal" method="post" action="{{ route('profile.password.request') }}" aria-label="{{ __('Login') }}">

        @csrf

        <input type="hidden" name="token" value="{{ $token }}">


        <div class="form-group">
            @if (session('status'))
            <div class="col-md-12">
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            </div>
            @endif
        </div>

        <div class="form-group">
            <div class="col-md-12">
                <input id="email" type="text" name="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Email" value="{{ old('email') }}">

                @if ($errors->has('email'))
                <span class=“help-block” role="alert">
                    <div style="color:red"><strong>{{ $errors->first('email') }}</strong></div>
                </span>
                @endif

            </div>
        </div>

        <div class="form-group">
            <div class="col-md-12">
                <input type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" id="password" placeholder="Mật khẩu mới"/>

                @if ($errors->has('password'))
                <span class=“help-block” role="alert">
                    <div style="color:red"><strong>{{ $errors->first('password') }}</strong></div>
                </span>
                @endif
            </div>



        </div>

        <div class="form-group">

            <div class="col-md-12">
                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" placeholder="Xác nhận mật khẩu">
            </div>

        </div>

        <div class="form-group">
            <div class="col-md-6">
                {{-- <a href="{{ route('profile.login') }}" type="button" class="btn btn-info btn-block"><i class="fa fa-arrow-left" aria-hidden="true"></i> Quay lại</a> --}}
            </div>
            <div class="col-md-6">
                <button class="btn login-btn btn-block" type="submit">Đăng nhập</button>
            </div>
        </div>
    </form>
</div>
<div class="login-footer">
    <center>&copy; 2018 Zent Software</center>
</div>
</div><!-- /.controls -->
@endsection

@section('footer')

@endsection
