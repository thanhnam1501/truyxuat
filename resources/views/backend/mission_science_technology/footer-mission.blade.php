@extends('edit')

@section('footer-mission')
<div class="panel-footer custom-footer">
          <div class="col-md-8">
            <h5><span class="error">(*)</span> Ghi chú: <br>- <i>Phiếu đề xuất được trình bày không quá 4 trang giấy khổ A4</i> <br>- <i>Các mục <span class="error">(*)</span> là bắt buộc</i></h5>
          </div>
          <div class="col-md-4" style="text-align: right"> <div class="col-md-12">
            @if ($is_filled)

              @if (!$is_submit_ele_copy)

                <button class="btn btn-info" id="btn_submit_ele_copy" data-key="{{ $st_key }}" data-is_submit_ele_copy="1">

                  <i class="fa fa-paper-plane" aria-hidden="true"></i> Nộp bản mềm
                </button>

                <button class="btn btn-success"id="update-science-technology-btn"><i class="fa fa-floppy-o" aria-hidden="true"></i> Lưu thông tin</button>

              @endif

              @if ($is_submit_ele_copy)
                <a href="javascript:;" class="btn btn-info" id="btn_submit_ele_copy" data-key="{{ $st_key }}" data-is_submit_ele_copy="0">
                  <i class="fa fa-pencil" aria-hidden="true"></i>&nbsp; &nbsp; Sửa bản mềm
                </a>

                <a href="{!! route('missionScienceTechnology.print',  $st_key) !!}" class="btn btn-success" target="_blank"><i class='fa fa-print'></i> &nbsp; In phiếu đề xuất</a>
              @endif

            @else
              <button class="btn btn-success"id="update-science-technology-btn"><i class="fa fa-floppy-o" aria-hidden="true"></i> Lưu thông tin</button>
            @endif

          </div> </div>
@endsection