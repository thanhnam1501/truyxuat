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
  <a class="btn btn-primary" data-toggle="modal" href='{{route('node.ShowFormCreateOne')}}'>Tạo bước cập nhật</a>

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
        <th>Trạng thái</th>
        <th>Hành động</th>
      </tr>
    </thead>


  </table>
</div>

<div class="modal fade" id="add-node">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Modal title</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">

        </div>
        <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
          <input type="text" class="form-control has-feedback-left" id="name1" name="name1" placeholder="Tên bước"  required>
          <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
        </div>

        <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">

          {{--    <textarea name="content{{$i}}" class="form-control" id="editor{{$i}}"></textarea> --}}
          <textarea  class="form-control " id="editor1" name="content1"></textarea>
          
        </div>

        <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">

          <select class="form-control has-feedback-left" name="user_id1" id="user_id1" required>
            <option value="">Chọn nhân viên quản lý</option>
           {{--  @foreach($user as $key => $value)
            <option value="{{$value->id}}">{{$value->name}}</option>
            @endforeach --}}
          </select>
          <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
        </div>
        

        {{ csrf_field() }}  

        <button type="submit" class="btn btn-primary">Tạo mới</button>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>


@endsection
@section('script')
<script>
  $(function() {
   $('#product-list').DataTable({
    serverSide: true,
    order: [],
    searching: true,
    ajax: '{!! route('node.getList') !!}',
    pageLength: 30,
    lengthMenu: [[30, 50, 100, 200, 500], [30, 50, 100, 200, 500]],
    columns: [
    {data: 'DT_Row_Index', name: 'DT_Row_Index', 'class':'dt-center', searchable: false},
    {data: 'name', name: 'name'},
    {data: 'product_name', name: 'product_name'},
    {data: 'updated_at', name: 'updated_at'},
    {data: 'created_at', name: 'created_at'},
    {data: 'nodes.status', name: 'nodes.status'},
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