<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	Kính gửi: {{($data->company->name)}} <br>
	Bạn vừa yêu cầu gian hạn thời gian sử dụng là: <span style="color: red"> {{$data['time_limit']/12}} </span> năm, với chi phí là: <span style="color: red">{{number_format($data['price'])}} </span>VNĐ.
	<br>
	Để hoàn tất quy trình, Bạn vui lòng chuyển tiền đến tài khoản:
	<p style="color: red">	Chủ tài khoản: NGUYEN THANH NAM<br>
	STK: 0711000297159<br>
	Chi nhanh Vietcombanh Thanh Xuân.</p>
	Chúng tôi sẽ gia hạn thời gian sử dụng cho quý khách sau khi nhận được thông báo chuyển khoản.<br>
	Xin chân thành cảm ơn!
</body>
</html>