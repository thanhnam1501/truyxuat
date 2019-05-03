@extends('layouts.master')

@section('content')
<section class="content-header">
  <h1>
    Tạo khối QR-Code
    {{--  <small>Control panel</small> --}}
  </h1>
 {{--  <ol class="breadcrumb">
    <li><a href="{{route('backend.site.index')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="{{route('backend.qrcode.index')}}">Danh sách QRCode đã in</a></li>
    <li class="active">In QRCode</li>
  </ol> --}}
</section>
<section class="content">
  <div class="">
    <div class="">
      <form action="{{route('qrcode.create')}}" method="POST">
        {{csrf_field()}}
        <div class="">
          <div class="">
            <h3 class="help">Lưu ý: những trường có (<span style="color: #f00">*</span>) là bắt buộc.</h3>
            <p style="color: #f00;">{{$errors->first()}}</p>

          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div class="">
              <div class="">
                <div class="form-group {{$errors->has('company_id') ? 'has-error' : ''}}">
                  <label class="required" for="company_id">Chọn doanh nghiệp <span style="color: #f00">*</span></label>
                  <select class="form-control" id="company_id" name="company_id" style="">
                    <option value="">--Chọn doanh nghiệp--</option>
                    @foreach($company as $item)
                    <option value="{{$item->id}}" {{old('company_id') == $item->id ? 'selected' : ''}}>{{$item->name}}</option>
                    @endforeach
                  </select>
                  <span class="help-block">{{$errors->first("company_id")}}</span>
                </div>
                
                <!-- /.form-group -->
                <div class="form-group {{$errors->has('start') ? 'has-error' : ''}}">
                  <label class="required" for="start">Serial đầu <span style="color: #f00">*</span></label>
                  <input type="number" class="form-control" name="start" id="start" placeholder="Số serial bắt đầu" value="{{old('start')}}">
                  <span class="help-block">{{$errors->first("start")}}</span>
                  <span id="spanstart" style="color: #f00;"></span>
                </div>
                <!-- /.form-group -->
                <div class="form-group {{$errors->has('end') ? 'has-error' : ''}}">
                  <label class="required" for="end">Serial cuối <span style="color: #f00">*</span></label>
                  <input type="number" class="form-control" name="end" id="end" placeholder="Số serial cuối" value="{{old('end')}}">
                  <span class="help-block">{{$errors->first("end")}}</span>
                  <span id="spanend" style="color: #f00;"></span>
                </div>
                   <!-- /.form-group -->
                <!-- /.form-group -->
                <!-- /.form-group -->
                <div class="form-group">
                  <label class="" for="note">Ghi chú</label>
                  <textarea class="form-control" name="note" id="note" rows="3" placeholder="Ghi chú">{{old('note')}}</textarea>
                </div>
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div>
          <!-- /.box-body -->
          <div class="box-footer text-center">
            <button type="submit" class="btn btn-primary mrg-10">Save</button>
            <button type="reset" class="btn btn-default mrg-10">Cancel</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</section>

@endsection
@section('script')

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<script>
 $.ajaxSetup({
   headers: {
     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
   }
 });
</script>
<script type="text/javascript">
  $('#company_id').select2();
  $('#company_id').change(function(event) {
    if($(this).val() != '') {
      $.ajax({
        type: 'POST',
        url: '{{route('backend.qrcode.checkStart')}}',
        data: {company_id: $('#company_id').val(), type: 'get'},
        dataType: 'json',
        success: function(resp) {
          $('#start').attr('readonly', true);
          $('#start').val(resp._start);
          var products = resp.products;
          var html = "";
          for (var i = 0; i < products.length ; i++) {
           html += "<option value='" + products[i]['id'] + "'>"+products[i]['name']+"</option>"
          }
          document.getElementById("product_id").innerHTML = html;
        }
     });
    }
  });
  $('#start').change(function() {
    if($('#company_id').val() == '') {
      $('#start').val('');
      toastr.error('Bạn chưa chọn doanh nghiệp nào', 'Thông báo');
      return false;
    } else if(parseInt($(this).val()) < 1) {
      $('#start').val('').focus();
      $('#spanstart').text('Serial đầu phải lớn hơn 0');
      return false;
    } else {
      $.ajax({
        type: 'POST',
        url: '{{route('backend.qrcode.checkStart')}}',
        data: {start: parseInt($(this).val()), company_id: $('#company_id').val()},
        dataType: 'json',
        success: function(resp) {
          if(resp.msg != '') {
            $('#start').val('').focus();
          }
          $('#spanstart').text(resp.msg);
        }
      });
    }
  });
  $('#end').change(function() {
    if($('#start').val() == '') {
      $('#end').val('');
      $('#start').focus();
      toastr.error('Bạn chưa nhập serial đầu', 'Thông báo');
      return false;
    } else if(parseInt($('#start').val()) > parseInt($(this).val())) {
      $(this).val('').focus();
      $('#spanend').text('Serial cuối phải lớn hơn hoặc bằng serial đầu');
    } else {
      $('#spanend').text('');
    }
  });
</script>
@endsection