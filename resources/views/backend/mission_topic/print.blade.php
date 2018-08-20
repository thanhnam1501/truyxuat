<!-- BEGIN: main -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" href="{{asset('css/A4style.css')}}" />
  <!-- Latest compiled and minified CSS & JS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
  <link rel="icon" href="{{asset('img/icon.png')}}" type="image/x-icon" />
  <script src="https://code.jquery.com/jquery.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
  <title>2075 | Chương trình phát triển thị trường</title>
</head>
<style>
  ol {
    list-style: none;
  }

  p {
    margin: 8px 0 8px 0;
  }
</style>
<!--onload="window.print()"-->

<body onload="window.print()">
  <div class="book">
    <div class="page">
      <p align="right">
        <strong>Mẫu A1-ĐXTN</strong>
      </p>
      <p align="right">
        03/2017/TT-BKHCN
      </p>
      <p align="center">
        <strong>PHIẾU ĐỀ XUẤT ĐẶT HÀNG NHIỆM VỤ </strong>
      </p>
      <p align="center">
        <strong>KHOA HỌC VÀ CÔNG NGHỆ CẤP QUỐC GIA </strong>
      </p>
      <p align="center">
        <em>(Dùng cho đề tài hoặc đề án)</em>
      </p>
      <p align="center">
        <em></em>
      </p>
      @if (isset($data) && !empty($data))
          @foreach ($data as $key => $value)
         <div class='form-group'>
           @if ($value["column"] == "expected_effect")
             <p><b>{{ $value["order"] }}. {!! $value["label"] !!}</b></p>
           @elseif ($value['column'] != "evaluation_form_01" && $value['column'] != "evaluation_form_02")
             <p><b>{{ $value["order"] }}. {!! $value["label"] !!}</b></p>
             <p class='text_value'>{{ $value["value"] }}</p>
           @endif
         </div>
       @endforeach
      @endif
      <table border="0" cellspacing="0" cellpadding="0" style="width: 100%">
        <tbody>
          <tr>
            <td width="459" valign="top">
              <p align="right">
                <em> </em>
                <em>..., ngày {{(!empty($date))?$date['d']:"....."}} tháng {{(!empty($date))?$date['m']:"....."}} năm {{(!empty($date))?$date['y']:"20..."}}</em>
                <strong></strong>
              </p>
              <p align="right">
                <strong></strong>
              </p>
              <p align="right">
                <strong>TỔ CHỨC, CÁ NHÂN ĐỀ XUẤT </strong>
              </p>
              <p align="right">
                <em>(Họ, tên và chữ ký - đóng dấu đối với tổ chức)</em>
                <strong><em></em></strong>
              </p>
              <p align="center">
                <strong><em></em></strong>
              </p>
            </td>
          </tr>
          <tr>
            <td width="459" valign="top">
              <p align="right">
                <em></em>
              </p>
            </td>
          </tr>
        </tbody>
      </table>
      <br><br><br><br><br><br><br><br>
        Ghi chú: <em> Phiếu đề xuất được trình bày không quá 4 trang giấy khổ A4.</em>
      </p>
    </div>
  </div>
  </div>
