<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Phiếu đánh giá</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="{{asset('css/A4style.css')}}" />
	<!-- Latest compiled and minified CSS & JS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	{{-- <script src="//code.jquery.com/jquery.js"></script> --}}
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</head>
<body onload="window.print()">
	
	<div class="container" style="padding-top: 50px;">
		<div class="row" style="padding-right: 4%">
			<div class="col-md-12">
				<div style="float: right;">
					<p><b>Mẫu B3-TVHĐ</b></p>
					<p>03/2017/TT-BKHCN</p>
				</div>
			</div>	
		</div>
		<div class="row" style="padding-right: 4%">
			<div class="col-md-12">
				<center><h4><b>PHIẾU NHẬN XÉT VÀ ĐÁNH GIÁ</b></h4></center>
				<center><h4><b>ĐỀ XUẤT ĐẶT HÀNG DỰ ÁN KHOA HỌC VÀ CÔNG NGHỆ CẤP QUỐC GIA</b></h4></center>
			</div>
		</div>
		<div class="row" style="padding-right: 4%">
			<div class="col-md-12">
		        <table align="right" width="45%" border="1">
		        	<tr>
		        		<td width="80%" style="padding-left: 5px"><strong>Chuyên gia/Ủy viên phản biện</strong></td>
		        		<td></td>
		        	</tr>
		        	<tr>
		        		<td style="padding-left: 5px"><strong>Ủy viên hội đồng</strong></td>
		        		<td></td>
		        	</tr>
		        </table>
		    </div>
		</div>
		
	    <div class="row">

	        <div class="col-md-12" style="margin-top: 20px;">
	        	<p><strong>Họ và tên chuyên gia: </strong> {{Auth::user()->name}}</p>
	        </div>
			
	        <div class="col-md-12">
	        	<p><strong>Tên dự án KH&CN đề xuất: </strong><br>  {{$mission_name}} </p>
	        </div>
			<br><br>
			<div class="col-md-12">

				<form action="POST" id="evalution-form">
					<input name="mission_id" id="mission_id" type="hidden" value="{{$mission->id}}">
					<strong style="">I. NHẬN XÉT VÀ ĐÁNH GIÁ CHUNG ĐỀ XUẤT ĐẶT HÀNG</strong><br><br>
					<div class="form-group"  style="padding-left: 3%">
						<label for="" class="">1.1 Tính cấp thiết và mục tiêu của đề xuất đặt hàng so với dự án đầu tư sản xuất các sản phẩm trọng điểm chủ lực của bộ, ngành địa phương và của quốc gia (được nêu tại mục 2 của Phiếu đề xuất nhiệm vụ)</label>
						<span><i>Nhận xét:</i></span><br><br>
						<p>{{($content != null)? $content['comment_evaluation']['urgency_target']['note']: ''}}</p>
						<br>
						<span><i>Đánh giá:</i></span>&nbsp;&nbsp;
						
						<label class="radio-inline"><input disabled type="checkbox" @if ($content == null)
							checked
						@elseif($content != null && $content['comment_evaluation']['urgency_target']['rate'] == 1)
							checked
						
						@endif> Đạt yêu cầu</label>
						<label class="radio-inline"><input disabled type="checkbox" name="urgency_target_rate" value="0" {{($content != null && $content['comment_evaluation']['urgency_target']['rate'] == 0 ) ? 'checked' : ''}}> Không đạt yêu cầu</label>

					</div>

					<div class="form-group"  style="padding-left: 3%">
						<label for="" class="">1.2 Nhu cầu cần thiết phải huy động nguồn lực quốc gia cho việc thực hiện đề xuất đặt hàng</label><br>
						<span><i>Nhận xét:</i></span><br><br>
						<p>{{($content != null) ? $content['comment_evaluation']['necessity']['note'] : ''}}</p>
						{{-- <textarea class="form-control" rows="5" id="necessity_note" name="necessity_note" placeholder="Nhu cầu cần thiết phải huy động nguồn lực quốc gia cho việc thực hiện đề xuất đặt hàng"> {{($content != null) ? $content['comment_evaluation']['necessity']['note'] : ''}}</textarea> --}}
						<br>
						<span><i>Đánh giá:</i></span>&nbsp;&nbsp;
						
						<label class="radio-inline"><input type="checkbox" disabled name="necessity_rate" value="1" @if ($content == null)
							checked
						@elseif($content != null && $content['comment_evaluation']['necessity']['rate'] == 1)
							checked
						
						@endif>Đạt yêu cầu</label>
						<label class="radio-inline"><input type="checkbox" disabled name="necessity_rate" value="0" {{($content != null && $content['comment_evaluation']['necessity']['rate'] == 0) ? 'checked' : ''}}>Không đạt yêu cầu</label>

					</div>

					<div class="form-group"  style="padding-left: 3%">
						<label for="" class="">	1.3 Tính khả thi thể hiện qua nội dung đặt ra trong đề xuất đặt hàng; phương án huy động nguồn lực của tổ chức chủ trì</label><br>
						<span><i>Nhận xét:</i></span><br><br>
						<p>{{($content != null) ? $content['comment_evaluation']['possibility']['note'] : ''}}</p>
						<br>
						<span><i>Đánh giá:</i></span>&nbsp;&nbsp;
						
						<label class="radio-inline"><input type="checkbox" disabled name="possibility_rate" value="1" @if ($content == null)
							checked
						@elseif($content != null && $content['comment_evaluation']['possibility']['rate'] == 1)
							checked
						
						@endif>Đạt yêu cầu</label>
						<label class="radio-inline"><input type="checkbox" disabled name="possibility_rate" value="0" {{($content != null && $content['comment_evaluation']['possibility']['rate'] == 0) ? 'checked' : ''}}>Không đạt yêu cầu</label>

					</div>
				

					<strong style="">II. Ý KIẾN CHUYÊN GIA </strong><span>(đánh dấu <strong>X</strong> vào 1 trong 3 ô dưới đây)</span><br><br>
					<div class="form-group" style="padding-left: 3%">
						<div class="radio">
							<label><input type="checkbox" disabled name="suggest_perform" class="suggest_perform" value="1" @if ($content == null)
							checked
						@elseif($content != null && $content['expert_opinions']['is_perform']['rate'] == 1)
							checked
						
						@endif>Đề nghị thực hiện</label>
						</div>
						<div class="radio">
							<label><input type="checkbox" disabled name="suggest_perform" class="suggest_perform" value="0" {{($content != null && $content['expert_opinions']['is_unperform'] == 1) ? 'checked' : ''}}>Đề nghị không thực hiện</label>
						</div>
						<div class="radio">
							<label><input type="checkbox" disabled name="suggest_perform" class="suggest_perform" value="2" {{($content != null && $content['expert_opinions']['is_perform'] == 0 && $content['expert_opinions']['is_unperform'] == 0) ? 'checked' : ''}}>Đề nghị thực hiện với các điều chỉnh nêu dưới đây: </label>
						</div> 
						
						<div class="request_change" style="display: none">
							<div class="form-group"  style="padding-left: 3%">
								<label for="" class="">	2.1 Tên dự án KH&CN:</label>
								<br><br>
								<p>{{($content != null) ? $content['expert_opinions']['request']['name'] :''}}</p>

							</div>

							<div class="form-group"  style="padding-left: 3%">
								<label for="" class="">	2.2 Mục tiêu:</label>
								<br><br>
								<p>{{($content != null) ? $content['expert_opinions']['request']['target'] : ''}}</p>
											
							</div>

							<div class="form-group"  style="padding-left: 3%">
								<label for="" class="">	2.3 Yêu cầu đối với kết quả:</label>
								<br><br>
								<p>{{($content != null) ? $content['expert_opinions']['request']['result'] :''}}</p>

							</div>

						</div>

					</div>


				</form>
			</div>
			
			<div class="col-md-12"> <br><br><br>
	            <div class="col-md-offset-6 col-md-6 col-xs-12">
	                <div style="float: right">
	                    <center>
		                    <h4>....., ngày {{$date['d']}} tháng {{$date['m']}} năm {{$date['y']}}</h4>
		                    <h5><i>(Chuyên gia ký, ghi rõ họ tên)</i></h5>
	                    </center>
	                </div>

	              	<br><br><br><br><br><br><br><br>
	            </div>
	        </div>
		
        </div>
	</div>	
	