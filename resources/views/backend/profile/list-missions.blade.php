@extends('backend.layouts.master-profile')

@section('header')
<link rel="stylesheet" type="text/css" id="theme" href="{{mix('build/css/mission_science_technology/mission_science_technology.css')}}"/>
    <style type="text/css">
      .table-hover .btn {
        margin-bottom: 10px;
        margin-right: 10px;
      }
  </style>
@endsection

@section('breadcrumb')
    <li class="active">Danh sách nhiệm vụ</li>
@endsection

@section('content')

  <div class="page-content-wrap">
    <div class="panel panel-default">

      <div class="panel-body">
        <div class="col-md-12">
          <a href="#create-mission-mdl" data-toggle="modal" class="btn btn-info"><i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp; Đăng ký nhiệm vụ mới</a>
        </div>
        
        <div class="col-md-12" style="margin-top: 10px">

            <h5>Anh/chị vui lòng đọc văn bản hợp nhất số 03 (Thông tư số 07/2014/TT-BKHCN và Thông tư số 03/2017/TT-BKHCN ) và văn bản hợp nhất số 01 (Thông tư số 32/2014/TT-BKHCN và Thông tư số 08/2016/TTBKHCN) để biết thêm thông tin chi tiết về các loại đề tài, đề án. <br><a href="{{ asset('documents/van_ban_hop_nhat.zip') }}" style="font-size: 14px"><Đọc tại đây></a></h5>

        </div>

        <div class="clearfix"></div>

        <div class="col-md-12"> <hr><br> <br>
            <ul class="nav nav-tabs" role="tablist">
                <li class="active"><a href="#tab-a1" role="tab" data-toggle="tab"> Đề tài hoặc đề án</a></li>
                <li class=""><a href="#tab-a3" role="tab" data-toggle="tab" id="btn-tab-a3"> Dự án khoa học và công nghệ</a></li>
             </ul>
        </div>

        <div class="col-md-12"> <br><br>
          <div class="tab-content">

            <div id="tab-a1" class="tab-pane fade in active table-responsive">
              <table class="table table-bordered table-hover table-striped" id="topic-tbl" width="100%">
                 <thead>
                   <tr>
                     <th id="index-column">STT</th>
                     <th id="code-column">Mã nhiệm vụ</th>
                     <th id="value-column">Tên nhiệm vụ</th>
                     <th id="type-column">Loại nhiệm vụ</th>
                     <th id="round-column">Đợt gọi hồ sơ</th>
                     <th id="status-column">Trạng thái</th>
                     <th id="action-column">Hành động</th>
                   </tr>
                 </thead>
              </table>
            </div>

            <div class="clearfix"></div>

            <div id="tab-a3" class="tab-pane fade table-responsive">
              <table class="table table-bordered table-hover table-striped" id="science-technology-tbl" width="100%">
                <thead>
                  <tr>
                    <th id="index-column">STT</th>
                    <th id="code-column">Mã nhiệm vụ</th>
                    <th id="value-column">Tên nhiệm vụ</th>
                    <th id="type-column">Loại nhiệm vụ</th>
                    <th id="round-column">Đợt gọi hồ sơ</th>
                    <th id="status-column">Trạng thái</th>
                    <th id="action-column">Hành động</th>
                  </tr>
                </thead>
              </table>
            </div>

          </div>
        </div>
      </div>
    </div>
</div>

  <div class="modal fade" id="create-mission-mdl" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form role="form" enctype="multipart/form-data" id="create-mission-frm">
        <div class="modal-header">
          <h4 class="modal-title">ĐĂNG KÝ NHIỆM VỤ MỚI</h4>
        </div>
        <div class="modal-body">

            <div class="form-group">
                  <label>Loại nhiệm vụ <span class='error'>(*)</span></label>
                  <select class="form-control" name="mission_type" id="mission_type">

                    <option value="-1">-- Lựa chọn loại nghiệm vụ --</option>
                    <option value="mission_topics">Đề tài hoặc đề án</option>
                    {{-- <option value="mission_sxtns">Đề tài hoặc dự án</option> --}}
                    <option value="mission_science_technologys">Dự án khoa học hoặc công nghệ</option>
                  </select>
              </div>
              <div class="form-group">
                  <label>Đợt gọi hồ sơ <span class='error'>(*)</span></label>
                  <select class="form-control" name="round_collection_id" id="round_collection_id">

                    @if (!empty($round_collections))
                      <option value="-1">-- Lựa chọn đợt gọi hồ sơ --</option>
                      @foreach ($round_collections as $round_collection)
                          <option value="{{$round_collection->id}}">{{ $round_collection->year }} - {{$round_collection->name}}</option>
                      @endforeach
                    @else
                      <option value="-1">(Chưa có đợt gọi hồ sơ nào)</option>
                    @endif
                  </select>
              </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
          <button type="submit" class="btn btn-success addSxtn" id="">Đăng ký</button>
        </div>
    </form>
      </div>
    </div>
  </div>
@endsection

@section('footer')
  {{-- <script type="text/javascript" src="{{mix('build/js/mission_sxtns.js')}}"></script> --}}
    <script type="text/javascript" src="{{mix('build/js/mission_topic.js')}}"></script>
    <script type="text/javascript" src="{{mix('build/js/mission_science_technology/mission_science_technology.js')}}"></script>
    <script type="text/javascript" src="{{mix('build/js/missions.js')}}"></script>
@endsection
