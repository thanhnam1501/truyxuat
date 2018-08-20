@extends('backend.layouts.master')

@section('header')
<link rel="stylesheet" href="{{mix('build/css/roles.css')}}">
@endsection

@section('breadcrumb')
	<li class="">Quản lý vai trò</li>
	<li class="">Danh sách chức năng</li>
@endsection

@section('content')
<div class="panel panel-default">
      <div class="panel-body tab-content">
            <div class="portlet light bordered">
            <div class="row">
            </div>
            <div class="portlet-body">


                <table class="table table-striped table-bordered table-hover" id="role-permissions-table" data-name="{{$name}}">

                    <thead>
                        <tr>
                            <th style="text-align: center;">STT</th>
                            <th style="text-align: center;">Quyền hạn</th>
                            <th style="text-align: center;">Miêu tả</th>
                            <th style="text-align: center;">Hành động</th>
                        </tr>
                    </thead>
                </table>

            </div>
            </div>

            <div class="modal fade bs-modal-lg" id="createTheoryGroupModal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg ">
                    <div class="modal-content">
                        <div class="modal-header " id="themmoi">
                            {{-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button> --}}
                            <h4 class="modal-title green">THÊM MỚI</h4>
                        </div>
                        <div class="modal-body">

                                    <div id="add-group" class="form-group form-md-line-input form-md-floating-label">
                                        <input type="text" class="form-control" id="name" name="name">
                                        <label for="class_fb_group">Tên nhóm</label>

                                    </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default btn-circle"
                                            data-dismiss="modal">
                                        Hủy
                                    </button>
                                    <button type="button" id="add"  class="btn green btn-circle">
                                        Thêm Mới
                                    </button>
                                </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
<script type="text/javascript" src="{{mix('build/js/roles.js')}}"></script>
@endsection
