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
   <a class="btn btn-primary" href='{{route('qrcode.ShowFormCreate')}}'>Tạo khối mới</a>

   <div class="">
    <table id="user-list" class="table table-striped responsive-utilities jambo_table">
      <thead>
        <tr class="headings">
          <th>
            #
          </th>
          <th>Tên công ty </th>
          <th>Số đầu</th>
          <th>Số cuối</th>
          <th>Tên người tạo</th>
          <th>Ngày tạo</th>
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
    $('#user-list').DataTable({
      processing: false,
      serverSide: true,
      order: [],
      ajax: '{!! route('qrcode.getList') !!}',
      pageLength: 30,
      ordering: false,
      lengthMenu: [[30, 50, 100, 200, 500], [30, 50, 100, 200, 500]],
      columns: [
      {data: 'DT_Row_Index', name: 'DT_Row_Index', 'class':'dt-center',searchable: false},
      {data: 'company_name', name: 'company_name'},
      {data: 'start', name: 'start', 'class':'dt-center'},
      {data: 'end', name: 'end', 'class':'dt-center'},
      {data: 'user_name', name: 'user_name', 'class':'dt-center'},
      {data: 'created_at', name: 'created_at',orderable: false, searchable: false},
      {data: 'action', name: 'action',searchable: false},
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
       
        toastr.error("Lỗi! Không thể xóa! <br>Vui lòng thử lại hoặc liên lạc với IT");
      }

    });
   } 
 });
 }
</script>
@endsection