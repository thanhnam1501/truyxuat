@extends('layouts.master_user')
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
   <div class="">
    <table id="user-list" class="table table-striped responsive-utilities jambo_table">
        <thead>
            <tr class="headings">
                <th>
                    #
                </th>
                <th>Tên người dùng </th>
                <th>Nội dung</th>
                <th>Thời gian</th>
            </tr>
        </thead>


    </table>
</div>

@endsection
@section('script')
<script>
    $(function() {
        $('#user-list').DataTable({
            processing: false,
            serverSide: true,
            order: [],
            searching: true,
            ajax: '{!! route('user.history.getList') !!}',
            pageLength: 30,
            lengthMenu: [[30, 50, 100, 200, 500], [30, 50, 100, 200, 500]],
            columns: [
            {data: 'DT_Row_Index', name: 'DT_Row_Index', 'class':'dt-center',},
            {data: 'user_name', name: 'user_name',},
            {data: 'content', name: 'content'},
            {data: 'created_at', name: 'created_at',},
            ]
        });

    });

</script>


@endsection