@extends('backend.layouts.master')

@section('header')
	{{-- expr --}}
@endsection

@section('breadcrumb')
	<li class="active"> Quản lý quyền hạn</li>
@endsection

@section('page-title')
	{{-- <h2>Quản lý quyền hạn</h2> --}}
@endsection

@section('content')

	<div class="panel panel-warnig">
			<div class="panel-body">

				<div class="table-responsive">
					<table class="table table-bordered table-hover" id="permission-list-tbl">
						<thead>
							<tr>
								<th style="width: 1%">STT</th>
								<th style="width: 30%">Tên hiển thị</th>
								<th style="width: 20%">Quyền hạn</th>
								<th style="width: 29%">Mô tả</th>
								<th style="width: 20%">Ngày tạo</th>
							</tr>
						</thead>
					</table>
				</div>

			</div>
	</div>

@endsection

@section('footer')

<script type="text/javascript" src="{{mix('build/js/permissions.js')}}"></script>

@endsection
