@extends('backend.layouts.master')

@section('header')

<style media="screen">
.btn {
  margin-right: 10px;
}
.red-noti{
  color: red;
}
.council_info p {
  margin-left: 5%;
}
</style>

@endsection

@section('breadcrumb')
<li class="active">Quản lý hội đồng</li>
@endsection

@section('page-title')
{{-- <h2>Danh sách hội đồng</h2> --}}
@endsection

@section('content')
<div class="panel panel-default">
  <div class="panel-body tab-content">

         <div class="button-container" style="margin-bottom: 10px">

          <a href="#create-topic-mdl" id="addCouncil" data-toggle="modal" class="btn btn-info addCouncil"><i class="fa fa-plus"></i> Đăng ký hội đồng mới</a>
        </div>
       <div class="clearfix"></div>

      <div class="portlet-body">

        <table class="table table-striped table-bordered table-hover" id="council">
          <thead>
            <tr>
              <th style="text-align: center;">STT</th>
              <th style="text-align: center;">Tên hội đồng</th>
              <th style="text-align: center;">Nhóm hội đồng</th>
              <th style="text-align: center;">Ngày tạo</th>
              <th style="text-align: center;">Trạng thái</th>
              <th style="text-align: center;">Đợt gọi hồ sơ</th>
              <th style="text-align: center;">Hành động</th>
            </tr>
          </thead>
        </table>

      </div>
    </div>
  </div>
</div>

{{-- Thêm mới hội đồng --}}
<div class="modal fade" id="create-council-mdl" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">TẠO MỚI HỘI ĐỒNG</h4>
      </div>
      <div class="modal-body">
        <form role="form" enctype="multipart/form-data" id="create-council-frm">

          <div class="form-group">
            <label>Tên hội đồng <span class='error'>(*)</span></label>
            <textarea id="name" name="name" class="form-control" placeholder="Tên hội đồng"></textarea>
          </div>

          <div class="form-group">
            <input type="hidden" id="status" name="status" class="form-control" placeholder="Tên hội đồng" value="1">
          </div>

          <div class="form-group">
            <label>Đợi gọi hồ sơ: <span class='error'>(*)</span></label>

            <select id="round_collection_id" name="round_collection_id" class="form-control">

              @if (!empty($round_collections) && $round_collections != null)
              <option value="-1">--Lựa chọn đợt gọi hồ sơ--</option>
              @foreach ($round_collections as $round_collection)

              <option value="{{$round_collection->id}}">{{$round_collection->year}} - {{$round_collection->name}}</option>

              @endforeach
              @else
              <option value="-1">(Chưa có đợt gọi hồ sơ nào)</option>
              @endif
            </select>
          </div>

          <div class="form-group">
            <label>Nhóm hội đồng: <span class='error'>(*)</span></label>

            <select id="group_council_id" name="group_council_id" class="form-control">

              @if (!empty($groupCouncils) && $groupCouncils != null)
              <option value="-1">--Lựa chọn nhóm hội đồng--</option>
              @foreach ($groupCouncils as $group_council)

              <option value="{{$group_council->id}}">{{$group_council->name}}</option>

              @endforeach
              @else
              <option value="-1">(Chưa có nhóm hội đồng nào)</option>
              @endif
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
        <button type="submit" class="btn btn-primary" id="create-council-btn">Tạo</button>
      </div>
    </div>
  </div>
</div>

{{-- Sửa hội đồng --}}
<div class="modal fade" id="edit-council-mdl" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">SỬA HỘI ĐỒNG</h4>
      </div>
      <div class="modal-body">
        <form role="form" enctype="multipart/form-data" id="edit-council-frm">
          <div class="form-group">
            <label>Tên hội đồng <span class='error'>(*)</span></label>
            <textarea id="name_council" name="name_council" class="form-control" placeholder="Tên hội đồng"></textarea>
          </div>

          <div class="form-group">
            <input type="hidden" id="status" name="status" class="form-control" placeholder="Tên hội đồng" value="1">
          </div>

          <div class="form-group">
            <label>Đợi gọi hồ sơ: <span class='error'>(*)</span></label>

            <select id="round_collection_id_council" name="round_collection_id_council" class="form-control">
              
              @if (!empty($round_collections) && $round_collections != null)
              <option value="-1">--Lựa chọn đợt gọi hồ sơ--</option>
              @foreach ($round_collections as $round_collection)

              <option value="{{$round_collection->id}}">{{$round_collection->year}} - {{$round_collection->name}}</option>

              @endforeach
              @else
              <option value="-1">(Chưa có đợt gọi hồ sơ nào)</option>
              @endif
            </select>
          </div>

          <div class="form-group">
            <label>Nhóm hội đồng: <span class='error'>(*)</span></label>

            <select id="group_council_id_council" name="group_council_id_council" class="form-control">

              @if (!empty($groupCouncils) && $groupCouncils != null)
              <option value="-1">--Lựa chọn đợt gọi hồ sơ--</option>
              @foreach ($groupCouncils as $group_council)

              <option value="{{$group_council->id}}">{{$group_council->name}}</option>

              @endforeach
              @else
              <option value="-1">(Chưa có nhóm hội đồng nào)</option>
              @endif
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
        <button type="button" class="btn btn-primary" id="edit-council-btn">Lưu</button>
      </div>
    </div>
  </div>
</div>

