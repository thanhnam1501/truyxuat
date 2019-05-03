@extends('layouts.master_user')
@section('content')
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <style>
        .slidecontainer {
            width: 100%;
        }

        .slider {
            -webkit-appearance: none;
            width: 100%;
            height: 15px;
            border-radius: 5px;
            background: #d3d3d3;
            outline: none;
            opacity: 0.7;
            -webkit-transition: .2s;
            transition: opacity .2s;
        }

        .slider:hover {
            opacity: 1;
        }

        .slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 25px;
            height: 25px;
            border-radius: 50%;
            background: #4CAF50;
            cursor: pointer;
        }

        .slider::-moz-range-thumb {
            width: 25px;
            height: 25px;
            border-radius: 50%;
            background: #4CAF50;
            cursor: pointer;
        }

        #qr-code {
            clip: rect(0px, 60px, 200px, 0px);
        }
    </style>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 x_panel">
            <div class="card mb-3">
                <div class="card-header">
                    <h3><i class="fa fa-check-square-o"></i> Cập nhật thông tin sản phẩm</h3>
                </div>

                <div class="card-body">

                    <form action="{{route('user.product.update')}}" method="POST" class="form-horizontal" role="form"
                          enctype="multipart/form-data">
                        <input style="display: none" type="hidden" id="id" name="id" value="{{$data->id}}">
                        <div class="form-group">
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
                                @if($data->image)
                                    <img style="width: 50%;margin-left: 20%; border: solid 1px black"
                                         src="{{asset('public/'.$data->image)}}" alt="">
                                @else
                                    <img style="width: 50%;margin-left: 20%; border: solid 1px black"
                                         src="{{ asset('public/image/noimage.png')}}" alt="">
                                @endif
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">

                                <label for="exampleInputEmail1">Tên sản phẩm</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{$data->name}}"
                                       placeholder="Tên sản phẩm" required>
                                {{-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}

                                <br>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Các bước cập nhật</label>
                                    <input type="number" class="form-control" id="node" name="node"
                                           value="{{$data->node}}" disabled>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Liên kết tĩnh</label>
                                    <input type="text" class="form-control" id="slug" name="slug"
                                           value="{{$data->slug}}">
                                </div>
                                <a onclick="window.open('{{$urlSlug}}')">{{$urlSlug}}</a>


                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
                                <img style="margin-left: 20%" src="data:image/png;base64, {!! base64_encode(QrCode::format('png')
							->size(200)
							->generate($url)) !!} ">
                                <br>
                                <a class="btn btn-primary" style="margin: 0 auto;" data-toggle="modal"
                                   href='#addSpProduct'>In
                                    QR-Code</a>

                            </div>
                        </div>

                        {{-- <div class="form-group">
                            <label for="exampleInputEmail1">Nhân viên quản lý</label>
                            <select class="form-control" name="user_id" id="user_id" value="{{$data->user_id}}" required>

                                @foreach($user as $user)
                                <option @if($data->user_id == $user->id) selected @endif value="{{$user->id}}">{{$user->name}}</option>
                                @endforeach
                            </select>
                        </div> --}}

                        <div class="form-group">
                            <label>Link sản phẩm <span style="color: red">(Nếu muốn chuyển sang trang web thông tin sản phẩm thì điền link vào đây)</span></label>
                            <input type="text" name="link_product" value="{{$data->link_product}}"
                                   class="form-control ">
                        </div>

                        <div class="form-group">
                            <div class="clearfix"></div>
                            <label>Mô tả ngắn sản phẩm</label>
                            <textarea name="sort_content" value="{{$data->sort_content}}" class="form-control "
                                      id="editor1">{{$data->sort_content}}</textarea>
                        </div>

                        <div class="form-group">
                            <label>Mô tả</label>
                            <textarea name="content" value="{{$data->content}}" class="form-control  "
                                      id="editor2">{{$data->content}}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Ảnh sản phẩm</label>
                            <input type="file" id="image_update" name="image_update">

                            {{-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
                        </div>
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </form>

                </div>
            </div><!-- end card-->
        </div>


        @for($i=0; $i <= $data->node ; $i++)
            @foreach($nodes as $key => $value)
                @if($i == $key)
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 x_panel"
                         style="border-color:red !important;">
                        <div class="card mb-3">
                            <div class="card-header">


                                <div role="tabpanel" class="tab-pane @if($i==0)active @endif fade in"
                                     id="tab_content{{$i}}" aria-labelledby="home-tab">
                                    @if($value->status == 1)
                                        <a data-tooltip="tooltip" title="Đã kích hoạt" href="javascript:;"
                                           onclick="activatedNode({{$value->id}})" class="btn btn-success ">
                                            <h3>
                                                <i class="fa fa-check-square-o"></i> {{$value->name}}
                                            </h3>
                                        </a>
                                    @else
                                        <a data-tooltip="tooltip" title="Đã kích hoạt" href="javascript:;"
                                           onclick="activatedNode({{$value->id}})" class="btn btn-danger "><h3><i
                                                        class="fa fa-check-square-o"></i> {{$value->name}}</h3></a>
                                    @endif

                                </div>
                            </div>
                            @if ($errors->any())
                                <div class="alert alert-danger">{{ implode('', $errors->all(':message')) }}</div>
                            @endif
                            <br>
                            <div class="clearfix"></div>
                            <div class="card-body">
                                <form action="{{route('user.node.updateById')}}" method="POST" class="form-horizontal"
                                      role="form" enctype="multipart/form-data" id="formUpdate{{$i}}">

                                    <div class="form-group">
                                        <label>Tên bước cập nhật</label>
                                        <input type="text" class="form-control" id="name{{$i}}" name="name"
                                               value="{{$value->name}}" placeholder="Họ và Tên" required>
                                        <input type="hidden" class="form-control" id="id{{$i}}" name="id"
                                               value="{{$value->id}}" placeholder="Họ và Tên" required>
                                        <input name="_method" type="hidden" value="PATCH">
                                    </div>

                                    <div class="form-group">
                                        <label>Mô tả</label>
                                        <textarea name="content" class="form-control " id="editor{{$i + 3}}">
                                            {{$value->content}}
                                        </textarea>
                                    </div>
                                    @method('post')
                                    @csrf


                                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                                </form>


                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        @endfor

        <div class="modal fade" id="modal-id">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Vị trí đặt QR-Code</h4>
                    </div>
                    <div id="printQrcode" class="modal-body container" style="margin: 0 0 0 0;padding: 0 0 0 0; ">
                        <form action="{{route('getViewPrint')}}" method="POST" id="formPrint" style="">
                            <div class="slidecontainer">
                                <p>Value: <span id="demo">%</span></p>
                                <input type="range" min="0" max="65" value="33" name="stampWidth" class="slider"
                                       id="stampWidth" onchange="myFunction()">
                            </div>

                            <div id="view-print"
                                 style="width: 294px;height: 204px; border: 1px solid black;margin-right: auto;margin-left: auto;">
                                <img id="qr-code" style="border: 1px solid black;margin-left: 33%;margin-top: 15%; "
                                     src="data:image/png;base64, {!! base64_encode(QrCode::format('png')
							->size(102)
							->generate($url)) !!} ">
                            </div>

                            <div class="slidecontainer">
                                <p>Value: <span id="demo2">%</span></p>
                                <input type="range" min="0" max="34" value="17" name="stampHeight" class="slider"
                                       id="stampHeight" onchange="myFunction2()">
                            </div>
                            <div>
                                <input type="hidden" name="url" value="{{$url}}">
                            </div>
                            {{ csrf_field() }}
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" form="formPrint" value="submit">In ngay</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div id="addSpProduct" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Thông tin in QR-Code</h4>
                    </div>
                    <div class="modal-body">
                        <form action="" method="POST" class="form-horizontal" role="form" enctype="multipart/form-data"
                              id="addSpProductForm" >
                            <div class="form-group">
                                @csrf
                                @method('POST')
                                <input type="hidden" id="id" value="{{$data->id}}" name="product_id" readonly required>
                                <input type="hidden" id="company_id" value="{{$data->company_id}}" name="company_id"
                                       required readonly>
                                <input type="hidden" id="user_id" value="{{Auth::guard('profile')->user()->id}}"
                                       name="user_id" required readonly>
                            </div>
                            <div class="form-group">
                                <label for="">Tên sản phẩm</label>
                                <input type="text" class="form-control" id="nameProduct" name="nameProduct"
                                       value="{{$data->name}}" readonly required>
                            </div>
                            <div class="form-group">
                                <label for="">Tên lần in</label>
                                <input type="text" class="form-control" id="namePrint" name="namePrint" required>
                            </div>
                            <div class="form-group">
                                <label for="">Ngày thu hoạch</label>
                                <input type="date" class="form-control" id="harvest_date" name="harvest_date" required>
                            </div>
                            <div class="form-group">
                                <label for="">Ngày hết hạn</label>
                                <input type="date" class="form-control" id="expiration_date" name="expiration_date" required>
                            </div>
                            <div class="form-group">
                                <label for="">Số lượng in</label>
                                <input type="number" min="0" class="form-control" name="amount" required>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-info" id="addSpProductSubmit">Lưu</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function activatedNode(id) {
            $.ajax({
                url: '{{ route('user.node.activated') }}',
                type: 'POST',
                data: {id: id},

                success: function success(res) {
                    if (res.node_status == 0) {
                        toastr.success('Bước cập nhật đã được mở khóa thành công!');
                        setTimeout(function () {
                            location.reload();
                        }, 3000);
                    } else {
                        toastr.error('Bước cập nhật đã bị khóa!');
                        setTimeout(function () {
                            location.reload();
                        }, 3000);
                    }
                },
                error: function error(xhr, ajaxOptions, thrownError) {
                    toastr.error("Lỗi! Không thể sửa! <br>Vui lòng thử lại hoặc liên lạc với IT");
                }
            })
        };
    </script>

    <script>
        function printDiv() {

            var divToPrint = document.getElementById('DivIdToPrint');

            var newWin = window.open('', 'Print-Window');

            newWin.document.open();

            newWin.document.write('<html><body onload="window.print()">' + printQrcode.innerHTML + '</body></html>');

            newWin.document.close();

            setTimeout(function () {
                newWin.close();
            }, 10);

        }
    </script>

    <script>
        var slider = document.getElementById("stampWidth");
        var output = document.getElementById("demo");
        output.innerHTML = slider.value;

        slider.oninput = function () {
            output.innerHTML = this.value;
        }
    </script>
    <script>
        var slider2 = document.getElementById("stampHeight");
        var output2 = document.getElementById("demo2");
        output2.innerHTML = slider2.value;

        slider2.oninput = function () {
            output2.innerHTML = this.value;
        }
    </script>

    <script>
        function testView() {
            var x = document.getElementById("stampWidth").value;
            var y = document.getElementById("stampHeight").value;
            document.getElementById("view-print").innerHTML = '<img style="border: 1px solid black;margin-left: ' + x + '%;margin-top: ' + y + '%;" src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(102)->generate($url)) !!} ">';

        }
    </script>

    <script>
        function myFunction() {
            var x = document.getElementById("stampWidth").value;
            var y = document.getElementById("stampHeight").value;
            document.getElementById("view-print").innerHTML = '<img style="border: 1px solid black;margin-left: ' + x + '%;margin-top: ' + y + '%;" src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(102)->generate($url)) !!} ">';
        }
    </script>

    <script>
        function myFunction2() {
            var y = document.getElementById("stampHeight").value;
            var x = document.getElementById("stampWidth").value;
            document.getElementById("view-print").innerHTML = '<img style="border: 1px solid black;margin-left: ' + x + '%;margin-top: ' + y + '%;" src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(102)->generate($url)) !!} ">';
        }
    </script>

    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $(function () {
                $('#addSpProductForm').on('submit', function (e) {
                    e.preventDefault();
                    $.ajax({
                        url: "{{ route('sp.product.store') }}",        // Only URL changed from your code
                        type: 'POST',
                        dataType: 'json',
                        data: $('#addSpProductForm').serialize(),
                        success: function (res) {
                            var url = res.data;
                            $('#addSpProduct').modal('hide');
                            $('#modal-id').modal('show');
                        }
                    });
                });
            });
        });

    </script>
@endsection