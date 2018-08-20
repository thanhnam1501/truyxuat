$(document).ready(function () {

	$(document).on('click','.bootstrap-datetimepicker-widget .year',function () {
		alert('ok');
	})

	$('.accordion-toggle:eq(1)').css('display', 'none');
	
    $('#expiration_time').datetimepicker({
        format: "YYYY-MM-DD HH:mm:ss",
        minDate: moment(),
    });
    $('#year').datetimepicker({
        minViewMode: 'years',
        format: 'YYYY',
        minDate: moment(),
    });
    $('#edit-expiration_time').datetimepicker({
        format: "YYYY-MM-DD HH:mm:ss",
        minDate: moment(),
    });
    $('#edit-year').datetimepicker({
        minViewMode: 'years',
        format: 'YYYY',
        minDate: moment(),
    });
    var collectionTable=null

	$(function() {

      	collectionTable= $('#round-collection-tbl').DataTable({
          	processing: true,
          	serverSide: true,
          	ajax: {
            	url: app_url + 'admin/round-collections/get-list',
            	type: 'post',
         	},
          	ordering: false,
          	columns: [
              {data: 'DT_Row_Index', name: 'DT_Row_Index', 'searchable':false, 'class':'text-center'},
              {data: 'name', name: 'name'},
              {data: 'year', name: 'year', 'class':'text-center'},
              {data: 'status', name: 'status', 'searchable':false, 'class':'text-center'},
              {data: 'expiration_time', name: 'expiration_time', 'class':'text-center'},
              {data: 'action', name: 'action', 'searchable':false, 'class':'text-center'},
          	]
      	});
  	});

	$('#btn-add').click(function (e) {
		e.preventDefault();
		$('#create-collection-mdl').modal('show');
		$('#name-error-custom').text('');
		$('#year-error-custom').text('');
		$('#expiration-time-error-custom').text('');
		$('#name').val('');
		$('#year input').val('');
		$('#expiration_time input').val('');
	})

	$('#create-collection-btn').click(function () {

	    $.ajax({
	      url: app_url + "admin/round-collections",
	      type: 'POST',
	      data: {
	        'name': $('#name').val(),
	        'year': $('#year input').val(),
	        'expiration_time': $('#expiration_time input').val(),
	      },
	      success: function(res){
	        if (res.err != true) {
	          // console.log(res);
	          collectionTable.ajax.reload();
	          $('#create-collection-mdl').modal('hide');
	          toastr.success('Đã tạo mới đợt thu hồ sơ');
	        }else{
	        	$('#year-error-custom').text(res.msg);
	        }
	      },
	      error: function (jqXHR, textStatus, errorThrown) {
	        if (jqXHR.responseJSON.errors.name!==undefined) {
	          $('#name-error-custom').text(jqXHR.responseJSON.errors.name[0]);
	        }
	        if (jqXHR.responseJSON.errors.year!==undefined) {
	          $('#year-error-custom').text(jqXHR.responseJSON.errors.year[0]);
	        }
	        if (jqXHR.responseJSON.errors.expiration_time!==undefined) {
	          $('#expiration-time-error-custom').text(jqXHR.responseJSON.errors.expiration_time[0]);
	        }
	      }
	    });
	})

	$(document).on('click', '.btn-edit' , function (e) {
		e.preventDefault();
		var id=$(this).attr('data-id');
	    $.ajax({
	      url: app_url + "admin/round-collections/"+id,
	      type: 'get',
	      success: function(res){
	        if (res.err != true) {
		        // console.log(res);
		        $('#edit-collection-mdl').modal('show');
		        $('#edit-collection-btn').attr('data-id',id);
		        $('#edit-name').val(res.data.name);
		        $('#edit-year input').val(res.data.year);
		        $('#edit-expiration_time input').val(res.data.expiration_time);
				$('#edit-name-error-custom').text('');
				$('#edit-year-error-custom').text('');
				$('#edit-expiration-time-error-custom').text('');
	        }
	      },
	      error: function (jqXHR, textStatus, errorThrown) {

	      }
	    });
	})

	$('#edit-collection-btn').click(function (e) {
		var id=$(this).attr('data-id');
		e.preventDefault();
	    $.ajax({
	      url: app_url + "admin/round-collections/"+id,
	      type: 'put',
	      data: {
	        'name': $('#edit-name').val(),
	        'year': $('#edit-year input').val(),
	        'expiration_time': $('#edit-expiration_time input').val(),
	      },
	      success: function(res){
	        if (res.err != true) {
	          // console.log(res);
	          collectionTable.ajax.reload();
	          $('#edit-collection-mdl').modal('hide');
	          toastr.success('Đã cập nhật đợt thu hồ sơ');
	        }else{
	        	$('#edit-year-error-custom').text(res.msg);
	        }
	      },
	      error: function (jqXHR, textStatus, errorThrown) {
	        if (jqXHR.responseJSON.errors.name!==undefined) {
	          $('#edit-name-error-custom').text(jqXHR.responseJSON.errors.name[0]);
	        }
	        if (jqXHR.responseJSON.errors.year!==undefined) {
	          $('#edit-year-error-custom').text(jqXHR.responseJSON.errors.year[0]);
	        }
	        if (jqXHR.responseJSON.errors.expiration_time!==undefined) {
	          $('#edit-expiration-time-error-custom').text(jqXHR.responseJSON.errors.expiration_time[0]);
	        }
	      }
	    });
	})

	$(document).on('click', '.btn-delete' , function (e) {
		e.preventDefault();
		var id=$(this).attr('data-id');
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
		      url: app_url + "admin/round-collections/"+id,
		      type: 'delete',
		      success: function(res){
		        if (res.err != true) {
		          collectionTable.ajax.reload();
		          toastr.warning('Đã xoá đợt thu hồ sơ');
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
	      url: app_url + "admin/round-collections/"+id,
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
		        $('#detail-collection-mdl').modal('show');
		        $('#edit-collection-btn').attr('data-id',id);
		        $('#detail-name').text("Tên: "+res.data.name);
		        $('#detail-year').text("Năm: "+res.data.year);
		        $('#detail-expiration_time').text("Hạn: "+res.data.expiration_time);
		        $('#detail-status').text("Trạng thái: "+status);
		        $('#detail-created_at').text("Ngày tạo: "+res.data.created_at);
	        }
	      },
	      error: function (jqXHR, textStatus, errorThrown) {

	      }
	    });
	})

	$(document).on('change','.hide-collection', function() {

	  var status = 0;
	  var id = $(this).attr('data-id');
	  console.log(id);
	  if ($(this).is(':checked')) {
	      status = 1;
	  }

	  $.ajax({
	      type: "POST",
	      url:  app_url + "admin/round-collections/lock",
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