
@extends('layouts.master_user')
@section('content')

<div class="col-md-3"></div>
<div class="col-md-6">
	<form action="{{route('user.profile.change_password')}}" method="POST">

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
            <br>
            <div class="clearfix"></div>

            <div class="form-group">
                <div class="col-md-12">
                    <button class="btn btn-info btn-block" type="submit">Thay đổi mật khẩu</button>
                </div>
            </div>

            

		{{ csrf_field() }}


	</form>
</div>
@endsection
