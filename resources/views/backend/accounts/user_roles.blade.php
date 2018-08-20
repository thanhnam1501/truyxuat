@extends('backend.layouts.master')

@section('header')
	<style media="screen">
		.btn {
			margin-right: 10px;
		}
	</style>
@endsection

@section('breadcrumb')
	<li class="">Quản lý tài khoản người dùng</li>
	<li class="active">Thêm vai trò cho người dùng</li>
@endsection

@section('page-title')

@endsection

@section('content')

  <div class="panel panel-default">
      <div class="panel-body tab-content">

        <div class="table-responsive">
					<table class="table table-striped table-bordered table-hover">
							<thead>
									<tr>
										 <th class="stl-column color-column">#</th>
										 <th class="stl-column color-column">Vai trò</th>
										 <th class="stl-column color-column">Miêu tả</th>
										 <th class="stl-column color-column">Quyền hạn</th>
										 <th class="stl-column color-column">Hành động</th>
									</tr>
							</thead>
							<tbody>
									@if(!empty($roles)) @foreach($roles as $key => $role)
									<tr>
											<td class="text-center"> {{ $key + 1 }} </td>

											<td class="text-left"> {{ $role->display_name }} </td>

											<td class="text-left"> {{ $role->description }} </td>

											<td class="text-left">
											@if(!empty($role->permissions))
													@foreach($role->permissions as $k => $permission)

															<label class="btn btn-info btn-rounded" style="cursor: default; margin-bottom: 8px">{{$permission->display_name}}</label>

													@endforeach
											@endif


											</td>

											<td class="text-center">
													<input type="hidden" id="checked-{{$role->id}}" value="{{$role->checked}}">

														@if(!empty($role->checked))

														 <i id="action-{{$role->id}}" class="fa fa-check-circle add-role-btn" data-user_id='{{$user->id}}' data-role_id='{{$role->id}}' aria-hidden="true" style="cursor: pointer; color: #3598dc;font-size: 20px;"></i>
													@else

														<i id="action-{{$role->id}}" class="fa fa-circle-o add-role-btn" data-user_id='{{$user->id}}' data-role_id='{{$role->id}}' aria-hidden="true" style="cursor: pointer; color: #3598dc;font-size: 20px;"></i>

													@endif


											 </td>


									</tr>
									@endforeach @else
										<tr>
											<td colspan="4" class="text-center"> Không có bản ghi nào </td>
										</tr>
									@endif

							</tbody>
					</table>
				</div>
      </div>
  </div>

@endsection

@section('footer')

<script type="text/javascript" src="{{mix('build/js/account-users.js')}}"></script>

@endsection
