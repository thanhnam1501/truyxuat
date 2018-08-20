
$(function() {
	var table = $('#mission-sxtns-table').DataTable({
		    processing: true,
        serverSide: true,
        // lengthChange: false,
        ajax: app_url + 'mission-sxtn/get-list',
        ordering: false,
        // searching : false,
        columns: [
          {data: 'DT_Row_Index', name: 'DT_Row_Index', 'class':'text-center', width: '80px','searchable':false},
          {data: 'code', name: 'code', 'class':'text-center'},
          {data: 'values', name: 'values.value', width: '200px'},
          {data: 'roundCollection', name: 'roundCollection.name', 'class':'text-center'},
          {data: 'created_at', name: 'created_at', width: '150px', 'class':'text-center'},
          {data: 'status', name: 'status', width: '150px', 'class':'text-center'},
          {data: 'action', name: 'action', 'searchable':false, 'class':'text-center'},
        ]
	});
})


$('#expected_funding').autoNumeric('init', {aSign:' VNĐ',pSign:'s', mDec: '0' });

$.validator.addMethod("valueNotEquals", function(value, element, arg){
  return arg !== value;
 }, "Value must not equal arg.");


$(function() {


	$('.addSxtn').on('click', function() {
		$('#create-sxtn-mdl').modal('show');	
	});

	$('#create-sxtn-frm').validate({ // initialize the plugin
      errorElement: "span",
      rules: {
        sxtn_name : {
          required : true,
          minlength: 10
          
        },
         round_collection_id: { 
           valueNotEquals: "-1" 
       	},

      },
      messages: {
        sxtn_name : {
          required : " Vui lòng nhập tên nhiệm vụ",
          minlength: jQuery.validator.format("Tên nhiệm vụ phải lớn hơn {0} ký tự")
        },
        round_collection_id : {
          valueNotEquals: ' Vui lòng chọn đợt gọi hồ sơ'
        }
      }
    });

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

    $('#create-sxtn-btn').on('click', function(e) {
    	e.preventDefault();

    	$check = $('#create-sxtn-frm').valid();
    	if (!$check) { return ;}
    	else {
    		$.ajax({
    			url: app_url + 'mission-sxtn/add-mission-sxtn',
    			type: 'POST',
    			dataType: 'json',
    			data: {
    				sxtn_name: $('#sxtn_name').val(),
    				round_collection_id : $('#round_collection_id').val()
    			},
    			success: function(res) {
    				
    				if (!res.error) {
	           $('#create-sxtn-mdl').modal('hide');
    					toastr.success(res.message);
    					setTimeout(function () {
                        	window.location.href = app_url + 'mission-sxtn/edit-mission-sxtn/' + res.key;
                    	}, 1000);    

    				}
    				else {
    						
    					toastr.error(res.message);	
    				}
    			},
    			error: function (xhr, ajaxOptions, thrownError) {
                	//toastr.error(thrownError);
	                toastr.error("Lỗi! Không thể đăng ký! <br>Vui lòng thử lại hoặc liên lạc với IT");
	            }
    		});
    					
    	}
    })

    $('#edit-sxtn-frm').on('submit', function(e) {
       	
    	e.preventDefault();

    	$check = $(this).valid();
    	var	key = $('#key').val();
      var data = $(this).serialize();

    	if (!$check) {return ;}
    	else {
    		$.ajax({
    			url: app_url + 'mission-sxtn/edit-mission-sxtn',
    			type: 'post',
    			dataType: 'json',
    			data: data,
    			success: function(res) {

    				if (!res.error) {
	
    					toastr.success(res.message);
    					setTimeout(function () {
                        	window.location.href = app_url + 'mission-sxtn/edit-mission-sxtn/' +  key;
                    	}, 1000);    

    				}
    				else {
    						
    					toastr.error(res.message);	
    				}
    			},

    			error: function (xhr, ajaxOptions, thrownError) {
                	//toastr.error(thrownError);
	                toastr.error("Lỗi! Không thể đăng ký! <br>Vui lòng thử lại hoặc liên lạc với IT");
	            }
    		});
    		
    	}
    })


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
          url: app_url + '/mission-sxtn/destroy',
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

    $(".btn-view-file").on('click', function(event) {
    event.preventDefault();
    /* Act on the event */
    var key = $("#key").val();
    var link = $(this).attr("data-link");
    var order = $(this).attr("data-order");

    $.ajax({
      url: app_url + '/mission-sxtn/viewFile',
      type: 'POST',
      data: {
        key: key,
        link: link,
        order: order
      },
      success: function (res){
        if (!res.error) {
          var link = res.link;

          window.open(link, '_blank');
        }
        
      },
      error: function(xhr, ajaxOptions, thrownError) {
        toastr.error(thrownError);
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
        url: app_url + 'mission-sxtn/uploadFile',
        type: 'Post',
        data: fd,
        success: function(res) {
          if (res.error) {
            toastr.error(res.message);
          }
        }
      });
      
    })
});

