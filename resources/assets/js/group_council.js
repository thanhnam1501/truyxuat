$(document).ready(function () {
    var groupTable=null

	$(function() {

      	groupTable= $('#group-council-tbl').DataTable({
          	processing: true,
          	serverSide: true,
          	ajax: {
            	url: app_url + 'admin/group-councils/get-list',
            	type: 'post',
         	},
          	ordering: false,
          	columns: [
              {data: 'DT_Row_Index', name: 'DT_Row_Index', 'searchable':false, 'class':'text-center'},
              {data: 'name', name: 'name'},
              {data: 'status', name: 'status', 'searchable':false, 'class':'text-center'},
              {data: 'action', name: 'action', 'searchable':false, 'class':'text-center'},
          	]
      	});
  	});

	$.validator.addMethod("valueNotEquals", function(value, element, arg){
	  return arg !== value;
	 }, "Value must not equal arg.");

	$('#create-group-frm').validate({ // initialize the plugin
      errorElement: "span",
      rules: {
        name : {
          required : true,
          minlength: 6,
          maxlength: 255,
          
        },
         type: { 
           valueNotEquals: "-1" 
       	},

      },
      messages: {
        name : {
          required : " Vui lòng nhập tên nhiệm vụ",
          minlength: jQuery.validator.format("Tên nhiệm vụ phải lớn hơn {0} ký tự"),
          maxlength: jQuery.validator.format("Tên nhiệm vụ phải nhỏ hơn {0} ký tự"),
        },
        type : {
          valueNotEquals: ' Vui lòng chọn chức năng'
        }
      }
    });

    $('#edit-group-frm').validate({ // initialize the plugin
      errorElement: "span",
      rules: {
        name : {
          required : true,
          minlength: 6,
          maxlength: 255,
          
        },
         type: { 
           valueNotEquals: "-1" 
       	},

      },
      messages: {
        name : {
          required : " Vui lòng nhập tên nhiệm vụ",
          minlength: jQuery.validator.format("Tên nhiệm vụ phải lớn hơn {0} ký tự"),
          maxlength: jQuery.validator.format("Tên nhiệm vụ phải nhỏ hơn {0} ký tự"),
        },
        type : {
          valueNotEquals: ' Vui lòng chọn chức năng'
        }
      }
    });


	$('#btn-add').click(function (e) {
		e.preventDefault();
		$('#create-group-mdl').modal('show');
		$('#name-error-custom').text('');
		$('#name').val('');
	})

	$('#create-group-btn').click(function () {
		var check = $('#create-group-frm').valid();
		if (!check) { return ;}

		else {
			$.ajax({
		      url: app_url + "admin/group-councils",
		      type: 'POST',
		      data: {
		        'name': $('#name').val(),
		        'type' : $('#type').val(),
		      },
		      success: function(res){
		        if (res.err != true) {
		          // console.log(res);
		          groupTable.ajax.reload();
		          $('#create-group-mdl').modal('hide');
		          toastr.success('Đã tạo mới nhóm hội đồng');
		        }
		      },
		      error: function (jqXHR, textStatus, errorThrown) {
		        if (jqXHR.responseJSON.errors.name!==undefined) {
		          $('#name-error-custom').text(jqXHR.responseJSON.errors.name[0]);
		        }
		      }
		    });	
		}
	    
	})

	$(document).on('click', '.btn-edit' , function (e) {
		e.preventDefault();
		var id=$(this).attr('data-id');
	    $.ajax({
	      url: app_url + "admin/group-councils/"+id,
	      type: 'get',
	      success: function(res){
	        if (res.err != true) {
		        // console.log(res.type);
		        $('#edit-group-mdl').modal('show');
		        $('#edit-group-btn').attr('data-id',id);
		        $('#edit-name').val(res.data.name);
				$('#edit-name-error-custom').text('');
				$('#edit-type').val(res.data.type);
				
	        }
	      },
	      error: function (jqXHR, textStatus, errorThrown) {

	      }
	    });
	})

	$('#edit-group-btn').click(function (e) {
		var id=$(this).attr('data-id');
		e.preventDefault();
	    $.ajax({
	      url: app_url + "admin/group-councils/"+id,
	      type: 'put',
	      data: {
	        'name': $('#edit-name').val(),
	      },
	      success: function(res){
	        if (res.err != true) {
	          // console.log(res);
	          groupTable.ajax.reload();
	          $('#edit-group-mdl').modal('hide');
	          toastr.success('Đã cập nhật nhóm hội đồng');
	        }
	      },
	      error: function (jqXHR, textStatus, errorThrown) {
	        if (jqXHR.responseJSON.errors.name!==undefined) {
	          $('#edit-name-error-custom').text(jqXHR.responseJSON.errors.name[0]);
	        }
	      }
	    });
	})

	$(document).on('click', '.btn-delete' , function (e) {
		e.preventDefault();
		var id=$(this).attr('data-id');
		swal({
		title: "Bạn chắc chắn muốn xóa?",
		icon: "warning",
		buttons: ['Hủy','Xóa'],
		dangerMode: true,
		})
		.then((willDelete) => {
		if (willDelete) {
		    $.ajax({
		      url: app_url + "admin/group-councils/"+id,
		      type: 'delete',
		      success: function(res){
		        if (res.err != true) {
		          groupTable.ajax.reload();
		          toastr.warning('Đã xoá nhóm hội đồng');
		        }
		      },
		      error: function (jqXHR, textStatus, errorThrown) {

		      }
		    });
      }
    });
	})

	
	$(document).on('click', '.btn-view' , function (e) {
		e.preventDefault();
		var id=$(this).attr('data-id');
	    $.ajax({
	      url: app_url + "admin/group-councils/"+id,
	      type: 'get',
	      success: function(res){
	        if (res.err != true) {
		        // console.log(res);
		        var status="";
		        if (res.data.status==1) {
		        	status="Hiện";
		        	$('#lock-icon').attr('class','fa fa-unlock-alt')
		        }else{
		        	status="Ẩn";
		        	$('#lock-icon').attr('class','fa fa-lock')
		        }
		        $('#detail-group-mdl').modal('show');
		        $('#edit-collection-btn').attr('data-id',id);
		        $('#detail-name').text("Tên: "+res.data.name);
		        $('#detail-status').text("Trạng thái: "+status);
		        $('#detail-created_at').text("Ngày tạo: "+res.data.created_at);
		        $('#detail-type').text("Chức năng: "+res.optionValueName);
	        }
	      },
	      error: function (jqXHR, textStatus, errorThrown) {

	      }
	    });
	})

	$(document).on('change','.hide-group', function() {

	  var status = 0;
	  var id = $(this).attr('data-id');
	  console.log(id);
	  if ($(this).is(':checked')) {
	      status = 1;
	  }

	  $.ajax({
	      type: "POST",
	      url:  app_url + "admin/group-councils/lock",
	      data: {
	          status: status,
	          id: id,
	      },
	      success: function(res)

	      {
	        if (!res.error) {

	          toastr.success(res.message);
	          $('#round-collection-tbl').DataTable().ajax.reload();

	        } else {

	          toastr.error(res.message);
	        }
	      },
	      error: function (xhr, ajaxOptions, thrownError) {
	        toastr.error(thrownError);
	      }
	  });

	})
})