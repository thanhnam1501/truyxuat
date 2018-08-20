$(function() {
	var  table = $('#position-councils-table').DataTable({
	  processing: true,
      serverSide: true,
      ajax: app_url + 'admin/position-councils/get-list',
       
      ordering: false,
      columns: [
          {data: 'DT_Row_Index', name: 'DT_Row_Index', 'class':'text-center', width: '80px','searchable':false},
          {data: 'name', name: 'name', 'class':'text-center'},
          {data: 'status', name: 'status',width: '200px', 'class' : 'text-center'},
          {data: 'action', name: 'action',width : '200px', 'searchable':false, 'class':'text-center'},
      ]
	});


	$('#add-position-councils').validate({
		errorElement: "span",
	      	rules: {
	        	name : {
	          		required : true,
	 
	      		},
	      	},
	      	messages: {
	        	name : {
	          		required : " Vui lòng nhập tên vị trí hội đồng",
	        	},
	    	}
	    
	});

	$('#edit-position-councils').validate({
		errorElement: "span",
	      	rules: {
	        	name : {
	          		required : true,
	 
	      		},
	      	},
	      	messages: {
	        	name : {
	          		required : " Vui lòng nhập tên vị trí hội đồng",
	        	},
	    	}
	    
	});

	$('#add-position-councils').on('submit', function(e) {

		e.preventDefault();

		var check = $(this).valid();
		if (!check) {
			return ;
		}
		else {
			$.ajax({
				url: app_url + 'admin/position-councils/store',
				type: 'POST',
				data: {name: $('#name').val()},
				success: function (res) {
					if (!res.error) {
						$('#createModal').modal('hide');
						$('#name').val('');
						toastr.success(res.message);
						table.ajax.reload();

					}
					else {
						toastr.error(res.message);
					}
				}
			});
			
		}
	})

	$(document).on('change','.hide-group', function() {

	  var status = 0;
	  var id = $(this).attr('data-id');
	  
	  if ($(this).is(':checked')) {
	      status = 1;
	  }

	  $.ajax({
	      type: "POST",
	      url:  app_url + "admin/position-councils/lock",
	      data: {
	          status: status,
	          id: id,
	      },
	      success: function(res)

	      {
	        if (!res.error) {

	          toastr.success(res.message);
	          table.ajax.reload();

	        } else {

	          toastr.error(res.message);
	        }
	      },
	      error: function (xhr, ajaxOptions, thrownError) {
	        toastr.error(thrownError);
	      }
	  });

	})

	$(document).on('click', '.btn-view' , function (e) {
		e.preventDefault();
		var id=$(this).attr('data-id');
	    $.ajax({
	      url: app_url + "admin/position-councils/"+id,
	      type: 'get',
	      success: function(res){
	        if (res.err != true) {
		        var status="";
		        if (res.data.status==1) {
		        	status="Hiện";
		        	$('#lock-icon').attr('class','fa fa-unlock-alt')
		        }else{
		        	status="Ẩn";
		        	$('#lock-icon').attr('class','fa fa-lock')
		        }
		        $('#detailModal').modal('show');
		        $('#edit-collection-btn').attr('data-id',id);
		        $('#detail-name').text("Tên: "+res.data.name);
		        $('#detail-status').text("Trạng thái: "+status);
		        $('#detail-created_at').text("Ngày tạo: "+res.created_at);
	        }
	      },
	      error: function (jqXHR, textStatus, errorThrown) {

	      }
	    });
	})

	$(document).on('click', '.btn-edit', function() {
		$('#editModal').modal('show');
		var id = $(this).data('id');

		$.ajax({
			url: app_url + 'admin/position-councils/' + id + '/edit',
			type: 'GET',
			success:function(res) {
				$('#edit-id').val(id);
				$('#edit-name').val(res.position_council.name);
			} 
		});
								

	})

	$('#edit-position-councils').on('submit', function(e) {
		e.preventDefault();

		var check = $(this).valid();
		if (!check) { return ;}
		else {
			$.ajax({
				url: app_url + 'admin/position-councils/update',
				type: 'Post',
				data: {
					id: $('#edit-id').val(),
					name: $('#edit-name').val(),
				},
				success:function(res) {
					console.log(res.a);
					if (!res.error) {
						$('#name').val('');
						$('#editModal').modal('hide');
						table.ajax.reload();
						toastr.success(res.message);

					}
					else {
						toastr.error(res.message);
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					toastr.error("Lỗi! Không thể sửa! <br>Vui lòng thử lại hoặc liên lạc với IT");
				}
			});
			
		}
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
		      url: app_url + "admin/position-councils/"+id,
		      type: 'delete',
		      success: function(res){
		        if (!res.error) {
		          table.ajax.reload();
		          toastr.success(res.message);
		        }
		      },
		      error: function (jqXHR, textStatus, errorThrown) {

		      }
		    });
      }
    });
	})
})