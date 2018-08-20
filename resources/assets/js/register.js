$(document).ready(function() {

	var app_url = $('meta[name="website"]').attr('content');

	$('#tax_code').on('keyup', function(event) {
		event.preventDefault();
		/* Act on the event */

		$.ajax({
	    	url: app_url + 'get-info-profile',
	    	type: 'POST',
	    	data: {tax_code: $(this).val()},
				success: function (res){
					if (res.profile != null ) {
							$('#name').val(res.profile.name);
					} else{
							$('#name').val("");
					}
				}
	    });
	});
});
