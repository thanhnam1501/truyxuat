@extends('backend.layouts.master')

@section('breadcrumb')
  <li class="">Danh sách nhiệm vụ</li>
  <li class=""><a href="{{ route('admin.mission-science-technologies.index') }}">Dự án khoa học và công nghệ</a></li>
  <li class="active">Phiếu đánh giá</li>
@endsection

@section('page-title')
@endsection


@section('content')
<div class="panel panel-default">
    <div class="panel-body">
    	<div class="container">
		    <div class="col-md-12">
		        <h3><i class="fa fa-book" aria-hidden="true"></i> PHIẾU NHẬN XÉT VÀ ĐÁNH GIÁ ĐỀ XUẤT ĐẶT HÀNG DỰ ÁN KHOA HỌC VÀ CÔNG NGHỆ CẤP QUỐC GIA 
				</h3> <br>
	      	</div>
			
	      	<div class="clearfix"></div>
	      	<hr>
			<br><br>
			<div style="font-size: 14px">
		      <p align="right">
		        <strong>Mẫu A3-ĐXNV</strong>
		      </p>
		      <p align="right">
		        03/2017/TT-BKHCN
		      </p>
			</div>
		    <div class="col-md-12">
	            <center>
	              	<br>
	              	<h3>PHIẾU NHẬN XÉT VÀ ĐÁNH GIÁ</h3>
	              	<h3>ĐỀ XUẤT ĐẶT HÀNG DỰ ÁN KHOA HỌC VÀ CÔNG NGHỆ CẤP QUỐC GIA</h3>
	            </center>
	        </div>
			<div class="col-md-12">
		        <table align="right" width="25%" border="1">
		        	<tr>
		        		<td width="80%"><strong>Chuyên gia/Ủy viên phản biện</strong></td>
		        		<td></td>
		        	</tr>
		        	<tr>
		        		<td><strong>Ủy viên hội đồng</strong></td>
		        		<td></td>
		        	</tr>
		        </table>
	        </div>

			<div class="content" style="font-size: 14px;">

		        <div class="col-md-12" style="margin-top: 20px;">
		        	<p><strong>Họ và tên chuyên gia: </strong> Vũ Văn Thương</p>
		        </div>
				
		        <div class="col-md-12">
		        	<p><strong>Tên dự án KH&CN đề xuất: </strong><br> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Atque similique possimus, nemo illo necessitatibus </p>
		        </div>
				<br><br>
				<div class="col-md-12">

					<form action="POST" id="evalution-form">
						<strong style="">I. NHẬN XÉT VÀ ĐÁNH GIÁ CHUNG ĐỀ XUẤT ĐẶT HÀNG</strong><br><br>
						<div class="form-group"  style="padding-left: 3%">
							<label for="" class="">1.1 Tính cấp thiết và mục tiêu của đề xuất đặt hàng so với dự án đầu tư sản xuất các sản phẩm trọng điểm chủ lực của bộ, ngành địa phương và của quốc gia (được nêu tại mục 2 của Phiếu đề xuất nhiệm vụ)</label>
							<span><i>Nhận xét:</i></span>
							<textarea class="form-control" rows="5"></textarea>
							<br>
							<span><i>Đánh giá:</i></span>&nbsp;&nbsp;
							
							<label class="radio-inline"><input type="radio" name="urgency_target">Đạt yêu cầu</label>
							<label class="radio-inline"><input type="radio" name="urgency_target">Không đạt yêu cầu</label>

						</div>

						<div class="form-group"  style="padding-left: 3%">
							<label for="" class="">1.2 Nhu cầu cần thiết phải huy động nguồn lực quốc gia cho việc thực hiện đề xuất đặt hàng</label>
							<span><i>Nhận xét:</i></span>
							<textarea class="form-control" rows="5"></textarea>
							<br>
							<span><i>Đánh giá:</i></span>&nbsp;&nbsp;
							
							<label class="radio-inline"><input type="radio" name="necessity">Đạt yêu cầu</label>
							<label class="radio-inline"><input type="radio" name="necessity">Không đạt yêu cầu</label>

						</div>

						<div class="form-group"  style="padding-left: 3%">
							<label for="" class="">	1.3 Tính khả thi thể hiện qua nội dung đặt ra trong đề xuất đặt hàng; phương án huy động nguồn lực của tổ chức chủ trì</label>
							<span><i>Nhận xét:</i></span>
							<textarea class="form-control" rows="5"></textarea>
							<br>
							<span><i>Đánh giá:</i></span>&nbsp;&nbsp;
							
							<label class="radio-inline"><input type="radio" name="possibility">Đạt yêu cầu</label>
							<label class="radio-inline"><input type="radio" name="possibility">Không đạt yêu cầu</label>

						</div>
					

						<strong style="">II. Ý KIẾN CHUYÊN GIA </strong><span>(đánh dấu <strong>X</strong> vào 1 trong 3 ô dưới đây)</span><br><br>
						<div class="form-group" style="padding-left: 3%">
							<div class="radio">
								<label><input type="radio" name="expert_opinions">Đề nghị thực hiện</label>
							</div>
							<div class="radio">
								<label><input type="radio" name="expert_opinions">Đề nghị không thực hiện</label>
							</div>
							<div class="radio">
								<label><input type="radio" name="expert_opinions">Đề nghị thực hiện với các điều chỉnh nêu dưới đây: </label>
							</div> 

							<div class="form-group"  style="padding-left: 3%">
								<label for="" class="">	2.1 Tên dự án KH&CN:</label>
			
								<textarea class="form-control" rows="5"></textarea>
								<br>
								
							</div>

							<div class="form-group"  style="padding-left: 3%">
								<label for="" class="">	2.2 Mục tiêu:</label>
			
								<textarea class="form-control" rows="5"></textarea>
								<br>
								
							</div>

							<div class="form-group"  style="padding-left: 3%">
								<label for="" class="">	2.3 Yêu cầu đối với kết quả:</label>
			
								<textarea class="form-control" rows="5"></textarea>
								<br>
								
							</div>


						</div>


					</form>
				</div>
				
				<div class="col-md-12"> <br><br><br>
		            <div class="col-md-offset-6 col-md-6 col-xs-12">
		                <div style="float: right">
		                    <center>
			                    <h4>....., ngày ..... tháng ..... năm 20...</h4>
			                    <h5><i>(Chuyên gia ký, ghi rõ họ tên)</i></h5>
		                    </center>
		                </div>

		              	<br><br><br><br><br><br><br><br>
		            </div>
		        </div>
			
	        </div>
			<div class="clearfix"></div>
			<hr>
	        <div class="col-md-12" style="text-align: right;"><button class="btn btn-success"id="update-science-technology-btn"><i class="fa fa-floppy-o" aria-hidden="true"></i> Lưu thông tin</button></div>
	    </div>
    </div>
 </div>
@endsection

@section('footer')
@endsection