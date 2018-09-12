@extends('backend.layouts.master')

@section('header')
  <style type="text/css">
    .indent-15 {
      padding-left: 30px !important;
    }
    .block {
      text-indent: 10px;
      margin-bottom: 30px;
    }
  </style>
@endsection

@section('breadcrumb')
<li class="">Danh sách nhiệm vụ</li>
<li><a href="{{ route('admin.mission-topics.index') }}">Đề án</a></li>
<li class="active">Đánh giá nhiệm vụ</li>
@endsection

@section('page-title')

@endsection

@section('content')
  
<form id="judge-form" enctype="multipart/form-data">
    <input type="hidden" name="id" value="{{$topic->id}}">
  <div class="panel panel-default">
    <div class="panel-body">

      <div class="panel-body tab-content">
        <div class="tab-pane active" id="tab-form">
          <div class="col-md-12">
            <center>
              <br>
              <h3>PHIẾU NHẬN XÉT VÀ ĐÁNH GIÁ</h3>
              <h3>ĐỀ XUẤT ĐẶT HÀNG ĐỀ ÁN KHOA HỌC CẤP QUỐC GIA</h3>
            </center>
            <br>
          </div>
          <div class="col-md-12">
            <h5><strong>Họ và tên chuyên gia:</strong> {{Auth::user()->name}}</h5>
            <h5><strong>Tên đề tài/dự án đề xuất:</strong> {{(isset($name))?$name:""}}</h5>
          </div>
          <div class="clearfix"></div>
          <br><br><br>
          <h5>
            <div class="col-md-12">
                <h4><strong>I. NHẬN XÉT VÀ ĐÁNH GIÁ CHUNG ĐỀ XUẤT ĐẶT HÀNG</strong></h4>
                <div class="col-md-12 block">
                    <p>1.1   Tính cấp thiết và triển vọng ứng dụng của các kết quả tạo ra vào việc xây dựng và hoạch định chính sách</p>
                    <div class="col-md-12 indent-15 form-group">
                      <p>Nhận xét: <span class='error'>(*)</span></p>
                      <textarea name="necessity_note" id="necessity_note" class="form-control" rows="6" placeholder="Vui lòng nhập nhận xét">{{isset($comment_evaluation['necessity'])?$comment_evaluation['necessity']['note']:""}}</textarea>
                    </div>

                    <div class="col-md-12 indent-15 form-group">
                      <span>Đánh giá: <span class='error'>(*)</span></span>
                      <label class="radio-inline">
                        <input type="radio" name="necessity_qualified" value="1" {{isset($comment_evaluation['necessity']) && $comment_evaluation['necessity']['qualified']?"checked":""}}>Đạt yêu cầu
                      </label>
                      <label class="radio-inline">
                        <input type="radio" name="necessity_qualified" value="0" {{isset($comment_evaluation['necessity']) && !$comment_evaluation['necessity']['qualified']?"checked":""}} {{(!isset($comment_evaluation['necessity']))?"checked":""}}>Không đạt yêu cầu
                      </label>
                    </div>
                </div>
                <div class="col-md-12 block">
                    <p>1.2   Ảnh hưởng đối với các ngành, lĩnh vực, vùng lãnh thổ và tầm quan trọng của vấn đề khoa học đặt ra trong đề xuất đặt hàng</p>
                    <div class="col-md-12 indent-15 form-group">
                      <p>Nhận xét: <span class='error'>(*)</span></p>
                      <textarea name="afftect_note" id="afftect_note" class="form-control" rows="6" placeholder="Vui lòng nhập nhận xét">{{isset($comment_evaluation['afftect'])?$comment_evaluation['afftect']['note']:""}}</textarea>
                    </div>

                    <div class="col-md-12 indent-15 form-group">
                      <span>Đánh giá: <span class='error'>(*)</span></span>
                      <label class="radio-inline">
                        <input type="radio" name="afftect_qualified" value="1" {{isset($comment_evaluation['afftect']) && $comment_evaluation['afftect']['qualified']?"checked":""}}>Đạt yêu cầu
                      </label>
                      <label class="radio-inline">
                        <input type="radio" name="afftect_qualified" value="0" {{isset($comment_evaluation['afftect']) && !$comment_evaluation['afftect']['qualified']?"checked":""}} {{(!isset($comment_evaluation['afftect']))?"checked":""}}>Không đạt yêu cầu
                      </label>
                    </div>
                </div>
                <div class="col-md-12 block">
                    <p>1.3   Nhu cầu cần thiết phải huy động nguồn lực quốc gia cho việc thực hiện đề án</p>
                    <div class="col-md-12 indent-15 form-group">
                      <p>Nhận xét: <span class='error'>(*)</span></p>
                      <textarea name="necessary_note" id="necessary_note" class="form-control" rows="6" placeholder="Vui lòng nhập nhận xét">{{isset($comment_evaluation['necessary'])?$comment_evaluation['necessary']['note']:""}}</textarea>
                    </div>

                    <div class="col-md-12 indent-15 form-group">
                      <span>Đánh giá: <span class='error'>(*)</span></span>
                      <label class="radio-inline">
                        <input type="radio" name="necessary_qualified" value="1" {{isset($comment_evaluation['necessary']) && $comment_evaluation['necessary']['qualified']?"checked":""}}>Đạt yêu cầu
                      </label>
                      <label class="radio-inline">
                        <input type="radio" name="necessary_qualified" value="0" {{isset($comment_evaluation['necessary']) && !$comment_evaluation['necessary']['qualified']?"checked":""}} {{(!isset($comment_evaluation['necessary']))?"checked":""}}>Không đạt yêu cầu
                      </label>
                    </div>
                </div>
              </div>
              <div class="col-md-12">
                <h4><strong>II. Ý KIẾN CHUYÊN GIA (tích vào 1 trong 3 ô dưới đây)</strong></h4>
                <div class="col-md-12 indent-15 form-group">
                    <div class="radio">
                      <label>
                        <input type="radio" name="is_perform" value="0" {{(isset($expert_opinions['is_unperform']) && $expert_opinions['is_unperform'])?"checked":""}} {{(empty($expert_opinions))?"checked":""}}>
                        Đề nghị không thực hiện
                      </label>
                    </div>
                    <div class="radio">
                      <label>
                        <input type="radio" name="is_perform" value="1"  {{(isset($expert_opinions['is_perform']) && $expert_opinions['is_perform'])?"checked":""}}>
                        Đề nghị thực hiện
                      </label>
                    </div>
                    <div class="radio">
                      <label>
                        <input type="radio" name="is_perform" id="inputHide" value="2" {{(isset($expert_opinions['is_perform_with_cond']) && !empty($expert_opinions['is_perform_with_cond']))?"checked":""}}>
                        Đề nghị thực hiện với các điều chỉnh nêu dưới đây: 
                      </label>
                    </div>
                    <div class="form-group other-radio  {{(isset($expert_opinions['is_perform_with_cond']) && !empty($expert_opinions['is_perform_with_cond']))?"":"hide"}}">
                      <p>2.1 Dự kiến tên đề tài/dự án:</span></p>
                      <textarea name="perform_name" id="perform_name" class="form-control" rows="6" placeholder="Vui lòng nhập nhận xét">{{(isset($expert_opinions['is_perform_with_cond']) && !empty($expert_opinions['is_perform_with_cond']))?$expert_opinions['is_perform_with_cond']['perform_name']:""}}</textarea>
                    </div>
                    <div class="form-group other-radio  {{(isset($expert_opinions['is_perform_with_cond']) && !empty($expert_opinions['is_perform_with_cond']))?"":"hide"}}">
                      <p>2.2 Định hướng mục tiêu:</span></p>
                      <textarea name="perform_target" id="perform_target" class="form-control" rows="6" placeholder="Vui lòng nhập nhận xét">{{(isset($expert_opinions['is_perform_with_cond']) && !empty($expert_opinions['is_perform_with_cond']))?$expert_opinions['is_perform_with_cond']['perform_target']:""}}</textarea>
                    </div>
                    <div class="form-group other-radio  {{(isset($expert_opinions['is_perform_with_cond']) && !empty($expert_opinions['is_perform_with_cond']))?"":"hide"}}">
                      <p>2.3 Yêu cầu đối với kết quả:</span></p>
                      <textarea name="perform_result" id="perform_result" class="form-control" rows="6" placeholder="Vui lòng nhập nhận xét">{{(isset($expert_opinions['is_perform_with_cond']) && !empty($expert_opinions['is_perform_with_cond']))?$expert_opinions['is_perform_with_cond']['perform_result']:""}}</textarea>
                    </div>
                  </div>
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
      </div>
    </div>
    <div class="clearfix"></div>
      <hr>
      <div class="col-md-12" style="text-align: right;">

        <button class="btn btn-primary save-evaluation" id="save-evaluation-science-technology-btn" data-is_filled='0'><i class="fa fa-floppy-o" aria-hidden="true"></i> Lưu</button>
        <button class="btn btn-success save-evaluation" id="evaluation-science-technology-btn" data-is_filled='1'><i class="fa fa-paper-plane-o" aria-hidden="true"></i> Gửi</button>
      </div>
  </div>
