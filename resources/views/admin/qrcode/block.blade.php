@extends('layouts.master')
@section('title', 'Block QRCode')
@section('content')
    {{-- {{dd($block)}} --}}
    <link rel="stylesheet" href="{{asset('public/js/datatables/dataTables.bootstrap.css')}}">
    <section class="content-header">
        <h1>
            Chia khối QRCode
        </h1>
    </section>
    <input type="hidden" id="block_start" value="{{$block->start}}">
    <input type="hidden" id="block_end" value="{{$block->end}}">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                {{--  START --}}
                <input type="hidden" id="url-add-winning" value="{{-- {{route('backend.winning.vAdd')}} --}}">
                <form id="form-saveBlockProduct" action="{{route('qrcode.saveBlockProduct')}}" method="POST">
                    {{csrf_field()}}
                    <input type="hidden" id="product-company-id" name="company_id" value="{{$block->company_id}}">
                    <input type="hidden" id="product-guid" name="guid" value="{{$block->id}}">
                    <div class="">
                        <div class="box-header with-border">
                            <h3 class="text-center">Danh sách sản phẩm đã chia</h3>
                            <h3 class="text-center help">{{$block->company->name}} | GUID: {{$block->id}} | Serial:
                                [{{$block->start}}-{{$block->end}}]</h3>
                            <p style="color: #f00;">{{$errors->first()}}</p>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                            class="fa fa-minus"></i></button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <table id="block-product" class="table table-bordered table-striped dataTable"
                                           role="grid" aria-describedby="example2_info">
                                        <thead>
                                        <tr role="row">
                                            <th class="text-center" width="25%">Tên sản phẩm</th>
                                            <th class="text-center" width="12%">Serial đầu</th>
                                            <th class="text-center" width="12%">Số lượng</th>
                                            <th class="text-center" width="12%">Serial cuối</th>
                                            <th class="text-center" width="12%">Thời hạn tem</th>
                                            <th class="text-center" width="12%">Giới hạn quét</th>
                                            <th class="text-center" width="15%">Tùy chọn</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php
                                            $total = 0;
                                            $residual_product = [];
                                            if(count($listProduct) == 0) $residual_product = [[$block->start,$block->end]];
                                        @endphp
                                        @foreach($listProduct as $key => $product)
                                            @php
                                                $start = trim($product->start) != '' ? trim($product->start) : 0;
                                                $end = trim($product->end) != '' ? trim($product->end) : 0;
                                                if($key == 0 && $start > $block->start) {
                                                  $residual_product[] = [$block->start,($start - 1)];
                                                }
                                                if($key > 0 && ($start-1) > $listProduct[$key-1]->end) {
                                                  $residual_product[] = [($listProduct[$key-1]->end + 1), ($start - 1)];
                                                }
                                                if($key == (count($listProduct) - 1) && $end < $block->end) {
                                                  $residual_product[] = [($end + 1), $block->end];
                                                }

                                                if ($product->amount != '') {
                                                  $total += $product->amount;
                                                }
                                            @endphp
                                            <tr role="row" id="product-{{$product->id}}"
                                                class="{{$key%2 == 0 ? 'even' : 'odd'}}">

                                                <td class="text-left">{{$product->name}}</td>
                                                <td><input type="number" name="product[{{$product->id}}][start]"
                                                           class="form-control product-start"
                                                           value="{{$product->start}}"
                                                           onchange="checkResidual(this,'product', 'start')"
                                                           onkeyup="changeInputBlock(this, 'product', 'start')"></td>
                                                <td><input type="number" name="product[{{$product->id}}][amount]"
                                                           class="form-control product-amount"
                                                           value="{{$product->amount}}"
                                                           onchange="checkResidual(this,'product', 'amount')"
                                                           onkeyup="changeInputBlock(this, 'product', 'amount')"></td>
                                                <td><input type="number" name="product[{{$product->id}}][end]"
                                                           class="form-control product-end" value="{{$product->end}}"
                                                           onchange="checkResidual(this,'product', 'end')"
                                                           onkeyup="changeInputBlock(this, 'product', 'end')"></td>
                                                <td>
                                                    <select class="form-control"
                                                            id="protected_time_of_tem_{{$product->id}}"
                                                            name="product[{{$product->id}}][protected_time_of_tem]">
                                                        @for($i=1;$i<100;$i++)
                                                            <option value="{{$i}}" {{$product->protected_time_of_tem == $i ? 'selected' : ''}}>{{$i.' tháng'}}</option>
                                                        @endfor
                                                    </select>
                                                </td>
                                                <td>
                                                    <select class="form-control" id="time_scans_{{$product->id}}"
                                                            name="product[{{$product->id}}][time_scans]">
                                                        @for($i=0;$i<100;$i++)
                                                            <option value="{{$i}}" {{$product->time_scans == $i ? 'selected' : ''}}>{{$i.' lần'}}</option>
                                                        @endfor
                                                    </select>
                                                </td>
                                                <td class="text-center">

                                                    {{--  <a data-tooltip="tooltip" title="Chưa kích hoạt" href="javascript:;" onclick="activated('products->id')" class="btn btn-default btn-xs"><i class="fa fa-times"></i></a> --}}
                                                    <a href="javascript:;" class="btn btn-info" title="Type hiển thị"
                                                       onclick="changeType({{$product->qrcode_products_id}})">Kiểu hiển
                                                        thị {{$product->type}}</a>
                                                    <a href="javascript: void(0);"
                                                       class="btn btn-danger deleteItemBlock" title="Xóa"><i
                                                                class="fa fa-fw fa-remove"></i></a>

                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        @php
                                            if(count($residual_product) > 0) {
                                              foreach($residual_product as $key => $item) {
                                                $residual_product[$key] = '['.implode('-', $item).']';
                                              }
                                            }
                                        @endphp
                                        <tr>
                                            <th rowspan="1" colspan="2" class="text-right">Các khối serial chưa dùng:
                                            </th>
                                            <td id="residual_product"
                                                colspan="8">{{implode(',',$residual_product)}}</td>
                                        </tr>
                                        <tr>
                                            <th rowspan="1" colspan="2" class="text-right">Tổng số tem đã chia:</th>
                                            <td id="total-blockproduct" rowspan="1" colspan="6">{{$total}}</td>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer text-center">
                            <button type="button" class="btn btn-primary " onclick="saveBlockProduct()">Lưu sản phẩm
                            </button>
                            {{-- <button type="button" class="btn btn-primary " onclick="blockAddForm(2)">Thêm sản phẩm mới</button> --}}
                            <a class="btn btn-primary " href="#modal-id" data-toggle="modal">Thêm sản phẩm mới</a>
                        </div>
                    </div>
                </form>
                {{--  END --}}
            </div>
        </div>
    </section>
    <input type="hidden" id="getFormUrl" value="{{url('admin/qrcode/getForm')}}">
    <input type="hidden" id="partner-company-id" value="{{$block->company_id}}">
    <input type="hidden" id="partner-guid" value="{{$block->id}}">


    <div class="modal fade" id="modal-id">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Thêm sản phẩm vào khối</h4>
                </div>
                <div class="modal-body">
                    <form id="form-product" action="" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="">
                            <div class="box-header with-border">
                                <h3 class="help">Lưu ý: những trường có (<span style="color: #f00">*</span>) là bắt
                                    buộc.</h3>
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                                class="fa fa-minus"></i></button>
                                </div>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-9">
                                        <div class="form-group {{$errors->has('company_id') ? 'has-error' : ''}}">


                                            <label class="required" for="company_id">Chọn sản phẩm <span
                                                        style="color: #f00">*</span></label>
                                            <select class="form-control" id="addProduct" name="addProduct">
                                                <option value="">--Chọn sản phẩm--</option>
                                                @foreach($listProductAdd as $item)
                                                    <option value="{{$item->id}}" {{(old('company_id') == $item->id || (isset($company_id) && $company_id == $item->id)) ? 'selected' : '' }}>{{$item->name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="help-block">{{$errors->first("company_id")}}</span>
                                        </div>

                                        <!-- /.form-group -->
                                        <input type="hidden" name="addProduct_company_id" id="addProduct_company_id"
                                               value="{{$block->company_id}}">
                                        <input type="hidden" name="addProduct_id" id="addProduct_id"
                                               value="{{$block->id}}">
                                        <!-- /.form-group -->
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->
                            </div>
                            <!-- /.box-body -->

                            <!-- /.box-body -->

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" data-dismiss="">Thêm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- begin modal add -->


        @endsection
        @section('script')
            <script type="text/javascript" src="{{asset('public/js/block.page.js')}}"></script>
            <script>
                function changeType(id) {
                    $.ajax({
                        url: '{{ route('qrcode.changeType') }}',
                        type: 'POST',
                        data: {id: id},

                        success: function success(res) {
                            window.location.reload();
                        },
                        error: function error(xhr, ajaxOptions, thrownError) {

                            toastr.error("Lỗi! Không thể sửa! <br>Vui lòng thử lại hoặc liên lạc với IT");
                        }

                    });
                }
            </script>

            <script type="text/javascript">
                $("#form-product").submit(function(e){
                    e.preventDefault();
                    var id = $('#addProduct_id').val();
                    var company_id = $('#addProduct_company_id').val();
                    var product_id = $('#addProduct').val();
                    $.ajax({
                        url: '{{route('qrcode.addProduct')}}',
                        type: 'POST',
                        dataType: 'JSON',
                        data: {
                            id: id,
                            company_id: company_id,
                            product_id:product_id
                        },
                        success : function(res) {
                            var data = res.data;
                            window.location.reload();
                            toastr.success('Sửa thành công !');
                        }
                    })
                });
            </script>

@endsection

