<?php

use Illuminate\Database\Seeder;
use App\Models\MissionScienceTechnologyAttribute;

class MissionScienceTechnologyAttributesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MissionScienceTechnologyAttribute::truncate();

        MissionScienceTechnologyAttribute::create([
          'tag_input_id'  =>  1,
          'label'         =>  '<b>Tên dự án khoa học và công nghệ (KH&CN)</b>:',
          'column'        =>  'name',
          'order'         =>  1,
          'placeholder'   =>  'Vui lòng nhập tên dự án'
        ]);

        MissionScienceTechnologyAttribute::create([
          'tag_input_id'  =>  6,
          'label'         =>  '<b>Xuất xứ hình thành</b>: <i>(nêu rõ nguồn hình thành của dự án KH&CN, tên dự án đầu tư sản xuất, các quyết định phê duyệt liên quan ...)</i>',
          'column'        =>  'provenance_originate',
          'order'         =>  2,
          'placeholder'   =>  'Vui lòng nhập xuất xứ hình thành'
        ]);

        MissionScienceTechnologyAttribute::create([
          'tag_input_id'  =>  6,
          'label'         =>  '<b>Tính cấp thiết; tầm quan trọng phải thực hiện ở tầm quốc gia; tác động và ảnh hưởng đến đời sống kinh tế - xã hội của đất nước v.v...</b>:',
          'column'        =>  'importance',
          'order'         =>  3,
          'placeholder'   =>  'Vui lòng nhập tính cấp thiết; tầm quan trọng phải thực hiện ở tầm quốc gia'
        ]);

        MissionScienceTechnologyAttribute::create([
          'tag_input_id'  =>  6,
          'label'         =>  '<b>Mục tiêu</b>:',
          'column'        =>  'target',
          'order'         =>  4,
          'placeholder'   =>  'Vui lòng nhập mục tiêu'
        ]);

        MissionScienceTechnologyAttribute::create([
          'tag_input_id'  =>  6,
          'label'         =>  '<b>Nội dung KH&CN chủ yếu</b>: <i>(mỗi nội dung đặt ra có thể hình thành được một đề tài, hoặc dự án SXTN)</i>',
          'column'        =>  'content',
          'order'         =>  5,
          'placeholder'   =>  'Vui lòng nhập nội dung KHCN chủ yếu'
        ]);

        MissionScienceTechnologyAttribute::create([
          'tag_input_id'  =>  6,
          'label'         =>  '<b>Yêu cầu đối với kết quả (công nghệ, thiết bị) và các chỉ tiêu kinh tế - kỹ thuật cần đạt</b>:',
          'column'        =>  'request_result',
          'order'         =>  6,
          'placeholder'   =>  'Vui lòng nhập yêu cầu đối với kết quả'
        ]);

        MissionScienceTechnologyAttribute::create([
          'tag_input_id'  =>  6,
          'label'         =>  '<b>Dự kiến tổ chức, cơ quan hoặc địa chỉ ứng dụng các kết quả tạo ra</b>:',
          'column'        =>  'application_address',
          'order'         =>  7,
          'placeholder'   =>  'Vui lòng nhập dự kiến tổ chức, cơ quan hoặc địa chỉ ứng dụng'
        ]);

        MissionScienceTechnologyAttribute::create([
          'tag_input_id'  =>  6,
          'label'         =>  '<b>Yêu cầu đối với thời gian thực hiện</b>:',
          'column'        =>  'request_time',
          'order'         =>  8,
          'placeholder'   =>  'Vui lòng nhập yêu cầu đối với thời gian thực hiện'
        ]);

        MissionScienceTechnologyAttribute::create([
          'tag_input_id'  =>  6,
          'label'         =>  '<b>Năng lực của tổ chức, cơ quan dự kiến ứng dụng kết quả</b>:',
          'column'        =>  'qualification',
          'order'         =>  9,
          'placeholder'   =>  'Vui lòng nhập năng lực của tổ chức, cơ quan'
        ]);

        MissionScienceTechnologyAttribute::create([
          'tag_input_id'  =>  1,
          'label'         =>  '<b>Dự kiến nhu cầu kinh phí</b>:',
          'column'        =>  'expected_fund',
          'order'         =>  10,
          'placeholder'   =>  'Vui lòng nhập dự kiến nhu cầu kinh phí'
        ]);

        MissionScienceTechnologyAttribute::create([
          'tag_input_id'  =>  6,
          'label'         =>  '<b>Phương án huy động các nguồn lực của cơ tổ chức, cơ quan dự kiến ứng dụng kết quả</b>: <i>(khả năng huy động nhân lực, tài chính và cơ sở vật chất từ các nguồn khác nhau để thực hiện dự án)</i>',
          'column'        =>  'plan_mobilize',
          'order'         =>  11,
          'placeholder'   =>  'Vui lòng nhập phương án huy động các nguồn lực của cơ tổ chức, cơ quan dự kiến'
        ]);

        MissionScienceTechnologyAttribute::create([
          'tag_input_id'  =>  16,
          'label'         =>  '<b>Dự kiến hiệu quả của dự án KH&CN</b>:',
          'column'        =>  'expected_effect',
          'order'         =>  12
        ]);

        MissionScienceTechnologyAttribute::create([
          'tag_input_id'  =>  6,
          'label'         =>  '<b>Hiệu quả kinh tế - xã hội</b>: <i>(cần làm rõ đóng góp của dự án KH&CN đối với các dự án đầu tư sản xuất trước mắt và lâu dài bao gồm số tiền làm lợi và các đóng góp khác...)</i>',
          'column'        =>  'economic_efficiency',
          'order'         =>  13,
          'parent_attribute_id' =>  12,
          'placeholder'   =>  'Vui lòng nhập hiệu quả kinh tế - xã hội'
        ]);

        MissionScienceTechnologyAttribute::create([
          'tag_input_id'  =>  6,
          'label'         =>  '<b>Hiệu quả về khoa học và công nghệ</b>: <i>(tác động đối với lĩnh vực khoa học công nghệ liên quan, đào tạo, bồi dưỡng đội ngũ cán bộ, tăng cường năng lực nội sinh..)</i>',
          'column'        =>  'science_technology_efficiency',
          'order'         =>  14,
          'parent_attribute_id' =>  12,
          'placeholder'   =>  'Vui lòng nhập hiệu quả về khoa học và công nghệ'
        ]);

        MissionScienceTechnologyAttribute::create([
          'tag_input_id'  =>  5,
          'label'         =>  '<b>Phiếu đánh giá của chuyên gia độc lập 01',
          'column'        =>  'evaluation_form_01',
          'order'         =>  15
        ]);

        MissionScienceTechnologyAttribute::create([
          'tag_input_id'  =>  5,
          'label'         =>  '<b>Phiếu đánh giá của chuyên gia độc lập 02',
          'column'        =>  'evaluation_form_02',
          'order'         =>  16
        ]);
    }
}