</form>
@endsection

@section('footer')

<script type="text/javascript">
  $('input:radio[name="is_perform"]').on('change', function() {
      if ($('#inputHide').is(':checked')) {
        $('.other-radio').removeClass('hide');
      } else {
        $('.other-radio').addClass('hide');
      }
  })

  $('#judge-form').validate({
    rules: {
      necessity_note: {
        minlength: 10
      },
      afftect_note: {
        minlength: 10
      },
      necessary_note: {
        minlength: 10
      },
      perform_name: {
        minlength: 10
      },
      perform_target: {
        minlength: 10
      },
      perform_result: {
        minlength: 10
      },
    },
    messages: {
      necessity_note: {
        minlength: jQuery.validator.format("Nhận xét tính cấp thiết và triển vọng ứng dụng của các kết quả tạo ra vào việc xây dựng và hoạch định chính sách phải lớn hơn {0} ký tự!")
      },
      afftect_note: {
        minlength: jQuery.validator.format("Nhận xét ảnh hưởng đối với các ngành, lĩnh vực, vùng lãnh thổ và tầm quan trọng của vấn đề khoa học đặt ra trong đề xuất đặt hàng phải lớn hơn {0} ký tự!")
      },
      necessary_note: {
        minlength: jQuery.validator.format("Nhận xét nhu cầu cần thiết phải huy động nguồn lực quốc gia cho việc thực hiện đề án phải lớn hơn {0} ký tự!")
      },
      fund_note: {
        minlength: jQuery.validator.format("Nhận xét khả năng huy động được nguồn kinh phí ngoài ngân sách để thực hiện (chỉ áp dụng đối với dự án) phải lớn hơn {0} ký tự!")
      },
      perform_name: {
        minlength: jQuery.validator.format("Nhận xét tính cấp thiết của việc thực hiện đề tài/dự án phải lớn hơn {0} ký tự!")
      },
      perform_target: {
        minlength: jQuery.validator.format("Nhận xét tính cấp thiết của việc thực hiện đề tài/dự án phải lớn hơn {0} ký tự!")
      },
      perform_result: {
        minlength: jQuery.validator.format("Nhận xét tính cấp thiết của việc thực hiện đề tài/dự án phải lớn hơn {0} ký tự!")
      },
    }
  });

 $('.save-evaluation').on('click', function(e) {
    e.preventDefault();
    alert('1');
    var is_filled = $(this).data('is_filled');
    data = $('#judge-form').serializeArray();
    data.push({name: 'is_filled', value: is_filled});

    if ($('#judge-form').valid()) {
      $.ajax({
        type: "POST",
        url: app_url + "admin/mission-topics/judge",
        data: data,
        success: function(res) {
          if (!res.error) {

            toastr.success(res.message);

            setTimeout(function() {
              location.reload();
            }, 1000)

          } else {

            toastr.error(res.message);
          }
        },
        error: function(xhr, ajaxOptions, thrownError) {
          toastr.error(thrownError);
        }
      });
    }
  });
</script>
@endsection
