@extends('layouts.master_user')
@section('content')
<div>						
	<div class="card mb-3">
		<div class="card-header">
			<h3><i class="fa fa-check-square-o"></i> Thêm  bước cập nhật</h3>
			
		</div>
		@if ($errors->any())
		<div class="alert alert-danger">{{ implode('', $errors->all(':message')) }}</div>
		@endif
		<br>
		<div class="clearfix"></div>
		<div class="card-body">
			<form action="{{route('user.node.createOne')}}" method="POST">
			
				<div class="form-group">
					<label></label>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
					<input type="text" class="form-control has-feedback-left" id="name" name="name" placeholder="Tên bước"  required>
					<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
				</div>

				<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
					
			{{-- 		<textarea name="content{{$i}}" class="form-control" id="editor{{$i}}"></textarea> --}}
					<textarea  class="form-control " id="editor1" name="content"></textarea>
					
				</div>

				<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">

					<select class="form-control has-feedback-left" name="product_id" id="product_i" required>
						<option value="">Chọn sản phẩm</option>
						@foreach($products as $key => $value)
						<option value="{{$value->id}}">{{$value->name}}</option>
						@endforeach
					</select>
					<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
				</div>

				<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">

					<select class="form-control has-feedback-left" name="user_id" id="user_id" required>
						<option value="">Chọn nhân viên quản lý</option>
						@foreach($user as $key => $value)
						<option value="{{$value->id}}">{{$value->name}}</option>
						@endforeach
					</select>
					<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
				</div>
			
				{{ csrf_field() }} 	

				<button type="submit" class="btn btn-primary">Tạo mới</button>
			</form>

		</div>
	</div>
</div>



@endsection