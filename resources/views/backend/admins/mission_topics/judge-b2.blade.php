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
    .other-radio {
      display: none;
    }
  </style>
@endsection

@section('breadcrumb')
<li class="">Danh sách nhiệm vụ</li>
<li><a href="{{ route('admin.mission-topics.index') }}">Đề tài hoặc đề án</a></li>
<li class="active">Đánh giá nhiệm vụ</li>
@endsection

@section('page-title')

@endsection

@section('content')

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
            <h5><strong>Tên đề tài/dự án đề xuất:</strong> test test test</h5>
          </div>
          <div class="clearfix"></div>
          <br><br><br>
          <h5>
            <div class="col-md-12">
              <form>
                <h4><strong>I. NHẬN XÉT VÀ ĐÁNH GIÁ CHUNG ĐỀ XUẤT ĐẶT HÀNG</strong></h4>
                <div class="col-md-12 block">
                    <p>1.1   Tính cấp thiết và triển vọng ứng dụng của các kết quả tạo ra vào việc xây dựng và hoạch định chính sách</p>
                    <div class="col-md-12 indent-15 form-group">
                      <p>Nhận xét: <span class='error'>(*)</span></p>
                      <textarea name="urgency" id="urgency" class="form-control" rows="6" placeholder="Vui lòng nhập nhận xét">{{isset($data['urgency'])?$data['urgency']:""}}</textarea>
                    </div>

                    <div class="col-md-12 indent-15 form-group">
                      <span>Đánh giá: <span class='error'>(*)</span></span>
                      <label class="radio-inline">
                        <input type="radio" name="type" value="0">Đạt yêu cầu
                      </label>
                      <label class="radio-inline">
                        <input type="radio" name="type" value="0">Không đạt yêu cầu
                      </label>
                    </div>
                </div>
                <div class="col-md-12 block">
                    <p>1.2   Ảnh hưởng đối với các ngành, lĩnh vực, vùng lãnh thổ và tầm quan trọng của vấn đề khoa học đặt ra trong đề xuất đặt hàng</p>
                    <div class="col-md-12 indent-15 form-group">
                      <p>Nhận xét: <span class='error'>(*)</span></p>
                      <textarea name="urgency" id="urgency" class="form-control" rows="6" placeholder="Vui lòng nhập nhận xét">{{isset($data['urgency'])?$data['urgency']:""}}</textarea>
                    </div>

                    <div class="col-md-12 indent-15 form-group">
                      <span>Đánh giá: <span class='error'>(*)</span></span>
                      <label class="radio-inline">
                        <input type="radio" name="type" value="0">Đạt yêu cầu
                      </label>
                      <label class="radio-inline">
                        <input type="radio" name="type" value="0">Không đạt yêu cầu
                      </label>
                    </div>
                </div>
                <div class="col-md-12 block">
                    <p>1.3   Nhu cầu cần thiết phải huy động nguồn lực quốc gia cho việc thực hiện đề án</p>
                    <div class="col-md-12 indent-15 form-group">
                      <p>Nhận xét: <span class='error'>(*)</span></p>
                      <textarea name="urgency" id="urgency" class="form-control" rows="6" placeholder="Vui lòng nhập nhận xét">{{isset($data['urgency'])?$data['urgency']:""}}</textarea>
                    </div>

                    <div class="col-md-12 indent-15 form-group">
                      <span>Đánh giá: <span class='error'>(*)</span></span>
                      <label class="radio-inline">
                        <input type="radio" name="type" value="0">Đạt yêu cầu
                      </label>
                      <label class="radio-inline">
                        <input type="radio" name="type" value="0">Không đạt yêu cầu
                      </label>
                    </div>
                </div>
              </form>
              </div>
              <div class="col-md-12">
                <form>
                  <h4><strong>II. Ý KIẾN CHUYÊN GIA (tích vào 1 trong 3 ô dưới đây)</strong></h4>
                  <div class="col-md-12 indent-15 form-group">
                      <div class="radio">
                        <label>
                          <input type="radio" name="perform" value="">
                          Đề nghị không thực hiện
                        </label>
                      </div>
                      <div class="radio">
                        <label>
                          <input type="radio" name="perform" value="">
                          Đề nghị thực hiện
                        </label>
                      </div>
                      <div class="radio">
                        <label>
                          <input type="radio" name="perform" id="inputHide" value="">
                          Đề nghị thực hiện với các điều chỉnh nêu dưới đây: 
                        </label>
                      </div>
                      <div class="form-group other-radio">
                        <p>2.1 Tên đề án:</span></p>
                        <textarea name="urgency" id="urgency" class="form-control" rows="6" placeholder="Vui lòng nhập nhận xét">{{isset($data['urgency'])?$data['urgency']:""}}</textarea>
                      </div>
                      <div class="form-group other-radio">
                        <p>2.2 Mục tiêu:</span></p>
                        <textarea name="urgency" id="urgency" class="form-control" rows="6" placeholder="Vui lòng nhập nhận xét">{{isset($data['urgency'])?$data['urgency']:""}}</textarea>
                      </div>
                      <div class="form-group other-radio">
                        <p>2.3 Yêu cầu đối với kết quả:</span></p>
                        <textarea name="urgency" id="urgency" class="form-control" rows="6" placeholder="Vui lòng nhập nhận xét">{{isset($data['urgency'])?$data['urgency']:""}}</textarea>
                      </div>
                    </div>
                </form>
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
  </div>
</form>
@endsection

@section('footer')

<script type="text/javascript">
  $('input:radio[name="perform"]').on('change', function() {
      if ($('#inputHide').is(':checked')) {
        $('.other-radio').css('display','block')
      } else {
        $('.other-radio').css('display','none')
      }
  })

</script>
@endsection
