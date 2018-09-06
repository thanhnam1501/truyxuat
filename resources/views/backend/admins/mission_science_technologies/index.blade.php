@extends('backend.layouts.master')

@section('header')
  <style type="text/css">
      #science-technology-tbl .btn {
        margin-bottom: 10px;
        margin-right: 10px;
        width: 25px;
      }
  </style>

  <link rel="stylesheet" type="text/css" id="theme" href="{{mix('build/css/admin_mission_science_technology.css')}}"/>
  {{-- <link rel="stylesheet" type="text/css" id="theme" href="{{asset('css/A4style.css')}}"/> --}}

@endsection

@section('breadcrumb')
  <li class="">Danh sách nhiệm vụ</li>
  <li class="active">Dự án khoa học và công nghệ</li>
@endsection

@section('page-title')

@endsection

@section('content')
        <div class="panel panel-default">
          <form role="form" enctype="multipart/form-data" id="search-mission-frm">
          
          <div class="panel-heading">
            <h3 class="panel-title">
              <strong><i class="fa fa-search"></i>&nbsp;&nbsp;&nbsp;Lọc dữ liệu</strong>
            </h3>
          </div>
          <div class="panel-body">
            <div class="col-md-6">
              <div class="form-group col-md-12">
                <div class="col-md-3 search-label">
                  <label for="">Đợt gọi hồ sơ</label>
                </div>
                <div class="col-md-9">
                  <select class="form-control" name="round_collection" id="round_collection">
                    @if (isset($round_collection))
                      <option value="-1">Mời chọn đợt gọi hồ sơ</option>
                      @foreach($round_collection as $value)
                      
                      <option value="{{ $value['id'] }}">{{ $value['name'] }} - {{ $value['year'] }}</option>
                    @endforeach @else
                      <option value="-1">Không có đợt gọi hồ sơ nào</option>
                    @endif
                  </select>
                </div>
              </div>

              <div class="form-group col-md-12">
                <div class="col-md-3 search-label">
                  <label for="">Tên nhiệm vụ</label>
                </div>
                <div class="col-md-9">
                  <input type="text" class="form-control" placeholder="" name="mission_name" value="" placeholder="Tên nhiệm vụ">
                </div>
              </div>

              <div class="form-group col-md-12">
                <div class="col-md-3 search-label">
                  <label for="">Đơn vị</label>
                </div>
                <div class="col-md-9">
                  <input type="text" class="form-control" placeholder="" name="organization" value="" placeholder="Đơn vị">
                </div>
              </div>

              <div class="form-group col-md-12">
                  <div class="col-md-3 search-label">
                    <label for="">TT nộp hồ sơ</label>
                  </div>
                  <div class="col-md-9">
                    <select class="form-control" name="status_submit_hard_copy">
                      <option value="-1">Tất cả</option>
                      <option value="1">Đã nộp bản cứng</option>
                      <option value="0">Chưa nộp bản cứng</option>
                    </select>
                  </div>
                </div>
            </div>
            <div class="col-md-6">
              <div class="form-group col-md-12">
                <div class="col-md-3 search-label">
                  <label for="">TT giao hồ sơ</label>
                </div>
                <div class="col-md-9">
                  <select class="form-control" name="status_submit_is_assign">
                    <option value="-1">Tất cả</option>
                      <option value="1">Đã giao cho chuyên viên</option>
                      <option value="0">Chưa giao cho chuyên viên</option>
                  </select>
                </div>
              </div>
                

                <div class="form-group col-md-12">
                  <div class="col-md-3 search-label">
                    <label for="">TT hợp lệ</label>
                  </div>
                  <div class="col-md-9">
                    <select class="form-control" name="status_submit_is_valid">
                      <option value="-1">Tất cả</option>
                      <option value="-2">Chưa cập nhập</option>
                      <option value="1">Hợp lệ</option>
                      <option value="0">Không hợp lệ</option>
                    </select>
                  </div>
                </div>

                <div class="form-group col-md-12">
                  <div class="col-md-3 search-label">
                    <label for="">TT đánh giá</label>
                  </div>
                  <div class="col-md-9">
                    <select class="form-control" name="status_submit_is_judged">
                      <option value="-1">Tất cả</option>
                      <option value="-2">Chưa cập nhập</option>
                      <option value="1">Được đánh giá trong hội đồng</option>
                      <option value="0">Không được đưa vào hội đồng đánh giá</option>
                    </select>
                  </div>
                </div>

                <div class="form-group col-md-12">
                  <div class="col-md-3 search-label">
                    <label for="">TT phê duyệt</label>
                  </div>
                  <div class="col-md-9">
                    <select class="form-control" name="status_submit_is_performed">
                      <option value="-1">Tất cả</option>
                      <option value="-2">Chưa cập nhập</option>
                      <option value="1">Được phê duyệt thực hiện</option>
                      <option value="0">Không được phê duyệt thực hiện</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>

            <div class="panel-footer">
              <div class="col-md-12">
                <div class="col-md-12">
                  <div class="col-md-12">
                    <div class="col-md-12">
                      <button type='button' class='btn btn-lg btn-success' id="btn-search-mission"><i class="fa fa-search"></i>&nbsp;&nbsp;&nbsp;Lọc dữ liệu</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </form>
          </div>

          <div class="panel panel-default">
            <div class="panel-heading">
                <br>
                <center><strong><h3>DANH SÁCH CÁC NHIỆM VỤ</h3></strong></center>
            </div>

              <div class="panel-body">
                <br>

                <div class="col-md-12">
                  <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="science-technology-tbl">
                      <thead>
                        <tr>
                          <th style="width: 30px">STT</th>
                          <th style="width: 100px">Hành động</th>
                          <th style="">Tên nhiệm vụ</th>
                          <th style="width: 100px">Tên đơn vị</th>
                          <th>Người đăng ký - SĐT</th>
                          <th style="width: 100px">Thời gian</th>
                          <th style="width: 80px">Mục tiêu</th>
                          <th style="width: 90px">Kết quả dự kiến</th>
                          <th>Kinh phí</th>
                          <th>Trạng thái</th>
                          
                        </tr>
                      </thead>
                    </table>
                    </div>
                </div>
              </div>
          </div>

          <div class="clearfix"></div>
  {{-- modal --}}
  <div class="modal fade" id="modal-valid" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          {{-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> --}}
          <center><h4 class="modal-title" id="">XÁC NHẬN HỒ SƠ HỢP LỆ</h4> </center>
        </div>
        <div class="modal-body">
          <div class="form-group col-md-12">
            <div class="col-md-3 search-label">
              <label for="">Trạng thái hồ sơ <span class="error">(*)</span></label>
            </div>
            <div class="col-md-9">
              <select class="form-control" id="status">
                <option value="-1">Chưa xác nhận</option>
                <option value="valid">Hợp lệ</option>
                <option value="invalid">Không hợp lệ</option>
              </select>
            </div>
          </div>
          <div class="form-group col-md-12">
              <div class="col-md-3 search-label">
                <label for="">Lý do</label>
              </div>
              <div class="col-md-9">
                <textarea disabled id="invalid_reason" class='form-control' placeholder='Trường hợp hồ sơ không hợp lệ, vui lòng nhập lý do đầy đủ' rows="5"></textarea>
              </div>
          </div>
          <div class="form-group col-md-12">
              <div class="col-md-3 search-label">
                {{-- <label for="">Lý do</label> --}}
              </div>
              <div class="col-md-9">
                <input type='checkbox' name='' value=''id="checkbox-send-email" > &nbsp;Gửi email thông báo
              </div>
          </div>

          <br>
        </div>
        <div class="clearfix"></div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Hủy bỏ</button>
          <button type="button" class="btn btn-success" data-id="">Đồng ý</button>
        </div>
      </div>
    </div>
  </div>

