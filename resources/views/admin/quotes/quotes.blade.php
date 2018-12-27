@extends('layouts.master')
@section('content')

<div>
	<a class="btn btn-primary" href='{{route('quotes.ShowFormCreate')}}'>Thêm mới</a>
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
        <th>Tên gói cước</th>
        <th>Thời Hạn</th>
        <th>Số tài khoản</th>
        <th>Số sản phẩm</th>
        <th>Giá thành</th>
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
      aaSorting: [[5, 'desc']],
      bPaginate: false,
      bFilter: false,
      bInfo: false,
      order: [],
      searching: true,
      bSortable: true,
      bRetrieve: true,
      ajax: '{!! route('quotes.getList') !!}',
      pageLength: 30,
      lengthMenu: [[30, 50, 100, 200, 500], [30, 50, 100, 200, 500]],
      columns: [
      {data: 'DT_Row_Index', name: 'DT_Row_Index', 'class':'dt-center', searchable: false},
      {data: 'name', name: 'name'},
      {data: 'time_limit', name: 'time_limit'},
      {data: 'account_limit', name: 'account_limit'},
      {data: 'product_limit', name: 'product_limit'},
      {data: 'price', name: 'price',},
      {data: 'action', name: 'action', searchable: false},
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
      url: '{{ route('quotes.delete') }}',
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
    url: '{{ route('quotes.activated') }}',
    type: 'POST',
    data: {id: id},

    success: function success(res) {

      if (res.status == true) {

        toastr.success(res.message);
        $('#product-list').DataTable().ajax.reload();
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