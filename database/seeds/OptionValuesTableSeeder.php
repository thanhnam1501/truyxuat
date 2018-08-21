<?php

use Illuminate\Database\Seeder;
use App\Models\OptionValue;
use App\Models\Option;

class OptionValuesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OptionValue::truncate();


        ///Chức vụ
       	$id = Option::where('code','USER-POS')->first()->id;

       	OptionValue::create([
       		'option_id'	=> 	$id,
       		'value'		=> 	0,
       		'name'		=>	'superadmin',
       		'note'		=> 	'có tất cả các quyền'
       	]);
       	OptionValue::create([
       		'option_id'	=> 	$id,
       		'value'		=> 	1,
       		'name'		=>	'Chuyên viên khởi tạo đợt thu hồ sơ',
       		'note'		=> 	'Có nhiệm vụ khởi tạo đợt thu, gọi hồ sơ đăng ký nhiệm vụ của đơn vị'
       	]);
       	OptionValue::create([
       		'option_id'	=> 	$id,
       		'value'		=> 	2,
       		'name'		=>	'Chuyên viên (Văn thư)',
       		'note'		=> 	'Có nhiệm vụ thu hồ sơ bản cứng và chuyển trạng thái nộp hồ sơ bản cứng cho đơn vị'
       	]);
       	OptionValue::create([
       		'option_id'	=> 	$id,
       		'value'		=> 	3,
       		'name'		=>	'Chuyên viên (Trưởng phòng)',
       		'note'		=> 	'Có nhiệm vụ chọn hồ sơ và giao cho chuyên viên chuyên môn kiểm tra hồ sơ có hợp lệ hay không'
       	]);
       	OptionValue::create([
       		'option_id'	=> 	$id,
       		'value'		=> 	4,
       		'name'		=>	'Chuyên viên (Chuyên môn)',
       		'note'		=> 	'Có nhiệm vụ nhận hồ sơ từ Trưởng phòng, và kiểm tra xem hồ sơ có hợp lệ hay không, sau đó chuyển trạng thái cho hồ sơ đã được kiểm tra'
       	]);
       	OptionValue::create([
       		'option_id'	=> 	$id,
       		'value'		=> 	5,
       		'name'		=>	'Ban chủ nhiệm',
       		'note'		=> 	'Có nhiệm vụ xem danh sách hồ sơ đã được kiểm tra hợp lệ theo đợt, sau đó chọn ra các hồ sơ được đánh giá, các hồ sơ bị từ chối kèm theo lý do'
       	]);
       	OptionValue::create([
       		'option_id'	=> 	$id,
       		'value'		=> 	6,
       		'name'		=>	'Chuyên viên cập nhật đánh giá hồ sơ',
       		'note'		=> 	'Có nhiệm vụ dựa theo danh sách các hồ sơ được chọn đánh giá từ ban chủ nhiệm, chuyển trạng thái cho hồ sơ của đơn vị đăng ký, nếu bị từ chối phải kèm theo lý do'
       	]);
       	OptionValue::create([
       		'option_id'	=> 	$id,
       		'value'		=> 	7,
       		'name'		=>	'Chuyên viên lập hội đồng đánh giá',
       		'note'		=> 	'Có nhiệm vụ lập hội đồng khoa học. ( Từ 7 đến 9 thành viên, gồm 1 chủ tịch, 1 phó chủ tịch, 2 ủy viên phản biện, 3 đến 5 ủy viên thường)'
       	]);
       	OptionValue::create([
       		'option_id'	=> 	$id,
       		'value'		=> 	8,
       		'name'		=>	'Chuyên viên chọn hội đồng đánh giá cho từng hồ sơ',
       		'note'		=> 	'Có nhiệm vụ chọn hội đồng đánh giá cho 1 hồ sơ (1 hội đồng có thể đánh giá nhiều hồ sơ )'
       	]);
       	OptionValue::create([
       		'option_id'	=> 	$id,
       		'value'		=> 	9,
       		'name'		=>	'Hội đồng',
       		'note'		=> 	'Có nhiệm vụ đánh giá hồ sơ trên hệ thống qua các form B1, B2, B3'
       	]);

       	///ENd chức vụ
    }
}
