<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>NATEC | HỆ THỐNG QUẢN LÝ NHIỆM VỤ KHOA HỌC VÀ CÔNG NGHỆ CẤP QUỐC GIA</title>

	<!-- Latest compiled and minified CSS & JS -->
	<link rel="stylesheet" media="screen" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
	<script src="https://code.jquery.com/jquery.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
	<style type="text/css">
	p{
		margin:10px 0;
		padding:0;
	}
	table{
		border-collapse:collapse;
	}
	h1,h2,h3,h4,h5,h6{
		display:block;
		margin:0;
		padding:0;
	}
	img,a img{
		border:0;
		height:auto;
		outline:none;
		text-decoration:none;
	}
	body,#bodyTable,#bodyCell{
		height:100%;
		margin:0;
		padding:0;
		width:100%;
	}
	.mcnPreviewText{
		display:none !important;
	}
	#outlook a{
		padding:0;
	}
	img{
		-ms-interpolation-mode:bicubic;
	}
	table{
		mso-table-lspace:0pt;
		mso-table-rspace:0pt;
	}
	.ReadMsgBody{
		width:100%;
	}
	.ExternalClass{
		width:100%;
	}
	p,a,li,td,blockquote{
		mso-line-height-rule:exactly;
	}
	a[href^=tel],a[href^=sms]{
		color:inherit;
		cursor:default;
		text-decoration:none;
	}
	p,a,li,td,body,table,blockquote{
		-ms-text-size-adjust:100%;
		-webkit-text-size-adjust:100%;
	}
	.ExternalClass,.ExternalClass p,.ExternalClass td,.ExternalClass div,.ExternalClass span,.ExternalClass font{
		line-height:100%;
	}
	a[x-apple-data-detectors]{
		color:inherit !important;
		text-decoration:none !important;
		font-size:inherit !important;
		font-family:inherit !important;
		font-weight:inherit !important;
		line-height:inherit !important;
	}
	.templateContainer{
		max-width:600px !important;
	}
	a.mcnButton{
		display:block;
	}
	.mcnImage,.mcnRetinaImage{
		vertical-align:bottom;
	}
	.mcnTextContent{
		word-break:break-word;
	}
	.mcnTextContent img{
		height:auto !important;
	}
	.mcnDividerBlock{
		table-layout:fixed !important;
	}

	h1{
		color:#222222;
		font-family:Helvetica;
		font-size:40px;
		font-style:normal;
		font-weight:bold;
		line-height:150%;
		letter-spacing:normal;
		text-align:left;
	}

	h2{
		color:#222222;
		font-family:Helvetica;
		font-size:28px;
		font-style:normal;
		font-weight:bold;
		line-height:150%;
		letter-spacing:normal;
		text-align:left;
	}

	h3{
		color:#444444;
		font-family:Helvetica;
		font-size:22px;
		font-style:normal;
		font-weight:bold;
		line-height:150%;
		letter-spacing:normal;
		text-align:left;
	}

	h4{
		color:#999999;
		font-family:Georgia;
		font-size:20px;
		font-style:italic;
		font-weight:normal;
		line-height:125%;
		letter-spacing:normal;
		text-align:left;
	}

	#templateHeader{
		background-color:#F7F7F7;
		background-image:none;
		background-repeat:no-repeat;
		background-position:center;
		background-size:cover;
		border-top:0;
		border-bottom:0;
		padding-top:30px;
		padding-bottom:30px;
	}

	.headerContainer{
		background-color:transparent;
		background-image:none;
		background-repeat:no-repeat;
		background-position:center;
		background-size:cover;
		border-top:0;
		border-bottom:0;
		padding-top:0;
		padding-bottom:0;
	}

	.headerContainer .mcnTextContent,.headerContainer .mcnTextContent p{
		color:#808080;
		font-family:Helvetica;
		font-size:16px;
		line-height:150%;
		text-align:left;
	}

	.headerContainer .mcnTextContent a,.headerContainer .mcnTextContent p a{
		color:#00ADD8;
		font-weight:normal;
		text-decoration:underline;
	}

	#templateBody{
		background-color:#FFFFFF;
		background-image:none;
		background-repeat:no-repeat;
		background-position:center;
		background-size:cover;
		border-top:0;
		border-bottom:0;
		padding-top:27px;
		padding-bottom:63px;
	}

	.bodyContainer{
		background-color:transparent;
		background-image:none;
		background-repeat:no-repeat;
		background-position:center;
		background-size:cover;
		border-top:0;
		border-bottom:0;
		padding-top:0;
		padding-bottom:0;
	}

	.bodyContainer .mcnTextContent,.bodyContainer .mcnTextContent p{
		color:#808080;
		font-family:Helvetica;
		font-size:16px;
		line-height:150%;
		text-align:left;
	}

	.bodyContainer .mcnTextContent a,.bodyContainer .mcnTextContent p a{
		color:#00ADD8;
		font-weight:normal;
		text-decoration:underline;
	}

	#templateFooter{
		background-color:#333333;
		background-image:none;
		background-repeat:no-repeat;
		background-position:center;
		background-size:cover;
		border-top:0;
		border-bottom:0;
		padding-top:45px;
		padding-bottom:63px;
	}

	.footerContainer{
		background-color:transparent;
		background-image:none;
		background-repeat:no-repeat;
		background-position:center;
		background-size:cover;
		border-top:0;
		border-bottom:0;
		padding-top:0;
		padding-bottom:0;
	}

	.footerContainer .mcnTextContent,.footerContainer .mcnTextContent p{
		color:#FFFFFF;
		font-family:Helvetica;
		font-size:12px;
		line-height:150%;
		text-align:center;
	}

	.footerContainer .mcnTextContent a,.footerContainer .mcnTextContent p a{
		color:#FFFFFF;
		font-weight:normal;
		text-decoration:underline;
	}
	#color_policy p, #color_policy span {
		color: #fff !important;
	}

	.color_policy p, .color_policy span {
		color: #fff !important;
	}
