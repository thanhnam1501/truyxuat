$(document).ready(function() {

  $('#science-technology-tbl').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: app_url + 'admin/mission-science-technologies/get-list',
        type: 'post',
      },
      ordering: false,
      columns: [
        {data: 'DT_Row_Index', name: 'DT_Row_Index', 'class':'text-center','searchable':false},
        {data: 'values', name: 'values.value', width: '228px'},
        {data: 'profile', name: 'profile.email', width: '110px'},
        {data: 'roundCollection', name: 'roundCollection.name', 'class':'text-center', width: '114px'},
        {data: 'type', name: 'type', 'class':'text-center', width: '80px'},
        {data: 'status', name: 'status', 'class':'text-center', width: '90px'},
        {data: 'is_assign', name: 'is_assign', 'class':'text-center', width: '80px'},
        {data: 'valid_status', name: 'valid_status', 'class':'text-center', width: '90px'},
        {data: 'is_judged', name: 'is_judged', 'class':'text-center'},
        {data: 'is_perform', name: 'is_perform', 'class':'text-center'},
        {data: 'action', name: 'action', 'searchable':false, 'class':'text-center'},
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
    $('#checkbox-send-email').attr('checked', 'checked');
    $('#invalid_reason').attr('disabled', 'disabled');

    var data_id = $(this).attr('data-id');
    $('#modal-valid .btn-success').attr('data_id', data_id);

  });

  $('#modal-valid').on('click', '.btn-success', function(event) {
    event.preventDefault();
    /* Act on the event */
    var status = $('#status').val();
    var reason = $('#invalid_reason').val();
    var checkbox = $('#checkbox-send-email').is(':checked');
    var data_id = $('#modal-valid .btn-success').attr('data_id');

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
          id: data_id
        }, success: function(res){
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
      $('#checkbox-send-email-judged').attr('checked', 'checked');
      $('#denied_reason').attr('disabled', 'disabled');

      var data_id = $(this).attr('data-id');
      $('#modal-judged .btn-success').attr('data_id', data_id);

    });

    $('#modal-judged').on('click', '.btn-success', function(event) {
      event.preventDefault();
      /* Act on the event */
      var status = $('#status_judged').val();
      var reason = $('#denied_reason').val();
      var checkbox = $('#checkbox-send-email-judged').is(':checked');
      var data_id = $('#modal-judged .btn-success').attr('data_id');

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
            id: data_id
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
});