$(function() {
    
    var app_url = $('meta[name="website"]').attr('content');

    $('#permission-list-tbl').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          url: app_url + 'admin/permissions/get-list',
          type: 'post',
        },
        ordering: false,
        columns: [
            {data: 'DT_Row_Index', name: 'DT_Row_Index', 'class':'text-center'},
            {data: 'display_name', name: 'display_name', width: '150px'},
            {data: 'name', name: 'name', width: '150px'},
            {data: 'description', name: 'description'},
            {data: 'created_at', name: 'created_at', 'class':'text-center'},
        ]
    });
});