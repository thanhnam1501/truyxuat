@extends('layouts.master_user')
@section('content')
<div>
{{--	<a class="btn btn-primary" href='{{route('user.report.qrcode.create')}}'>Thêm báo cáo mới</a>--}}
 @if(isset($messageError))
 <div class="alert alert-danger">
   <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
   {{ $messageError }}
 </div>
 @endif
 @if(isset($messageSuccess))
 <div class="alert alert-success">
   <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
   {{ $messageSuccess }}
 </div>
 @endif
 <div class="">
  <table id="report-list" class="table table-striped responsive-utilities jambo_table">
    <thead>
      <tr class="headings">
        <th>
          #
        </th>
        <th>Tên  </th>
        <th>Số lượng in</th>
        <th>Tên sản phẩm</th>
        <th>Tên người yêu cầu</th>
        <th>Ngày tạo</th>
        <th>Trạng thái</th>
        <th>Action</th>
      </tr>
    </thead>


  </table>
</div>

@endsection
@section('script')
<script>
  $(function() {
    $('#report-list').DataTable({
      processing: false,
      serverSide: true,
      order: [],
      ajax: '{!! route('user.report.qrcode.getList') !!}',
      pageLength: 30,
      lengthMenu: [[30, 50, 100, 200, 500], [30, 50, 100, 200, 500]],
      columns: [
      {data: 'DT_Row_Index', name: 'DT_Row_Index', 'class':'dt-center',searchable: false},
      {data: 'name', name: 'name'},
      {data: 'amount', name: 'email'},
      {data: 'product_name', name: 'product_name'},
      {data: 'user_name', name: 'user_name'},
      {data: 'created_at', name: 'created_at'},
      {data: 'status', name: 'status'},
      {data: 'action', name: 'action',searchable: false},
      ]
    });

  });

</script>
<script>    
  function deleteReport(id){
   swal({
    title: "Bạn có chắc muốn xóa?",
    text: "Bạn sẽ không thể khôi phục dữ liệu này!",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  })
   .then((willDelete) => {
    if (willDelete) {

     $.ajax({
      url: '{{ route('user.report.qrcode.delete') }}',
      type: 'POST',
      data: {id: id},

      success: function success(res) {

        if (!res.error) {
          toastr.error(res.message);
          $('#report-list').DataTable().ajax.reload();
        } else {

          toastr.error(res.message);
           $('#report-list').DataTable().ajax.reload();
        }
      },
      error: function error(xhr, ajaxOptions, thrownError) {

        toastr.error("Lỗi! Không thể đăng ký! <br>Vui lòng thử lại hoặc liên lạc với IT");
      }

    });
   } 
 });
 }
</script>

@if(Auth::guard('profile')->user()->type == 1)
<script>
  function activated(id){
   $.ajax({
    url: '{{ route('user.report.qrcode.activated') }}',
    type: 'POST',
    data: {id: id},

    success: function success(res) {

      if (res.status == true) {

        toastr.success(res.message);
        $('#report-list').DataTable().ajax.reload();
      } else {

        toastr.success(res.message);
      }
    },
    error: function error(xhr, ajaxOptions, thrownError) {

      toastr.error("Lỗi! Không thể sửa! <br>Vui lòng thử lại hoặc liên lạc với IT");
    }

  });
 }
</script>
@endif

@endsection