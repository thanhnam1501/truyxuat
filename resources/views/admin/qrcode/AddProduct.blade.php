
<form id="form-product" action="" method="POST" enctype="multipart/form-data">
	{{csrf_field()}}
	<div class="">
	    <div class="box-header with-border">
	      <h3 class="help">Lưu ý: những trường có (<span style="color: #f00">*</span>) là bắt buộc.</h3>
	      <div class="box-tools pull-right">
	        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
	      </div>
	    </div>
	    <!-- /.box-header -->
	    <div class="box-body">
	      	<div class="row">
		        <div class="col-md-9">
			    	<div class="form-group {{$errors->has('company_id') ? 'has-error' : ''}}">
			            <label class="required" for="company_id">Chọn sản phẩm <span style="color: #f00">*</span></label>
			            <select class="form-control" id="company_id" name="company_id">
			            	<option value="">--Chọn sản phẩm--</option>
			                @foreach($listProduct as $item)
			                <option value="{{$item->id}}" {{(old('company_id') == $item->id || (isset($company_id) && $company_id == $item->id)) ? 'selected' : '' }}>{{$item->name}}</option>
			                @endforeach
			            </select>
			            <span class="help-block">{{$errors->first("company_id")}}</span>
			      	</div>
		      		
			      	<!-- /.form-group -->
		          
	                <!-- /.form-group -->
		        </div>
		        <!-- /.col -->
		  	</div>
	  	<!-- /.row -->
		</div>
	    <!-- /.box-body -->
	 
	     <!-- /.box-body -->
	    <div class="box-footer text-center">
        	<button type="submit" class="btn btn-primary mrg-10">Save</button>
        	@if(isset($company) && $company->id != '')
        	<button type="button" class="btn btn-primary mrg-10" id="close-popup-btn">Close</button>
        	@else
        	<button type="reset" class="btn btn-default mrg-10">Cancel</button>
        	@endif
      	</div>
  	</div>
</form>
