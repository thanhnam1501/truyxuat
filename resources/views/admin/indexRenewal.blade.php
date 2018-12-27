@extends('layouts.master')
@section('content')
<div class="clearfix"></div>
<div>
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
 <div>
   <div class="">
    <table id="renewal-list" class="table table-striped responsive-utilities jambo_table">
      <thead>
        <tr class="headings">
          <th>
            #
          </th>
          <th>Tên quản trị viên  </th>
          <th>Thời hạn (Tháng)</th>
          <th>Giá tiền</th>
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
   $.ajaxSetup({
     headers: {
       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
     }
   });
 </script>
 <script>
  $(function() {
    $('#renewal-list').DataTable({
      processing: false,
      serverSide: true,
      order: [],
      ajax: '{!! route('renewal.getList') !!}',
      pageLength: 30,
      ordering: false,
      lengthMenu: [[30, 50, 100, 200, 500], [30, 50, 100, 200, 500]],
      columns: [
      {data: 'DT_Row_Index', name: 'DT_Row_Index', 'class':'dt-center',searchable: false},
      {data: 'company_name', name: 'company_name'},
      {data: 'time_limit', name: 'time_limit','class':'dt-center'},
      {data: 'price', name: 'price','class':'dt-center'},
      {data: 'created_at', name: 'created_at',orderable: false, searchable: false,'class':'dt-center'},
      {data: 'status', name: 'status','class':'dt-center'},
      {data: 'action', name: 'action',searchable: false,'class':'dt-center'},
      ]
    });

  });

</script>
<script>    
  function deleteAdmin(id){
    
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
        url: '{{ route('user.delete') }}',
        type: 'POST',
        data: {id: id},

        success: function success(res) {

          if (!res.error) {

            toastr.error(res.message);
            $('#user-list').DataTable().ajax.reload();
          } else {

            toastr.error(res.message);
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

<script>
  function activated(id){
     $.ajax({
        url: '{{ route('renewal.activatedRenewal') }}',
        type: 'POST',
        data: {id: id},

        success: function success(res) {

          if (res.status == true) {

            toastr.success(res.message);
            $('#renewal-list').DataTable().ajax.reload();
        } else {

            toastr.error(res.message);
        }
    },
    error: function error(xhr, ajaxOptions, thrownError) {

      toastr.error("Lỗi! Không thể sửa! <br>Vui lòng thử lại hoặc liên lạc với IT");
  }

});
 }
</script>


@endsection