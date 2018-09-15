<!DOCTYPE html>
<html lang="en" dir="ltr">
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
  <body onload="window.print()">
    <div class="page">
      <br><br>
      <p align="right">
        <strong>Mẫu A3-ĐXNV</strong>
      </p>
      <p align="right">
        03/2017/TT-BKHCN
      </p>
      <br>
      <p align="center">
    <strong>PHIẾU ĐỀ XUẤT ĐẶT HÀNG NHIỆM VỤ </strong>
</p>
<p align="center">
    <strong>KHOA HỌC VÀ CÔNG NGHỆ CẤP QUỐC GIA </strong>
</p>
<p align="center">
    <em> (Dùng cho dự án khoa học và công nghệ)</em>
</p>
<p align="center">
    <em></em> <br>
</p>
<b> <br>
    1. Tên dự án khoa học và công nghệ (KH&amp;CN):
</b>
<p class="style-value" style="text-align: justify;"> {!! nl2br(e($data['name'])) !!}</p>
<p><br>
  <b>2. Xuất xứ hình thành:</b>

    <em>
        (nêu rõ nguồn hình thành của dự án KH&amp;CN, tên dự án đầu tư sản
        xuất, các quyết định phê duyệt liên quan ...)
    </em>
</p>
<p  class="style-value" style="text-align: justify;">
  {!! nl2br(e($data['provenance_originate'])) !!}
</p>
<b><br>
    3. Tính cấp thiết; tầm quan trọng phải thực hiện ở tầm quốc gia; tác động
    và ảnh hưởng đến đời sống kinh tế - xã hội của đất nước v.v...:
</b>
<p  class="style-value" style="text-align: justify;">
  {!! nl2br(e($data['importance'])) !!}
</p>
<b><br>
    4. Mục tiêu:
</b>
<p  class="style-value" style="text-align: justify;">
  {!! nl2br(e($data['target'])) !!}
</p>
<p><br>
    <b>5. Nội dung KH&amp;CN chủ yếu:</b><strong> </strong>
    <em>
        (mỗi nội dung đặt ra có thể hình thành được một đề tài, hoặc dự án
        SXTN)
    </em>
    <em> </em>
</p>
<p  class="style-value" style="text-align: justify;">
  {!! nl2br(e($data['content'])) !!}
</p>
<b><br>
    6. Yêu cầu đối với kết quả (công nghệ, thiết bị) và các chỉ tiêu kinh tế -
    kỹ thuật cần đạt:
</b>
<p  class="style-value" style="text-align: justify;">
  {!! nl2br(e($data['request_result'])) !!}
</p>
<b><br>
    7. Dự kiến tổ chức, cơ quan hoặc địa chỉ ứng dụng các kết quả tạo ra:
</b>
<p  class="style-value" style="text-align: justify;">
  {!! nl2br(e($data['application_address'])) !!}
</p>
<b><br>
    8. Yêu cầu đối với thời gian thực hiện:
</b>
<p  class="style-value" style="text-align: justify;">
  {!! nl2br(e($data['request_time'])) !!}
</p>
<b><br>
    9. Năng lực của tổ chức, cơ quan dự kiến ứng dụng kết quả:
</b>
<p  class="style-value" style="text-align: justify;">
  {!! nl2br(e($data['qualification'])) !!}
</p>
<b><br>
    10.Dự kiến nhu cầu kinh phí:
</b>
<p  class="style-value" style="text-align: justify;">
  {!! nl2br(e($data['expected_fund'])) !!}
</p>
<p><br>
    <b>11. Phương án huy động các nguồn lực của cơ tổ chức, cơ quan dự kiến ứng
    dụng kết quả:</b> <em>(</em>
    <em>
        khả năng huy động nhân lực, tài chính và cơ sở vật chất từ các nguồn
        khác nhau để thực hiện dự án
    </em>
    <em>)</em>
</p>
<p  class="style-value" style="text-align: justify;">
  {!! nl2br(e($data['plan_mobilize'])) !!}
</p>
<b><br>
    12.Dự kiến hiệu quả của dự án KH&amp;CN:
</b>
<p>
    <b>12.1. Hiệu quả kinh tế - xã hội:</b>
    <em>
        (cần làm rõ đóng góp của dự án KH&amp;CN đối với các dự án đầu tư sản
        xuất trước mắt và lâu dài bao gồm số tiền làm lợi và các đóng góp
        khác...
    </em>
</p>
<p  class="style-value" style="text-align: justify;">
  {!! nl2br(e($data['economic_efficiency'])) !!}
</p>
<p><br>
    <b>12.2. Hiệu quả về khoa học và công nghệ:</b><strong> </strong>
    <em>
        (tác động đối với lĩnh vực khoa học công nghệ liên quan, đào tạo, bồi
        dưỡng đội ngũ cán bộ, tăng cường năng lực nội sinh...)
    </em>
</p>
<p class="style-value" style="text-align: justify;">
  {!! nl2br(e($data['science_technology_efficiency'])) !!}
</p>
<p>
    <strong><em></em></strong>
</p>
<br><br><br><br>
<table border="0" cellspacing="0" cellpadding="0" style="width: 100%">
       <tbody>
         <tr>
           <td width="459" valign="top">
             <p align="right" style="margin-right: 45px">
               <em> </em>
               <em>..., ngày {{(!empty($date))?$date['d']:"....."}} tháng {{(!empty($date))?$date['m']:"....."}} năm {{(!empty($date))?$date['y']:"20..."}}</em>
               <strong></strong>
             </p>
             <p align="right">
               <strong></strong>
             </p>
             <p align="right" style="margin-right: 25px">
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
<p>
    Ghi chú:
</p>
<em> Phiếu đề xuất được trình bày không quá 6 trang giấy khổ A4.</em>
    </div>
  </body>
</html>
