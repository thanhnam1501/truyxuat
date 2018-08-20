@extends('backend.layouts.master')

@section('header')
	<style media="screen">
		.btn {
			margin-right: 10px;
		}
	</style>
@endsection

@section('breadcrumb')
	<li class="active">Quản lý tài khoản cá nhân</li>
@endsection

@section('page-title')

@endsection

@section('content')

  <div class="panel panel-default">
      <div class="panel-body tab-content">
        <div class="button-container" style="margin-bottom: 10px">
          <a href="javascript:;" onclick="addModal()" class="btn btn-info"><i class="fa fa-plus"></i> Thêm mới</a>
        </div>

        <div class="clearfix"></div>

        <div class="table-responsive">
			<table class="table table-bordered table-hover" id="user-tbl">
				<thead>
					<tr>
						<th>STT</th>
						<th>Người đăng ký</th>
						<th>Email</th>
						<th>Tên tổ chức</th>
						<th>Trạng thái</th>
						<th>Hành động</th>
					</tr>
				</thead>
			</table>
		</div>
      </div>
  </div>

<div class="modal fade" id="create-user-mdl" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Thêm mới người dùng</h4>
      </div>
      <div class="modal-body">
				<form role="form" enctype="multipart/form-data" id="create-user-frm">
						<div class="form-group">
								<label>Tên đơn vị/tổ chức <span class='error'>(*)</span></label>
								<input type="text" id="name" name="name" class="form-control"/>
						</div>
						<div class="form-group">
								<label class='control-label'>Email <span style="color: red">(*)</span></label>
								<input readonly type="email" id="email" name="email" class="form-control"/>
								<span class='control-label hide' id="email-error-custom"></span>
						</div>
						<p><i>Lưu ý: mật khẩu sẽ là "123456"</i></p>
				</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
        <button type="button" class="btn btn-primary" data-type='0' data-profile_id="" id="create-user-btn">Lưu</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="detail-user-mdl" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Chi tiết người dùng</h4>
      </div>
      <div class="modal-body">
				<div class="form-group">
					<div class="input-group input-group-lg">
							<span class="input-group-addon"><i class="fa fa-user"></i></span>
							<span class="form-control" id="name-detail"></span>
					</div>
				</div>
				<div class="form-group">
					<div class="input-group input-group-lg">
							<span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>
							<span class='form-control' id="email-detail"></span>
					</div>
				</div>
				<div class="form-group">
					<div class="input-group input-group-lg">
							<span class="input-group-addon"><i class="fa fa-picture-o"></i></span>
							<img class='img-responsive' src="{!! asset('img/avatar/default.jpg') !!}" style="width: 30%"></img>
					</div>
				</div>
				<div class="form-group">
					<div class="input-group input-group-lg">
							<span class="input-group-addon"><i class="fa fa-unlock-alt"></i></span>
							<span class='form-control' id="status-detail"></span>
					</div>
				</div>
				<div class="form-group hide">
					<div class="input-group input-group-lg">
							<span class="input-group-addon"><i class="fa fa-users"></i></span>
							<span class='form-control' id="type-detail"></span>
					</div>
				</div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('footer')

<script type="text/javascript" src="{{mix('build/js/account.js')}}"></script>

<script type="text/javascript">
	function addModal()
	{
			$('#create-user-frm').trigger('reset');

			$('#create-user-mdl').find('.modal-title').text('Thêm mới người dùng');

			$('#email').attr('readonly',false);

			$('#name').attr('readonly',false);

			$('#create-user-btn').attr('data-type',0);

			$('#create-user-btn').data('type',0);

			$('#create-user-mdl').modal('show')
	}

	function editModal(id)
	{
			var app_url = $('meta[name="website"]').attr('content');

			$.ajax({
					type: "GET",
					url: app_url + 'admin/account-profiles/'+id+'/edit',
					success: function(res)
					{
						if (!res.error) {

							$('#create-user-mdl').find('.modal-title').text('Chỉnh sửa người dùng');

							$('#email').attr('readonly',true);

							$('#email').val(res.profile.email);

							$('#name').val(res.profile.name);

							$('#email').parent().removeClass('has-error');

							$('#email-error-custom').addClass('hide');

							$('#email-error-custom').text("");

							$('#create-user-btn').data('type',1);

							$('#create-user-btn').data('profile_id',id);

							$('#create-user-mdl').modal('show')

						} else {

							toastr.error(res.message);
						}
					},
					error: function (xhr, ajaxOptions, thrownError) {
						toastr.error(thrownError);
					}
			});
	}

	function detail(id)
	{
		var app_url = $('meta[name="website"]').attr('content');

		$.ajax({
	      type: "GET",
	      url: app_url + 'admin/account-profiles/'+id+'/edit',
	      success: function(res)
	      {
	        if (!res.error) {

	          $('#name-detail').text(res.profile.name);
	          $('#avatar-detail').text(res.profile.avatar);
	          $('#email-detail').text(res.profile.email);
	          $('#type-detail').text(res.profile.type);

	          if (res.company.status == 0) {
	              $('#status-detail').text('Tài khoản bị khóa');
	              $('#status-detail').css('color','red');
	          } else {
	              $('#status-detail').text('Đã kích hoạt');
	              $('#status-detail').css('color','#555');
	          }

	          $('#detail-user-mdl').modal('show')

	        } else {

	          toastr.error(res.message);
	        }
	      },
	      error: function (xhr, ajaxOptions, thrownError) {
	        toastr.error(thrownError);
	      }
	  });
	}

</script>

@endsection
