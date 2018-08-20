$(function() {

	$.validator.addMethod("valueNotEquals", function(value, element, arg){
	  return arg !== value;
	 }, "Value must not equal arg.");


	$('#create-mission-frm').validate({ // initialize the plugin
      errorElement: "span",
      rules: {
        mission_type: { 
           valueNotEquals: "-1" 
       	},
         round_collection_id: { 
           valueNotEquals: "-1" 
       	},

      },
      messages: {
       
        mission_type : {
          valueNotEquals: ' Vui lòng chọn đợt gọi hồ sơ'
        },
        round_collection_id : {
          valueNotEquals: ' Vui lòng chọn loại nhiệm vụ'
        }
      }
    });

    $('.addSxtn').on('click', function(e) {

    	e.preventDefault();

    	$check = $('#create-mission-frm').valid();
    	if (!$check) { return ;}
    	else {
    		var mission_type = $('#mission_type').val();


    		var path_url = '';
    		var path_location = '';

    		if (mission_type == 'mission_topics') {

    			 path_url = path_url + app_url + 'mission-topics/store';
    			
    			 path_location = app_url + 'mission-topics/edit/';	
    		}
    		if (mission_type == 'mission_science_technologys') {
    			path_url	= path_url + app_url + 'mission-science-technology/store';

    			path_location = app_url + 'mission-science-technology/edit/';	
    		}

    		$.ajax({
    			url: path_url,
    			type: 'POST',
    			dataType: 'json',
    			data: $('#create-mission-frm').serialize(),
    			success: function(res) {
    				
    				if (!res.error) {
	           			$('#create-mission-mdl').modal('hide');
    					toastr.success(res.message);
    					   
    					setTimeout(function () {
                        	window.location.href = path_location + res.key;
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

})