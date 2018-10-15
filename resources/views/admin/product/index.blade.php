@extends('layouts.master')
@section('content')
<div>
	<a class="btn btn-primary" href='{{route('product.ShowFormCreate')}}'>Thêm sản phẩm mới</a>
	
    <div class="">
        <table id="product-list" class="table table-striped responsive-utilities jambo_table">
            <thead>
                <tr class="headings">
                    <th>
                        #
                    </th>
                    <th>id</th>
                    <th>Tên sản phẩm</th>
                    <th>Cập nhật</th>
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
            ajax: '{!! route('product.getList') !!}',
            pageLength: 30,
            lengthMenu: [[30, 50, 100, 200, 500], [30, 50, 100, 200, 500]],
            ordering: false,
            columns: [
            {data: 'DT_Row_Index', name: 'DT_Row_Index', 'class':'dt-center',searchable: false},
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'updated_at', name: 'updated_at'},
            {data: 'created_at', name: 'created_at',orderable: false, searchable: false},
            {data: 'action', name: 'action',searchable: false},
            ]
        });

    });



</script>
<script>    
    function delete(id){
        $('.btn_delete').click(function(){
            // alert('aaa');
            swal({
                title: "Bạn có chắc muốn xóa?",
                text: "Bạn sẽ không thể khôi phục lại bản ghi này !",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                cancelButtonText: "Không",
                confirmButtonText: "Có",
                closeOnConfirm: true,
            },
            function(isConfirm){
                if (isConfirm) {
                    $.ajax({
                        url: '{{ route('company.delete') }}',
                        type: 'POST',
                        data: {id: id},

                        success : function(res) {
                            console.log(res);
                            if (res.status) {
                                $('#supplier_'+id).remove();
                                toastr.success('Xoá thành công!', '',{timeOut: 1000});
                            }
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            toastr.error('Xoá thất bại!', '',{timeOut: 1000});
                        }
                    });

                }else{
                    toastr.error('Thao tác bị huỷ!', '',{timeOut: 1000});
                }
            });

        });
    }
</script>

@endsection