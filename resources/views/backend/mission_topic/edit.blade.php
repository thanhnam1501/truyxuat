@extends('backend.layouts.master-profile')

@section('header')
  <link rel="stylesheet" type="text/css" id="theme" href="{{mix('build/css/timeline.css')}}"/>
@endsection

@section('breadcrumb')
  <li class=""><a href="{{ route('home.list-missions') }}">Danh sách nhiệm vụ</a></li>
  <li class="active">Đề tài hoặc đề án</li>
@endsection

@section('page-title')

@endsection

@section('content')

  <div class="panel panel-default">

    <div class="panel-body">
      <div class="col-md-12">
        <h3><i class="fa fa-book" aria-hidden="true"></i> ĐĂNG KÝ NHIỆM VỤ DÙNG CHO ĐỀ TÀI HOẶC ĐỀ ÁN</h3> <br>
      </div>

      <div class="clearfix"></div>

      <div class="panel panel-default tabs">
          <ul class="nav nav-tabs" role="tablist">
            @if (!$topic->is_submit_ele_copy)
              <li class="active"><a href="#tab-form" role="tab" data-toggle="tab"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>&nbsp; Form đăng ký</a></li>
            @endif
            @if ($topic->is_submit_ele_copy)
              <li class="active"><a href="#tab-review" role="tab" data-toggle="tab"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp; Xem và in hồ sơ</a></li>
            @endif
            <li><a href="#tab-timeline" role="tab" data-toggle="tab"><i class="fa fa-calendar" aria-hidden="true"></i>&nbsp; Theo dõi hồ sơ</a></li>
          </ul>
      </div>

      <div class="panel-body tab-content">
        @if (!$topic->is_submit_ele_copy)
          <div class="tab-pane active" id="tab-form">
            <div class="col-md-12">
              <center>
                <br>
                <h3>PHIẾU ĐỀ XUẤT ĐẶT HÀNG NHIỆM VỤ</h3>
                <h3>KHOA HỌC VÀ CÔNG NGHỆ CẤP QUỐC GIA</h3>
                <h4><i>(Dùng cho đề tài hoặc đề án)</i></h4>
              </center>
            </div>

            <div class="col-md-12">
              <form action="" role="form" enctype="multipart/form-data" id="update-topic-frm">
                <input type="hidden" name="id" value="{{$topic->id}}">
                <input type="hidden" name="key" id="key" value="{{$topic->key}}">
                <div class="form-group">
                  <label for="type" class="label-custom-size">Loại nhiệm vụ <span class='error'>(*)</span></label><br>
                  <label class="radio-inline">
                    <input type="radio" name="type" {{($topic->type == 0)?"checked":""}} value="0">Đề tài
                  </label>
                  <label class="radio-inline">
                    <input type="radio" name="type" {{($topic->type == 1)?"checked":""}} value="1">Đề án
                  </label>
                </div>
                <div class="form-group">
                  <br>
                  <label for="" class="label-custom-size">1. Tên nhiệm vụ: <span class='error'>(*)</span></label>
                  <textarea type="text" id='name' name="name" rows="6" class="form-control" placeholder="Vui lòng nhập tên nhiệm vụ">{{isset($data['name'])?$data['name']:""}}</textarea>
                </div>
                <div class="form-group">
                  <label for="" class="label-custom-size">2. Căn cứ đề xuất <i>(giải trình căn cứ theo quy định tại Điều 3 của Thông tư 03/2017/TT-BKHCN Quy định trình tự thủ tục xác định nhiệm vụ khoa học và công nghệ cấp quốc gia sử dụng ngân sách nhà nước)</i>: <span class='error'>(*)</span></label>
                  <textarea name="propose_base" id="propose_base" class="form-control" rows="6" placeholder="Vui lòng nhập căn cứ đề xuất">{{isset($data['propose_base'])?$data['propose_base']:""}}</textarea>
                </div>
                <div class="form-group">
                  <label class="label-custom-size">3. Tính cấp thiết; tầm quan trọng phải thực hiện ở tầm quốc gia; tác động và ảnh hưởng đến đời sống kinh tế - xã hội của đất nước v.v...: <span class='error'>(*)</span></label>
                  <textarea name="urgency" id="urgency" class="form-control" rows="6" placeholder="Vui lòng nhập tính cấp thiết">{{isset($data['urgency'])?$data['urgency']:""}}</textarea>
                </div>
                <div class="form-group">
                  <label class="label-custom-size">4. Mục tiêu: <span class='error'>(*)</span></label>
                  <textarea name="target" id="target" class="form-control" rows="6" placeholder="Vui lòng nhập mục tiêu">{{isset($data['target'])?$data['target']:""}}</textarea>
                </div>
                <div class="form-group">
                  <label class="label-custom-size">5. Yêu cầu các kết quả chính và các chỉ tiêu cần đạt: <span class='error'>(*)</span></label>

                  <textarea name="result_target_requirement" id="result_target_requirement" class="form-control" rows="6" placeholder="Vui lòng nhập yêu cầu kết quả và chỉ tiêu cần đạt">{{isset($data['result_target_requirement'])?$data['result_target_requirement']:""}}</textarea>
                </div>
                <div class="form-group">
                  <label class="label-custom-size">6. Kiến nghị các nội dung cần thực hiện để đạt kết quả:<span class='error'>(*)</span></label>

                  <textarea name="expected_main_content" id="expected_main_content" class="form-control" rows="6" placeholder="Vui lòng nhập kiến nghị các nội dung cần thực hiện">{{isset($data['expected_main_content'])?$data['expected_main_content']:""}}</textarea>
                </div>
                <div class="form-group">
                  <label class="label-custom-size">7. Dự kiến tổ chức, cơ quan hoặc địa chỉ ứng dụng các kết quả tạo ra:<span class='error'>(*)</span></label>
                  <textarea name="expected_result_perform" id="expected_result_perform" class="form-control" rows="6" placeholder="Vui lòng nhập dự kiến tổ chức, cơ quan hoặc địa chỉ ứng dụng các kết quả">{{isset($data['expected_result_perform'])?$data['expected_result_perform']:""}}</textarea>
                </div>
                <div class="form-group">
                  <label class="label-custom-size">8. Yêu cầu đối với thời gian để đạt được các kết quả:<span class='error'>(*)</span></label>
                  <textarea name="time_result_requirement" id="time_result_requirement" class="form-control" rows="6" placeholder="Vui lòng nhập yêu cầu đối với thời gian để đạt được các kết quả">{{isset($data['time_result_requirement'])?$data['time_result_requirement']:""}}</textarea>
                </div>
                <div class="form-group">
                  <label class="label-custom-size">9. Dự kiến nhu cầu kinh phí:<span class='error'>(*)</span></label>
                  <input type="text" id='expected_fund' name="expected_fund" value="{{isset($data['expected_fund'])?number_format($data['expected_fund']).' VNĐ':" "}}" class="form-control" placeholder="Vui lòng nhập dự kiến nhu cầu kinh phí"/>
                </div>
                <br>
                <div class="form-group">
                  <label for="evaluation_form_01" class="label-custom-size">Phiếu đánh giá của chuyên gia độc lập 01
                      @if (isset($data['evaluation_form_01']))
                        @if (!empty($data['evaluation_form_01']))
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          <a data-link="{{ $data['evaluation_form_01'] }}" data-order="10" class="btn-view-file">
                            <span style="font-style: italic; color: green">
                              <i class="fa fa-check" aria-hidden="true"></i> Xem file
                            </span>
                          </a>
                        @endif
                      @endif
                  </label>
                  <input data-order='01' type="file" class="evaluation_form" id="evaluation_form_01" name="evaluation_form_01" accept="application/pdf" @if (!empty($data['evaluation_form_01'])) data-exists='1' @endif/>
                  <span style="font-style: italic; color: red">(*) Định dạng PDF, dung lượng <5MB</span>
                </div>
                <div class="form-group">
                    <label class="label-custom-size">Phiếu đánh giá của chuyên gia độc lập 02
                      @if (isset($data['evaluation_form_02']))
                        @if (!empty($data['evaluation_form_02']))
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          <a data-link="{{ $data['evaluation_form_02'] }}" data-order="11" class="btn-view-file">
                            <span style="font-style: italic; color: green">
                              <i class="fa fa-check" aria-hidden="true"></i> Xem file
                            </span>
                          </a>
                        @endif
                      @endif
                  </label>
                  <input data-order='02' type="file" class="evaluation_form" id="evaluation_form_02" name="evaluation_form_02" accept="application/pdf" @if (!empty($data['evaluation_form_02'])) data-exists='1' @endif/>
                  <span style="font-style: italic; color: red">(*) Định dạng PDF, dung lượng <5MB</span>
                </div>
              </form>

            </div>
          </div>
        @endif

        @if ($topic->is_submit_ele_copy)
          <div class="tab-pane active" id="tab-review">
            <div class="col-md-12">
              <center>
                <br>
                <h3>PHIẾU ĐỀ XUẤT ĐẶT HÀNG NHIỆM VỤ</h3>
                <h3>KHOA HỌC VÀ CÔNG NGHỆ CẤP QUỐC GIA</h3>
                <h4><i>(Dùng cho đề tài hoặc đề án)</i></h4>
              </center>
              <br>
            </div>
            <div class="col-md-12">
                @if (isset($data) && !empty($data))
                  @foreach ($data as $key => $value)
                   <div class='form-group'>
                     @if ($value["column"] == "expected_effect")
                       <h5><b>{{ $value["order"] }}. {!! $value["label"] !!}</b></h5>
                     @elseif ($value['column'] != "evaluation_form_01" && $value['column'] != "evaluation_form_02")
                       <h5><b>{{ $value["order"] }}. {!! $value["label"] !!}</b></h5>
                       <h5 class='text_value'>{{ $value["value"] }}</h5>
                       <br>
                     @endif
                   </div>
                 @endforeach
                @endif
            </div>
              <div class="col-md-12"> <br><br><br>
                <div class="col-md-offset-6 col-md-6 col-xs-12">
                  <div style="float: right">
                      <center>
                        <h5>....., ngày {{(!empty($date))?$date['d']:"....."}} tháng {{(!empty($date))?$date['m']:"....."}} năm {{(!empty($date))?$date['y']:"20..."}}</h5> <br>
                        <b><h4>TỔ CHỨC, CÁ NHÂN ĐỀ XUẤT</h4></b>
                        <h4><i>(Họ, tên và chữ ký - đóng dấu đối với tổ chức)</i></h4>
                      </center>
                  </div>

                  <br><br><br><br><br><br><br><br><br><br><br><br>
                </div>
              </div>
          </div>
        @endif
        <div class="tab-pane" id="tab-timeline">
          <div class="col-md-12">
            <center><br><h3>THEO DÕI HỒ SƠ</h3></center>
          </div>

          <div class="col-md-12">
            <div id="timeline">
              <div class="timeline-item">
        				<div class="timeline-icon">
        					<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                  	 width="21px" height="20px" viewBox="0 0 21 20" enable-background="new 0 0 21 20" xml:space="preserve">
                  <path fill="#FFFFFF" d="M19.998,6.766l-5.759-0.544c-0.362-0.032-0.676-0.264-0.822-0.61l-2.064-4.999
                  	c-0.329-0.825-1.5-0.825-1.83,0L7.476,5.611c-0.132,0.346-0.462,0.578-0.824,0.61L0.894,6.766C0.035,6.848-0.312,7.921,0.333,8.499
                  	l4.338,3.811c0.279,0.246,0.395,0.609,0.314,0.975l-1.304,5.345c-0.199,0.842,0.708,1.534,1.468,1.089l4.801-2.822
                  	c0.313-0.181,0.695-0.181,1.006,0l4.803,2.822c0.759,0.445,1.666-0.23,1.468-1.089l-1.288-5.345
                  	c-0.081-0.365,0.035-0.729,0.313-0.975l4.34-3.811C21.219,7.921,20.855,6.848,19.998,6.766z"/>
                  </svg>

        				</div>
        				<div class="timeline-content">
        					<center>
                    <h3>HỒ SƠ BẢN MỀM</h3>
                    <br>
                    <h4>
                      @if (isset($status_submit_ele_copy))
                        {!! $status_submit_ele_copy !!}
                      @endif
                    </h4>
                  </center>
        				</div>
        			</div>

        			<div class="timeline-item">
        				<div class="timeline-icon">
        					<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                  	 width="21px" height="20px" viewBox="0 0 21 20" enable-background="new 0 0 21 20" xml:space="preserve">
                  <g>
                  	<path fill="#FFFFFF" d="M17.92,3.065l-1.669-2.302c-0.336-0.464-0.87-0.75-1.479-0.755C14.732,0.008,7.653,0,7.653,0v5.6
                  		c0,0.096-0.047,0.185-0.127,0.237c-0.081,0.052-0.181,0.06-0.268,0.02l-1.413-0.64C5.773,5.183,5.69,5.183,5.617,5.215l-1.489,0.65
                  		c-0.087,0.038-0.19,0.029-0.271-0.023c-0.079-0.052-0.13-0.141-0.13-0.235V0H2.191C1.655,0,1.233,0.434,1.233,0.97
                  		c0,0,0.025,15.952,0.031,15.993c0.084,0.509,0.379,0.962,0.811,1.242l2.334,1.528C4.671,19.905,4.974,20,5.286,20h10.307
                  		c1.452,0,2.634-1.189,2.634-2.64V4.007C18.227,3.666,18.12,3.339,17.92,3.065z M16.42,17.36c0,0.464-0.361,0.833-0.827,0.833H5.341
                  		l-1.675-1.089h10.341c0.537,0,0.953-0.44,0.953-0.979V2.039l1.459,2.027V17.36L16.42,17.36z"/>
                  </g>
                  </svg>

        				</div>
        				<div class="timeline-content right">
        					<center>
                    <h3>HỒ SƠ BẢN CỨNG</h3> <br>
                    <h4>
                      @if (isset($status_submit_hard_copy))
                        {!! $status_submit_hard_copy !!}
                      @endif
                    </h4>
                  </center>
        				</div>
        			</div>

        			<div class="timeline-item">
        				<div class="timeline-icon">
                  <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                  	 width="21px" height="20px" viewBox="0 0 21 20" enable-background="new 0 0 21 20" xml:space="preserve">
                  <path fill="#FFFFFF" d="M19.998,6.766l-5.759-0.544c-0.362-0.032-0.676-0.264-0.822-0.61l-2.064-4.999
                  	c-0.329-0.825-1.5-0.825-1.83,0L7.476,5.611c-0.132,0.346-0.462,0.578-0.824,0.61L0.894,6.766C0.035,6.848-0.312,7.921,0.333,8.499
                  	l4.338,3.811c0.279,0.246,0.395,0.609,0.314,0.975l-1.304,5.345c-0.199,0.842,0.708,1.534,1.468,1.089l4.801-2.822
                  	c0.313-0.181,0.695-0.181,1.006,0l4.803,2.822c0.759,0.445,1.666-0.23,1.468-1.089l-1.288-5.345
                  	c-0.081-0.365,0.035-0.729,0.313-0.975l4.34-3.811C21.219,7.921,20.855,6.848,19.998,6.766z"/>
                  </svg>

        				</div>
        				<div class="timeline-content">
                  <center>
                    <h3>TRẠNG THÁI HỒ SƠ</h3> <br>
                    <p class="error">
                        Hồ sơ đang chờ xử lý
                    </p>
                  </center>
        				</div>
        			</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="panel-footer">
      <div class="col-md-8">
        <h5><span class="error">(*)</span> Ghi chú: <br>- <i>Phiếu đề xuất được trình bày không quá 4 trang giấy khổ A4</i> <br>- <i>Các mục <span class="error">(*)</span> là bắt buộc</i></h5>
      </div>
      <div class="col-md-4" style="text-align: right"> <div class="col-md-12">
        @if ($topic->is_filled)

          @if (!$topic->is_submit_ele_copy)

            <button class="btn btn-info" id="btn_submit_ele_copy" data-key="{{ $topic->key }}" data-is_submit_ele_copy="1">

              <i class="fa fa-paper-plane" aria-hidden="true"></i> Nộp bản mềm
            </button>

            <button class="btn btn-success"id="update-topic-btn"><i class="fa fa-floppy-o" aria-hidden="true"></i> Lưu thông tin</button>

          @endif

          @if ($topic->is_submit_ele_copy)
            <a href="javascript:;" class="btn btn-info" id="btn_submit_ele_copy" data-key="{{ $topic->key }}" data-is_submit_ele_copy="0">
              <i class="fa fa-pencil" aria-hidden="true"></i>&nbsp; &nbsp; Sửa bản mềm
            </a>

            <a href="{!! route('missionTopic.detail',[$topic->key,'print']) !!}" class="btn btn-success" target="_blank"><i class='fa fa-print'></i> &nbsp; In phiếu đề xuất</a>
          @endif

        @else
          <button class="btn btn-success"id="update-topic-btn"><i class="fa fa-floppy-o" aria-hidden="true"></i> Lưu thông tin</button>
        @endif

      </div> </div>
    </div>
  </div>
@endsection

@section('footer')
<script type="text/javascript" src="{{mix('build/js/mission_topic.js')}}"></script>
@endsection
