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
	<div class="row" style="padding-right: 4%">
		<div class="col-md-12">
			<div style="float: right;">
				<p><b>Mẫu B1-TVHĐ</b></p>
				<p>03/2017/TT-BKHCN</p>
			</div>
		</div>	
	</div>
	<div class="col-md-12">
            <center><strong>
              <h4>PHIẾU NHẬN XÉT VÀ ĐÁNH GIÁ</h4>
              <h4>ĐỀ XUẤT ĐẶT HÀNG ĐỀ TÀI/DỰ ÁN CẤP QUỐC GIA</h4></strong>
            </center>
            <br>
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
          </div>
          <div class="col-md-12">
            <h5><strong>Họ và tên chuyên gia:</strong> {{Auth::user()->name}}</h5>
            <h5><strong>Tên đề tài/dự án đề xuất:</strong> {{(isset($name))?$name:""}}</h5>
          </div>

          <div class="clearfix"></div>
          <br><br><br>
          <h5>
            <div class="col-md-12">
                <h4><strong>I. NHẬN XÉT VÀ ĐÁNH GIÁ ĐỀ XUẤT ĐẶT HÀNG</strong></h4>
                <div class="col-md-12 block">
                    <label>1.1   Tính cấp thiết của việc thực hiện đề tài/dự án</label>
                    <div class="col-md-12 indent-15 form-group">
                      <p>Nhận xét: <span class='error'>(*)</span></p>
                      <p>{{isset($comment_evaluation['necessity'])?$comment_evaluation['necessity']['note']:""}}</p>
                    </div>

                    <div class="col-md-12 indent-15 form-group">
                      <span>Đánh giá: <span class='error'>(*)</span></span>
                      <label class="radio-inline">
                        <input type="checkbox" disabled name="necessity_qualified" value="1" {{isset($comment_evaluation['necessity']) && $comment_evaluation['necessity']['qualified']?"checked":""}}>Đạt yêu cầu
                      </label>
                      <label class="radio-inline">
                        <input type="checkbox" disabled name="necessity_qualified" value="0" {{isset($comment_evaluation['necessity']) && !$comment_evaluation['necessity']['qualified']?"checked":""}} {{(!isset($comment_evaluation['necessity']))?"checked":""}}>Không đạt yêu cầu
                      </label>
                    </div>
                </div>
                <div class="col-md-12 block">
                    <label>1.2   Tính liên ngành, liên vùng và tầm quan trọng của vấn đề khoa học đặt ra trong đề xuất đặt hàng</label>
                    <div class="col-md-12 indent-15 form-group">
                      <p>Nhận xét: <span class='error'>(*)</span></p>
                      <p>{{isset($comment_evaluation['important'])?$comment_evaluation['important']['note']:""}}</p>
                    </div>

                    <div class="col-md-12 indent-15 form-group">
                      <span>Đánh giá: <span class='error'>(*)</span></span>
                      <label class="radio-inline">
                        <input type="checkbox" disabled name="important_qualified" value="1" {{isset($comment_evaluation['important']) && $comment_evaluation['important']['qualified']?"checked":""}}>Đạt yêu cầu
                      </label>
                      <label class="radio-inline">
                        <input type="checkbox" disabled name="important_qualified" value="0" {{isset($comment_evaluation['important']) && !$comment_evaluation['important']['qualified']?"checked":""}} {{(!isset($comment_evaluation['important']))?"checked":""}}>Không đạt yêu cầu
                      </label>
                    </div>
                </div>
                <div class="col-md-12 block">
                    <label>1.3   Khả năng không trùng lắp của đề tài, dự án với các nhiệm vụ khoa học và công nghệ đã và đang thực hiện</label>
                    <div class="col-md-12 indent-15 form-group">
                      <p>Nhận xét: <span class='error'>(*)</span></p>
                      <p>{{isset($comment_evaluation['unique'])?$comment_evaluation['unique']['note']:""}}</p>
                    </div>

                    <div class="col-md-12 indent-15 form-group">
                      <span>Đánh giá: <span class='error'>(*)</span></span>
                      <label class="radio-inline">
                        <input type="checkbox" disabled name="unique_qualified" value="1" {{isset($comment_evaluation['unique']) && $comment_evaluation['unique']['qualified']?"checked":""}}>Đạt yêu cầu
                      </label>
                      <label class="radio-inline">
                        <input type="checkbox" disabled name="unique_qualified" value="0" {{isset($comment_evaluation['unique']) && !$comment_evaluation['unique']['qualified']?"checked":""}} {{(!isset($comment_evaluation['unique']))?"checked":""}}>Không đạt yêu cầu
                      </label>
                    </div>
                </div>
                <div class="col-md-12 block">
                    <label>1.4   Nhu cầu cần thiết phải huy động nguồn lực quốc gia cho việc thực hiện đề tài, dự án</label>
                    <div class="col-md-12 indent-15 form-group">
                      <p>Nhận xét: <span class='error'>(*)</span></p>
                      <p>{{isset($comment_evaluation['natinal_resources'])?$comment_evaluation['natinal_resources']['note']:""}}</p>
                    </div>

                    <div class="col-md-12 indent-15 form-group">
                      <span>Đánh giá: <span class='error'>(*)</span></span>
                      <label class="radio-inline">
                        <input type="checkbox" disabled name="natinal_resources_qualified" value="1" {{isset($comment_evaluation['natinal_resources']) && $comment_evaluation['natinal_resources']['qualified']?"checked":""}}>Đạt yêu cầu
                      </label>
                      <label class="radio-inline">
                        <input type="checkbox" disabled name="natinal_resources_qualified" value="0" {{isset($comment_evaluation['natinal_resources']) && !$comment_evaluation['natinal_resources']['qualified']?"checked":""}} {{(!isset($comment_evaluation['natinal_resources']))?"checked":""}}>Không đạt yêu cầu
                      </label>
                    </div>
                </div>
                <div class="col-md-12 block">
                    <label>1.5   Khả năng huy động được nguồn kinh phí ngoài ngân sách để thực hiện (chỉ áp dụng đối với dự án)</label>
                    <div class="col-md-12 indent-15 form-group">
                      <p>Nhận xét: <span class='error'>(*)</span></p>
                      <p>{{isset($comment_evaluation['fund'])?$comment_evaluation['fund']['note']:""}}</p>
                    </div>

                    <div class="col-md-12 indent-15 form-group">
                      <span>Đánh giá: <span class='error'>(*)</span></span>
                      <label class="radio-inline">
                        <input type="checkbox" disabled name="fund_qualified" value="1" {{isset($comment_evaluation['fund']) && $comment_evaluation['fund']['qualified']?"checked":""}}>Đạt yêu cầu
                      </label>
                      <label class="radio-inline">
                        <input type="checkbox" disabled name="fund_qualified" value="0" {{isset($comment_evaluation['fund']) && !$comment_evaluation['fund']['qualified']?"checked":""}} {{(!isset($comment_evaluation['fund']))?"checked":""}}>Không đạt yêu cầu
                      </label>
                    </div>
                </div>
              </div>
              <div class="col-md-12">
                <h4><strong>II. Ý KIẾN CHUYÊN GIA (tích vào 1 trong 3 ô dưới đây)</strong></h4>
                <div class="col-md-12 indent-15 form-group">
                    <div class="radio">
                      <label>
                        <input type="checkbox" disabled name="is_perform" value="0" {{(isset($expert_opinions['is_unperform']) && $expert_opinions['is_unperform'])?"checked":""}} {{(empty($expert_opinions))?"checked":""}}>
                        Đề nghị không thực hiện
                      </label>
                    </div>
                    <div class="radio">
                      <label>
                        <input type="checkbox" disabled name="is_perform" value="1"  {{(isset($expert_opinions['is_perform']) && $expert_opinions['is_perform'])?"checked":""}}>
                        Đề nghị thực hiện
                      </label>
                    </div>
                    <div class="radio">
                      <label>
                        <input type="checkbox" disabled name="is_perform" id="inputHide" value="2" {{(isset($expert_opinions['is_perform_with_cond']) && !empty($expert_opinions['is_perform_with_cond']))?"checked":""}}>
                        Đề nghị thực hiện với các điều chỉnh nêu dưới đây: 
                      </label>
                    </div>
                    <div class="form-group other-radio  {{(isset($expert_opinions['is_perform_with_cond']) && !empty($expert_opinions['is_perform_with_cond']))?"":"hide"}}">
                      <label>2.1 Dự kiến tên đề tài/dự án:</span></label>
                      <p>{{(isset($expert_opinions['is_perform_with_cond']) && !empty($expert_opinions['is_perform_with_cond']))?$expert_opinions['is_perform_with_cond']['perform_name']:""}}</p>
                    </div>
                    <div class="form-group other-radio  {{(isset($expert_opinions['is_perform_with_cond']) && !empty($expert_opinions['is_perform_with_cond']))?"":"hide"}}">
                      <label>2.2 Định hướng mục tiêu:</span></label>
                      <p>{{(isset($expert_opinions['is_perform_with_cond']) && !empty($expert_opinions['is_perform_with_cond']))?$expert_opinions['is_perform_with_cond']['perform_target']:""}}</p>
                    </div>
                    <div class="form-group other-radio  {{(isset($expert_opinions['is_perform_with_cond']) && !empty($expert_opinions['is_perform_with_cond']))?"":"hide"}}">
                      <label>2.3 Yêu cầu đối với kết quả:</span></label>
                      <p>{{(isset($expert_opinions['is_perform_with_cond']) && !empty($expert_opinions['is_perform_with_cond']))?$expert_opinions['is_perform_with_cond']['perform_result']:""}}</p>
                    </div>
                  </div>
              </div>
              <div class="col-md-12" style="margin-top: 20px">
                <i>
                  Lưu ý:
                  <p>Đối với đề tài ứng dụng và phát triển công nghệ cần nêu rõ 2 yêu cầu:</p>
                  <p>-  Các chỉ tiêu kinh tế - kỹ thuật đối với công nghệ  hoặc sản phẩm khoa học và công nghệ</p>
                  <p>-  Yêu cầu đối với phương án phát triển công nghệ hoặc sản phẩm khoa học công nghệ trong giai đoạn sản xuất thử nghiệm</p>
                  <p>Đối với Dự án SXTN:</p>
                  <p>-  Các yêu cầu đối với chỉ tiêu kinh tế kỹ thuật cần đạt của các sản phẩm</p>
                  <p>-  Quy mô sản xuất thử nghiệm</p>
                </i>
              </div>
          </h5>
            <div class="col-md-12"> 
              <br><br><br>
              <div class="col-md-offset-6 col-md-6 col-xs-12">
                <div style="float: right">
                    <center>
                      <h5>....., ngày {{(!empty($date))?$date['d']:"....."}} tháng {{(!empty($date))?$date['m']:"....."}} năm {{(!empty($date))?$date['y']:"20..."}}</h5> <br>
                      <h4><i>(Chuyên gia ghi rõ họ tên)</i></h4>
                    </center>
                </div>

                <br><br><br><br><br><br><br><br><br><br><br><br>
              </div>
            </div>
        </div>
	