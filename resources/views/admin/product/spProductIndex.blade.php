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
    </div>

    <div class="">
        <table id="company-list" class="table table-striped responsive-utilities jambo_table">
            <thead>
            <tr class="headings">
                <th>
                    #
                </th>
                <th>Tên sản phẩm</th>
                <th>Ngày thu hoạch</th>
                <th>Ngày hết hạn</th>
                <th>Ngày tạo</th>
                <th>action</th>
            </tr>
            </thead>
        </table>
    </div>

@endsection
@section('script')
    <script>
        $(function () {
            $('#company-list').DataTable({
                processing: false,
                serverSide: true,
                order: [],
                ajax: {
                    "url": '{!! route('admin.sp.product.getlist') !!}',
                    "data": {"id": {{$id}} }
                },
                pageLength: 30,
                lengthMenu: [[30, 50, 100, 200, 500], [30, 50, 100, 200, 500]],
                columns: [
                    {data: 'DT_Row_Index', name: 'DT_Row_Index', 'class': 'dt-center'},
                    {data: 'product_name', name: 'product_name'},
                    {data: 'harvest_date', name: 'harvest_date'},
                    {data: 'expiration_date', name: 'expiration_date'},
                    {data: 'created_at', name: 'created_at', orderable: false, searchable: false},
                    {data: 'action', name: 'action'},
                ]
            });

        });

    </script>
@endsection