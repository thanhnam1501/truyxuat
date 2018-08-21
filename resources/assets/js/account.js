$(document).ready(function() {
  //var app_url = $('meta[name="website"]').attr('content');

  $('#create-user-frm').validate({
    rules: {
      representative: {
        required: true,
        minlength: 6
      },
      email: {
        required: true,
        email: true,
        minlength: 6
      }
    },
    messages: {
      representative: {
        required: "Tên cá nhân / tổ chức không được bỏ trống",
        minlength: jQuery.validator.format("Họ và tên phải có ít nhất {0} ký tự!")
      },
      email: {
        required: "Email không được bỏ trống",
        email: "Email không đúng định dạng ( example@gmail.com )",
        minlength: jQuery.validator.format("Email phải có ít nhất {0} ký tự!")
      }
    }
  });

  $('#create-user-btn').on('click', function() {

    if ($('#create-user-btn').data('type') == 1) {

      var url = app_url + 'admin/account-profiles/'+$('#create-user-btn').data('scientist_id');

      var type = "PUT";

    } else {

      var url = app_url + 'admin/account-profiles';

      var type = "POST";

      if (checkEmail($('#email').val())) {

          return false;
      }
    }

    if (!$('#create-user-frm').valid()) {

        return false;
    }

    $.ajax({
        type: type,
        url:  url,
        data: $('#create-user-frm').serialize(),
        success: function(res)

        {
          if (!res.error) {

            toastr.success(res.message);
            $('#user-tbl').DataTable().ajax.reload();
            $('#create-user-mdl').modal('hide');
            $('#create-user-frm').trigger('reset');
          } else {

            toastr.error(res.message);
          }
        },
        error: function (xhr, ajaxOptions, thrownError) {
          toastr.error(thrownError);
        }
    });

  })

  $('#email').on('change', function() {

      checkEmail($(this).val());
  })

  $(function() {

      $('#user-tbl').DataTable({
          processing: true,
          serverSide: true,
          ajax: {
            url: app_url + 'admin/account-profiles/get-list',
            type: 'post',
          },
          ordering: false,
          columns: [
              {data: 'DT_Row_Index', name: 'DT_Row_Index', 'searchable':false, 'class':'text-center', width: '80px'},
              {data: 'representative', name: 'representative'},
              {data: 'mobile', name: 'mobile'},
              {data: 'email', name: 'email', width: '300px'},
              {data: 'organization', name: 'organization.name'},
              {data: 'status', name: 'status', 'searchable':false, width: '150px', 'class':'text-center'},
              {data: 'action', name: 'action', 'searchable':false, 'class':'text-center'},
          ]
      });
  });

  function checkEmail(email)
  {
    var flag = true;

    $.ajax({
        async: false,
        type: "GET",
        url: app_url + 'admin/account-profiles/check-email/' + email,
        success: function(res)
        {
          if (!res.exists) {

              $('#email').parent().removeClass('has-error');

              $('#email-error-custom').addClass('hide');

              $('#email-error-custom').text("");

              flag = false;

          } else {

              $('#email').parent().addClass('has-error');

              $('#email-error-custom').text('Email đã tồn tại, vui lòng sử dụng email khác');

              $('#email-error-custom').removeClass('hide');
          }
        },
        error: function (xhr, ajaxOptions, thrownError) {
          toastr.error(thrownError);
        }
    });

    return flag;
  }

  $('#user-tbl').on('change','.lock-account', function() {

      var status = 0;
      var profile_id = $(this).data('profile_id');

      if ($(this).is(':checked')) {

          status = 1;
      }

      $.ajax({
          type: "POST",
          url:  app_url + "admin/account-profiles/lock",
          data: {
              status: status,
              profile_id: profile_id,
          },
          success: function(res)

          {
            if (!res.error) {

              toastr.success(res.message);
              $('#user-tbl').DataTable().ajax.reload();

            } else {

              toastr.error(res.message);
            }
          },
          error: function (xhr, ajaxOptions, thrownError) {
            toastr.error(thrownError);
          }
      });

  })

  $('#user-tbl').on('click', '.delete-btn', function() {

    swal({
      title: "Bạn chắc chắn muốn xóa?",
      text: "Dữ liệu đã xóa không thể khôi phục!",
      icon: "warning",
      buttons: ['Hủy','Xóa'],
      dangerMode: true,
      })
      .then((willDelete) => {
      if (willDelete) {
        $.ajax({
            type: "DELETE",
            url:  app_url + "admin/account-profiles/"+$(this).data('id'),
            success: function(res)
            {
              if (!res.error) {

                toastr.success(res.message);
                $('#user-tbl').DataTable().ajax.reload();
              } else {

                toastr.error(res.message);
              }
            },
            error: function (xhr, ajaxOptions, thrownError) {
              toastr.error(thrownError);
            }
        });
      }
    });
  });

  $('#send-email').on('click', function(){
     $('#modal-send-email').modal('show');
  });
});
