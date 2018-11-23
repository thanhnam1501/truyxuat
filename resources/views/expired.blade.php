<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<style>
body {
	background:url({{asset('image/loading.gif')}});
	background-repeat: no-repeat;
	background-attachment: fixed;
	background-position: center; 
	text-align: center;
	color: red;

</style>
<body>
	<div>
		<h1>Thông báo</h1>
		<h4>Tài khoản của quý khách đã hết hạn sử dụng !</h4>
		<h4>Để tiếp tục sử dụng dịch vụ, quý khách vui lòng liên hệ với quản trị viên !</h4>
		<h4>Xin cảm ơn !</h4>
	</div>

	<script>
		setTimeout(function(){
			 window.location="/logout";
		}, 10000);
	</script>
</body>
</html>