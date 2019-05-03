@extends('layouts.master')
@section('content')
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">						
	<div class="card mb-3">
		<div class="card-header">
			<h3><i class="fa fa-check-square-o"></i> Bước cập nhật</h3>
			
		</div>
		@if ($errors->any())
		<div class="alert alert-danger">{{ implode('', $errors->all(':message')) }}</div>
		@endif
		<br>
		<div class="clearfix"></div>
		<div class="card-body">
			<form action="{{route('node.update')}}" method="POST">

				<div class="form-group">
					<label>Tên bước cập nhật</label>
					<input type="text" class="form-control" id="name" name="name" value="{{$data->name}}" placeholder="Họ và Tên" required>
					<input type="hidden" class="form-control" id="id" name="id" value="{{$data->id}}" placeholder="Họ và Tên" required>
				</div>

				<div class="form-group">
						<label>Mô tả</label>
						<textarea name="content" value="{{$data->content}}" class="form-control " id="editor1">{{$data->content}}</textarea>
					</div> 
					<div class="form-group">
						<label>Người quản lý</label>
						<select name="user_id" id="user_id" class="form-control">
							<option value="">Chọn người quản lý</option>
							@foreach($users as $key => $value)
							<option value="{{$value['id']}}">{{$value['name']}}</option>
							@endforeach
						</select>
					</div> 

				{{ csrf_field() }}

				<button type="submit" class="btn btn-primary">Cập nhật</button>
			</form>


		</div>
	</div>
</div>

@endsection