@extends('layouts.master')
@section('content')
<div class="row">

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">						
		<div class="card mb-3">
			<div class="card-header">
				<h3><i class="fa fa-check-square-o"></i> Thêm doanh nghiệp mới</h3>

			</div>

			<div class="card-body">

				<form method="POST" action="{{route('company.create')}}">
					<div class="form-group">
						<label for="exampleInputEmail1">Tên doanh nghiệp</label>
						<input type="text" class="form-control" id="name" name="name" {{-- aria-describedby="emailHelp" --}} placeholder="Tên doanh nghiệp" required>
						{{-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1">Mã số thuế</label>
						<input type="number" class="form-control" id="tax_code" name="tax_code" {{-- aria-describedby="emailHelp" --}} placeholder="Mã số thuế" required>
						{{-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
					</div>
					
					<div class="form-group">
						<label for="exampleInputEmail1">Số điện thoại</label>
						<input type="number" class="form-control" id="mobile_phone" name="mobile_phone" {{-- aria-describedby="emailHelp" --}} placeholder="Số điện thoại" required>
						{{-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
					</div>
					
					<div class="form-group">
						<label for="exampleInputEmail1">Địa chỉ</label>
						<input type="text" class="form-control" id="address" name="address" placeholder="Địa chỉ" required>
						{{-- <small id="numberlHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
					</div>

					<div class="form-group">
						<label for="exampleInputEmail1">Giới hạn tài khoản</label>
						<select class="form-control" name="account_limit" id="account_limit" required>

							<option value="5">5</option>
							<option value="10">10</option>
							<option value="25">25</option>
							<option value="100">100</option>
							<option value="10000">Không giới hạn</option>
							
						</select>
						{{-- <small id="numberlHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
					</div>

					<div class="form-group">
						<label for="exampleInputEmail1">Giới hạn sản phẩm</label>
						
						<select class="form-control" name="product_limit" id="product_limit" required>

							<option value="5">5</option>
							<option value="10">10</option>
							<option value="25">25</option>
							<option value="100">100</option>
							<option value="10000">Không giới hạn</option>
							
						</select>
						{{-- <small id="numberlHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
					</div>

					<div class="form-group">
						<label for="exampleInputEmail1">Giới hạn thời gian</label>
						
						<select class="form-control" name="time_limit" id="time_limit" required>
							<option value="3">3 tháng</option>
							<option value="12">1 năm</option>
							<option value="24">2 năm</option>
							<option value="36">3 năm</option>
							<option value="48">4 năm</option>
							<option value="60">5 năm</option>
							<option value="10000">Không giới hạn</option>							
						</select>
						{{-- <small id="numberlHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
					</div>


					<div class="form-group">
						<label>Content</label>
						<textarea name="content" class="form-control " id="editor1"></textarea>
					</div> 
					  {{ csrf_field() }}

					<button type="submit" class="btn btn-primary">Tạo mới</button>
				</form>

			</div>														
		</div><!-- end card-->					
	</div>

	@endsection