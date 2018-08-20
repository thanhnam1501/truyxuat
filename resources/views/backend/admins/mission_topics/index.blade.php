@extends('backend.layouts.master')

@section('header')
  <style type="text/css">
    #topic-tbl .btn {
      margin-bottom: 10px;
      margin-right: 10px;
    }
  </style>
  <link rel="stylesheet" type="text/css" id="theme" href="{{mix('build/css/admin_mission_science_technology.css')}}"/>
@endsection

@section('breadcrumb')
  <li class="">Danh sách nhiệm vụ</li>
  <li class="active">Đề tài hoặc đề án</li>
@endsection

@section('page-title')

@endsection

@section('content')

  <div class="panel panel-default">
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
            <select class="form-control">
              @if (isset($round_collection)) @foreach($round_collection as $value)
              <option>Mời chọn đợt gọi hồ sơ</option>
              <option value="{{ $value['id'] }}">{{ $value['name'] }} - {{ $value['year'] }}</option>
              @endforeach @else
              <option>Không có đợt gọi hồ sơ nào</option>
              @endif
            </select>
          </div>
        </div>

        <div class="form-group col-md-12">
          <div class="col-md-3 search-label">
            <label for="">Tên nhiệm vụ</label>
          </div>
          <div class="col-md-9">
            <input type="text" class="form-control" placeholder="">
          </div>
        </div>

        <div class="form-group col-md-12">
          <div class="col-md-3 search-label">
            <label for="">Đơn vị</label>
          </div>
          <div class="col-md-9">
            <input type="text" class="form-control" placeholder="">
          </div>
        </div>

        <div class="form-group col-md-12">
          <div class="col-md-3 search-label">
            <label for="">Năm</label>
          </div>
          <div class="col-md-9">
            <select class="form-control">
              @if (isset($round_collection)) @foreach($round_collection as $value)
              <option>Mời chọn năm</option>
              <option data-id="{{ $value['id'] }}">{{ $value['name'] }} - {{ $value['year'] }}</option>
              @endforeach @else
              <option>Không có năm nào</option>
              @endif
            </select>
          </div>
        </div>
      </div>
      <div class="col-md-6">

        <div class="form-group col-md-12">
          <div class="col-md-3 search-label">
            <label for="">Trạng thái nộp</label>
          </div>
          <div class="col-md-9">
            <select class="form-control">
              <option value="">Trạng thái</option>
              <option value="ele">Đã nộp bản mềm</option>
              <option value="hard">Đã nộp bản cứng</option>
            </select>
          </div>
        </div>

        <div class="form-group col-md-12">
          <div class="col-md-3 search-label">
            <label for="">Trạng thái hồ sơ</label>
          </div>
          <div class="col-md-9">
            <select class="form-control">
              <option value="">Trạng thái hồ sơ</option>
              <option value="true">Hợp lệ</option>
              <option value="false">Không hợp lệ</option>
            </select>
          </div>
        </div>

        <div class="form-group col-md-12">
          <div class="col-md-3 search-label">
            <label for="">Trạng thái BCN</label>
          </div>
          <div class="col-md-9">
            <select class="form-control">
              <option value="">Chưa cập nhật</option>
              <option value="ele">Được đánh giá trong hội đồng</option>
              <option value="hard">Không được đưa vào hội đồng đánh giá</option>
            </select>
          </div>
        </div>

        <div class="form-group col-md-12">
          <div class="col-md-3 search-label">
            <label for="">Phê duyệt</label>
          </div>
          <div class="col-md-9">
            <select class="form-control">
              <option value="">Chưa cập nhật</option>
              <option value="ele">Được phê duyệt thực hiện</option>
              <option value="hard">Không được phê duyệt thực hiện</option>
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
              <button type='submit' class='btn btn-lg btn-success'><i class="fa fa-search"></i>&nbsp;&nbsp;&nbsp;Lọc dữ liệu</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="panel panel-default">
    <div class="panel-heading">
      <br>
      <center><strong><h3>DANH SÁCH CÁC NHIỆM VỤ</h3></strong></center>
    </div>

    <div class="panel-body">
      <br>

      <div class="table-responsive">
        <table class="table table-bordered table-hover" id="topic-tbl">
          <thead>
            <tr>
              <th style="width: 4%">STT</th>
              <th style="width: 11%">Tên nhiệm vụ</th>
              <th style="width: 5%">Đơn vị</th>
              <th style="width: 10%">Đợt gọi hồ sơ</th>
              <th style="width: 10%">Hình thức thực hiện</th>
              <th style="width: 10%">Trạng thái nộp HS</th>
              <th style="width: 10%">Trạng thái giao HS</th>
              <th style="width: 10%">Trạng thái hồ sơ</th>
              <th style="width: 10%">Trạng thái xét duyệt BCN</th>
              <th style="width: 10%">Trạng thái đưa vào đánh giá HĐ</th>
              <th style="width: 10%">Hành động</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>

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
@endsection

@section('footer')
  <script type="text/javascript" src="{{mix('build/js/admin_mission_topic.js')}}"></script>
@endsection
