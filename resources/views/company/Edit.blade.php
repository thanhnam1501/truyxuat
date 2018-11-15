@extends('layouts.master')
@section('content')
<div class="row">

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">						
		<div class="card mb-3">
			<div class="card-header">
				<h3><i class="fa fa-check-square-o"></i> Cập nhật thông tin doanh nghiệp</h3>

			</div>

			<div class="card-body">

				<form method="POST" action="{{route('company.update')}}">
					<input style="display: none" type="hidden" id="id" name="id" value="{{$data->id}}" >
					<div class="form-group">
						<label for="exampleInputEmail1">Tên doanh nghiệp</label>
						<input type="text" class="form-control" id="name" name="name" value="{{$data->name}}" placeholder="Tên doanh nghiệp" required>
						{{-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1">Mã số thuế</label>
						<input type="number" class="form-control" id="tax_code" name="tax_code" value="{{$data->tax_code}}" placeholder="Mã số thuế" required>
						{{-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
					</div>
					
					<div class="form-group">
						<label for="exampleInputEmail1">Số điện thoại</label>
						<input type="number" class="form-control" id="mobile_phone" name="mobile_phone" value="{{$data->mobile_phone}}" placeholder="Số điện thoại" required>
						{{-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
					</div>
					
					<div class="form-group">
						<label for="exampleInputEmail1">Địa chỉ</label>
						<input type="text" class="form-control" id="address" value="{{$data->address}}" name="address" placeholder="Địa chỉ" required>
						{{-- <small id="numberlHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
					</div>

					<div class="form-group">
						<label for="exampleInputEmail1">Giới hạn tài khoản</label>
						<input type="number" class="form-control" id="account_limit" name="account_limit" value="{{$data->account_limit}}" placeholder="Giới hạn tài khoản" required>
						{{-- <small id="numberlHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
					</div>

					<div class="form-group">
						<label for="exampleInputEmail1">Giới hạn sản phẩm</label>
						<input type="number" class="form-control" id="product_limit" name="product_limit" value="{{$data->product_limit}}" placeholder="Giới hạn sản phẩm" required>
						{{-- <small id="numberlHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
					</div>

					<div class="form-group">
						<label>Mô tả</label>
						<textarea name="content" value="{{$data->content}}" class="form-control " id="editor1"></textarea>
					</div> 


					  {{ csrf_field() }}

					<button type="submit" class="btn btn-primary">Cập nhật</button>
				</form>

			</div>														
		</div><!-- end card-->					
	</div>

	@endsection