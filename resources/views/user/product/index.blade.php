@extends('layouts.master_user')
@section('content')
<div>
	<a class="btn btn-primary" href='{{route('user.product.ShowFormCreate')}}'>Thêm sản phẩm mới</a>
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
        <th>ID</th>
        <th>Tên sản phẩm</th>
        <th>Cập nhật</th>
        <th>Ngày tạo</th>
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
    $('#product-list').DataTable({
      aaSorting: [[5, 'desc']],
      bPaginate: false,
      bFilter: false,
      bInfo: false,
      order: [],
      searching: true,
      bSortable: true,
      bRetrieve: true,
      ajax: '{!! route('user.product.getList') !!}',
      pageLength: 30,
      lengthMenu: [[30, 50, 100, 200, 500], [30, 50, 100, 200, 500]],
      columns: [
      {data: 'DT_Row_Index', name: 'DT_Row_Index', 'class':'dt-center', searchable: false},
      {data: 'id', name: 'id'},
      {data: 'name', name: 'name'},
      {data: 'updated_at', name: 'updated_at'},
      {data: 'created_at', name: 'created_at',},
      {data: 'status', name: 'status'},
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
       
        toastr.error("Lỗi! Không thể xóa! <br>Vui lòng thử lại hoặc liên lạc với IT");
      }

    });
   } 
 });
 }
</script>
<script>

  function ImagetoPrint(source)
  {
    return "<html><head><script>function step1(){\n" +
    "setTimeout('step2()', 10);}\n" +
    "function step2(){window.print();window.close()}\n" +
    "</scri" + "pt></head><body onload='step1()'>\n" +
    "<img src='data:image/png;base64," + source + "' /></body></html>";
  }

  function PrintImage(source)
  {
    Pagelink = "about:blank";
    var pwa = window.open(Pagelink, "_new");
    pwa.document.open();
    pwa.document.write(ImagetoPrint(source));
    pwa.document.close();
  }

</script>
<script>
  function activated(id){
   $.ajax({
    url: '{{ route('user.product.activated') }}',
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