@extends('backend.layouts.master')
@section('head')
<link rel="stylesheet" type="text/css" id="theme" href="{{mix('build/css/admin_mission_science_technology.css')}}"/>

@endsection
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
							<span><i>Nhận xét:</i></span>
							<textarea class="form-control" rows="5" id="urgency_target_note" name="urgency_target_note" placeholder="Tính cấp thiết và mục tiêu của đề xuất đặt hàng so với dự án đầu tư sản xuất các sản phẩm trọng điểm chủ lực của bộ, ngành địa phương và của quốc gia (được nêu tại mục 2 của Phiếu đề xuất nhiệm vụ)">{{($content != null)? $content['comment_evaluation']['urgency_target']['note']: ''}}</textarea>
							<br>
							<span><i>Đánh giá:</i></span>&nbsp;&nbsp;
							
							<label class="radio-inline"><input type="radio" name="urgency_target_rate" value="1" @if ($content == null)
								checked
							@elseif($content != null && $content['comment_evaluation']['urgency_target']['rate'] == 1)
								checked
							
							@endif>Đạt yêu cầu</label>
							<label class="radio-inline"><input type="radio" name="urgency_target_rate" value="0" {{($content != null && $content['comment_evaluation']['urgency_target']['rate'] == 0 ) ? 'checked' : ''}}>Không đạt yêu cầu</label>

						</div>

						<div class="form-group"  style="padding-left: 3%">
							<label for="" class="">1.2 Nhu cầu cần thiết phải huy động nguồn lực quốc gia cho việc thực hiện đề xuất đặt hàng</label><br>
							<span><i>Nhận xét:</i></span>
							<textarea class="form-control" rows="5" id="necessity_note" name="necessity_note" placeholder="Nhu cầu cần thiết phải huy động nguồn lực quốc gia cho việc thực hiện đề xuất đặt hàng">{{($content != null) ? $content['comment_evaluation']['necessity']['note'] : ''}}</textarea>
							{{-- <textarea class="form-control" rows="5" id="necessity_note" name="necessity_note" placeholder="Nhu cầu cần thiết phải huy động nguồn lực quốc gia cho việc thực hiện đề xuất đặt hàng"> {{($content != null) ? $content['comment_evaluation']['necessity']['note'] : ''}}</textarea> --}}
							<br>
							<span><i>Đánh giá:</i></span>&nbsp;&nbsp;
							
							<label class="radio-inline"><input type="radio" name="necessity_rate" value="1" @if ($content == null)
								checked
							@elseif($content != null && $content['comment_evaluation']['necessity']['rate'] == 1)
								checked
							
							@endif>Đạt yêu cầu</label>
							<label class="radio-inline"><input type="radio" name="necessity_rate" value="0" {{($content != null && $content['comment_evaluation']['necessity']['rate'] == 0) ? 'checked' : ''}}>Không đạt yêu cầu</label>

						</div>

						<div class="form-group"  style="padding-left: 3%">
							<label for="" class="">	1.3 Tính khả thi thể hiện qua nội dung đặt ra trong đề xuất đặt hàng; phương án huy động nguồn lực của tổ chức chủ trì</label><br>
							<span><i>Nhận xét:</i></span>
							<textarea class="form-control" rows="5" id="possibility_note" name="possibility_note" placeholder="Tính khả thi thể hiện qua nội dung đặt ra trong đề xuất đặt hàng; phương án huy động nguồn lực của tổ chức chủ trì">{{($content != null) ? $content['comment_evaluation']['possibility']['note'] : ''}}</textarea>
							<br>
							<span><i>Đánh giá:</i></span>&nbsp;&nbsp;
							
							<label class="radio-inline"><input type="radio" name="possibility_rate" value="1" @if ($content == null)
								checked
							@elseif($content != null && $content['comment_evaluation']['possibility']['rate'] == 1)
								checked
							
							@endif>Đạt yêu cầu</label>
							<label class="radio-inline"><input type="radio" name="possibility_rate" value="0" {{($content != null && $content['comment_evaluation']['possibility']['rate'] == 0) ? 'checked' : ''}}>Không đạt yêu cầu</label>

						</div>
					

						<strong style="">II. Ý KIẾN CHUYÊN GIA </strong><span>(đánh dấu <strong>X</strong> vào 1 trong 3 ô dưới đây)</span><br><br>
						<div class="form-group" style="padding-left: 3%">
							<div class="radio">
								<label><input type="radio" name="suggest_perform" class="suggest_perform" value="1" @if ($content == null)
								checked
							@elseif($content != null && $content['expert_opinions']['is_perform']['rate'] == 1)
								checked
							
							@endif>Đề nghị thực hiện</label>
							</div>
							<div class="radio">
								<label><input type="radio" name="suggest_perform" class="suggest_perform" value="0" {{($content != null && $content['expert_opinions']['is_unperform'] == 1) ? 'checked' : ''}}>Đề nghị không thực hiện</label>
							</div>
							<div class="radio">
								<label><input type="radio" name="suggest_perform" class="suggest_perform" value="2" {{($content != null && $content['expert_opinions']['is_perform'] == 0 && $content['expert_opinions']['is_unperform'] == 0) ? 'checked' : ''}}>Đề nghị thực hiện với các điều chỉnh nêu dưới đây: </label>
							</div> 
							
							<div class="request_change" style="display: none">
								<div class="form-group"  style="padding-left: 3%">
									<label for="" class="">	2.1 Tên dự án KH&CN:</label>
				
									<textarea class="form-control" rows="5" name="project_name" id="project_name">{{($content != null) ? $content['expert_opinions']['request']['name'] :''}}</textarea>
									<br>
									
								</div>

								<div class="form-group"  style="padding-left: 3%">
									<label for="" class="">	2.2 Mục tiêu:</label>
				
									<textarea class="form-control" rows="5" name="project_target" id="project_target">{{($content != null) ? $content['expert_opinions']['request']['target'] : ''}}</textarea>
									<br>
									
								</div>

								<div class="form-group"  style="padding-left: 3%">
									<label for="" class="">	2.3 Yêu cầu đối với kết quả:</label>
				
									<textarea class="form-control" rows="5" name="project_result" id="project_result">{{($content != null) ? $content['expert_opinions']['request']['result'] :''}}</textarea>
									<br>
									
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
			<div class="clearfix"></div>
			<hr>
	        <div class="col-md-12" style="text-align: right;"><button class="btn btn-success"id="evaluation-science-technology-btn"><i class="fa fa-floppy-o" aria-hidden="true"></i> Lưu thông tin</button></div>
	    </div>
    </div>
 </div>
@endsection

@section('footer')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/3.1.4/js/bootstrap-datetimepicker.min.js" charset="utf-8"></script>
<script type="text/javascript" src="{{ mix('build/js/admin_mission_science_technology.js') }}"></script>
@endsection