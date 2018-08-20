
$(function() {
	var table = $('#mission-sxtns-table').DataTable({
		    processing: true,
        serverSide: true,
        // lengthChange: false,
        ajax: {
          url: app_url + 'admin/mission-sxtns/get-list',
          type: 'post',
        },
        ordering: false,
        // searching : false,
        columns: [
          {data: 'DT_Row_Index', name: 'DT_Row_Index', 'class':'text-center', width: '80px','searchable':false},
          {data: 'code', name: 'code', 'class':'text-center'},
          {data: 'values', name: 'values.value', width: '200px'},
          {data: 'profile', name: 'profile.email'},
          {data: 'roundCollection', name: 'roundCollection.name', 'class':'text-center'},
          {data: 'created_at', name: 'created_at', width: '150px', 'class':'text-center'},
          {data: 'status', name: 'status', width: '150px', 'class':'text-center'},
          {data: 'action', name: 'action', 'searchable':false, 'class':'text-center'},
        ]
	});



  $("body").on('click', '.btn-delete-mission ', function(){
    var key = $(this).data('key');

    swal({
      title: "Bạn có đồng ý xóa?",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
        $.ajax({
          url: app_url + '/admin/mission-sxtns/destroy',
          type: 'POST',
          data: { key },
          success: function(res) {
            if (res.error != true) {
              toastr.success(res.message);

              $("#mission-sxtns-table").DataTable().ajax.reload();

            }
          }
        });
      };
    });
  });


  $('#expected_funding').autoNumeric('init', {aSign:' VNĐ',pSign:'s', mDec: '0' });
  $('#edit-sxtn-frm').validate({ // initialize the plugin
      rules: {
        sxtn_name : {
          required : true,
          minlength: 10
          
        },
        expected_funding : {
         required: true,
         minCustom: '100,000 VNĐ',

        },

        formation : {
          required: true,
          minlength: 10,
        },

        urgency_importance : {
          required: true,
          minlength: 10,
        },

        target : {
          required: true,
          minlength: 10,
        },

        main_content : {
          required: true,
          minlength: 10,
        },

        claim_result : {
          required: true,
          minlength: 10,
        },

        market_demand : {
          required: true,
        },

        expected_organize : {
          required: true,
          minlength: 10,
        },

        claim_excecution_time : {
          required: true,
          minlength: 10,
        },

        plan_mobilizing_resource : {
          required: true,
          minlength: 10,
        },
        evaluation_form_01 : {
          extension:'pdf',
          filesize: 5,
        },
        evaluation_form_02 : {
          extension: 'pdf',
          filesize: 5,
        }
      },
      messages: {
        expected_funding : {
          required : " Vui lòng nhập kinh phí dự chi",
          minCustom: jQuery.validator.format("Dự kiến nhu cầu kinh phí phải lớn hơn {0}")
        },
        sxtn_name : {
          required: ' Vui lòng nhập tên nhiệm vụ',
          minlength: jQuery.validator.format("Nội dung phải lớn hơn {0} ký tự") 
        },
        formation : {
          required: ' Vui lòng không để trống',
          minlength: jQuery.validator.format("Nội dung phải lớn hơn {0} ký tự")
        },

        urgency_importance : {
          required: ' Vui lòng không để trống',
          minlength: jQuery.validator.format("Nội dung phải lớn hơn {0} ký tự")
        },

        target : {
          required: ' Vui lòng không để trống',
          minlength: jQuery.validator.format("Nội dung phải lớn hơn {0} ký tự")
        },

        main_content : {
          required: ' Vui lòng không để trống',
          minlength: jQuery.validator.format("Nội dung phải lớn hơn {0} ký tự")
        },

        claim_result : {
          required: ' Vui lòng không để trống',
          minlength: jQuery.validator.format("Nội dung phải lớn hơn {0} ký tự")
        },

        market_demand : {
          required: ' Vui lòng không để trống',
          minlength: jQuery.validator.format("Nội dung phải lớn hơn {0} ký tự")
        },

        expected_organize : {
          required: ' Vui lòng không để trống',
          minlength: jQuery.validator.format("Nội dung phải lớn hơn {0} ký tự")
        },

        claim_excecution_time : {
          required: ' Vui lòng không để trống',
          minlength: jQuery.validator.format("Nội dung phải lớn hơn {0} ký tự")
        },

        plan_mobilizing_resource : {
          required: ' Vui lòng không để trống',
          minlength: jQuery.validator.format("Nội dung phải lớn hơn {0} ký tự")
        },
        evaluation_form_01: {
          extension: 'Định dạng phải là PDF',
          filesize: ' Dung lượng file không được lớn hơn {0} Mb',
        },
        evaluation_form_02: {
          extension: 'Định dạng phải là PDF',
          filesize: ' Dung lượng file không được lớn hơn {0} Mb',
        }
      }
    });


  $('#edit-sxtn-frm').on('submit', function(e) {
        
      e.preventDefault();

      // $check = $(this).valid();
      console.log("22");
      

  });
});