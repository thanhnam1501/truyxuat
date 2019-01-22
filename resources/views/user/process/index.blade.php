@extends('layouts.master_user')
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
 <div class="">
    <table id="process-list" class="table table-striped responsive-utilities jambo_table">
        <thead>
            <tr class="headings">
                <th>
                    #
                </th>
                <th>Tên quy trình</th>
                <th>Tên sản phẩm</th>
                <th>Tên NV chăm sóc</th>
                <th>Trạng thái</th>
                <th>Hành động</th>

            </tr>
        </thead>


    </table>
</div>

@endsection
@section('script')
<script>
    $(function() {
        $('#process-list').DataTable({
            processing: false,
            serverSide: true,
            order: [],
            ajax: '{!! route('user.process.getList') !!}',
            pageLength: 30,
            lengthMenu: [[30, 50, 100, 200, 500], [30, 50, 100, 200, 500]],
            columns: [
            {data: 'DT_Row_Index', name: 'DT_Row_Index', 'class':'dt-center',searchable: false},
            {data: 'name', name: 'name'},
            {data: 'product_name', name: 'product_name'},
            {data: 'user_name', name: 'user_name'},
            {data: 'status', name: 'status',},
            {data: 'action', name: 'action',orderable: false,},
            ]
        });

    });

</script>

<script>    
  function deleteProcess(id){
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
      url: '{{ route('user.process.delete') }}',
      type: 'POST',
      data: {id: id},

      success: function success(res) {

        if (!res.error) {

          toastr.error(res.message);
          $('#process-list').DataTable().ajax.reload();
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
<script>
  function activated(id){
     $.ajax({
        url: '{{ route('user.process.activated') }}',
        type: 'POST',
        data: {id: id},

        success: function success(res) {

          if (res.status == true) {

            toastr.success(res.message);
            $('#process-list').DataTable().ajax.reload();
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

@endsection