$(document).ready(function () {

	$('#add-new-logo').on('change', function() {
		var formData = new FormData();
		order = $(this).data('order');

		formData.append('file', $(this)[0].files[0]);
		$.ajax({
			processData: false,
			contentType: false,
			type: "POST",
			url: app_url + "/change-avatar",
			data: formData,
			success: function success(res) {
				if (res.status == true) {
				toastr.success(res.message);
					setTimeout((function() {
						window.location.reload();
					}), 250);
				}else{
					toastr.error(res.message);
				}
			},
			error: function error(xhr, ajaxOptions, thrownError) {
				toastr.error(thrownError);
			}
		});
	});

	$('#add-new-logo-admin').on('change', function() {
		var formData = new FormData();
		order = $(this).data('order');

		formData.append('file', $(this)[0].files[0]);
		$.ajax({
			processData: false,
			contentType: false,
			type: "POST",
			url: app_url + "admin/change-avatar",
			data: formData,
			success: function success(res) {
				if (res.status == true) {
				toastr.success(res.message);
					setTimeout((function() {
						window.location.reload();
					}), 250);
				}else{
					toastr.error(res.message);
				}
			},
			error: function error(xhr, ajaxOptions, thrownError) {
				toastr.error(thrownError);
			}
		});
	});
});