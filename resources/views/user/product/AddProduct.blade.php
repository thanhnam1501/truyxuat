@include ( 'ckfinder::setup')
@extends('layouts.master_user')
@section('content')

<div class="card mb-3">
	<div class="card-header">
		<h3><i class="fa fa-check-square-o"></i> Thêm sản phẩm mới</h3>
		
	</div>
	@if ($errors->any())
	<div class="alert alert-danger">{{ implode('', $errors->all(':message')) }}</div>
	@endif
	<br>
	<div class="clearfix"></div>
	<div class="card-body">
		<form action="{{route('user.product.create')}}" method="POST" class="form-horizontal" role="form" enctype="multipart/form-data">
			<div class="form-group">
				<label for="exampleInputEmail1">Tên sản phẩm</label>
				<input type="text" class="form-control" id="name" name="name" placeholder="Tên sản phẩm" required>
			</div>
			
			<div class="form-group">
				<label>Mô tả ngắn sản phẩm</label>
				<textarea name="sort_content" class="form-control" id="editor1"></textarea>
			</div> 
			
			<div class="form-group">
				<label>Mô tả</label>
				<textarea name="content" class="form-control" id="editor2"></textarea>
			</div> 
			<div class="form-group">
				<label for="exampleInputEmail1">Các bước cập nhật</label>
				<input type="number" class="form-control" id="node" name="node" placeholder="Số bước" required>
			</div>

			<div class="form-group">
				<label for="exampleInputEmail1">Ảnh sản phẩm</label>
				<input type="file" id="image" name="image" >

				{{-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
			</div>


			{{ csrf_field() }}

			<button type="submit" class="btn btn-primary">Đăng</button>
		</form>


	</div>
</div>


@endsection