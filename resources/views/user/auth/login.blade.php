@extends('layouts.auth')
@section('content')
<div class="">
    <a class="hiddenanchor" id="toregister"></a>
    <a class="hiddenanchor" id="tologin"></a>
    @if(isset($message))
    <div class="alert alert-danger">
       <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
       {{ $message }}
   </div>
   @endif
   <div id="wrapper">
    <div id="login" class="animate form">
        <section class="login_content">
            @if(!empty($message))
            <div class="alert alert-danger">
               <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
               {{ $message }}
           </div>
           @endif
           <form method="POST" action="{{ route('profile.login.submit') }}" aria-label="">
            @csrf

            <h1>Login Form</h1>
            <div>
                <input id="email" type="email" name="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Email" value="{{ old('email') }}" required autofocus>
                @if ($errors->has('email'))
                <span class=“help-block” role="alert">
                    <div style="color:red"><strong>{{ $errors->first('email') }}</strong></div>
                </span>
                @endif
            </div>
            <div class="form-group">

                <input type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" id="password" placeholder="Mật khẩu"/>
            </div>

            @if ($errors->has('password'))
            <span class=“help-block” role="alert">
                <div style="color:red"><strong>{{ $errors->first('password') }}</strong></div>
            </span>
            @endif


            <div>
                <button class="btn btn-default submit" type="submit"">Log in</button>
                <a class="reset_pass" href="#">Lost your password?</a>
            </div>
            <div class="clearfix"></div>
            <div class="separator">


                <div class="clearfix"></div>
                <br />
                <div>
                    <h1><i class="fa fa-paw" style="font-size: 26px;"></i> <span style="color: red;font-size: bold;">S</span>mart<span style="color: red;font-size: bold;">C</span>heck</h1>

                    <p>©2015 All Rights Reserved. Gentelella Alela! is a Bootstrap 3 template. Privacy and Terms</p>
                </div>
            </div>
        </form>
        <!-- form -->
    </section>
    <!-- content -->
</div>
<div id="register" class="animate form">
    <section class="login_content">
        <form>
            <h1>Create Account</h1>
            <div>
                <input type="text" class="form-control" placeholder="Username" required="" />
            </div>
            <div>
                <input type="email" class="form-control" placeholder="Email" required="" />
            </div>
            <div>
                <input type="password" class="form-control" placeholder="Password" required="" />
            </div>
            <div>
                <a class="btn btn-default submit" href="index.html">Submit</a>
            </div>
            <div class="clearfix"></div>
            <div class="separator">

                <p class="change_link">Already a member ?
                    <a href="#tologin" class="to_register"> Log in </a>
                </p>
                <div class="clearfix"></div>
                <br />
                <div>
                    <h1><i class="fa fa-paw" style="font-size: 26px;"></i> Gentelella Alela!</h1>

                    <p>©2015 All Rights Reserved. Gentelella Alela! is a Bootstrap 3 template. Privacy and Terms</p>
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