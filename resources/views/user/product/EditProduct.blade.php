@include ( 'ckfinder::setup')
@extends('layouts.master_user')
@section('content')
<div class="row">

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">						
		<div class="card mb-3">
			<div class="card-header">
				<h3><i class="fa fa-check-square-o"></i> Cập nhật thông tin sản phẩm</h3>

			</div>

			<div class="card-body">

				<form action="{{route('user.product.update')}}" method="POST" class="form-horizontal" role="form" enctype="multipart/form-data">
					<input style="display: none" type="hidden" id="id" name="id" value="{{$data->id}}" >
					<div class="form-group">
						<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
							@if($data->image)
							<img style="width: 50%;margin-left: 20%; border: solid 1px black" src="{{asset($data->image)}}" alt="">
							@else
							<img style="width: 50%;margin-left: 20%; border: solid 1px black" src="{{ asset('image/noimage.png')}}" alt="">
							@endif
						</div>
						<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
							
							<label for="exampleInputEmail1">Tên sản phẩm</label>
							<input type="text" class="form-control" id="name" name="name" value="{{$data->name}}" placeholder="Tên sản phẩm" required>
							{{-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}

							<br>
							<div class="form-group">
								<label for="exampleInputEmail1">Các bước cập nhật</label>
								<input type="number" class="form-control" id="node" name="node" value="{{$data->node}}" disabled>
							</div>	
							
						</div>
						<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
							<img style="margin-left: 20%" src="data:image/png;base64, {!! base64_encode(QrCode::format('png')
							->size(200)
							->generate($url)) !!} ">
							
						</div>
					</div> 
					
					
					{{-- <div class="form-group">
						<label for="exampleInputEmail1">Nhân viên quản lý</label>
						<select class="form-control" name="user_id" id="user_id" value="{{$data->user_id}}" required>
							
							@foreach($user as $user)
							<option @if($data->user_id == $user->id) selected @endif value="{{$user->id}}">{{$user->name}}</option>
							@endforeach
						</select>
					</div> --}}
					<div class="form-group">
						<div class="clearfix"></div>
						<label>Mô tả ngắn sản phẩm</label>
						<textarea name="sort_content" value="{{$data->sort_content}}" class="form-control " id="editor1">{{$data->sort_content}}</textarea>
					</div> 
					<div class="form-group">
						<label>Mô tả</label>
						<textarea name="content" value="{{$data->content}}" class="form-control  " id="editor2">{{$data->content}}</textarea>
					</div> 
					
					<div class="form-group">
						<label for="exampleInputEmail1">Ảnh sản phẩm</label>
						<input type="file" id="image_update" name="image_update" >

						{{-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
					</div>
					{{ csrf_field() }}
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