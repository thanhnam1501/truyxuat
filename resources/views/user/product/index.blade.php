@extends('layouts.master_user')
@section('content')
<div>
	<a class="btn btn-primary" href='{{route('user.product.ShowFormCreate')}}'>Thêm sản phẩm mới</a>
	
<div class="">
    <table id="product-list" class="table table-striped responsive-utilities jambo_table">
        <thead>
            <tr class="headings">
                <th>
                    #
                </th>
                <th>id</th>
                <th>name</th>
                <th>cập nhật</th>
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
        $('#product-list').DataTable({
            processing: false,
            serverSide: true,
            order: [],
            ajax: '{!! route('user.product.getList') !!}',
            pageLength: 30,
            lengthMenu: [[30, 50, 100, 200, 500], [30, 50, 100, 200, 500]],
            columns: [
            {data: 'DT_Row_Index', name: 'DT_Row_Index', 'class':'dt-center'},
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'updated_at', name: 'updated_at'},
            {data: 'created_at', name: 'created_at',orderable: false, searchable: false},
            {data: 'action', name: 'action'},
            ]
        });

    });

</script>
<script>    
        function deleteProduct(id){
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
                url: '{{ route('user.product.delete') }}',
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