{{-- modal --}}
  <div class="modal fade" id="approve-mdl" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          {{-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> --}}
          <center><h4 class="modal-title" id="">XÁC NHẬN PHÊ DUYỆT THỰC HIỆN</h4> </center>
        </div>
        <div class="modal-body">
          <form enctype="multipart/form-data" id="approve-frm">
            <input type="hidden" name="id" id="id" value="">
            <input type="hidden" name="mission_name" id="mission_name" value="">
            <div class="form-group col-md-12">
              <div class="col-md-3">
                <label for="">Trạng thái <span class="error">(*)</span></label>
              </div>
              <div class="col-md-9">
                <select class="form-control" name="is_performed" id="is_performed">
                  <option value="-1">Chưa cập nhập</option>
                  <option value="1">Được phê duyệt thực hiện</option>
                  <option value="0">Không được phê duyệt thực hiện</option>
                </select>
              </div>
            </div>
            <div class="form-group col-md-12">
                <div class="col-md-3">
                  <label for="">Lý do</label>
                </div>
                <div class="col-md-9">
                  <textarea id="is_unperformed_reason" name="is_unperformed_reason" class='form-control' placeholder='Trường hợp hồ sơ không hợp lệ, vui lòng nhập lý do đầy đủ' rows="5"></textarea>
                  <span class="error"></span>
                </div>
            </div>
            <div class="form-group col-md-12">
                <div class="col-md-3">
                  <label for="">Phê duyệt <span class="error">(*)</span></label>
                </div>
                <div class="col-md-9">
                  <label class="radio-inline">
                    <input type="radio" name="approve_type" value="0" checked>Giao trực tiếp
                  </label>
                  <label class="radio-inline">
                    <input type="radio" name="approve_type" value="1">Tuyển chọn
                  </label>
                </div>
            </div>
            <div class="form-group col-md-12">
                <div class="col-md-8">
                  <label for="">Quyết định danh mục nhiệm vụ được thực hiện <span class="error">(*)</span></label>
                  <br><i><span class="error">Chỉ file *.doc, *.docx, *.pdf và file dưới 5Mb được chấp nhập</span></i>
                </div>
                <div class="col-md-4">
                  <input type="file" name="list_categories" id="list_categories" accept="application/pdf, application/msword">
                </div>
            </div>
            <div class="form-group col-md-12">
                <div class="checkbox col-md-12">
                  <label>
                    <input type='checkbox' name='is_send_email' value='is_send_email' id="is_send_email" > &nbsp;Gửi email thông báo
                  </label>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Hủy bỏ</button>
          <button type="button" class="btn btn-success" id="approve-submit-btn" data-id="">Đồng ý</button>
        </div>
      </div>
    </div>
  </div>

    {{-- modal --}}
  <div class="modal fade" id="modal-judged" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog" style="width: 60%">
        <div class="modal-content">
          <div class="modal-header">
            {{-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> --}}
            <center><h4 class="modal-title" id="">XÁC NHẬN HỒ SƠ ĐƯỢC ĐÁNH GIÁ TRONG HỘI ĐỒNG</h4> </center>
          </div>
          <div class="modal-body">
            <div class="form-group col-md-12">
              <div class="col-md-3 search-label">
                <label for="">Trạng thái xét duyệt từ BCN <span class="error">(*)</span></label>
              </div>
              <div class="col-md-9">
                <select class="form-control" id="status_judged">
                  <option value="-1">Chưa cập nhật</option>
                  <option value="judged">Được đánh giá trong hội đồng</option>
                  <option value="denied">Không được đưa vào hội đồng đánh giá</option>
                </select>
              </div>
            </div>
            <div class="form-group col-md-12">
                <div class="col-md-3 search-label">
                  <label for="">Lý do</label>
                </div>
                <div class="col-md-9">
                  <textarea disabled id="denied_reason" class='form-control' placeholder='Trường hợp hồ sơ bị từ chối, vui lòng nhập lý do đầy đủ' rows="5"></textarea>
                </div>
            </div>
            <div class="form-group col-md-12">
                <div class="col-md-3 search-label">
                  {{-- <label for="">Lý do</label> --}}
                </div>
                <div class="col-md-9">
                  <input type='checkbox' name='' value=''id="checkbox-send-email-judged" > &nbsp;Gửi email thông báo
                </div>
            </div>

            <br>
          </div>
          <div class="clearfix"></div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Hủy bỏ</button>
            <button type="button" class="btn btn-success" data-id="">Đồng ý</button>
          </div>
        </div>
      </div>
    </div>

    {{-- modal --}}

  <div class="modal fade" id="modal-view-detail" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog" style="width: 75%">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <center>
            <h4 class="modal-title" id="">XEM CHI TIẾT NHIỆM VỤ</h4>
          </center>
        </div>
        <div class="modal-body">
            <div class="col-md-12">
              <center>
                <br><br>
                <h3>PHIẾU ĐỀ XUẤT ĐẶT HÀNG NHIỆM VỤ</h3>
                <h3>KHOA HỌC VÀ CÔNG NGHỆ CẤP QUỐC GIA</h3>
                <h4><i>(Dùng cho dự án khoa học và công nghệ)</i></h4>
              </center>
              <br>
            </div>
              <div class="col-md-12">
                <br> <br>
                <b>1. Tên dự án khoa học và công nghệ (KH&amp;CN)</b> :
                <p class="style-value"><span class="name"></span></p> <br>

                <b>2. Xuất xứ hình thành</b>:
                <em>
                    (nêu rõ nguồn hình thành của dự án KH&amp;CN, tên dự án đầu tư sản
                    xuất, các quyết định phê duyệt liên quan ...)
                </em>
                <p class="style-value"><span class="provenance_originate"></span></p><br>

                <b>
                    3. Tính cấp thiết; tầm quan trọng phải thực hiện ở tầm quốc gia; tác động
                    và ảnh hưởng đến đời sống kinh tế - xã hội của đất nước v.v...:
                </b>
                <p class="style-value"><span class="importance"></span></p><br>

                <b>4. Mục tiêu:</b>
                <p class="style-value"><span class="target"></span></p><br>


                <b>5. Nội dung KH&amp;CN chủ yếu:</b>
                <em>
                    (mỗi nội dung đặt ra có thể hình thành được một đề tài, hoặc dự án
                    SXTN)
                </em>
                <em> </em>
                <p class="style-value"><span class="content"></span></p><br>

                <b>
                    6. Yêu cầu đối với kết quả (công nghệ, thiết bị) và các chỉ tiêu kinh tế -
                    kỹ thuật cần đạt:
                </b>
                <p class="style-value"><span class="request_result"></span></p><br>

                <b>
                    7. Dự kiến tổ chức, cơ quan hoặc địa chỉ ứng dụng các kết quả tạo ra:
                </b>
                <p class="style-value">
                  <span class="application_address"></span>
                </p><br>

                <b>
                    8. Yêu cầu đối với thời gian thực hiện:
                </b>
                <p class="style-value">
                  <span class="request_time"></span>
                </p><br>

                <b>
                    9. Năng lực của tổ chức, cơ quan dự kiến ứng dụng kết quả:
                </b>
                <p  class="style-value">
                  <span class="qualification"></span>
                </p><br>

                <b>
                    10. Dự kiến nhu cầu kinh phí:
                </b>
                <p  class="style-value">
                  <span class="expected_fund"></span>
                </p><br>


                <b>11. Phương án huy động các nguồn lực của cơ tổ chức, cơ quan dự kiến ứng
                dụng kết quả:</b> <em>(</em>
                <em>
                    khả năng huy động nhân lực, tài chính và cơ sở vật chất từ các nguồn
                    khác nhau để thực hiện dự án
                </em>
                <em>)</em>
                <p class="style-value">
                  <span class="plan_mobilize"></span>
                </p><br>

                <b>
                    12. Dự kiến hiệu quả của dự án KH&amp;CN:
                </b>
                <b>12.1. Hiệu quả kinh tế - xã hội:</b>
                <em>
                    (cần làm rõ đóng góp của dự án KH&amp;CN đối với các dự án đầu tư sản
                    xuất trước mắt và lâu dài bao gồm số tiền làm lợi và các đóng góp
                    khác...
                </em>
                <p class="style-value">
                  <span class="economic_efficiency"></span>
                </p><br>

                <b>12.2. Hiệu quả về khoa học và công nghệ:</b><strong> </strong>
                <em>
                    (tác động đối với lĩnh vực khoa học công nghệ liên quan, đào tạo, bồi
                    dưỡng đội ngũ cán bộ, tăng cường năng lực nội sinh...)
                </em>
                <p  class="style-value">
                  <span class="science_technology_efficiency"></span>
                </p><br>
              </div>

              <div class="col-md-12"> <br><br><br>
                <div class="col-md-offset-6 col-md-6 col-xs-12">
                  <div style="float: right">
                      <center>
                        <h5>....., ngày {{(!empty($date))?$date['d']:"....."}} tháng {{(!empty($date))?$date['m']:"....."}} năm {{(!empty($date))?$date['y']:"20..."}}</h5> <br>
                        <b><h5>TỔ CHỨC, CÁ NHÂN ĐỀ XUẤT</h5></b>
                        <h5><i>(Họ, tên và chữ ký - đóng dấu đối với tổ chức)</i></h5>
                      </center>
                  </div>

                  <br><br><br><br><br><br><br><br><br><br><br><br>
                </div>
              </div>
        </div>
        <div class="clearfix"></div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
        </div>
      </div>
    </div>
  </div>


  <div class="modal fade" id="addCouncilModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">

    <div class="modal-dialog" style="width: 60%">
      <div class="modal-content">
        <div class="modal-header">
          {{-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> --}}

          <center><h4 class="modal-title" id="">CHỌN HỘI ĐỒNG ĐÁNH GIÁ</h4> </center>
        </div>
        <div class="modal-body">

          <div class="row form-group">
            <input type="hidden" id="add_council_mission_id">
            <input type="hidden" id="round_collection_id">
            <div class="col-md-2 search-label" style="text-align: left !important"><label>Nhóm:</label></div>
            <div class="col-md-6">
              <select name="group_council" id="group_council" class="form-control"> 
                @if (isset($group_councils) && !empty($group_councils))
                  @foreach ($group_councils as $group_council)
                    <option value="{{$group_council->id}}">{{$group_council->name}}</option>
                  @endforeach
                @endif

              </select>
            </div>
          </div>
          
          <div class="row form-group">
            <div class="col-md-2"><label>Đợt gọi hồ sơ:</label></div>
            <div class="col-md-6"><p id="round_collection_add_council"></p>
            </div>
          </div>
          
          <div class="row form-group">
            <div class="col-md-2"><label>Năm:</label></div>
            <div class="col-md-6"><p id="year_round_collection"></p></div>
          </div>
  
          <div class="row">
              <table class="table table-bordered table-hover" id="list-council-tbl" width="100%">
                    <thead>
                      <tr>
                        <th style="width: 3%">STT</th>
                        <th style="width: 30%">Tên hội đồng</th>
                        <th style="width: 20%">Chủ tịch hội đồng</th>
                        <th style="width: 25%">Nhóm</th>
                        <th style="width: 12%">Đợt gọi hồ sơ</th>
                        <th style="width: 5%">#</th>
                        <th style="width: 5%"></th>
                      </tr>
                    </thead>
                  </table>

                  {{-- <span class="error">Vui lòng chọn hội đồng</span> --}}
          </div>
        
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Hủy bỏ</button>
          <button type="button" class="btn btn-success" id="add-council-submit-btn">Lưu thông tin</button>
        </div>
    </div>
  </div>
  </div>
<div class="modal fade" id="modal-assign">

    <div class="modal-dialog" style="width: 60%">
      <div class="modal-content">
        <div class="modal-header">
          <center><h4 class="modal-title" id="">GIAO HỒ SƠ CHO CHUYÊN VIÊN</h4> </center>
        </div>
          
        <div class="modal-body">
          <form role="form" enctype="multipart/form-data" id="frm-devolve">
            <input type="hidden" name="mission_id" id="mission_id" class="form-control" value="">
            <div class="form-group col-md-12">
              <div class="col-md-3 search-label">
                <label for="">Người giao <span class="error">(*)</span></label>
              </div>
              <div class="col-md-9">
                <select class="form-control" id="role_user_devolve_file">
                    @if (!empty($role_user_devolve_file) && $role_user_devolve_file->count() != 0) 
                      @foreach($role_user_devolve_file as $value)
                        <option value="{{ $value['id'] }}">{{ $value['name'] }}</option>
                      @endforeach 
                    @else 
                      <option value="-1">Không có chuyên viên nào</option>
                    @endif
                  </select>
                  <span class="error"></span>
              </div>
            </div>
            <div class="form-group col-md-12">
              <div class="col-md-3 search-label">
                <label for="">Người xử lý <span class="error">(*)</span></label>
              </div>
              <div class="col-md-9">
                <select class="form-control" id="role_user_handle_file">
                    @if (!empty($role_user_handle_file) && $role_user_handle_file->count() != 0) 
                      @foreach($role_user_handle_file as $value)
                        <option value="{{ $value['id'] }}">{{ $value['name'] }}</option>
                      @endforeach 
                    @else 
                      <option value="-1">Không có chuyên viên nào</option>
                    @endif
                  </select>
                  <span class="error"></span>
              </div>
            </div>
            <div class="form-group col-md-12">
              <div class="col-md-3 search-label">
                <label for="">Deadline <span class="error">(*)</span></label>
              </div>
              <div class="col-md-9">
                 <div class='input-group date' id='deadline-group'>
                    <input type='text' class="form-control" id="deadline"/>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
                <span class="error" id="err-deadline"></span>
              </div>
            </div>
            <div class="form-group col-md-12">
                <div class="col-md-3 search-label">
                  <label for="">Ghi chú</label>
                </div>
                <div class="col-md-9">
                  <textarea id="note" class='form-control' placeholder='Ghi chú' rows="5"></textarea>
                </div>
            </div>
            {{-- <div class="form-group col-md-12">
                <div class="col-md-3 search-label">
                  <label for="">Lý do</label>
                </div>
                <div class="col-md-9">
                  <input type='checkbox' name='' value=''id="checkbox-send-email-judged" > &nbsp;Gửi email thông báo
                </div>
            </div> --}}

            <br>
          </form>
          </div>
          <div class="clearfix"></div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Hủy bỏ</button>
          <button type="button" class="btn btn-success" id="btn-submit-devolve" data-id="">Đồng ý</button>

        </div>
      </div>
    </div>
  </div>
  
  <div class="modal fade" id="listMemberCouncil" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">

    <div class="modal-dialog" style="width: 60%">
      <div class="modal-content">
        <div class="modal-header">

          <center><h4 class="modal-title" id="">DANH SÁCH THÀNH VIÊN TRONG HỘI ĐỒNG</h4> </center>
        </div>
        <div class="modal-body">

          <div class="row">
              <table class="table table-bordered table-hover" id="list-member-council-tbl" width="100%">
                    <thead>
                      <tr>
                        <th style="width: 3%">STT</th>
                        <th style="width: 30%">Họ và tên</th>
                        <th style="width: 20%">Số điện thoại</th>
                        <th style="width: 25%">Email</th>
                        <th style="width: 22%">Vị trí</th>
                      </tr>
                    </thead>
                  </table>

                  {{-- <span class="error">Vui lòng chọn hội đồng</span> --}}
          </div>
        
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Hủy bỏ</button>
          {{-- <button type="button" class="btn btn-success" id="add-council-submit-btn">Lưu thông tin</button> --}}
        </div>
    </div>
  </div>
  </div>

@endsection

@section('footer')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/3.1.4/js/bootstrap-datetimepicker.min.js" charset="utf-8"></script>
  <script type="text/javascript" src="{{mix('build/js/admin_mission_science_technology.js')}}"></script>
@endsection
