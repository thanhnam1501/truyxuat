$(document).ready(function() {

  $('#topic-tbl').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: app_url + 'mission-topics/get-list',
        type: 'post',
      },
      ordering: false,
      columns: [
          {data: 'DT_Row_Index', name: 'DT_Row_Index', 'class':'text-center', width: '30px','searchable':false},
          {data: 'code', name: 'code', 'class':'text-center', width:'200px'},
          {data: 'values', name: 'values.value',width: '300px'},
          {data: 'type', name: 'type', width: '80px'},
          {data: 'roundCollection', name: 'roundCollection.name', 'class':'text-center', width: '100px'},
          {data: 'status', name: 'status', width: '150px', 'class':'text-center', searchable: false},
          {data: 'action', name: 'action', 'searchable':false, 'class':'text-center'},
      ]
  });

  $('#expected_fund').autoNumeric('init', {
    aSign: ' VNĐ',
    pSign: 's',
    mDec: '0',
    vMin: '0'
  });

  $.validator.addMethod("valueNotEquals", function(value, element, arg){
    return arg !== value;
   }, "Value must not equal arg.");

  $('#create-topic-frm').validate({
    rules: {
      name: {
        required: true,
        minlength: 10
      },
      round_collection_id: {
        valueNotEquals: "-1"
      },
    },
    messages: {
      name: {
        required: "Tên nhiệm vụ không được bỏ trống",
        minlength: jQuery.validator.format("Tên nhiệm vụ phải lớn hơn {0} ký tự!")
      },
      round_collection_id : {
        valueNotEquals: '(*) Vui lòng chọn đợt gọi hồ sơ'
      },
    }

  });

  $('#create-topic-mdl-btn').on('click', function() {
      $('#create-topic-frm').trigger('reset');
      $('#create-topic-mdl').modal('show');
      var childrens = $('#create-topic-frm').find('.form-control');

      for (var i = 0; i < childrens.length; i++) {
        childrens.eq(i).removeClass('valid');
      }
  });

  $('#create-topic-btn').on('click', function() {

    if (!$('#create-topic-frm').valid()) {

      return false;
    }

    $.ajax({
      type: "POST",
      url: app_url + "/mission-topics/store",
      data: $('#create-topic-frm').serialize(),
      success: function(res) {
        if (!res.error) {

          toastr.success(res.message);

          setTimeout(function() {
            location.href = app_url + 'mission-topics/edit/' + res.key;
          }, 1000)

        } else {

          toastr.error(res.message);
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        toastr.error(thrownError);
      }
    });

  });

  $('#update-topic-frm').validate({
    rules: {
      name: {
        required: true,
        minlength: 10
      },
      propose_base: {
        required: true,
        minlength: 10
      },
      urgency: {
        required: true,
        minlength: 10
      },
      target: {
        required: true,
        minlength: 10
      },
      result_target_requirement: {
        required: true,
        minlength: 10
      },
      expected_main_content: {
        required: true,
        minlength: 10
      },
      expected_result_perform: {
        required: true,
        minlength: 10
      },
      time_result_requirement: {
        required: true,
        minlength: 10
      },
      expected_fund: {
        required: true,
        minCustom: '100,000 VNĐ'
      },
      evaluation_form_01 : {
        extension: 'pdf',
        filesize: max_file_size,
        requiredFile: true,
      },
      evaluation_form_02 : {
        extension: 'pdf',
        filesize: max_file_size,
        requiredFile: true,
      },
    },
    messages: {
      name: {
        required: "Nội dung không được bỏ trống",
        minlength: jQuery.validator.format("Nội dung phải lớn hơn {0} ký tự!")
      },
      propose_base: {
        required: "Nội dung không được bỏ trống",
        minlength: jQuery.validator.format("Nội dung phải lớn hơn {0} ký tự!")
      },
      urgency: {
        required: "Nội dung không được bỏ trống",
        minlength: jQuery.validator.format("Nội dung phải lớn hơn {0} ký tự!")
      },
      target: {
        required: "Nội dung không được bỏ trống",
        minlength: jQuery.validator.format("Nội dung phải lớn hơn {0} ký tự!")
      },
      result_target_requirement: {
        required: "Nội dung không được bỏ trống",
        minlength: jQuery.validator.format("Nội dung phải lớn hơn {0} ký tự!")
      },
      expected_main_content: {
        required: "Nội dung không được bỏ trống",
        minlength: jQuery.validator.format("Nội dung phải lớn hơn {0} ký tự!")
      },
      expected_result_perform: {
        required: "Nội dung không được bỏ trống",
        minlength: jQuery.validator.format("Nội dung phải lớn hơn {0} ký tự!")
      },
      time_result_requirement: {
        required: "Nội dung không được bỏ trống",
        minlength: jQuery.validator.format("Nội dung phải lớn hơn {0} ký tự!")
      },
      expected_fund: {
        required: "Dự kiến nhu cầu kinh phí không được bỏ trống",
        minCustom: jQuery.validator.format("Dự kiến nhu cầu kinh phí phải lớn hơn {0}")
      },
      evaluation_form_01 : {
        extension: '(*) Chỉ nhận định dạng PDF',
        filesize: '(*) Dung lượng file không được lớn hơn 5Mb',
        requiredFile: '(*) Vui lòng đính kèm file',
      },
      evaluation_form_02 : {
        extension: '(*) Chỉ nhận định dạng PDF',
        filesize: '(*) Dung lượng file không được lớn hơn 5Mb',
        requiredFile: '(*) Vui lòng đính kèm file',
      },
    }
  });

  $('#update-topic-btn').on('click', function() {

    // if ($('#update-topic-frm').length > 0) {
    //   if (!$('#update-topic-frm').valid()) {

    //     return false;
    //   }
    // }

    $.ajax({
      type: "POST",
      url: app_url + "/mission-topics/update",
      data: $('#update-topic-frm').serialize(),
      success: function(res) {
        if (!res.error) {

          toastr.success(res.message);

          setTimeout(function() {
            location.reload();
          }, 1000)

        } else {

          toastr.error(res.message);
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        toastr.error(thrownError);
      }
    });

  });

  $('#topic-tbl').on('click', '.delete-btn', function() {

    swal({
      title: "Bạn chắc chắn muốn xóa?",
      icon: "warning",
      buttons: ['Hủy','Xóa'],
      dangerMode: true,
      })
      .then((willDelete) => {
      if (willDelete) {
        $.ajax({
            type: "GET",
            url:  app_url + "/mission-topics/delete/"+$(this).data('id'),
            success: function(res)
            {
              if (!res.error) {

                toastr.success(res.message);

                $('#topic-tbl').DataTable().ajax.reload();

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

  $(".btn-view-file").on('click', function(event) {
    event.preventDefault();
    /* Act on the event */
    var key = $("#key").val();
    var link = $(this).attr("data-link");
    var order = $(this).attr("data-order");

    $.ajax({
      url: app_url + '/mission-topics/viewFile',
      type: 'POST',
      data: {
        key: key,
        link: link,
        order: order
      },
      success: function (res){
        if (res.error != true) {
          window.open(res.link, "_blank");
        }
      }
    });

  });

    // $('.evaluation_form').on('change', function() {
    //   var fd = new FormData();
    //   order = $(this).data('order');
    //   fd.append('file', $(this)[0].files[0]);
    //   fd.append('order', order);
    //   fd.append('key', $('#key').val());

    //   $.ajax({
    //     cache: false,
    //     contentType: false,
    //     processData: false,
    //     url: app_url + 'mission-topics/uploadFile',
    //     type: 'Post',
    //     data: fd,
    //     success: function(res) {
    //       if (res.error) {
    //         toastr.error(res.message);
    //       }
    //     }
    //   });

    // });

    $('.btn_submit_ele_copy').on('click', function(event) {
      if ($('#update-topic-frm').length > 0) {
        if (!$('#update-topic-frm').valid()) {

          $('#tab-form-btn').click();

          toastr.error('Vui lòng nhập đầy đủ form đăng ký và lưu thông tin trước khi nộp bản mềm');

          return false;
        }
      }

      event.preventDefault();
      /* Act on the event */
      var is_submit_ele_copy = $(this).attr('data-is_submit_ele_copy');

      if (is_submit_ele_copy == 1) {
        $msg = "Xác nhận nộp hồ sơ bản mềm?";
      } else {
        $msg = "Xác nhận mở lại hồ sơ bản mềm?";
      }

      swal({
        title: $msg,
        icon: "warning",
        buttons: ['Hủy','Xác nhận'],
        dangerMode: true,
        })
        .then((willDelete) => {
        if (willDelete) {
          $.ajax({
              type: "GET",
              url:  app_url + "/mission-topics/submit_ele_copy/",
              data: {
                key: $(this).attr('data-key'),
                is_submit_ele_copy: is_submit_ele_copy,
              },
              success: function(res)
              {
                if (!res.error) {
                  toastr.success(res.msg);
                  setTimeout(function() {
                    location.reload();
                  }, 1000)

                } else {
                  // if (res.msg == "Not Filled") {
                  //   swal({
                  //     title: "Vui lòng điền đẩy đủ thông tin vào phiếu đăng ký nhiệm vụ !",
                  //     text: "",
                  //     icon: "warning",
                  //     button: "Đóng",
                  //     dangerMode: true,
                  //   });
                  // }else {
                    
                  // }
                  
                  toastr.error(res.msg);

                  if (res.reload) {
                      setTimeout(function() {
                        location.reload();
                      }, 1000)
                  }
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
