@extends('layouts.master')
@section('content')
<div>
  <h2>Danh sách </h2>
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
    <table id="product-list" class="table table-striped responsive-utilities jambo_table">
        <thead>
            <tr class="headings">
                <th>
                    #
                </th>
                <th>Tên bước</th>
                <th>Tên sản phẩm</th>
                <th>Cập nhật</th>
                <th>Ngày tạo</th>
                <th>Hành động</th>
            </tr>
        </thead>


    </table>
</div>

@endsection
@section('script')
<script>
    $(function() {
        $('#product-list').DataTable({
            processing: false,
            serverSide: true,
            order: [],
            ajax: '{!! route('node.getList') !!}',
            pageLength: 30,
            lengthMenu: [[30, 50, 100, 200, 500], [30, 50, 100, 200, 500]],
            columns: [
            {data: 'DT_Row_Index', name: 'DT_Row_Index', 'class':'dt-center', searchable: false},
            {data: 'name', name: 'name'},
            {data: 'product_name', name: 'product_name'},
            {data: 'updated_at', name: 'updated_at'},
            {data: 'created_at', name: 'created_at',orderable: false,},
            {data: 'action', name: 'action', searchable: false},
            ]
        });

    });

</script>
<script>    
        function deleteNode(id){
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
                url: '{{ route('user.node.delete') }}',
                type: 'POST',
                data: {id: id},
                
                success: function success(res) {

                    if (!res.error) {

                        toastr.error(res.message);
                        $('#product-list').DataTable().ajax.reload();
                    } else {

                        toastr.error(res.message);
                    }
                },
                error: function error(xhr, ajaxOptions, thrownError) {
                                        //toastr.error(thrownError);
                                        toastr.error("Lỗi! Không thể xóa! <br>Vui lòng thử lại hoặc liên lạc với IT");
                                    }

                                });
         } 
     });
     }
 </script>

@endsection