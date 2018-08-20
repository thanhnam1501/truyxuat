
$(function() {

    $role_table = $('#roles-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: app_url + 'admin/get-list-role',
        ordering: false,
        columns: [
            {data: 'DT_Row_Index', searchable: false},
            {data: 'display_name', name: 'display_name'},
            {data: 'name', name: 'name'},
            {data: 'description', name: 'description'},
            {data: 'created_at', name: 'created_at'},
            {data: 'action', name: 'action', orderable: false, searchable: false,'class':'text-center'}
        ]
    });

});

$('.addRole').on('click', function() {
    $('#createRoleModal').modal('show');
    $('#name').val('');
    $('#display_name').val('');
    $('#description').val('');
});


$('#add-role').validate({ // initialize the plugin
  errorElement: "span",
  rules: {
    name : {
      required : true,

    },
    display_name : {
      required :true,
    },
  },
  messages: {
    name : {
      required : "Vui lòng nhập vai trò",
    },
    display_name : {
      required :"Vui lòng nhập tên hiển thị",
    }
  }
});


$('#add-role').on('submit',function(e){

  e.preventDefault();

  var form= $('#add-role');
  var formData= form.serialize();

  if(! form.valid()) return false;

  $.ajax({
    type:'POST',
    url: app_url + 'admin/roles',
    data: formData,
    success:function(data){
        if(!data.error) {

            toastr["success"]("Thêm vai trò thành công");

            $('#createRoleModal').modal('hide');

            $role_table.ajax.reload();

        } else {

            if(!IsNull(data.message)) {
                toastr.error(data.message);
            }
        }

    },
    error: function (xhr, ajaxOptions, thrownError) {
          toastr.error(thrownError);
        }
      });

  });

//edit
$('body').on('click', '.editRole', function() {
    $('#editRoleModal').modal('show');
    var id = $(this).data('id');
    $.ajax({
          type: "GET",
          url: app_url + '/admin/roles/' + id,
          success: function(res)
          {

            $('#edit_name').val(res.data.name);
            $('#edit_id').val(res.data.id);
            $('#edit_name').focus();
            $('#edit_display_name').val(res.data.display_name);
            $('#edit_display_name').focus();
            $('#edit_description').val(res.data.description);
          },
          error: function (xhr, ajaxOptions, thrownError) {
            toastr.error(thrownError);
          }
    });


    $('#edit-role').on('submit',function(e){

          e.preventDefault();

          var form= $('#edit-role');
          var formData= form.serialize();

          if(! form.valid()) return false;

          $.ajax({
            type:'PUT',
            url: app_url + '/admin/roles/' + id,
            data: formData,
            success:function(data){
                if(!data.error) {

                    toastr["success"]("Cập nhật vai trò thành công");

                    $('#editRoleModal').modal('hide');

                    $role_table.ajax.reload();


                } else {

                    if(!IsNull(data.message.name )) {
                        toastr.error(data.message.name[0]);
                    }
                    if(!IsNull(data.message.display_name)) {
                        toastr.error(data.message.display_name[0]);
                    }

                }

            },
            error: function (xhr, ajaxOptions, thrownError)
            {
              toastr.error(thrownError);
            }
        });

    });
})

$('body').on('click', '.alertDel', function() {
    var id = $(this).data('id');
    var path = app_url + 'admin/roles/' + id;

    swal({
      title: "Bạn chắc chắn muốn xóa?",
      text: "Dữ liệu đã xóa không thể khôi phục!",
      icon: "warning",
      buttons: ['Hủy','Xóa'],
      dangerMode: true,

        // closeOnConfirm: false,
    })
    .then((willDelete) => {
      if (willDelete) {
        $.ajax({
              type: "DELETE",
              url: path,
              success: function(res)
              {
                if(!res.error) {
                    toastr.success('Xóa thành công!');
                    $role_table.ajax.reload();
                }
              },
              error: function (xhr, ajaxOptions, thrownError) {
                toastr.error(thrownError);
              }
        });

        } else {
            toastr.info("Thao tác xóa đã bị huỷ bỏ!");
        }
    });
});

$(function() {
    var name = $('#role-permissions-table').data('name');
    
    $('#role-permissions-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: app_url + 'admin/roles/list-permissions/' + name,
        columns: [
            {data: 'id', name: 'id'},
            {data: 'display_name', name: 'display_name'},
            // {data: 'name', name: 'name'},
            {data: 'description', name: 'description'},
            // {data: 'created_at', name: 'created_at'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });
});

$('body').on('click', '.addPermission', function() {
    var role_id = $(this).data('role');

    var permission_id = $(this).data('permission');

    var checked = $('#checked-' + permission_id).val();

        $.ajax({
              type: "POST",
              url: app_url + 'admin/roles/permissions',
              data: {
                role_id: role_id,
                permission_id: permission_id,
                checked: checked,
              },
              success: function(res)
              {

                if (res.message == 'deleted') {
                  $('#action-' + permission_id).removeClass('fa-check-circle').addClass('fa-circle-o');
                  $('#checked-' + permission_id).val(0);
                  toastr.success('Xóa thành công');
                }

                if (res.message == 'added') {
                  $('#action-' + permission_id).removeClass('fa-circle-o').addClass('fa-check-circle');
                  $('#checked-' + permission_id).val(1);
                  toastr.success('Thêm thành công');
                }


              },
              error: function (xhr, ajaxOptions, thrownError) {

                console.log('error');

                toastr.error(thrownError);
              }
        });
})
