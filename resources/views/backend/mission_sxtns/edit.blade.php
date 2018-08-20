@extends('backend.layouts.master-company')

@section('header')
<link rel="stylesheet" type="text/css" href="{{mix('build/css/mission-sxtns.css')}}">

@endsection

@section('breadcrumb')
	<li>Danh sách nhiệm vụ</li>
  <li class="active"><a href="{{ route('mission-sxtn.index') }}">Dự án SXTN</a></li>
  <li class="active">Cập nhật phiếu đề xuất</li>
@endsection

@section('content')
<form action="" method="post" id="edit-sxtn-frm" enctype="multipart/form-data" role="form">
	<input type="hidden" id="key" name="key" value="{{$key}}">
  <div class="panel panel-default">
      <div class="panel-body tab-content">
      	<div class="row">
      		<div class="col-md-12">
	          <center>
	            <br>
	            <h3>PHIẾU ĐỀ XUẤT ĐẶT HÀNG NHIỆM VỤ</h3>
	            <h3>KHOA HỌC VÀ CÔNG NGHỆ CẤP QUỐC GIA</h3>
	            <h4><i>(Dùng cho dự án SXTN)</i></h4>
	          </center>
	        </div>
	    </div>
	        <hr>
			{{-- <br><br><br><br> --}}
      		<div class="row">
				<div class="form-group">
	                <label class="label-custom-size">1. Tên nhiệm vụ: <span class="error">(*)</span></label>
	                <div class="col-md-12 col-xs-12">
	                    <textarea placeholder="Vui lòng nhập tên nhiệm vụ" class="form-control" rows="5" id="sxtn_name" name="sxtn_name">{{$arr['sxtn_name']}}</textarea>
	                </div>
	            </div>
            </div>
			<br>

            <div class="row">
	            <div class="form-group">
	                <label class="label-custom-size">2. Xuất xứ hình thành: 
	                &nbsp;<i>(Từ một trong các nguồn sau: kết quả của các đề tài; kết quả khai thác sáng chế, giải pháp hữu ích; kết quả KH&CN chuyển giao từ nước ngoài... có khả năng ứng dụng): </i><span style="font-style: italic; color: red">(*)</span></label>
	                <div class="col-md-12 col-xs-12">
	                    <textarea placeholder="Vui lòng nhập xuất xứ hình thành" class="form-control" rows="5" id="formation" name="formation">{{$arr['formation']}}</textarea>
	                </div>
	            </div>
			</div>
			<br>
			<div class="row">
	            <div class="form-group">
	                <label class="label-custom-size">3. Tính cấp thiết; tầm quan trọng phải thực hiện ở tầm quốc gia; tác động và ảnh hưởng đến đời sống kinh tế - xã hội của đất nước v.v...: <span style="font-style: italic; color: red">(*)</span> </label>
	                <div class="col-md-12 col-xs-12">
	                    <textarea placeholder="Vui lòng nhập tính cấp thiết, tầm quan trọng phải thực hiện ở tầm quốc gia; tác động và ảnh hưởng đến đời sống kinh tế - xã hội của đất nước v.v..." class="form-control" rows="5" id="urgency_importance" name="urgency_importance">{{$arr['urgency_importance']}}</textarea>
	                </div>
	            </div>
			</div>
			<br>
			<div class="row">
	            <div class="form-group">
	                <label class="label-custom-size">4. Mục tiêu: <span class="error">(*)</span></label>
	                <div class="col-md-12 col-xs-12">
	                    <textarea placeholder="Vui lòng nhập mục tiêu" class="form-control" rows="5" id="target" name="target">{{$arr['target']}}</textarea>
	                </div>
	            </div>
			</div>
			<br>
			<div class="row">
	            <div class="form-group">
	                <label class="label-custom-size">5. Kiến nghị các nội dung chính cần thực hiện để hoàn thiện công nghệ và đạt kết quả: <span style="font-style: italic; color: red">(*)</span> </label>
	                <div class="col-md-12 col-xs-12">
	                    <textarea placeholder="Vui lòng nhập kiến nghị các nội dung chính cần thực hiện để hoàn thiện công nghệ và đạt kết quả" class="form-control" rows="5" id="main_content" name="main_content">{{$arr['main_content']}}</textarea>
	                </div>
	            </div>
			</div>
			<br>
			<div class="row">
	            <div class="form-group">
	                <label class="label-custom-size">6. Yêu cầu đối với kết quả (công nghệ, thiết bị) và các chỉ tiêu kỹ thuật cần đạt: <span style="font-style: italic; color: red">(*)</span> </label>
	                <div class="col-md-12 col-xs-12">
	                    <textarea placeholder="Vui lòng nhập Yêu cầu đối với kết quả (công nghệ, thiết bị) và các chỉ tiêu kỹ thuật cần đạt" class="form-control" rows="5" id="claim_result" name="claim_result">{{$arr['claim_result']}}</textarea>
	                </div>
	            </div>
			</div>
            <br>

            <div class="row">
	            <div class="form-group">
	                <label class="label-custom-size">7. Nhu cầu thị trường: (Khả năng thị trường tiêu thụ, phương thức chuyển giao và thương mại hoá các sản phẩm của dự án): <span style="font-style: italic; color: red">(*)</span> </label>
	                <div class="col-md-12 col-xs-12">
	                    <textarea placeholder="Vui lòng nhập nhu cầu thị trường" class="form-control" rows="5" id="market_demand" name="market_demand">{{$arr['market_demand']}}</textarea>
	                </div>
	            </div>
			</div>
            <br>

            <div class="row">
	            <div class="form-group">
	                <label class="label-custom-size">8. Dự kiến tổ chức cơ quan hoặc địa chỉ ứng dụng các kết quả tạo ra: <span style="font-style: italic; color: red">(*)</span> </label>
	                <div class="col-md-12 col-xs-12">
	                    <textarea placeholder="vui lòng nhập dự kiến tổ chức cơ quan hoặc địa chỉ ứng dụng các kết quả tạo ra" class="form-control" rows="5" id="expected_organize" name="expected_organize">{{$arr['expected_organize']}}</textarea>
	                </div>
	            </div>
			</div>
            <br>

            <div class="row">
	            <div class="form-group">
	                <label class="label-custom-size">9. Yêu cầu đối với thời gian thực hiện: <span style="font-style: italic; color: red">(*)</span> </label>
	                <div class="col-md-12 col-xs-12">
	                    <textarea placeholder="Vui lòng nhập yêu cầu đối với thời gian thực hiện" class="form-control" rows="5" id="claim_excecution_time" name="claim_excecution_time">{{$arr['claim_excecution_time']}}</textarea>
	                </div>
	            </div>
			</div>
            <br>

			<div class="row">
	            <div class="form-group">
	                <label class="label-custom-size">10. Phương án huy động các nguồn lực của tổ chức dự kiến ứng dụng kết quả tạo ra: (Khả năng huy động nhân lực, tài chính và cơ sở vật chất từ các nguồn khác nhau để thực hiện dự án): <span style="font-style: italic; color: red">(*)</span> </label>
	                <div class="col-md-12 col-xs-12">
	                    <textarea placeholder="vui lòng nhập phương án huy động các nguồn lực của tổ chức dự kiến ứng dụng kết quả tạo ra" class="form-control" rows="5" id="plan_mobilizing_resource" name="plan_mobilizing_resource">{{$arr['plan_mobilizing_resource']}}</textarea>
	                </div>
	            </div>
			</div>
            <br>

            <div class="row">
	            <div class="form-group">
	                <label class="label-custom-size">11. Dự kiến nhu cầu kinh phí: <span style="font-style: italic; color: red">(*)</span></label>
	                <div class="col-md-12 col-xs-12">
	                    <input type="text" class="form-control" id="expected_funding" name="expected_funding" value="{{($arr['expected_funding'] != '') ? number_format(Crypt::decrypt($arr['expected_funding'])) : ''}} VNĐ"/>
	                </div>
	            </div>
			</div>
			<br>

			<div class="row">
	            <div class="form-group">
	                <label class="label-custom-size">Phiếu đánh giá của chuyên gia độc lập 01
	                @if ($check_input_01 == true)
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      <a @if(isset($arr['evaluation_form_01'])) data-link="{{ $arr['evaluation_form_01'] }}" data-order="{{ $order_evaluation_form_01 }}"@endif class="btn-view-file">
                      	<span style="font-style: italic; color: green"><i class="fa fa-check" aria-hidden="true"></i> Xem file </span>
                      </a>
                    @endif
                    </label>
	                <div class="col-md-12 col-xs-12">

	                    <input type="file" class="evaluation_form" id="evaluation_form_01" name="evaluation_form_01" data-order='01'/>
	                    <p style="font-style: italic; color: red">(*) Định dạng PDF, dung lượng < 5 Mb</p>
	                </div>
	            </div>
			</div>
			<br>

			<div class="row">
	            <div class="form-group">
	                <label class="label-custom-size">Phiếu đánh giá của chuyên gia độc lập 02
	                	@if ($check_input_02 == true)
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      <a @if(isset($arr['evaluation_form_02'])) data-link="{{ $arr['evaluation_form_02'] }}" data-order="{{ $order_evaluation_form_02 }}"@endif class="btn-view-file">
                      	<span style="font-style: italic; color: green"><i class="fa fa-check" aria-hidden="true"></i> Xem file </span>
                      </a>
                    @endif</label>
	                <div class="col-md-12 col-xs-12">
	                    <input data-order='02' type="file" class="evaluation_form" id="evaluation_form_02" name="evaluation_form_02"/>
						<p style="font-style: italic; color: red">(*) Định dạng PDF, dung lượng < 5 Mb</p>

	                </div>
	            </div>
			</div>
			<br>

		</div>
         <div class="panel-footer">
         	<div class="row">
				<div class="col-md-6 col-xs-12">
					<h5><span class="error">(*)</span> Ghi chú: <br>- <i>Phiếu đề xuất được trình bày không quá 6 trang giấy khổ A4</i> <br>- <i>Các mục <span class="error">(*)</span> là bắt buộc</i></h5>
				</div>

			   <div class="col-md-6 col-xs-12">
			   		<div class="pull-right">
			   			@if (isset($is_filled) && $is_filled == 1)
			            	<a href="{{ route('mission-sxtn.detail', $key) }}" target="_blank" class="btn btn-success" type="submit"><span class="fa fa-eye"></span> Xem phiếu</a>
			            @endif

			            <button class="btn btn-info" type="submit"><span class="fa fa-floppy-o"></span> Lưu thông tin</button>

			        </div>
			   </div>
	        </div>
        </div>
  	</div>
 </form>

@endsection

@section('footer')
  <script type="text/javascript" src="{{mix('build/js/mission_sxtns.js')}}"></script>

@endsection
