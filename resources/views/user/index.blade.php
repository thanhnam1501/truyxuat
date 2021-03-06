@extends('layouts.master_user')
@section('content')
<div>
	<a class="btn btn-primary" href='{{route('user.profile.ShowFormCreate')}}'>Thêm người dùng mới</a>
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
  <table id="user-list" class="table table-striped responsive-utilities jambo_table">
    <thead>
      <tr class="headings">
        <th>
          #
        </th>
        <th>Tên  </th>
        <th>Email</th>
        <th>Số điện thoại</th>
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
      aaSorting: [[5, 'desc']],
      bPaginate: false,
      bFilter: false,
      bInfo: false,
      bSortable: true,
      bRetrieve: true,
      ajax: '{!! route('user.profile.getList') !!}',
      pageLength: 30,
      lengthMenu: [[30, 50, 100, 200, 500], [30, 50, 100, 200, 500]],
      columns: [
      {data: 'DT_Row_Index', name: 'DT_Row_Index', 'class':'dt-center',searchable: false},
      {data: 'name', name: 'name'},
      {data: 'email', name: 'email'},
      {data: 'mobile', name: 'mobile'},
      {data: 'created_at', name: 'created_at'},
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
      url: '{{ route('user.profile.delete') }}',
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
                                        //toastr.error(thrownError);
                                        toastr.error("Lỗi! Không thể đăng ký! <br>Vui lòng thử lại hoặc liên lạc với IT");
                                      }

                                    });
   } 
 });
 }
</script>

@endsection