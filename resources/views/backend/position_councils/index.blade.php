@extends('backend.layouts.master')

@section('header')
<style>
    table .btn{
        margin-right: 10px;
        margin-top: 5px;
    }
</style>
@endsection

@section('breadcrumb')
	<li class="active">Quản lý vị trí hội đồng</li>
@endsection

@section('page-title')
{{-- <h2>Danh sách vị trí hội đồng</h2> --}}
@endsection

@section('content')
<div class="panel panel-default">
      <div class="panel-body tab-content">
        <div class="portlet light bordered">
        	<div class="row">
        	    <div class="col-xs-12 col-sm-4 col-md-6 col-lg-5">
        	        @if(true)
        	        <a href="#createModal" data-toggle="modal" class="btn btn-info addPositionCouncil"><i class="fa fa-plus"></i> Thêm mới</a>
        	        @endif
        	    </div>
        	</div>
        	<br>
        	<div class="portlet-body">

        	    <table class="table table-striped table-bordered table-hover" id="position-councils-table">
        	        <thead>
        	            <tr>
        	                <th style="text-align: center;">STT</th>
                            <th style="text-align: center;">Tên vị trí</th>
        	                <th style="text-align: center;">Trạng thái</th>
        	                <th style="text-align: center;">Hành động</th>
        	            </tr>
        	        </thead>
        	    </table>

        	</div>
        </div>

        <div class="modal fade bs-modal-lg" id="createModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg ">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Thêm vị trí hội đồng</h4>
                    </div>
                    <form id="add-position-councils" name="add-position-councils" action="" method="POST">
                        <div class="modal-body">

                            {{csrf_field()}}
                            <label for="display_name">Tên <span style="color:red;">(*)</span></label>
                                <div id="add-group" class="form-group form-md-line-input form-md-floating-label">
                                    <textarea class="form-control" id="name" name="name" rows="5" placeholder="Tên nhóm hội đồng"></textarea>

                                </div>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default btn-circle"
                                    data-dismiss="modal">
                                Hủy
                            </button>
                            <button type="submit" id="add"  class="btn green btn-primary">
                                Lưu
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Chi tiết vị trí hội đồng</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <div class="input-group input-group-lg">
                    <span class="input-group-addon"><i class="fa fa-compass"></i></span>
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
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Sửa vị trí hội đồng</h4>
      </div>
      <form id="edit-position-councils" name="edit-position-councils" action="" method="POST">
            <input type="hidden" id="edit-id" name="edit-id">
            <div class="modal-body">

                {{csrf_field()}}
                <label for="display_name">Tên <span style="color:red;">(*)</span></label>
                    <div id="edit-add-group" class="form-group form-md-line-input form-md-floating-label">
                        <textarea class="form-control" id="edit-name" name="edit-name" rows="5" placeholder="Tên nhóm hội đồng"></textarea>

                    </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-circle"
                        data-dismiss="modal">
                    Hủy
                </button>
                <button type="submit" id="edit" class="btn green btn-primary">
                    Lưu
                </button>
            </div>
        </form>
    </div>
  </div>
</div>
@endsection

@section('footer')
<script type="text/javascript" src="{{mix('build/js/position-councils.js')}}"></script>
@endsection
