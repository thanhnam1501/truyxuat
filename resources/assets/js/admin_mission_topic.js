$(document).ready(function() {
  
  $('#expected_fund').autoNumeric('init', {
    aSign: ' VNĐ',
    pSign: 's',
    mDec: '0',
    vMin: '0'
  });

  $('#topic-tbl').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: app_url + 'admin/mission-topics/get-list-submit-ele-copy',
        type: 'post',
      },
      ordering: false,
      columns: [
        {data: 'DT_Row_Index', name: 'DT_Row_Index', 'class':'text-center','searchable':false},
        {data: 'action', name: 'action', 'searchable':false, 'class':'text-center'},
        {data: 'mission_name', name: 'values.mission_name'},
        {data: 'organization', name: 'organization.name'},
        {data: 'profile', name: 'profile'},
        {data: 'request_time', name: 'request_time', 'class':'text-center'},
        {data: 'target', name: 'target', 'class':'text-center'},
        {data: 'request_result', name: 'request_result', 'class':'text-center'},
        {data: 'expected_fund', name: 'expected_fund', 'class':'text-center'},
        {data: 'status', name: 'status', 'class':'text-center'},
          
      ]
  });

  $('#approval-topic-tbl').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: app_url + 'admin/mission-topics/get-submit-hard-list',
        type: 'POST',
      },
      ordering: false,
      // searching: false,
      columns: [
        {data: 'DT_Row_Index', name: 'DT_Row_Index', 'class':'text-center','searchable':false},
        {data: 'action', name: 'action', 'searchable':false, 'class':'text-center'},
        {data: 'mission_name', name: 'values.mission_name'},
        // {data: 'organization', name: 'organization.name'},
        // {data: 'profile', name: 'profile'},
        {data: 'request_time', name: 'request_time', 'class':'text-center'},
        {data: 'target', name: 'target', 'class':'text-center'},
        {data: 'request_result', name: 'request_result', 'class':'text-center'},
        {data: 'expected_fund', name: 'expected_fund', 'class':'text-center'},
        {data: 'status', name: 'status', 'class':'text-center'},
      ]
  });


    $('#evaluation-topic-tbl').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: app_url + 'admin/mission-topics/get-list-evaluation',
        type: 'post',
      },
      ordering: false,
      searching: false,
      columns: [
          {data: 'DT_Row_Index', name: 'DT_Row_Index', 'class':'text-center','searchable':false},
          {data: 'action', name: 'action', 'searchable':false, 'class':'text-center'},
          {data: 'values', name: 'values.value', width: '228px'},
          {data: 'profile', name: 'profile.email', width: '110px'},
          {data: 'roundCollection', name: 'roundCollection.name', 'class':'text-center', width: '114px'},
          {data: 'type', name: 'type', 'class':'text-center', width: '80px'},
          {data: 'status', name: 'status', 'class':'text-center', width: '90px'},
          
      ]
  });


    $('#list-invalid-doc-tbl').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: app_url + 'admin/mission-topics/get-list-invalid-topic',
        type: 'post',
      },
      ordering: false,
      searching: false,
      columns: [
          {data: 'DT_Row_Index', name: 'DT_Row_Index', 'class':'text-center','searchable':false},
          {data: 'action', name: 'action', 'searchable':false, 'class':'text-center'},
          {data: 'mission_name', name: 'values.mission_name'},
          // {data: 'organization', name: 'organization.name'},
          // {data: 'profile', name: 'profile'},
          {data: 'request_time', name: 'request_time', 'class':'text-center'},
          {data: 'target', name: 'target', 'class':'text-center'},
          {data: 'request_result', name: 'request_result', 'class':'text-center'},
          {data: 'expected_fund', name: 'expected_fund', 'class':'text-center', width: '50px'},
          {data: 'status', name: 'status', 'class':'text-center', width: '90px'},
            
        ]
  });

  $('#topic-tbl').on('click','.submit-hard-copy-btn', function() {

    swal({
      title: "Bạn có chắc chắn nhận bản cứng hoàn thiện của hồ sơ này?",
      icon: "info",
      buttons: ['Hủy','Đồng ý'],
      confirmButtonColor: "#1caf9a",
      })
      .then((willDelete) => {
      if (willDelete) {
        $.ajax({
            type: "POST",
            url:  app_url + "admin/mission-topics/submit-hard-copy",
            data: {
              id: $(this).data('id'),
              mission_name: $(this).data('name')
            },
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


  // 
  $('body').on('click','.approve-btn', function() {
      $('#id').val($(this).data('id'));
      var mission_name = $(this).data('name');
      $('#mission_name').val(mission_name);
  });

  $('#approve-frm').validate({
    rules: {
      is_performed: {
        requiredSelect: true,
      },
      list_categories: {
        extension: 'doc|docx|pdf',
        filesize: 5,
      }
    },
    messages: {
      is_performed: {
        requiredSelect: "Vui lòng chọn trạng thái",
      },
      list_categories: {
        extension: 'Chỉ file *.doc, *.docx, *.pdf và file dưới 5Mb được chấp nhập',
        filesize: 'File không được lớn hơn 5Mb',
      }
    }
  });

  $('#approve-submit-btn').on('click', function() {

      if ($('#is_performed').val() == 0 && ($('#is_unperformed_reason').val() == null || $('#is_unperformed_reason').val().length < 10)) {

        $('#is_unperformed_reason').next().text('Lý không được phê duyệt không được bỏ trống và phải lớn hơn 10 ký tự');

        return false;
      } else {

        $('#is_unperformed_reason').next().text('');
      }

      if ($('#approve-frm').valid()) {
        $.ajax({
            type: "POST",
            url:  app_url + "admin/mission-topics/approve-mission",
            data: $('#approve-frm').serialize(),
            success: function(res)
            {
              if (!res.error) {

                toastr.success(res.message);

                $('#approve-mdl').modal('hide');

                $('#approve-frm').trigger('reset');

                $('#list-invalid-doc-tbl').DataTable().ajax.reload();

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

    $('#list_categories').on('change', function() {
      var fd = new FormData();
      fd.append('file', $(this)[0].files[0]);
      fd.append('id', $('#id').val());

      $.ajax({
        cache: false,
        contentType: false,
        processData: false,
        url: app_url + 'admin/mission-topics/upload-list-categories',
        type: 'Post',
        data: fd,
        success: function(res) {
          if (res.error) {
            toastr.error(res.message);
          }
        }
      });

    });

// submit valid
  $(document).on('click','.submit-valid', function(event) {
    event.preventDefault();
    /* Act on the event */
    $('#modal-valid').modal('show');
    $('#status').val('-1');
    $('#invalid_reason').val('');
    // $('#checkbox-send-email').attr('checked', 'checked');
    $('#invalid_reason').attr('disabled', 'disabled');

    var data_id = $(this).attr('data-id');
    $('#modal-valid .btn-success').attr('data_id', data_id);

    var mission_name = $(this).data('name');
    $('#modal-valid .btn-success').attr('mission_name', mission_name);

  });

  $('#modal-valid').on('click', '.btn-success', function(event) {
    event.preventDefault();
    /* Act on the event */
    var status = $('#status').val();
    var reason = $('#invalid_reason').val();
    var checkbox = $('#checkbox-send-email').is(':checked');
    var data_id = $('#modal-valid .btn-success').attr('data_id');
    var mission_name = $('#modal-valid .btn-success').attr('mission_name');

    if (status == -1) {
      toastr.error('Vui lòng chọn trạng thái hồ sơ ! ');
    }
    else if (status == 'invalid' && reason == "") {
      toastr.error('Vui lòng nhập lý do hồ sơ không hợp lệ ! ');
    } else {
      $.ajax({
        url: app_url + 'admin/mission-topics/submit-valid',
        type: 'POST',
        data: {
          status: status,
          reason: reason,
          checkbox: checkbox,
          id: data_id,
          mission_name: mission_name
        }, success: function(res){
          if (!res.error) {

            toastr.success(res.message);
            $('#modal-valid').modal('hide');
            $('#approval-topic-tbl').DataTable().ajax.reload();

          } else {

            toastr.error(res.message);
          }
        }, error: function (xhr, ajaxOptions, thrownError) {
          toastr.error(thrownError);
        }
      });
    }

  });

  $('#modal-valid').on('change', '#status', function(event) {
    var result = $(this).val();

    if (result == 'valid') {
      $('#invalid_reason').val('');
      $('#invalid_reason').attr('disabled', 'disabled');
    } else if (result == 'invalid') {
      $('#invalid_reason').removeAttr('disabled');
    }
  });

  // submit judged

    $('body').on('click','.submit-judged', function(event) {
      event.preventDefault();
      /* Act on the event */
      $('#modal-judged').modal('show');
      $('#status_judged').val('-1');
      $('#denied_reason').val('');
      // $('#checkbox-send-email-judged').attr('checked', 'checked');
      $('#denied_reason').attr('disabled', 'disabled');

      var data_id = $(this).data('id');
      $('#modal-judged .btn-success').attr('data_id', data_id);

      var mission_name = $(this).data('name');
      $('#modal-judged .btn-success').attr('mission_name', mission_name);

    });

    $('#modal-judged').on('click', '.btn-success', function(event) {
      event.preventDefault();
      /* Act on the event */
      var fd = new FormData();
      fd.append('attachment_file_judged', $('#attachment_file_judged')[0].files[0]);

      fd.append('status', $('#status_judged').val());
      fd.append('reason', $('#denied_reason').val());
      fd.append('checkbox', $('#checkbox-send-email-judged').is(':checked'));
      fd.append('id', $('#modal-judged .btn-success').attr('data_id'));
      fd.append('mission_name', $('#modal-judged .btn-success').attr('mission_name'));

      var status = $('#status_judged').val();
      // var reason = $('#denied_reason').val();
      // var checkbox = $('#checkbox-send-email-judged').is(':checked');
      // var data_id = $('#modal-judged .btn-success').attr('data_id');
      // var mission_name = $('#modal-judged .btn-success').attr('mission_name');

      if (status == -1) {
        toastr.error('Vui lòng chọn trạng thái xét duyệt ! ');
      }
      else if (status == 'denied' && reason == "") {
        toastr.error('Vui lòng nhập lý do từ chối hồ sơ ! ');
      }
      else if ($('#attachment_file_judged')[0].files[0].size > 5000000) {
        toastr.error('Dung lượng file không được phép lớn hơn 5 Mb ! ');
      } else {
        $.ajax({
          url: app_url + 'admin/mission-topics/submit-judged',
          type: 'POST',
          data: fd, 
          cache: false,
          contentType: false,
          processData: false,
          success: function(res){

            if (!res.error) {

              toastr.success(res.message);
              $('#modal-judged').modal('hide');
              $('#list-invalid-doc-tbl').DataTable().ajax.reload();

            } else {

              toastr.error(res.message);
            }
          }, error: function (xhr, ajaxOptions, thrownError) {
            toastr.error(thrownError);
          }
        });
      }

    });

    $('#modal-judged').on('change', '#status_judged', function(event) {
      var result = $(this).val();

      if (result == 'judged') {
        $('#denied_reason').val('');
        $('#denied_reason').attr('disabled', 'disabled');
      } else if (result == 'denied') {
        $('#denied_reason').removeAttr('disabled');
      }
    });

  $('body').on('click',' .assign-doc', function(){
    $('#modal-assign').modal('show');

    var data_id = $(this).attr('data-id');
    $('#mission_id').val(data_id);
  });

  $('#deadline').datetimepicker({format: "YYYY-MM-DD HH:mm:ss",
    minDate: moment()});

  $('#modal-assign').on('click','#btn-submit-devolve', function(event){
    event.preventDefault(); 
    var user_devolve = $("#role_user_devolve_file").val();
    var user_hanle = $("#role_user_handle_file").val();
    var deadline = $('#deadline-group').find("input").val();
    var note = $('#note').val();

    if (user_devolve == '-1') {
      $("#role_user_devolve_file").next().text("Vui lòng chọn người giao hồ sơ");
      return false;
    } else {
      $("#role_user_devolve_file").next().text("");
    }

    if (user_hanle == '-1') {
      $("#role_user_handle_file").next().text("Vui lòng chọn người xử lý hồ sơ");
      return false;
    }else {
      $("#role_user_handle_file").next().text("");
    }

    if (deadline == "") {
      $("#err-deadline").text("Vui lòng chọn hạn xử lý hồ sơ");
      return false;
    }else {
      $("#err-deadline").text("");
    }

    $.ajax({
      url: app_url + "/admin/mission-topics/submit-assign",
      type: 'POST',
      data: {
        admin_id : user_devolve,
        user_id : user_hanle,
        deadline: deadline,
        note: note,
        mission_id : $('#mission_id').val()
      },
      success: function (res){
        if (res != null) {
          if (res != true) {
            toastr.success(res.msg);
            $("#topic-tbl").DataTable().ajax.reload();
            $("#role_user_devolve_file").val("-1");
            $("#role_user_handle_file").val("-1");
            $('#deadline-group').find("input").val("");
            $('#note').val("");

            $("#modal-assign").modal("hide");

            
          }
        }
      }, error: function (err){

      }
    });
    
  });

  $('#add-council-submit-btn').on('click', function() {

    if (IsNull($('input[name=council_id]:checked').val())) {
      toastr.error('Vui lòng chọn hội đồng');
      return ;
    }
    else {
      var council_id = $('input[name=council_id]:checked').val();
      var mission_topic_id = $('#add-council-submit-btn').data('mission_id');

      $.ajax({
        url: app_url + 'admin/mission-topics/add-council',
        type: 'post',
        data: {
          council_id: council_id,
          mission_topic_id: mission_topic_id,
          group_council_id: $('#group_council').val(),
        },
        success: function(res) {
          if (!res.error) {
            $('#addCouncilModal').modal('hide');
            toastr.success(res.message);
            $('#topic-tbl').DataTable().ajax.reload();
            
          }
          else {
            toastr.error(res.message);
          }
        },
        error: function(xhr, ajaxOptions, thrownError) {
          toastr.error(thrownError);
        }
      });
      
    }

  })

    $('body').on('click', '.add-council-btn', function(e) {
    e.preventDefault();
    
   $('#addCouncilModal').modal('show'); 

   var id = $(this).data('id');

   $('#add_council_mission_id').val(id);
   $.ajax({
     url: app_url + 'admin/mission-topics/get-round-collection/' + id,
     type: 'GET',
     success: function(res) {

        $('#add-council-submit-btn').attr('data-mission_id', id);
        $('#round_collection_add_council').html(res.year + ' - ' + res.name);
        $('#year_round_collection').html(res.year);
        // $('#list-council-tbl').attr('data-round_colection_id', res.id);
        $('#round_collection_id').val(res.id);

        $('#list-council-tbl').DataTable().destroy();
        $('#list-council-tbl').DataTable({
          searching: false,
          paginate: false,
          ordering: false,
          ajax: {
            url: app_url + 'admin/mission-topics/get-list-council',
            type: 'post',
            data: {
              mission_id : id,
              round_collection_id : res.id,
              group_council_id: $('#group_council').val(),
            }
          },
        columns: [
          {data: 'DT_Row_Index', name: 'DT_Row_Index', 'class':'text-center', 'searchable':false},
          {data: 'name', name: 'name', 'class':'text-center'},
          {data: 'chairman_name', name: 'chairman_name'},
          {data: 'group_council', name: 'group_council', 'class':'text-center'},
          {data: 'round_collection', name: 'round_collection','class':'text-center'},
          {data: 'action', name: 'action', 'searchable':false, 'class':'text-center'},
          {data: 'choose', name: 'choose', 'searchable':false, 'class':'text-center'},
        ]
        });        

     }
   
   });
        
  })

  $('#group_council').on('change', function() {
    var group_council_id = $(this).val();

    var round_collection_id = $('#round_collection_id').val();

    $('#list-council-tbl').DataTable().destroy();

    $('#list-council-tbl').DataTable({
          ajax: {
            url: app_url + 'admin/mission-topics/get-list-council',
            type: 'post',
            data: {
              round_collection_id : round_collection_id,
              group_council_id: group_council_id,
            }
          },
        searching: false,
        paginate: false,
        ordering: false,
        columns: [
          {data: 'DT_Row_Index', name: 'DT_Row_Index', 'class':'text-center','searchable':false},
          {data: 'name', name: 'name', 'class':'text-center'},
          {data: 'chairman_name', name: 'chairman_name'},
          {data: 'group_council', name: 'group_council', 'class':'text-center'},
          {data: 'round_collection', name: 'round_collection', 'class':'text-center'},
          {data: 'action', name: 'action', 'searchable':false, 'class':'text-center'},
          {data: 'choose', name: 'choose', 'searchable':false, 'class':'text-center'},
        ]
        });        
    
  });

  $('body').on('click', '.btn-give-back-hard-copy', function(event){
    event.preventDefault();

    swal({
      title: "Bạn có chắc chắn muốn trả lại bản cứng?",
      icon: "warning",
      buttons: ['Hủy','Đồng ý'],
      confirmButtonColor: "#1caf9a",
      })
      .then((willDelete) => {
      if (willDelete) {
        $.ajax({
            type: "POST",
            url:  app_url + "admin/mission-topics/give-back-hard-copy",
            data: {
              id: $(this).data('id'),
            },
            success: function(res)
            {
              // console.log(res);
              if (!res.error) {

                toastr.success(res.msg);

                $('#topic-tbl').DataTable().ajax.reload();

              } else {

                toastr.error(res.msg);
              }
            },
            error: function (xhr, ajaxOptions, thrownError) {
              toastr.error(thrownError);
            }
        });
      }
    });
  });

  $('#btn-search-mission').on('click', function(event) {
    event.preventDefault();

    $('#topic-tbl').DataTable().destroy();

    $('#topic-tbl').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: app_url + 'admin/mission-topics/get-list-submit-ele-copy',
        type: 'POST',
        data: {
          data: $('#search-mission-frm').serialize(),
          filter: true
        }
      },
      ordering: false,
      columns: [
        {data: 'DT_Row_Index', name: 'DT_Row_Index', 'class':'text-center','searchable':false},
        {data: 'action', name: 'action', 'searchable':false, 'class':'text-center'},
        {data: 'mission_name', name: 'values.mission_name'},
        {data: 'organization', name: 'organization.name'},
        {data: 'profile', name: 'profile'},
        {data: 'request_time', name: 'request_time', 'class':'text-center'},
        {data: 'target', name: 'target', 'class':'text-center'},
        {data: 'request_result', name: 'request_result', 'class':'text-center'},
        {data: 'expected_fund', name: 'expected_fund', 'class':'text-center'},
        {data: 'status', name: 'status', 'class':'text-center'},
      ]
    });

  });

  $('body').on('click', '#viewListMember', function() {
    var id = $(this).data('id');

    $('#list-member-council-tbl').DataTable().destroy();

    $('#list-member-council-tbl').DataTable({
      searching: false,
      paginate: false,
      ordering: false,
      ajax: {
        url: app_url + 'admin/mission-topics/list-member-council/' + id,
        type: 'GET',
      },
      columns: [
        {data: 'DT_Row_Index', name: 'DT_Row_Index', 'class':'text-center',width: '15px'},
        {data: 'name', name: 'name', width: '70px'},
        {data: 'mobile', name: 'mobile' },
        {data: 'email', name: 'email', 'class':'text-center'},
        {data: 'position', name: 'position', 'class':'text-center', width: '50px'},
      ]
    });
  })
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
        //requiredFile: true,
      },
      evaluation_form_02 : {
        extension: 'pdf',
        filesize: max_file_size,
        //requiredFile: true,
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
        //requiredFile: '(*) Vui lòng đính kèm file',
      },
      evaluation_form_02 : {
        extension: '(*) Chỉ nhận định dạng PDF',
        filesize: '(*) Dung lượng file không được lớn hơn 5Mb',
        //requiredFile: '(*) Vui lòng đính kèm file',
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
      url: app_url + "admin/mission-topics/update",
      data: $('#update-topic-frm').serialize(),
      success: function(res) {
        if (!res.error) {

          toastr.success(res.message);

          setTimeout(function() {
            location.href = app_url + 'admin/mission-topics';
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
