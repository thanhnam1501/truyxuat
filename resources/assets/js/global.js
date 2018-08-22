$(document).ready(function() {
    $("body").tooltip({ selector: '[data-tooltip=tooltip]' });
});

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

var app_url = $('meta[name="website"]').attr('content');

function IsNull(obj)
{
  var is;
  if (obj instanceof jQuery)
      is = obj.length <= 0;
  else
      is = obj === null || typeof obj === 'undefined' || obj == "";

  return is;

}

/* start custom datatable */
$.extend( true, $.fn.dataTable.defaults, {
  "language": {
    "responsive":     true,
    "emptyTable":     "Không có bản ghi nào",
    "search":         "Tìm kiếm:",
    "info":           "Hiển thị từ bản ghi số _START_ đến _END_ trong _TOTAL_ bản ghi",
    "infoEmpty":      "Hiển thị 0 đến 0 trong 0 bản ghi",
    "zeroRecords":    "Không tìm thấy bản ghi nào",
    "loadingRecords": "Đang tải...",
    "lengthMenu": '<select class="form-control input-inline">'+
    '<option value="30" selected>30</option>'+
    '<option value="50">50</option>'+
    '<option value="100">100</option>'+
    '<option value="200">200</option>'+
    '<option value="500">500</option>'+
    '</select> bản ghi',
    "paginate": {
        "first":      "Trang đầu",
        "last":       "Trang cuối",
        "next":       "Trang tiếp",
        "previous":   "Trang trước"
    },
  },
  "pageLength": 30,
  "lengthMenu": [[30, 50, 100, 200, 500], [30, 50, 100, 200, 500]],
});

/* End custom datatable */

/* Start additional method jquery validate */
/* jquery validate min with autoNumeric */
/* rule name: minCustom */
jQuery.validator.addMethod("minCustom", function(value, element, params) {

  value = parseInt(value.replace(/,/g,'').replace('đ',''));

  params = parseInt(params.replace(/,/g,'').replace('đ',''));

  return this.optional(element) || value >= params;
});

$.validator.addMethod('filesize', function (value, element, param) {
  return this.optional(element) || (element.files[0].size <= (param*1000000))
});

 $(document).ready(function () {
       $(document).ajaxStart(function () {
         $("#cover").show();
     }).ajaxStop(function () {
         $("#cover").hide();
     });
  });

jQuery.validator.addMethod("requiredSelect", function(value, element, params) {

  var failed = false;

  if (value != 0 && value != 1) {
      failed = true;
  }

  return this.optional(element) || failed == false;
});

jQuery.validator.addMethod("requiredFile", function(value, element, params) {

  var failed = false;

  if ($(element).data('exists') == undefined || $(element).data('exists') != 1) {

      if (value == "" || value == null) {
        failed = true;
      }

  } else {

    failed = false;
  }
  
  return failed == false;
});

jQuery.validator.addMethod("requiredSelectDyn", function(value, element, params) {

  return this.optional(element) || value != params;
});

jQuery.validator.setDefaults({
    ignore: "",
});
/* End additional method jquery validate */
