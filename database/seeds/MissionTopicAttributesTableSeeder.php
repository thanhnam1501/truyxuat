<?php

use Illuminate\Database\Seeder;
use App\Models\MissionTopicAttribute;

class MissionTopicAttributesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MissionTopicAttribute::truncate();

        MissionTopicAttribute::create([
          'tag_input_id'  =>  1,
          'label'         =>  '<strong>Tên Đề tài/Đề án</strong>',
          'column'        =>  'name',
          'order'         =>  1,
        ]);
        MissionTopicAttribute::create([
          'tag_input_id'  =>  6,
          'label'         =>  '<strong>Căn cứ đề xuất</strong> <i>(giải trình căn cứ theo quy định tại Điều 3 của Thông tư 03/2017/TT-BKHCN Quy định trình tự thủ tục xác định nhiệm vụ khoa học và công nghệ cấp quốc gia sử dụng ngân sách nhà nước)</i><strong>:</strong>',
          'column'        =>  'propose_base',
          'order'         =>  2,
        ]);
        MissionTopicAttribute::create([
          'tag_input_id'  =>  6,
          'label'         =>  '<strong>Tính cấp thiết; tầm quan trọng phải thực hiện ở tầm quốc gia; tác động và ảnh hưởng đến đời sống kinh tế - xã hội của đất nước v.v...</strong>',
          'column'        =>  'urgency',
          'order'         =>  3,
        ]);
        MissionTopicAttribute::create([
          'tag_input_id'  =>  6,
          'label'         =>  '<strong>Mục tiêu:</strong>',
          'column'        =>  'target',
          'order'         =>  4,
        ]);
        MissionTopicAttribute::create([
          'tag_input_id'  =>  6,
          'label'         =>  '<strong>Yêu cầu các kết quả chính và các chỉ tiêu cần đạt:</strong>',
          'column'        =>  'result_target_requirement',
          'order'         =>  5,
        ]);
        MissionTopicAttribute::create([
          'tag_input_id'  =>  6,
          'label'         =>  '<strong>Kiến nghị các nội dung cần thực hiện để đạt kết quả:</strong>',
          'column'        =>  'expected_main_content',
          'order'         =>  6,
        ]);
        MissionTopicAttribute::create([
          'tag_input_id'  =>  6,
          'label'         =>  '<strong>Dự kiến tổ chức, cơ quan hoặc địa chỉ ứng dụng các kết quả tạo ra:</strong>',
          'column'        =>  'expected_result_perform',
          'order'         =>  7,
        ]);
        MissionTopicAttribute::create([
          'tag_input_id'  =>  6,
          'label'         =>  '<strong>Yêu cầu đối với thời gian để đạt được các kết quả:</strong>',
          'column'        =>  'time_result_requirement',
          'order'         =>  8,
        ]);
        MissionTopicAttribute::create([
          'tag_input_id'  =>  5,
          'label'         =>  '<strong>Dự kiến nhu cầu kinh phí:</strong>',
          'column'        =>  'expected_fund',
          'order'         =>  9,
        ]);
        MissionTopicAttribute::create([
          'tag_input_id'  =>  1,
          'label'         =>  'Phiếu đánh giá của chuyên gia độc lập 01',
          'column'        =>  'evaluation_form_01',
          'order'         =>  10,
        ]);
        MissionTopicAttribute::create([
          'tag_input_id'  =>  5,
          'label'         =>  'Phiếu đánh giá của chuyên gia độc lập 02',
          'column'        =>  'evaluation_form_02',
          'order'         =>  11,
        ]);

    }
}
