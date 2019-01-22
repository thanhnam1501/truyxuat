@extends('layouts.master_user')
@section('content')
@if(empty($data))
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
			<form action="{{route('user.process.getFormCreateProcess')}}" method="POST" class="form-horizontal" role="form" enctype="multipart/form-data">
				<div class="form-group">
					<label>Chọn sản phẩm</label>
					<select class="form-control" name="product_id" id="product_id" required>

						@foreach($products as $product)
						<option value="{{$product->id}}">{{$product->name}}</option>
						@endforeach
					</select>
				</div>

				<div class="form-group">
					<label>Số quy trình sản xuất</label>
					<input type="number" class="form-control" id="number_process" name="number_process" placeholder="Số quy trình sản xuất" required>
					
				</div> 
				
				{{ csrf_field() }} 	

				<button type="submit" class="btn btn-primary">Tạo mới</button>
			</form>

		</div>
	</div>
</div>
@else
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
			<form action="{{route('user.process.create')}}" method="POST">
				<input type="hidden" class="form-control has-feedback-left" id="product_id" name="product_id" value="{{$data['product_id']}}"  required>
				<input type="hidden" class="form-control has-feedback-left" id="number_process" name="number_process" value="{{$data['number_process']}}"  required>
				@for($i=1; $i <= $data['number_process'] ; $i++)
				<div class="form-group">
					<label>Bước thứ {{$i}}</label>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
					<input type="text" class="form-control has-feedback-left" id="name{{$i}}" name="name{{$i}}" placeholder="Tên bước"  required>
					<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
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
@endif


@endsection