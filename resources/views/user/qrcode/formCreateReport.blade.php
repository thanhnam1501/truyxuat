@extends('layouts.master_user')
@section('content')

<div>						
	<div class="card mb-3">
		<div class="card-header">
			<h3><i class="fa fa-check-square-o"></i> Báo cáo số lượng in</h3>			
		</div>
		@if ($errors->any())
		<div class="alert alert-danger">{{ implode('', $errors->all(':message')) }}</div>
		@endif
		<br>
		<div class="clearfix"></div>
		<div class="card-body">
			<form action="{{route('user.report.qrcode.store')}}" method="POST">
				
				<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
					<label for="">Tên báo cáo</label>
					<input type="text" class="form-control" name="name" id="name" placeholder="Nhập tên báo cáo" required>
				</div>

				<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
					<label for="">Số lượng in</label>
					<input type="text" class="form-control" name="amount" id="amount" placeholder="Nhập số lượng tem cần in" required>
				</div>

				<div class="col-md-12 col-sm-12 col-xs-12 form-group ">
					<label for="">Sản phẩm cần in</label>
					<select class="form-control " name="product_id" id="product_id" required>
						<option value="">Sản phẩm </option>
						@foreach($products as $key => $value)
						<option value="{{$value->id}}">{{$value->name}}</option>
						@endforeach
					</select>
					
				</div>
				
				
				{{ csrf_field() }} 	

				<button type="submit" class="btn btn-primary">Tạo mới</button>
			</form>

		</div>
	</div>
</div>



@endsection