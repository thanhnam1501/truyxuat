@extends('layouts.master')
@section('content')
<div class="row">

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">						
		<div class="card mb-3">
			<div class="card-header">
				<h3><i class="fa fa-check-square-o"></i> Cập nhật thông tin sản phẩm</h3>

			</div>

			<div class="card-body">

			<form action="{{route('product.update')}}" method="POST" class="form-horizontal" role="form" enctype="multipart/form-data">
					<input style="display: none" type="hidden" id="id" name="id" value="{{$data->id}}" >
					<div class="form-group">
						<div class="col-xl-9 col-lg-9 col-md-9 col-sm-9 col-xs-9">
							<br>
							<label for="exampleInputEmail1">Tên sản phẩm</label>
							<input type="text" class="form-control" id="name" name="name" value="{{$data->name}}" placeholder="Tên sản phẩm" required>
							{{-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
				
							<br>

							<label>Tên doanh nghiệp</label>
							<select class="form-control" name="company_id" id="company_id" value="{{$data->company_id}}">
								@foreach($companies as $company)
								<option value="{{$company->id}}">{{$company->name}}</option>
								@endforeach
							</select>
						</div>
						<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
							<img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')
							->size(200)
							->generate($url)) !!} ">
						</div>
					</div> 

					<div class="form-group">
						<label>Mô tả ngắn sản phẩm</label>
						<textarea name="sort_content" value="{{$data->sort_content}}" class="form-control " id="editor1">{{$data->sort_content}}</textarea>
					</div> 
					<div class="form-group">
						<label>Mô tả</label>
						<textarea name="content" value="{{$data->content}}" class="form-control " id="editor1">{{$data->content}}</textarea>
					</div> 
					{{ csrf_field() }}
					<div class="form-group">
						<label for="exampleInputEmail1">Ảnh sản phẩm</label>
						<img src="" alt="">
						<input type="file" class="form-control" id="image" value="{{$data->image}}" name="image" >
						{{-- <small id="numberlHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
					</div>
					<button type="submit" class="btn btn-primary">Cập nhật</button>
				</form>

			</div>														
		</div><!-- end card-->					
	</div>

	@endsection

	@section('footer')
	<script src="SVGMagic.min.js"></script>
	<script>
		$(document).ready(function(){
			$('#qrcode').svgmagic();
		});
	</script>
	@endsection