</style>
<link rel="stylesheet" href="{{ asset('timeline/dist/css/responsive_email.css') }}">
</head>
<body>
	<span class="mcnPreviewText" style="display:none; font-size:0px; line-height:0px; max-height:0px; max-width:0px; opacity:0; overflow:hidden; visibility:hidden; mso-hide:all;">NATEC</span>

	<center>
		<table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable">
			<tr>
				<td align="center" valign="top" id="bodyCell">

					<table border="0" cellpadding="0" cellspacing="0" width="100%">
						<tr>
							<td align="center" valign="top" id="templateHeader" data-template-container>
								<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer">
									<tr>
										<td valign="top" class="headerContainer">
											<table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnImageBlock" style="min-width:100%;">
												<tbody class="mcnImageBlockOuter">
													<tr>
														<td valign="top" style="padding:9px" class="mcnImageBlockInner">
															<table align="left" width="100%" border="0" cellpadding="0" cellspacing="0" class="mcnImageContentContainer" style="min-width:100%;">
																<tbody>
																	<tr>
																		<td class="mcnImageContent" valign="top" style="padding-right: 9px; padding-left: 9px; padding-top: 0; padding-bottom: 0; text-align:center;">

																			<img src="http://natec.gov.vn/file/2016/08/banner.png" alt="loading..." align="center" width="564" style="max-width:1176px; padding-bottom: 0; display: inline !important; vertical-align: bottom;" class="mcnImage">

																		</td>
																	</tr>
																</tbody>
															</table>
														</td>
													</tr>
												</tbody>
											</table>
										</td>
									</tr>
								</table>
							</td>
						</tr>

						<tr>
							<td align="center" valign="top" id="templateBody" data-template-container>
								<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer">
									<tr>
										<td valign="top" class="bodyContainer">
											<table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
												<tbody class="mcnTextBlockOuter">
													<tr>
														<td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
															<table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
																<tbody>
																	<tr>
																		<td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">

																			Xin chào bạn, <br><br>

																			Chúng tôi vừa nhận được một yêu cầu đăng ký tài khoản từ email của bạn. <br>
																			Để hoàn tất quá trình đăng ký, vui lòng xác nhận: <br> <br>

																			<center>
																				<a href='@if (isset($parameter['link']))
																					{{$parameter['link']}}
																				@endif' class='m_5715491286458392283button m_5715491286458392283button-blue' style='font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;border-radius:3px;color:#fff;display:inline-block;text-decoration:none;background-color:#3097d1;border-top:10px solid #3097d1;border-right:18px solid #3097d1;border-bottom:10px solid #3097d1;border-left:18px solid #3097d1' target='_blank' >Kích hoạt tài khoản</a>
																			</center> <br>

																			Cảm ơn !

																			<br> <hr> <br>
																			Nếu bạn gặp vấn đề trong việc nhấn nút "Kích hoạt tài khoản", sao chép đường link này và dán vào trình duyệt của bạn: <br>
																			@if (isset($parameter['link']))
																				{{$parameter['link']}}
																			@endif
																		</td>

																	</tr>
																</tbody>
															</table>
														</td>
													</tr>
												</tbody>
											</table>

											<br>

											<table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnDividerBlock" style="min-width:100%;">
												<tbody class="mcnDividerBlockOuter">
													<tr>
														<td class="mcnDividerBlockInner" style="min-width:100%; padding:18px;">
															<table class="mcnDividerContent" border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width:100%;">
																<tbody>
																	<tr>
																		<td>
																			<span></span>
																		</td>
																	</tr>
																</tbody>
															</table>
														</td>
													</tr>
												</tbody>
											</table>
											<!-- <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnBoxedTextBlock" style="min-width:100%;">
												<tbody class="mcnBoxedTextBlockOuter">
													<tr>
														<td valign="top" class="mcnBoxedTextBlockInner">
															<table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width:100%;" class="mcnBoxedTextContentContainer">
																<tbody>
																	<tr>
																		<td style="padding-top:9px; padding-left:18px; padding-bottom:9px; padding-right:18px;">
																			<table border="0" cellspacing="0" class="mcnTextContentContainer" width="100%" style="min-width: 100% !important;background-color: #F7F7F7;">
																				<tbody>
																					<tr>
																						<td valign="top" class="mcnTextContent" style="padding: 18px; text-align: center;">
																							<h3 style="text-align:center;">
																								<span style="font-size:16px">BẠN ĐANG CÓ THẮC MẮC</span>
																							</h3>

																							<p style="text-align:center !important;"><span style="font-size:15px">Liên hệ trực tiếp với chúng tôi qua hotline: <strong><span style="color:#FF8C00"><a href="0868901456">0868901456</a></span></strong> hoặc email <a href="mailto:info@zent.vn"><strong><span style="color:#FF8C00">info@zent.vn</span></strong></a></span></p>
																						</td>
																					</tr>
																				</tbody>
																			</table>
																		</td>
																	</tr>
																</tbody>
															</table>
														</td>
													</tr>
												</tbody>
											</table> -->
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							{{-- <td align="center" valign="top" id="templateFooter" data-template-container> --}}
								<!-- <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer">
									<tr>
										<td valign="top" class="footerContainer">

												<tbody class="mcnDividerBlockOuter">
													<tr>
														<td class="mcnDividerBlockInner" style="min-width:100%; padding:18px;">
															<table class="mcnDividerContent" border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width: 100%;border-top: 2px solid #505050;">
																<tbody><tr>
																	<td>
																		<span></span>
																	</td>
																</tr>
															</tbody></table>
														</td>
													</tr>
												</tbody>
											</table> -->
											<!-- <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
												<tbody class="mcnTextBlockOuter">
													<tr>
														<td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
															<table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
																<tbody><tr align="center">
																	<td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">

																		<strong style="color: white;">Zent Space Tầng 5, Số 2 Ngõ Trại Cá, Trương Định, Hai Bà Trưng, Hà Nội</strong>
																		<br>
																		<strong style="color: white;">Website:</strong>
																		<a href="https://zent.edu.vn" target="_blank" >https://zent.edu.vn</a>
																		<br>
																		<strong style="color: white;">Địa chỉ hòm thư liên hệ:</strong>
																		<a href="mailto:info@zent.vn">info@zent.vn</a>
																		<br><br>
																		<em style="color: white;">Copyright © 2018 Zent Group, All rights reserved.</em>

																	</td>
																</tr>
															</tbody></table>
														</td>
													</tr>
												</tbody>
											</table> -->
										{{-- </td> --}}
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</center>
</body>
</html>
