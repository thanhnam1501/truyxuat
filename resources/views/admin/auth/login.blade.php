@extends('layouts.auth')
@section('content')
    <div class="">
        <a class="hiddenanchor" id="toregister"></a>
        <a class="hiddenanchor" id="tologin"></a>

        <div id="wrapper">
            <div id="login" class="animate form">
                <section class="login_content">
                    <form method="POST" action="{{ route('admin.login.submit') }}" aria-label="">
                        @csrf

                        <h1>Login Form</h1>
                        <div>
                            <input id="email" type="email" name="email"
                                   class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                   placeholder="Email" value="{{ old('email') }}" required autofocus>
                            @if ($errors->has('email'))
                                <span class=“help-block” role="alert">
                            <div style="color:red"><strong>{{ $errors->first('email') }}</strong></div>
                        </span>
                            @endif
                        </div>
                        <div class="form-group">

                            <input type="password"
                                   class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}"
                                   name="password" id="password" placeholder="Mật khẩu"/>
                            @if ($errors->has('password'))
                                <span class=“help-block” role="alert">
                        <div style="color:red"><strong>{{ $errors->first('password') }}</strong></div>
                    </span>
                            @endif
                        </div>


                        <div>
                            <button class="btn btn-default submit" type="submit"
                            ">Log in</button>
                            <a class="reset_pass" href="#">Lost your password?</a>
                        </div>
                        <div class="clearfix"></div>
                        <div class="separator">

                            <p class="change_link">New to site?
                                <a href="#toregister" class="to_register"> Create Account </a>
                            </p>
                            <div class="clearfix"></div>
                            <br/>
                            <div>
                                <h1><i class="fa fa-paw" style="font-size: 26px;"></i> Gentelella Alela!</h1>

                                <p>©2015 All Rights Reserved. Gentelella Alela! is a Bootstrap 3 template. Privacy and
                                    Terms</p>
                            </div>
                        </div>
                    </form>
                    <!-- form -->
                </section>
                <!-- content -->
            </div>

        </div>
    </div>

@endsection