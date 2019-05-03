@extends('layouts.master')
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

<div>
  <form action="{{route('qrcode.restore')}}" method="POST" role="form">
    <legend>Khôi phục mã QR-Code</legend>
  
    <div class="form-group">
      <label for="">Tên công ty</label>
      <select class="form-control" name="company_id" id="" required>
        @foreach($companies as $key => $value)
        <option value="{{$value->id}}">{{$value->name}}</option>
        @endforeach
      </select>
    </div>
    <div class="form-group">
      <label for="">Số Serial</label>
     <input type="number" class="form-control" name="serial" placeholder="Số Serial" required>
    </div>
    {{csrf_field()}}
    <button type="submit" class="btn btn-primary">Khôi phục</button>
  </form>
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
  function restore(){
   swal({
    title: "Bạn có chắc muốn khôi phục mã này?",
    text: "Bạn sẽ không thể khôi phục dữ liệu này!",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  })
   .then((willDelete) => {
    if (willDelete) {

     $.ajax({
      url: '{{ route('user.delete') }}',
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
       
        toastr.error("Lỗi! Không thể xóa! <br>Vui lòng thử lại hoặc liên lạc với IT");
      }

    });
   } 
 });
 }
</script>
 
@endsection