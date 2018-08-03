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