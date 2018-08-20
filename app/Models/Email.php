<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Email extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $table = "emails";

    protected $fillable = ['to', 'subject', 'parameter','view', 'type', 'status', 'num_submissions'];

 //    to : người nhận,có thể nhập nhiều email nối với nhau = dấu phẩy. 'manhau@gmail.com,manhau174@gmail.com'
 //
 //    subject: tiêu đề mail
 //
 //    view: view của mail :gọi đến view blade trong View: ví dụ : emails.normal
 //    view normal chỉ để gửi mail fix cứng nội dung ['content'	=>	'...'];
 //
 //    parameter: mảng tham số truyền sang view ['name'=>'ahihi', 'content'=>'abc'];
 //
 //    type: loại email
 //    0- Chăm sóc học viên
	// 1- Xác nhận phiếu thống kê
	// 2- Không đồng ý giờ giảng dạy
	// 3- Thông báo cho học viên trong lớp học
	// 4- Tư vấn
	// 5- Đăng ký khoá học
	// 6- Quên mật khẩu
	// 7- gửi thư liên hệ



    public static function createEmailLog($to, $subject, $view, $parameter, $type, $status, $numb) {
        // $optionValue = OptionValue::where('type_mail', $type)->first();
        if ($view == null || $view == "") {
           $view = 'emails.default';
        }
        foreach ($parameter as $key => $value) {
            if ($value instanceof Illuminate\Database\Eloquent\Collection) {
                $parameter[$key] = $value->toArray();
            }
        }
        
    	Email::create([
    		'to'			=>	$to,
    		'subject'		=>	$subject,
    		'view'			=>	$view,
    		'parameter'		=>	json_encode($parameter), // convert array -> json
    		'type'			=>	$type,
    		'status'		=>	$status,
    		'num_submissions'	=>	$numb,
    	]);

    }
}
