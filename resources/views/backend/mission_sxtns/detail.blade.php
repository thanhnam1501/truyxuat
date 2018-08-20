@extends('backend.layouts.master-company')
@section('header')
<link rel="stylesheet" type="text/css" href="{{mix('build/css/mission-sxtns.css')}}">

 <title>NATEC</title>
@endsection

@section('breadcrumb')
  <li class="">Danh sách nhiệm vụ</li>
  <li><a href="{{ route('mission-sxtn.index') }}">Dự án SXTN</a></li>
  <li class="active">Xem chi tiết</li>
@endsection

@section('content')
<div class="panel panel-default">
    <div class="panel-body tab-content">
    	<div class="row">
      		<div class="col-md-12">
	          <center>
	            <br>
	            <h3>PHIẾU ĐỀ XUẤT ĐẶT HÀNG NHIỆM VỤ</h3>
	            <h3>KHOA HỌC VÀ CÔNG NGHỆ CẤP QUỐC GIA</h3>
	            <h4><i>(Dùng cho dự án SXTN)</i></h4>
	          </center>
	        </div>
	    </div>
	    <br>
	    @if (!empty($mission_sxtn_detail) && $mission_sxtn_detail != null)
	    @foreach ($mission_sxtn_detail as $mission_sxtn)
	    	<div class="row">
		    	<div class="col-md-12">
		    		<h5><b>{{$mission_sxtn->order}}. {!!$mission_sxtn->label!!}</b></h5>

		    	</div>
		    	<div class="col-md-12">
		    		@if ($mission_sxtn->column == 'expected_funding')
		    			<h5>{{($mission_sxtn->value != '') ? number_format(Crypt::decrypt($mission_sxtn->value)) : ''}} VNĐ</h5>
		    		@elseif($mission_sxtn->column == 'evaluation_form_01' || $mission_sxtn->column == 'evaluation_form_02')
		    			<h5></h5>
		    		@else
		    			<h5>{!!$mission_sxtn->value!!}</h5>
		    		@endif
		    	</div>
		    </div>
		    <br>
	    @endforeach
	    @endif
	    <br>
	    <table border='0' cellspacing='0' cellpadding='0' style='width: '100%' align="right">
	      <tbody>
	        <tr>
	          <td width='300' valign='top'>
	            <p align='center'>
	              <em></em>
	              <h5>
	              	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	              	<em>..., ngày ... tháng... năm 20..</em> …</h5> 
	              <strong></strong>
	            </p>
	            <p align='center'>
	              <strong></strong>
	            </p>
	            <p align='center'>
	              <h4>
	              	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	              	TỔ CHỨC, CÁ NHÂN ĐỀ XUẤT </h4>
	            </p>
	            <p align='center'>
	              <h5><em>(Họ, tên và chữ ký - đóng dấu đối với tổ chức)</em></h5>
	              <strong><em></em></strong>
	            </p>
	            <p align='center'>
	              <strong><em></em></strong>
	            </p>
	          </td>
	        </tr>
	        <tr>
	          <td width="300" valign="top">
	            <p align="right">
	              <em></em>
	            </p>
	          </td>
	        </tr>
	      </tbody>
	    </table>
	</div>

	<div class="panel-footer">  
		<div class="col-md-8">
	        <h5><span class="error">(*)</span> Ghi chú: <br>- <i>Phiếu đề xuất được trình bày không quá 6 trang giấy khổ A4</i> <br>- <i>Các mục <span class="error">(*)</span> là bắt buộc</i></h5>
	      </div>   
		<div class=" col-md-4">                                                               
			<div class="pull-right">
		
	    		<a target="_blank" href="{{ route('mission-sxtn.print', $key) }}" class="btn btn-success" type="submit"><span class="fa fa-print"></span> &nbsp;in nhiệm vụ</a>
	    	</div>
	    </div>
	</div> 
</div>
@endsection

@section('footer')

@endsection