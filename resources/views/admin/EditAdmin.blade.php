@extends('layouts.master')
@section('content')
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <div class="card mb-3">
            <div class="card-header">
                <h3><i class="fa fa-check-square-o"></i> Cập nhật quản trị viên</h3>

            </div>
            @if ($errors->any())
                <div class="alert alert-danger">{{ implode('', $errors->all(':message')) }}</div>
            @endif
            <br>
            <div class="clearfix"></div>
            <div class="card-body">
                <form action="{{route('user.update')}}" method="POST">

                    <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control has-feedback-left" id="name" name="name"
                               value="{{$data->name}}" placeholder="Họ và Tên" required>
                        <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                        <input type="email" class="form-control has-feedback-left" id="email" name="email"
                               value="{{$data->email}}" placeholder="Email" readonly>
                        <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                        <input type="phone" class="form-control has-feedback-left" id="mobile" name="mobile"
                               value="{{$data->mobile}}" placeholder="Số điện thoại" required>
                        <span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                        <select class="form-control has-feedback-left" name="company_id" id="company_id">
                            @foreach($companies as $company)
                                <option @if($data->company_id == $company->id) selected
                                        @endif value="{{$company->id}}">{{$company->name}}</option>
                            @endforeach
                        </select>
                        <span class="fa fa-university form-control-feedback left" aria-hidden="true"></span>
                        {{-- <input type="s" class="form-control has-feedback-left" id="company_id" name="company_id" placeholder="Số điện thoại" required>
                        <span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span> --}}
                    </div>
                    {{ csrf_field() }}

                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </form>

            </div>
        </div>
    </div>

    <div class="clearfix"></div>

    <div style="margin-top: 3%">
        <div class="card-header">
            Danh sách công ty quản lý

        </div>
        <div class="">
            <table id="user-list" class="table table-striped responsive-utilities jambo_table">
                <thead>
                <tr class="headings">
                    <th>
                        #
                    </th>
                    <th>Tên Công ty</th>
                    <th>Ngày tạo</th>
                    <th>Action</th>
                </tr>
                </thead>
            </table>
        </div>
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
        $(function () {
            $('#user-list').DataTable({
                processing: false,
                serverSide: true,
                order: [],
                ajax: {
                    "url": '{{route('company.getListCompanyUser')}}',
                    "data": {
                        "user_id": {{$data->id}}
                    }
                },
                pageLength: 30,
                ordering: false,
                lengthMenu: [[30, 50, 100, 200, 500], [30, 50, 100, 200, 500]],
                columns: [
                    {data: 'DT_Row_Index', name: 'DT_Row_Index', 'class': 'dt-center', searchable: false},
                    {data: 'name', name: 'name'},
                    {data: 'created_at', name: 'created_at', orderable: false, searchable: false},
                    {data: 'action', name: 'action', searchable: false},
                ]
            });

        });

    </script>

    <script>
        function deleteCompanyUser(id) {

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
                            url: '{{ route('company.deleteCompanyUser') }}',
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
                                //toastr.error(thrownError);
                                toastr.error("Lỗi! Không thể đăng ký! <br>Vui lòng thử lại hoặc liên lạc với IT");
                            }

                        });
                    }
                });
        }
    </script>
@endsection