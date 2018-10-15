@extends('layouts.master_user')
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

					<div class="form-group">
						<label for="exampleInputEmail1">Ảnh sản phẩm</label>
						<input type="file" class="form-control" id="image" name="image" required>
						<img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')
							->size(200)
							->generate($url)) !!} ">
					</div>
					  {{ csrf_field() }}

					<button type="submit" class="btn btn-primary">Đăng</button>
				</form>


		</div>
	</div>
</div>

@endsection