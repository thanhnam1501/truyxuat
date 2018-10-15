@extends('layouts.master')
@section('content')
<div class="{{-- col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 --}}">						
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
			<form action="{{route('product.create')}}" method="POST" class="form-horizontal" role="form" enctype="multipart/form-data">
					<input style="display: none" type="hidden" id="id" name="id" >
					<div class="form-group">
						<label for="exampleInputEmail1">Tên sản phẩm</label>
						<input type="text" class="form-control" id="name" name="name" placeholder="Tên sản phẩm" required>
					</div>

				
					<div class="form-group">
						<label>Tên doanh nghiệp</label>
						<select class="form-control" name="company_id" id="company_id" >
						@foreach($companies as $company)
						<option value="{{$company->id}}">{{$company->name}}</option>
						@endforeach
					</select>
					</div> 
					
					<div class="form-group">
						<label>Mô tả ngắn sản phẩm</label>
						<textarea name="sort_content" class="form-control " id="editor1"></textarea>
					</div> 
					<div class="form-group">
						<label>Mô tả</label>
						<textarea name="content" class="form-control " id="editor1"></textarea>
					</div> 

					<div class="form-group">
						<label for="exampleInputEmail1">Ảnh sản phẩm</label>
						<input type="file" class="form-control" id="image" name="image" required>
						{{-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
					</div>
					  {{ csrf_field() }}

					<button type="submit" class="btn btn-primary">Đăng</button>
				</form>


		</div>
	</div>
</div>

@endsection