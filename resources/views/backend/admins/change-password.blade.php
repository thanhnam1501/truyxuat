@extends('backend.layouts.master')

@section('head')
  <style type="text/css">
  .login-container{
    background: #f5f5f5 url('../img/bg.png') left top repeat;
  }
  </style>
@endsection

@section('breadcrumb')

<li class="active">Thay đổi mật khẩu</li>
@endsection

@section('content')
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">


  <div class="panel panel-default">
      <div class="col-md-offset-3 col-md-6"> <br>
    <div class="panel-body ">
      {{-- <div class="login-container"> --}}
        <div class="login-box">
         <div>
             @if(isset($messageError))
             <div class="alert alert-danger">
               <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
               {{ $messageError }}
           </div>
           @endif
                @if(isset($messageSuccess))
             <div class="alert alert-success">
               <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
               {{ $messageSuccess }}
           </div>
           @endif
       </div>
       <div class="login-body" style="color: black">
        <form class="form-horizontal" method="post" action="{{ route('user.post.change-password') }}" >

            @csrf
            <div class="form-group">
                <label for="email" class="col-md-4 col-form-label text-md-right">Mật khẩu cũ</label>
                <div class="col-md-12">
                    <input style="color: black" id="oldpassword" type="password" name="oldpassword" placeholder="Mật khẩu cũ" class="form-control" required autofocus>
                </div>
            </div>

            <div class="form-group">
                <label for="password" class="col-md-4 col-form-label text-md-right">Mật khẩu mới</label>
                <div class="col-md-12">
                    <input style="color: black" type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" id="newpassword" placeholder="Mật khẩu mới" required autofocus/>
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
                    <input style="color: black"  id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Xác nhận mật khẩu" required>
                </div>

            </div>

            <div class="form-group">
                <div class="col-md-12">
                    <button class="btn btn-info btn-block" type="submit">Thay đổi mật khẩu</button>
                </div>
            </div>

            <br>
        </form>
    </div>
  </div>

</div>

<div class="login-footer">
    <div class="" style="color: black;">
        <center>&copy; 2018 Zent Software</center> <br>
    </div>
</div>
</div>

</div>

</div>
<!-- END PAGE CONTENT WRAPPER -->

@endsection
@section('footer')
@endsection
