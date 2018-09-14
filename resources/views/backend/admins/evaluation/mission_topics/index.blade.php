@extends('backend.layouts.master')

@section('header')
  <style type="text/css">
    #evaluation-topic-tbl .btn {
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
{{-- 
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
          </div> --}}

  <div class="panel panel-default">
    <div class="panel-heading">
      <br>
      <center><strong><h3>DANH SÁCH CÁC NHIỆM VỤ</h3></strong></center>
    </div>

    <div class="panel-body">
      <br>

      <div class="table-responsive">
        <table class="table table-bordered table-hover" id="evaluation-topic-tbl">
          <thead>
            <tr>
              	<th style="width: 5%">STT</th>
                <th style="width: 15%">Hành động</th>
                <th style="width: 25%">Tên nhiệm vụ</th>
                <th style="width: 10%">Đơn vị</th>
                <th style="width: 15%">Đợt gọi hồ sơ</th>
                <th style="width: 10%">Hình thức thực hiện</th>
                <th style="width: 20%">Trạng thái HS</th>
              
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>

@endsection

@section('footer')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/3.1.4/js/bootstrap-datetimepicker.min.js" charset="utf-8"></script>
  <script type="text/javascript" src="{{mix('build/js/admin_mission_topic.js')}}"></script>
@endsection
