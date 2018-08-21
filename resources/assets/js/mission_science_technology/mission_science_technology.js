$(document).ready(function() {

  $('#science-technology-tbl').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: app_url + 'mission-science-technology/get-list',
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

  $('#register-mission-btn').on('click', function() {
      $("#name").val("");
      $("#round_collection_id").val("-1");
  })

  $('#expected_fund').autoNumeric('init', {
    aSign: ' VNĐ',
    pSign: 's',
    mDec: '0',
    vMin: '0'
  });

  $.validator.addMethod("valueNotEquals", function(value, element, arg){
    return arg !== value;
   }, "Value must not equal arg.");

  $('#create-science-technology-frm').validate({
    errorElement: "span",

    rules: {
      name: {
        required: true,
        minlength: 10
      },
      expected_fund: {
        required: true,
        minCustom: '100,000 đ'
      },
      round_collection_id: {
        valueNotEquals: "-1"
     },
    },
    messages: {
      name: {
        required: "Tên dự án khoa học và công nghệ",
        minlength: jQuery.validator.format("Tên nhiệm vụ phải lớn hơn {0} ký tự!")
      },
      expected_fund: {
        required: "Dự kiến nhu cầu kinh phí không được bỏ trống",
        minCustom: jQuery.validator.format("Dự kiến nhu cầu kinh phí phải lớn hơn {0}")
      },
      round_collection_id : {
        valueNotEquals: "Vui lòng chọn đợt gọi hồ sơ"
      }
    }
  });

  $('#create-science-technology-btn').on('click', function() {

    if (!$('#create-science-technology-frm').valid()) {

      return false;
    }

    $.ajax({
      type: "POST",
      url: app_url + "/mission-science-technology/store",
      data: $('#create-science-technology-frm').serialize(),
      success: function(res) {
        // console.log(res);
        if (!res.error) {
        	toastr.success(res.message);

          setTimeout(function () {
              location.href = app_url + 'mission-science-technology/edit/' + res.key;
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

  // form update
  $('#frm-update-mission-science-technology').validate({
    rules: {
      name: {
        required: true,
        minlength: 10
      },
      provenance_originate: {
        required: true,
        minlength: 10
      },
      importance: {
        required: true,
        minlength: 10
      },
      target: {
        required: true,
        minlength: 10
      },
      content: {
        required: true,
        minlength: 10
      },
      request_result: {
        required: true,
        minlength: 10
      },
      application_address: {
        required: true,
        minlength: 10
      },
      request_time: {
        required: true,
        minlength: 10
      },
      qualification: {
        required: true,
        minlength: 10
      },

      expected_fund: {
        required: true,
        minCustom: '100,000 đ'
      },
      plan_mobilize: {
        required: true,
        minlength: 10
      },
      economic_efficiency: {
        required: true,
        minlength: 10
      },
      science_technology_efficiency: {
        required: true,
        minlength: 10
      },
      evaluation_form_01 : {
        requiredFile: true,
        extension: 'pdf',
        filesize: max_file_size,
      },
      evaluation_form_02 : {
        requiredFile: true,
        extension: 'pdf',
        filesize: max_file_size,
      },
    },
    messages: {
      name: {
        required: "Trường không được bỏ trống",
        minlength: jQuery.validator.format("Trường phải lớn hơn {0} ký tự!")
      },
      provenance_originate: {
        required: "Trường không được bỏ trống",
        minlength: jQuery.validator.format("Trường phải lớn hơn {0} ký tự!")
      },
      importance: {
        required: "Trường không được bỏ trống",
        minlength: jQuery.validator.format("Trường phải lớn hơn {0} ký tự!")
      },
      target: {
        required: "Trường không được bỏ trống",
        minlength: jQuery.validator.format("Trường phải lớn hơn {0} ký tự!")
      },
      content: {
        required: "Trường không được bỏ trống",
        minlength: jQuery.validator.format("Trường phải lớn hơn {0} ký tự!")
      },
      request_result: {
        required: "Trường không được bỏ trống",
        minlength: jQuery.validator.format("Trường phải lớn hơn {0} ký tự!")
      },
      application_address: {
        required: "Trường không được bỏ trống",
        minlength: jQuery.validator.format("Trường phải lớn hơn {0} ký tự!")
      },
      request_time: {
        required: "Trường không được bỏ trống",
        minlength: jQuery.validator.format("Trường phải lớn hơn {0} ký tự!")
      },
      expected_fund: {
        required: "Dự kiến nhu cầu kinh phí không được bỏ trống",
        minCustom: jQuery.validator.format("Dự kiến nhu cầu kinh phí phải lớn hơn {0}")
      },
      qualification: {
        required: "Trường không được bỏ trống",
        minlength: jQuery.validator.format("Trường phải lớn hơn {0} ký tự!")
      },
      plan_mobilize: {
        required: "Trường không được bỏ trống",
        minlength: jQuery.validator.format("Trường phải lớn hơn {0} ký tự!")
      },
      expected_effect: {
        required: "Trường không được bỏ trống",
        minlength: jQuery.validator.format("Trường phải lớn hơn {0} ký tự!")
      },
      economic_efficiency: {
        required: "Trường không được bỏ trống",
        minlength: jQuery.validator.format("Trường phải lớn hơn {0} ký tự!")
      },
      science_technology_efficiency: {
        required: "Dự kiến nhu cầu kinh phí không được bỏ trống",
        minCustom: jQuery.validator.format("Dự kiến nhu cầu kinh phí phải lớn hơn {0}")
      }
      ,evaluation_form_01 : {
        requiredFile: '(*) Vui lòng đính kèm file',
        extension: 'Chỉ file .pdf được chấp nhận',
        filesize: "Dung lượng file đính kèm không được lớn hơn {0} MB",
      }
      ,evaluation_form_02 : {
        requiredFile: '(*) Vui lòng đính kèm file',
        extension: 'Chỉ file .pdf được chấp nhận',
        filesize: "Dung lượng file đính kèm không được lớn hơn {0} MB",
      },
    }
  });

  $('#update-science-technology-btn').on('click', function() {

    // if ($('#frm-update-mission-science-technology').length > 0) {
    //   if (!$('#frm-update-mission-science-technology').valid()) {

    //     return false;
    //   }
    // }

    var formData = new FormData($('#frm-update-mission-science-technology')[0]);

    $.ajax({
      processData: false,
      contentType: false,
      type: "POST",
      url: app_url + "/mission-science-technology/update",
      data: formData,
      success: function(res) {
        // console.log(res);
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

  $("#science-technology-tbl").on('click', '.btn-delete-mission ', function(){
    var key = $(this).attr("data-key");

    swal({
      title: "Bạn có chắc chắn muốn xóa?",
      icon: "warning",
      buttons: ['Hủy','Xóa'],
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
        $.ajax({
          url: app_url + '/mission-science-technology/destroy',
          type: 'POST',
          data: { key },
          success: function(res) {
            // console.log(res);
            if (res.error != true) {
              toastr.success(res.message);

              $("#science-technology-tbl").DataTable().ajax.reload();

            }
          }
        });
      };
    });
  });

  $(".btn-view-file").on('click', function(event) {
    event.preventDefault();
    /* Act on the event */
    var key = $("#key").val();
    var link = $(this).attr("data-link");
    var order = $(this).attr("data-order");

    $.ajax({
      url: app_url + '/mission-science-technology/viewFile',
      type: 'POST',
      data: {
        key: key,
        link: link,
        order: order
      },
      success: function (res){
        if (res.error != true) {
          window.open(res.link, "_blank");
          // window.location.href = res.link;
        }

      }
    });

  });

  $('.evaluation_form').on('change', function() {
    var fd = new FormData();
    order = $(this).data('order');
    fd.append('file', $(this)[0].files[0]);
    fd.append('order', order);
    fd.append('key', $('#key').val());

    $.ajax({
      cache: false,
      contentType: false,
      processData: false,
      url: app_url + 'mission-science-technology/uploadFile',
      type: 'Post',
      data: fd,
      success: function(res) {
        if (res.error) {
          // console.log(res);
          toastr.error(res.message);
        }
      }
    });

  });

  $('#btn_submit_ele_copy').on('click', function(event) {
    event.preventDefault();
    /* Act on the event */

    // if ($('#frm-update-mission-science-technology').length > 0) {
    //   if (!$('#frm-update-mission-science-technology').valid()) {

    //     return false;
    //   }
    // }

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
            url:  app_url + "/mission-science-technology/submit_ele_copy/",
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
                if (res.msg == "Not Filled") {
                  swal({
                    title: "Vui lòng điền đẩy đủ thông tin vào phiếu đăng ký nhiệm vụ !",
                    text: "",
                    icon: "warning",
                    button: "Đóng",
                    dangerMode: true,
                  });
                }else {
                  toastr.error(res.msg);

                  if (res.reload == true) {
                    setTimeout(function() {
                      location.reload();
                    }, 1000);
                  }
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
