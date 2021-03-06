$(document).ready(function() {
  //var app_url = $('meta[name="website"]').attr('content');

  $('#create-user-frm').validate({
    rules: {
      name: {
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
      name: {
        required: "Tên đơn vị không được bỏ trống",
        minlength: jQuery.validator.format("Tên đơn vị phải có ít nhất {0} ký tự!")
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

      var url = app_url + 'admin/account-profile/'+$('#create-user-btn').data('profile_id');

      var type = "PUT";

    } else {

      var url = app_url + 'admin/account-profile';

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
            url: app_url + 'admin/account-profile/get-list',
            type: 'post',
          },
          ordering: false,
          columns: [
              {data: 'DT_Row_Index', name: 'DT_Row_Index', 'class':'text-center', width: '80px'},
              {data: 'name', name: 'name'},
              {data: 'email', name: 'email', width: '300px'},
              {data: 'status', name: 'status', width: '150px', 'class':'text-center'},
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
        url: app_url + 'admin/account-profile/check-email/' + email,
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
          url:  app_url + "admin/account-profile/lock",
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
            url:  app_url + "admin/account-profile/"+$(this).data('id'),
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

});
