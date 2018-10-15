@extends('layouts.master')
@section('content')

<div class="">
    <table id="company-list" class="table table-striped responsive-utilities jambo_table">
        <thead>
            <tr class="headings">
                <th>
                    #
                </th>
                <th>Tên doanh nghiệp </th>
                <th>Địa chỉ</th>
                <th>Số điện thoại</th>
                <th>Ngày tạo</th>
                <th>action</th>
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
        $('#company-list').DataTable({
            processing: false,
            serverSide: true,
            order: [],
            ajax: '{!! route('company.getList') !!}',
            pageLength: 30,
            lengthMenu: [[30, 50, 100, 200, 500], [30, 50, 100, 200, 500]],
            columns: [
            {data: 'DT_Row_Index', name: 'DT_Row_Index', 'class':'dt-center'},
            {data: 'name', name: 'name'},
            {data: 'address', name: 'address'},
            {data: 'mobile_phone', name: 'mobile_phone'},
            {data: 'created_at', name: 'created_at',orderable: false, searchable: false},
            {data: 'action', name: 'action'},
            ]
        });

    });

</script>
<script>    
    function deleteCompany(id){

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
            url: '{{ route('company.delete') }}',
            type: 'POST',
            data: {id: id},
            
            success: function success(res) {

                if (!res.error) {

                    toastr.error(res.message);
                    $('#company-list').DataTable().ajax.reload();
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