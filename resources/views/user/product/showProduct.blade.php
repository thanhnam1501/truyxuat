
@extends('layouts.master_user')
@section('content')
<style>

.imageProduct{
 max-width: 100%;
 margin: 5px auto;
 justify-content: center;
</style>

<div >
  <div>
    <h3 style="color: red">{{$product->name}}</h3>
  </div>
  <div >
    <div class="x_panel">
      <div class="x_title">
        <h2><i class="fa fa-bars"></i> Thông tin sản phẩm</h2>

        <div class="clearfix"></div>
      </div>
      <div class="x_content">

        <div class="col-xs-12 col-md-6 col-sm-6">
          <!-- required for floating -->
          <!-- Nav tabs -->
          @if($product->image)
          <img style="width: 50%;margin-left: 20%; border: solid 1px black" src="{{asset($product->image)}}" alt="">
          @else
          <img style="width: 50%;margin-left: 20%; border: solid 1px black" src="{{ asset('image/noimage.png')}}" alt="">
          @endif
        </div>

        <div class="col-xs-12 col-md-6 col-sm-6">
          <!-- Tab panes -->
          <div class="tab-content">
            <div class="tab-pane active" id="home">
              <p>
                {!!$product->sort_content!!}
              </p>
            </div>
          </div>
        </div>

        <div class="clearfix"></div>

      </div>
    </div>
  </div>
</div>


<div ">
  <div class="x_panel">
    <div class="x_title">
      <h2><i class="fa fa-bars"></i> Mô tả</h2>
      
      <div class="clearfix"></div>
    </div>
    <div class="x_content">

      <div class="col-xs-12">
        <!-- Tab panes -->
        <div class="tab-content">
         <p>{!!$product->content!!}</p>
       </div>
     </div>

     <div class="clearfix"></div>

   </div>
 </div>
</div>

<div >
  <div class="x_panel">
    <div class="x_title">
      <h2><i class="fa fa-bars"></i> Quy trình</h2>
      
      <div class="clearfix"></div>
    </div>
    <div class="x_content">

      <div class="col-md-3 col-xs-12">
        <!-- required for floating -->
        <!-- Nav tabs -->
        <ul class="nav nav-tabs tabs-left">
          @for($i= 0; $i < $product->node ; $i++)
          @foreach($nodes as $key => $value)
          @if($key == $i)
          <li role="presentation" class="@if($i==0)active @endif col-xs-12"><a href="#tab_content{{$i}}" role="tab" id="profile-tab" data-toggle="tab"  aria-expanded="false">{{$value->name}}</a>

          </li>
          @endif
          @endforeach
          @endfor
        </ul>
      </div>

      <div class="col-md-9 col-xs-12">
        <!-- Tab panes -->
        <div class="tab-content">
         @for($i= 0; $i < $product->node ; $i++)
         @foreach($nodes as $key => $value)
         @if($key === $i)
         <div role="tabpanel" class="tab-pane @if($i==0)active @endif fade in" id="tab_content{{$i}}" aria-labelledby="home-tab">
           @if($value->status == 1)
           <a data-tooltip="tooltip" title="Đã kích hoạt" href="javascript:;" onclick="activatedNode({{$value->id}})" class="btn btn-success "><i class="fa fa-check"> Node đã được kích hoạt</i></a>
           @else
           <a data-tooltip="tooltip" title="Đã kích hoạt" href="javascript:;" onclick="activatedNode({{$value->id}})" class="btn btn-danger "><i class="fa fa-check"> Node chưa được kích hoạt</i></a>
           @endif
           <p>{{$value->content}}</p>
         </div>
         @endif
         @endforeach
         @endfor
       </div>
     </div>

     <div class="clearfix"></div>

   </div>
 </div>
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
      {data: 'DT_Row_Index', name: 'DT_Row_Index', 'class':'dt-center', searchable: false},
      {data: 'name', name: 'name'},
      {data: 'updated_at', name: 'updated_at'},
      {data: 'created_at', name: 'created_at',orderable: false,},
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
  function activatedNode(id){
   $.ajax({
    url: '{{ route('user.node.activated') }}',
    type: 'POST',
    data: {id: id},

    success: function success(res) {

      if (res.status == true) {

        toastr.success(res.message);
        location.reload();
        setTimeout(function(){
             location.reload();
        }, 5000);
      } 
    },
    error: function error(xhr, ajaxOptions, thrownError) {

      toastr.error("Lỗi! Không thể sửa! <br>Vui lòng thử lại hoặc liên lạc với IT");
    }

  });
 }
</script>

@endsection