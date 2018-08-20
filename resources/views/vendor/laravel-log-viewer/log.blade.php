
@extends('backend.layouts.master')

@section('header')
  <style>
    body {
      /*padding: 25px;*/
    }

    h1 {
      font-size: 1.5em;
      margin-top: 0;
    }

    #table-log {
        font-size: 1.2rem;
    }

    .sidebar {
        font-size: 1.2rem;
        line-height: 1;
        margin-bottom: 30px;
        display: inline-block;
        width: 40%;
    }

    .btn {
        font-size: 1rem;
    }

    .stack {
      font-size: 1.2em;
    }

    .date {
      min-width: 75px;
    }

    .text {
      word-break: break-all;
    }

    a.llv-active {
      z-index: 2;
      background-color: #f5f5f5;
      border-color: #777;
    }

    .list-group-item {
      word-wrap: break-word;
    }

    .folder {
      padding-top: 15px;
    }
    .float-right{
      float: right;
    }
    .table-responsive{
      margin-bottom: 40px;
    }
  </style>
@endsection

@section('breadcrumb')
  <li class="active">Quản lý logs hệ thống</li>
@endsection

@section('page-title')
  {{-- <h2>Quản lý logs</h2> --}}
@endsection

@section('content')
<div class="panel panel-default">
  <div class="panel-body tab-content">

          <div class="sidebar ">
            <div class="list-group">
              @foreach($folders as $folder)
                <div class="list-group-item">
                  <a href="?f={{ \Illuminate\Support\Facades\Crypt::encrypt($folder) }}">
                    <span class="fa fa-folder"></span> {{$folder}}
                  </a>
                  @if ($current_folder == $folder)
                    <div class="list-group folder">
                      @foreach($folder_files as $file)
                        <a href="?l={{ \Illuminate\Support\Facades\Crypt::encrypt($file) }}&f={{ \Illuminate\Support\Facades\Crypt::encrypt($folder) }}"
                          class="list-group-item @if ($current_file == $file) llv-active @endif">
                          {{$file}}
                        </a>
                      @endforeach
                    </div>
                  @endif
                </div>
              @endforeach
{{--               @foreach($files as $file)
                <a href="?l={{ \Illuminate\Support\Facades\Crypt::encrypt($file) }}"
                   class="list-group-item @if ($current_file == $file) llv-active @endif">
                  {{$file}}
                </a>
              @endforeach --}}
              <select class="form-control" onchange="location = this.value;">
                @foreach($files as $file)
                  <option value="{{ asset('admin/logs/') }}?l={{ \Illuminate\Support\Facades\Crypt::encrypt($file) }}" class=" @if ($current_file == $file) option-active @endif">{{$file}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="table-responsive">
            @if ($logs === null)
              <div>
                Log file >50M, please download it.
              </div>
            @else
              <table id="table-log" class="table-bordered table table-striped table-responsive" data-ordering-index="{{ $standardFormat ? 2 : 0 }}">
                <thead>
                <tr>
                  @if ($standardFormat)
                    <th>Level</th>
                    <th>Context</th>
                    <th>Date</th>
                  @else
                    <th>Line number</th>
                  @endif
                  <th style="width: 70%">Content</th>
                </tr>
                </thead>
                <tbody>

                @foreach($logs as $key => $log)
                  <tr data-display="stack{{{$key}}}">
                    @if ($standardFormat)
                      <td class="text-{{{$log['level_class']}}}">
                        <span class="fa fa-{{{$log['level_img']}}}" aria-hidden="true"></span>&nbsp;&nbsp;{{$log['level']}}
                      </td>
                      <td class="text">{{$log['context']}}</td>
                    @endif
                    <td class="date">{{{$log['date']}}}</td>
                    <td class="text">
                      @if ($log['stack'])
                        <button type="button"
                                class="float-right expand btn btn-outline-dark btn-sm mb-2 ml-2"
                                data-display="stack{{{$key}}}">
                          <span class="fa fa-search"></span>
                        </button>
                      @endif
                      {{{$log['text']}}}
                      @if (isset($log['in_file']))
                        <br/>{{{$log['in_file']}}}
                      @endif
                      @if ($log['stack'])
                        <div class="stack" id="stack{{{$key}}}"
                             style="display: none; white-space: pre-wrap;">{{{ trim($log['stack']) }}}
                        </div>
                      @endif
                    </td>
                  </tr>
                @endforeach

                </tbody>
              </table>
            @endif
            <div class="p-3">
              @if($current_file)
                <a href="?dl={{ \Illuminate\Support\Facades\Crypt::encrypt($current_file) }}{{ ($current_folder) ? '&f=' . \Illuminate\Support\Facades\Crypt::encrypt($current_folder) : '' }}">
                  <span class="fa fa-download"></span> Tải file
                </a>
                -
                <a id="clean-log" href="?clean={{ \Illuminate\Support\Facades\Crypt::encrypt($current_file) }}{{ ($current_folder) ? '&f=' . \Illuminate\Support\Facades\Crypt::encrypt($current_folder) : '' }}">
                  <span class="fa fa-sync"></span> Xoá dữ liệu trong file
                </a>
                -
                <a id="delete-log" href="?del={{ \Illuminate\Support\Facades\Crypt::encrypt($current_file) }}{{ ($current_folder) ? '&f=' . \Illuminate\Support\Facades\Crypt::encrypt($current_folder) : '' }}">
                  <span class="fa fa-trash"></span> Xoá file
                </a>
                @if(count($files) > 1)
                  -
                  <a id="delete-all-log" href="?delall=true{{ ($current_folder) ? '&f=' . \Illuminate\Support\Facades\Crypt::encrypt($current_folder) : '' }}">
                    <span class="fa fa-trash-alt"></span> Xoá tất cả các files
                  </a>
                @endif
              @endif
            </div>
          </div>

  </div>
</div>

@endsection

@section('footer')
<script>
  $(document).ready(function () {
    $(".option-active").attr('selected','selected');
    $('#table-log tr').on('click', function () {
      $('#' + $(this).data('display')).toggle();
    });
    $('#table-log').DataTable({
      "order": [$('#table-log').data('orderingIndex'), 'desc'],
      "stateSave": true,
      "stateSaveCallback": function (settings, data) {
        window.localStorage.setItem("datatable", JSON.stringify(data));
      },
      "stateLoadCallback": function (settings) {
        var data = JSON.parse(window.localStorage.getItem("datatable"));
        if (data) data.start = 0;
        return data;
      }
    });
    $('#delete-log, #clean-log, #delete-all-log').click(function (e) {
      e.preventDefault();
      swal({
      title: "Bạn chắc chắn muốn xóa?",
      text: "Dữ liệu đã xóa không thể khôi phục!",
      icon: "warning",
      buttons: ['Hủy','Xóa'],
      dangerMode: true,
      })
      .then((willDelete) => {
      if (willDelete) {
          window.location.href = $(this).attr('href');
        }
      });
    });
  });
</script>
@endsection
