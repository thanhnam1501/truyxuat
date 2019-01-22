@extends('layouts.master_user')
@section('content')
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">						
	<div class="card mb-3">
		<div class="card-header">
			<h3><i class="fa fa-check-square-o"></i> Bước cập nhật</h3>
			
		</div>
		@if ($errors->any())
		<div class="alert alert-danger">{{ implode('', $errors->all(':message')) }}</div>
		@endif
		<br>
		<div class="clearfix"></div>
		<div class="card-body">
			<form action="{{route('user.process.update')}}" method="POST">

				<div class="form-group">
					<label>Tên bước cập nhật</label>
					<input type="text" class="form-control" id="name" name="name" value="{{$data->name}}" placeholder="Họ và Tên" required>
					<input type="hidden" class="form-control" id="id" name="id" value="{{$data->id}}" placeholder="Họ và Tên" required>
				</div>

				<div class="form-group">
					<label>Mô tả</label>
					<textarea name="content" value="{{$data->content}}" class="form-control " id="editor1">{{$data->content}}</textarea>
				</div> 
				@if(Auth::guard('profile')->user()->type == [1,2])
				<div class="s form-group has-feedback">
					<select class="form-control has-feedback-left" name="user_id1" id="user_id1" required>
						<option value="">Chọn nhân viên quản lý</option>
						@foreach($user as $key => $value)
						<option @if($value->id == $data->user_id) selected @endif value="{{$value->id}}">{{$value->name}}</option>
						@endforeach
					</select>
					<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
				</div>
				@endif
				{{ csrf_field() }}

				<button type="submit" class="btn btn-primary">Cập nhật</button>
			</form>


		</div>
	</div>
</div>

@endsection