$(document).ready(function() {

  $('#expected_fund').autoNumeric('init', {
    aSign: ' VNĐ',
    pSign: 's',
    mDec: '0',
    vMin: '0'
  });

  $('#science-technology-tbl').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: app_url + 'admin/mission-science-technologies/get-list',
        type: 'POST',
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

// submit hard copy
  $('#science-technology-tbl').on('click','.submit-hard-copy-btn', function(event) {
    event.preventDefault();
    /* Act on the event */

    swal({
      title: "Bạn có chắc chắn nhận bản cứng hoàn thiện của hồ sơ này?",
      icon: "warning",
      buttons: ['Hủy','Đồng ý'],
      confirmButtonColor: "#1caf9a",
      })
      .then((willDelete) => {
      if (willDelete) {
        $.ajax({
            type: "POST",
            url:  app_url + "admin/mission-science-technologies/submit-hard-copy",
            data: {
              id: $(this).data('id'),
              mission_name: $(this).data('name')
            },
            success: function(res)
            {
              // console.log(res);
              if (!res.error) {

                toastr.success(res.message);

                $('#science-technology-tbl').DataTable().ajax.reload();

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

// submit valid
  $('#science-technology-tbl').on('click','.submit-valid', function(event) {
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
        url: app_url + 'admin/mission-science-technologies/submit-valid',
        type: 'POST',
        data: {
          status: status,
          reason: reason,
          checkbox: checkbox,
          id: data_id,
          mission_name: mission_name
        }, success: function(res){
          // console.log(res);
          if (!res.error) {

            toastr.success(res.message);
            $('#modal-valid').modal('hide');
            $('#science-technology-tbl').DataTable().ajax.reload();

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

  // approve-submit

    $('#science-technology-tbl').on('click','.approve-btn', function() {
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
              url:  app_url + "admin/mission-science-technologies/approve-mission",
              data: $('#approve-frm').serialize(),
              success: function(res)
              {
                if (!res.error) {

                  toastr.success(res.message);

                  $('#approve-mdl').modal('hide');

                  $('#approve-frm').trigger('reset');

                  $('#science-technology-tbl').DataTable().ajax.reload();

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
          url: app_url + 'admin/mission-science-technologies/upload-list-categories',
          type: 'Post',
          data: fd,
          success: function(res) {
            if (res.error) {
              toastr.error(res.message);
            }
          }
        });

      });

  // submit judged

    $('#science-technology-tbl').on('click','.submit-judged', function(event) {
      event.preventDefault();
      /* Act on the event */
      $('#modal-judged').modal('show');
      $('#status_judged').val('-1');
      $('#denied_reason').val('');
      // $('#checkbox-send-email-judged').attr('checked', 'checked');
      $('#denied_reason').attr('disabled', 'disabled');

      var data_id = $(this).attr('data-id');
      $('#modal-judged .btn-success').attr('data_id', data_id);

      var mission_name = $(this).data('name');
      $('#modal-judged .btn-success').attr('mission_name', mission_name);
    });

    $('#modal-judged').on('click', '.btn-success', function(event) {
      event.preventDefault();
      /* Act on the event */
      var status = $('#status_judged').val();
      var reason = $('#denied_reason').val();
      var checkbox = $('#checkbox-send-email-judged').is(':checked');
      var data_id = $('#modal-judged .btn-success').attr('data_id');
      var mission_name = $('#modal-judged .btn-success').attr('mission_name');

      if (status == -1) {
        toastr.error('Vui lòng chọn trạng thái xét duyệt ! ');
      }
      else if (status == 'denied' && reason == "") {
        toastr.error('Vui lòng nhập lý do từ chối hồ sơ ! ');
      } else {
        $.ajax({
          url: app_url + 'admin/mission-science-technologies/submit-judged',
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
              $('#modal-judged').modal('hide');
              $('#science-technology-tbl').DataTable().ajax.reload();

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

  // view detail
  $('#science-technology-tbl').on('click','.btn-view-detail', function(event) {
    event.preventDefault();
    /* Act on the event */
    $('#modal-view-detail').modal('show');

    var id = $(this).attr('data-id');

    $.ajax({
      url: app_url + "/admin/mission-science-technologies/view-detail",
      type: 'POST',
      data: {id},
      success: function (res){
        if (res != null) {
          $('.name').html(res.name);
          $('.provenance_originate').html(res.provenance_originate);
          $('.importance').html(res.importance);
          $('.target').html(res.target);
          $('.content').html(res.content);
          $('.request_result').html(res.request_result);
          $('.application_address').html(res.application_address);
          $('.request_time').html(res.request_time);
          $('.qualification').html(res.qualification);
          $('.expected_fund').html(res.expected_fund);
          $('.plan_mobilize').html(res.plan_mobilize);
          $('.economic_efficiency').html(res.economic_efficiency);
          $('.science_technology_efficiency').html(res.science_technology_efficiency);
        }
      }, error: function (err){

      }
    });

  });


  $('#science-technology-tbl').on('click', '.add-council-btn', function(e) {
    e.preventDefault();
    
   $('#addCouncilModal').modal('show'); 

   var id = $(this).data('id');

   $('#add_council_mission_id').val(id);
   $.ajax({
     url: app_url + 'admin/mission-science-technologys/get-round-collection/' + id,
     type: 'GET',
     success: function(res) {
        $('#round_collection_add_council').html(res.year + ' - ' + res.name);
        $('#add-council-submit-btn').attr('data-mission_id', id);
        
        $('#year_round_collection').html(res.year);
        // $('#list-council-tbl').attr('data-round_colection_id', res.id);
        $('#round_collection_id').val(res.id);

        $('#list-council-tbl').DataTable().destroy();
        $('#list-council-tbl').DataTable({
          searching: false,
          paginate: false,
          ordering: false,
          ajax: {
            url: app_url + 'admin/mission-science-technologys/get-list-council',
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
            url: app_url + 'admin/mission-science-technologys/get-list-council',
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
    
  })

  $('#science-technology-tbl').on('click',' .assign-doc', function(){
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
      url: app_url + "/admin/mission-science-technologies/submit-assign",
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
            $("#role_user_devolve_file").val("-1");
            $("#role_user_handle_file").val("-1");
            $('#deadline-group').find("input").val("");
            $('#note').val("");

            $("#modal-assign").modal("hide");

            $("#science-technology-tbl").DataTable().ajax.reload();
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
      var mission_science_technology_id = $('#add-council-submit-btn').data('mission_id');

      var group_council_id  = $('#group_council').val();
      
      $.ajax({
        url: app_url + 'admin/mission-science-technologys/add-council',
        type: 'post',
        data: {
          council_id: council_id,
          mission_science_technology_id: mission_science_technology_id,
          group_council_id: group_council_id,
        },
        success: function(res) {
          if (!res.error) {
            $('#addCouncilModal').modal('hide');
            toastr.success(res.message);
            $('#science-technology-tbl').DataTable().ajax.reload();
            
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

  $('#evaluation-science-technology-btn').on('click', function() {
    var data = $('#evalution-form').serialize();

    $.ajax({
      url: app_url + '/admin/mission-science-technologys/evaluation/store',
      type: 'post',
      data: data,
      success:function(res) {
      
        if (!res.error) {
          toastr.success(res.message);
          setTimeout(function () {
              window.location.href = app_url + 'admin/mission-science-technologies';
          }, 1000);    

        
        }
        else {
          toastr.error(res.message);
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        toastr.error(thrownError);
      }

    });

  })

  $(function() {
    if ($('input[name=suggest_perform]:checked').val() == 2) {
      $('.request_change').css('display', 'block');
    }
  })

  $('.suggest_perform').on('click', function() {
    var suggest_perform = $('input[name=suggest_perform]:checked').val();
    if (suggest_perform == 2) {
      
      // $('#project_name').removeAttr('disabled');
      // $('#project_result').removeAttr('disabled');
      // $('#project_target').removeAttr('disabled');
      $('.request_change').css('display', 'block');
    }
    else {
      // $('#project_name').attr('disabled','true');
      $('#project_name').val('');
      // $('#project_result').attr('disabled','true');
      $('#project_result').val('');
      // $('#project_target').attr('disabled','true');
      $('#project_target').val('');
      $('.request_change').css('display', 'none');
    }
  })


  $('#btn-search-mission').on('click', function(event) {
    event.preventDefault();

    $('#science-technology-tbl').DataTable().destroy();

    $('#science-technology-tbl').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: app_url + 'admin/mission-science-technologies/get-list',
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

  $('#science-technology-tbl').on('click', '.btn-give-back-hard-copy', function(event){
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
            url:  app_url + "admin/mission-science-technologies/give-back-hard-copy",
            data: {
              id: $(this).data('id'),
            },
            success: function(res)
            {
              // console.log(res);
              if (!res.error) {

                toastr.success(res.msg);

                $('#science-technology-tbl').DataTable().ajax.reload();

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

  $('body').on('click', '#viewListMember', function() {
    var id = $(this).data('id');

    $('#list-member-council-tbl').DataTable().destroy();

    $('#list-member-council-tbl').DataTable({
      searching: false,
      paginate: false,
      ordering: false,
      ajax: {
        url: app_url + 'admin/mission-science-technologies/list-member-council/' + id,
        type: 'GET',
      },
      columns: [
        {data: 'DT_Row_Index', name: 'DT_Row_Index', 'class':'text-center','searchable':false},
        {data: 'name', name: 'name', width: '70px'},
        {data: 'mobile', name: 'mobile'},
        {data: 'email', name: 'email', 'class':'text-center'},
        {data: 'position', name: 'position', 'class':'text-center', width: '50px'},
      ]
    });
  })


  $('#evaluation-science-technology-tbl').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: app_url + 'admin/mission-science-technologies/get-list-evaluation',
        type: 'POST',
      },
      ordering: false,
      columns: [
        {data: 'DT_Row_Index', name: 'DT_Row_Index', 'class':'text-center','searchable':false},
        {data: 'action', name: 'action', 'searchable':false, 'class':'text-center'},
        {data: 'values', name: 'values.value', width: '228px'},
        {data: 'profile', name: 'profile.email', width: '110px'},
        {data: 'roundCollection', name: 'roundCollection.name', 'class':'text-center', width: '114px'},
        {data: 'status', name: 'status', 'class':'text-center', width: '90px'},
      ]
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
      // evaluation_form_01 : {
      //   requiredFile: true,
      //   extension: 'pdf',
      //   filesize: max_file_size,
      // },
      // evaluation_form_02 : {
      //   requiredFile: true,
      //   extension: 'pdf',
      //   filesize: max_file_size,
      // },
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
      // ,evaluation_form_01 : {
      //   requiredFile: '(*) Vui lòng đính kèm file',
      //   extension: 'Chỉ file .pdf được chấp nhận',
      //   filesize: "Dung lượng file đính kèm không được lớn hơn {0} MB",
      // }
      // ,evaluation_form_02 : {
      //   requiredFile: '(*) Vui lòng đính kèm file',
      //   extension: 'Chỉ file .pdf được chấp nhận',
      //   filesize: "Dung lượng file đính kèm không được lớn hơn {0} MB",
      // },
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
      url: app_url + "admin/mission-science-technologies/update",
      data: formData,
      success: function(res) {
        // console.log(res);
        if (!res.error) {
          toastr.success(res.message);

          setTimeout(function() {
            location.href = app_url + 'admin/mission-science-technologies';
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