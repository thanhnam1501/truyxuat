@extends('layouts.master')
@section('content')
<div class="card-header">
  <h3><i class="fa fa-user"></i> Danh sách người dùng</h3>

</div>
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
</div>
<div>
	<a class="btn btn-primary" href='{{route('profile.ShowFormCreate')}}'>Thêm người dùng mới</a>
	
  <div class="">
    <table id="user-list" class="table table-striped responsive-utilities jambo_table">
      <thead>
        <tr class="headings">
          <th>
            #
          </th>
          <th>Tên  </th>
          <th>Email</th>
          <th>Số điện thoại</th>
          <th>Tên công ty</th>
          <th>Ngày tạo</th>
          <th>Action</th>
        </tr>
      </thead>


    </table>
  </div>

  @endsection
  @section('script')
  <script>
    $(function() {
      $('#user-list').DataTable({
        processing: false,
        serverSide: true,
        order: [],
        ajax: '{!! route('profile.getList') !!}',
        pageLength: 30,
        lengthMenu: [[30, 50, 100, 200, 500], [30, 50, 100, 200, 500]],
        ordering: false,
        columns: [
        {data: 'DT_Row_Index', name: 'DT_Row_Index', 'class':'dt-center',searchable: false},
        {data: 'name', name: 'name'},
        {data: 'email', name: 'email'},
        {data: 'mobile', name: 'mobile'},
        {data: 'company_name', name: 'company_name'},
        {data: 'created_at', name: 'created_at',orderable: false, searchable: false},
        {data: 'action', name: 'action',searchable: false},
        ]
      });

    });

  </script>
  <script>    
    function deleteUser(id){
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
        url: '{{ route('profile.delete') }}',
        type: 'POST',
        data: {id: id},

        success: function success(res) {
            console.log(res.data);
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

 @endsection