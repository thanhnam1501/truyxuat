@extends('backend.layouts.master')

@section('header')
<link rel="stylesheet" href="{{mix('build/css/roles.css')}}">
@endsection

@section('breadcrumb')
	<li class="active">Quản lý vai trò</li>
@endsection

@section('page-title')
{{-- <h2>Danh sách vai trò</h2> --}}
@endsection

@section('content')
<div class="panel panel-default">
      <div class="panel-body tab-content">
        <div class="portlet light bordered">
        	<div class="row">
        	    <div class="col-xs-12 col-sm-4 col-md-6 col-lg-5">
        	        @if(Entrust::can(['roles-add']))
        	        <button class="btn btn-info addRole"><i class="fa fa-plus"></i> Thêm mới</button>
        	        @endif
        	    </div>
        	</div>
        	<br>
        	<div class="portlet-body">

        	    <table class="table table-striped table-bordered table-hover" id="roles-table">
        	        <thead>
        	            <tr>
        	                <th style="text-align: center;">STT</th>
        	                <th style="text-align: center; width: 20%">Tên hiển thị</th>
                            <th style="text-align: center; width: 20%">Vai trò</th>
                            <th style="text-align: center; width: 30%">Miêu tả</th>
        	                <th style="text-align: center;">Ngày tạo</th>
        	                <th style="text-align: center;">Hành động</th>
        	            </tr>
        	        </thead>
        	    </table>

        	</div>
        </div>

        <div class="modal fade bs-modal-lg" id="createRoleModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg ">
                <div class="modal-content">
                    <div class="modal-header " id="themmoi">
                        {{-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button> --}}
                        <h4 class="modal-title green">THÊM MỚI</h4>
                    </div>
                    <div class="modal-body">
                            <form id="add-role" name="add-role" action="" method="POST">
                                {{csrf_field()}}
                                <label for="display_name">Tên hiển thị <span style="color:red;">(*)</span></label>
                                    <div id="add-group" class="form-group form-md-line-input form-md-floating-label">
                                        <input type="text" class="form-control" id="display_name" name="display_name" placeholder="Tên hiển thị">

                                    </div>
                                    <label for="name">Vai trò <span style="color:red;">(*)</span></label>
                                    <div id="add-group" class="form-group form-md-line-input form-md-floating-label">
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Vai trò">

                                    </div>

        							<label for="description">Miêu tả</label>
                                    <div id="add-group" class="form-group form-md-line-input form-md-floating-label">

                                        <textarea class="form-control" id="description" name="description" placeholder="Miêu tả" placeholder="Miêu tả"></textarea>
                                        {{-- <label for="class_fb_group">Miêu tả</label> --}}

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
</div>
    <div class="modal fade bs-modal-lg" id="editRoleModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg ">
            <div class="modal-content">
                <div class="modal-header " id="themmoi">
                    {{-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button> --}}
                    <h4 class="modal-title green">CẬP NHẬT</h4>
                </div>
                <div class="modal-body">
                        <form id="edit-role" name="edit-role" action="" method="POST">
                                {{csrf_field()}}
                                <input type="hidden" value="PUT" name="_method">
    							<label for="class_fb_group">Tên hiển thị <span style="color:red;">(*)</span></label>
                                <div id="add-group" class="form-group form-md-line-input form-md-floating-label">
                                    <input type="text" class="form-control" id="edit_display_name" name="display_name">

                                </div>
    							<label for="edit_description">Vai trò <span style="color:red;">(*)</span></label>
                                <div id="add-group" class="form-group form-md-line-input form-md-floating-label">
                                    <input type="hidden" class="form-control" id="edit_id" name="id">
                                    <input type="text" class="form-control" id="edit_name" name="name">

                                </div>

    							<label for="edit_description">Miêu tả</label>
                                <div id="add-group" class="form-group form-md-line-input form-md-floating-label">

                                    <textarea class="form-control" id="edit_description" name="description" placeholder="Miêu tả"></textarea>
                                    {{-- <label for="class_fb_group">Miêu tả</label> --}}

                                </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default btn-circle"
                                        data-dismiss="modal">
                                    Hủy
                                </button>
                                <button type="submit" id="update"  class="btn green btn-primary">
                                    Lưu
                                </button>
                            </div>
                        </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
<script type="text/javascript" src="{{mix('build/js/roles.js')}}"></script>
@endsection