{{-- Xem chi tiết --}}
<div class="modal fade" id="detail-council-mdl" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Chi tiết hội đồng</h4>
      </div>
      <div class="modal-body">

        <div class="form-group">
          <div class="input-group input-group-lg">
            <span class="input-group-addon"><i class="fa fa-globe"></i></span>
            <span class="form-control" id="detail-name"></span>
          </div>
        </div>

        <div class="form-group">
          <div class="input-group input-group-lg">
            <span class="input-group-addon"><i class="fa fa-adjust"></i></span>
            <span class='form-control' id="detail-status"></span>
          </div>
        </div>

        <div class="form-group">
          <div class="input-group input-group-lg">
            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
            <span class='form-control' id="detail-created_at"></span>
          </div>
        </div>

        <div class="form-group">
          <div class="input-group input-group-lg">
            <span class="input-group-addon"><i class="fa fa-group"></i></span>
            <span class='form-control' id="detail-group_council_id"></span>
          </div>
        </div>

        <div class="form-group">
          <div class="input-group input-group-lg">
            <span class="input-group-addon"><i class="fa fa-archive"></i></span>
            <span class='form-control' id="detail-round_collection_id"></span>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="list-member-mdl" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog" style="width: 70% ">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Danh sách thành viên hội đồng</h4>
      </div>
      <div class="modal-body">
          <div class="row">
            <div class="col-md-2 council_info">
              <p>
                  Tên hội đồng
              </p>
              <p>Nhóm</p>
              <p>Năm</p>
            </div>
            <div class="col-md-6">
              <p id="council_name"></p>
              <p id="group_council_name"></p>
              <p id="year"></p>  
            </div>
            <div class="col-md-4">
                <a href="#add-member-mdl" data-toggle="modal" class="btn btn-info" style="float: right"><i class="fa fa-plus"></i>Thêm mới thành viên</a>
            </div>
          </div><br>
          <div class="row">
            <div class="col-md-12">
              <table class="table table-striped table-bordered table-hover" id="council_member" width="100%">
                <thead>
                  <tr>
                    <th style="text-align: center;">STT</th>
                    <th style="text-align: center;">Họ và tên</th>
                    <th style="text-align: center;">Email</th>
                    <th style="text-align: center;">Số điện thoại</th>
                    <th style="text-align: center;">Vị trí</th>
                    <th style="text-align: center;">#</th>
                  </tr>
      
                </thead>
                {{-- <tbody id="flag">
                  
                </tbody> --}}
              </table> 
            </div>
          </div>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="add-member-mdl" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog" style="width:50% ">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Thêm mới thành viên</h4>
      </div>
      <form role="form" enctype="multipart/form-data" id="add-council-member">
      <div class="modal-body">
        
            <input type="hidden" id="council_id" name="council_id">
          <div class="form-group">
            <label>Chuyên gia: <span class='error'>(*)</span></label>

            <select id="user_id" name="user_id" class="form-control select" data-live-search="true">
              <option data-hidden="true" value="-1">--Mời bạn chọn chuyên gia--</option>
              @if (!empty($users) && isset($count_user) && $count_user != 0)
              @foreach ($users as $user)

              <option value="{{$user->id}}">{{$user->name}} - {{$user->email}} - {{($user->mobile != '')?$user->mobile:'Chưa cập nhật'}}</option>

              @endforeach
              @else
              <option value="-1">(Không có chuyên gia nào)</option>
              @endif
            </select>
            <span class="error" id="user_id_msg"></span>
          </div>

          <div class="form-group">
            <label>Vị trí hội đồng: <span class='error'>(*)</span></label>

            <select id="position_council_id" name="position_council_id" class="form-control">
              <option value="-1">--Vui lòng chọn vị trí hội đồng--</option>
              @if (!empty($position_councils) && $position_councils != null)
              
              @foreach ($position_councils as $position_council)

              <option value="{{$position_council->id}}">{{$position_council->name}}</option>

              @endforeach
              @else
              <option>(Không có vị trí hội đồng nào)</option>
              @endif
            </select>
            <span class="error" id="position_council_id_msg"></span>
          </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
        <button type="submit" class="btn btn-info" id="add-member-btn">Lưu</button>
      </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="update-member-mdl" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog" style="width:50% ">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Cập nhật thành viên</h4>
      </div>
      <form role="form" enctype="multipart/form-data" id="update-council-member">
      <div class="modal-body">
        
            <input type="hidden" id="e_council_id" name="e_council_id">
            
            <input type="hidden" id="e_user_id" name="e_user_id">
            <div class="row">
              <div class="col-md-3">
                  <p>Họ tên: </p>
                  <p>Email: </p>
                  <p>Số điện thoại: </p>
              </div>
              <div class="col-md-9">
                <p id="user_name"></p>
                <p id="email"></p>
                <p id="mobile"></p>
              </div>
            </div>
            
            <br>

          <div class="form-group">
            <label>Vị trí hội đồng: <span class='error'>(*)</span></label>

            <select id="e_position_council_id" name="e_position_council_id" class="form-control">
              <option value="-1">--Vui lòng chọn vị trí hội đồng--</option>
              @if (!empty($position_councils) && $position_councils != null)
              
              @foreach ($position_councils as $position_council)

              <option value="{{$position_council->id}}">{{$position_council->name}}</option>

              @endforeach
              @else
              <option>(Không có vị trí hội đồng nào)</option>
              @endif
            </select>
            <span class="error" id="position_council_id_msg"></span>
          </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
        <button type="submit" class="btn btn-info" id="add-member-btn">Lưu</button>
      </div>
      </form>
    </div>
  </div>
</div>

@endsection
@section('footer')<script type="text/javascript" src="{{mix('build/js/council.js')}}"></script>
@endsection
