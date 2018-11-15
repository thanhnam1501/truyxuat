@extends('layouts.master')
@section('content')
<div>						
	<div class="card mb-3">
		<div class="card-header">
			<h3><i class="fa fa-check-square-o"></i> Thêm các bước cập nhật</h3>
			
		</div>
		@if ($errors->any())
		<div class="alert alert-danger">{{ implode('', $errors->all(':message')) }}</div>
		@endif
		<br>
		<div class="clearfix"></div>
		<div class="card-body">
			<form action="{{route('node.create')}}" method="POST">
				<input type="hidden" class="form-control has-feedback-left" id="product_id" name="product_id" value="{{$product_id}}"  required>
				<input type="hidden" class="form-control has-feedback-left" id="company_id" name="company_id" value="{{$company_id}}"  required>
				<input type="hidden" class="form-control has-feedback-left" id="node" name="node" value="{{$node}}"  required>

				@for($i=1; $i <= $node ; $i++)
				<div class="form-group">
					<label>Bước thứ {{$i}}</label>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
					<input type="text" class="form-control has-feedback-left" id="name{{$i}}" name="name{{$i}}" placeholder="Tên bước"  required>
					<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
				</div>

				<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
					
			{{-- 		<textarea name="content{{$i}}" class="form-control" id="editor{{$i}}"></textarea> --}}
					<textarea  class="form-control " id="editor{{$i}}" name="content{{$i}}"></textarea>
					
				</div>

				<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">

					<select class="form-control has-feedback-left" name="user_id{{$i}}" id="user_id{{$i}}" required>
						<option value="">Chọn nhân viên quản lý</option>
						@foreach($user as $key => $value)
						<option value="{{$value->id}}">{{$value->name}}</option>
						@endforeach
					</select>
					<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
				</div>
				
				@endfor
				{{ csrf_field() }} 	

				<button type="submit" class="btn btn-primary">Tạo mới</button>
			</form>

		</div>
	</div>
</div>

@endsection