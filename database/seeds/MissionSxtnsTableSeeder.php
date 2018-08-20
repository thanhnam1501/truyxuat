<?php

use Illuminate\Database\Seeder;
use App\Models\MissionSxtn;
use App\Models\MissionSxtnAttribute;
use App\Models\MissionSxtnAttributeValue;
use App\Models\MissionSxtnValue;

class MissionSxtnsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MissionSxtnAttribute::truncate();
        // MissionSxtn::truncate();
        // MissionSxtnAttributeValue::truncate();
        // MissionSxtnValue::truncate();
        // 
        // MissionSxtn::create(
        // 	array(
        // 		'status'	=>	0,
        // 		'checked_status'	=>	0,
        // 		'process_status'	=>	0,
        // 		'report_status'	=>	0
        // 	)
        // );

        MissionSxtnAttribute::create(
        	array(
	 
	        	'label'	=>	'<strong>Tên dự án SXTN</strong>',
	        	'column'	=>	'sxtn_name',
	        	'tag_input_id'	=>	6,
                'order' => 1,
	        )
        );

        MissionSxtnAttribute::create(
        	array(
	     
	        	'label'	=>	'<strong>Xuất sứ hình thành </strong><i> (Từ một trong các nguồn sau: kết quả của các đề tài; kết quả khai thác sáng chế, giải pháp hữu ích; kết quả KH&CN chuyển giao từ nước ngoài... có khả năng ứng dụng)</i>',
	        	'column'	=>	'formation',
	        	'tag_input_id'	=>	6,
                'order' => 2,
	        )
        );

        MissionSxtnAttribute::create(
        	array(
   
        		'label'	=> '<strong>Tính cấp thiết; tầm quan trọng phải thực hiện ở tầm quốc gia; tác động và ảnh hưởng đến đời sống kinh tế - xã hội của đất nước v.v...Tính cấp thiết; tầm quan trọng phải thực hiện ở tầm quốc gia; tác động và ảnh hưởng đến đời sống kinh tế - xã hội của đất nước v.v...</strong>',
        		'column'	=>	'urgency_importance',
        		'tag_input_id'	=>	6,
                'order' => 3,
        	)
        );

        MissionSxtnAttribute::create(
        	array(

        		'label'	=> '<strong>Mục tiêu</strong>',
        		'column'	=>	'target',
        		'tag_input_id'	=>	6,
                'order' => 4,
        	)
        );

        MissionSxtnAttribute::create(
        	array(

        		'label'	=> '<strong>Kiến nghị các nội dung chính cần thực hiện để hoàn thiện công nghệ và đạt kết quả</strong>',
        		'column'	=>	'main_content',
        		'tag_input_id'	=>	6,
                'order' => 5,
        	)
        );


        MissionSxtnAttribute::create(
        	array(
        		
        		'label'	=> '<strong>Yêu cầu đối với kết quả (công nghệ, thiết bị) và các chỉ tiêu kỹ thuật cần đạt</strong>',
        		'column'	=>	'claim_result',
        		'tag_input_id'	=>	6,
                'order' => 6,
        	)
        );

        MissionSxtnAttribute::create(
        	array(
        		
        		'label'	=> '<strong>Nhu cầu thị trường: </strong> <i>(từ một trong các nguồn sau: kết quả của các đề tài; kết quả khai thác sáng chế, giải pháp hữu ích; kết quả KH&CN chuyển giao từ nước ngoài... có khả năng ứng dụng)</i>',
        		'column'	=>	'market_demand',
        		'tag_input_id'	=>	6,
                'order' => 7,
        	)
        );

        MissionSxtnAttribute::create(
        	array(
        		
        		'label'	=> '<strong>Dự kiến tổ chức cơ quan hoặc địa chỉ ứng dụng các kết quả tạo ra</strong>',
        		'column'	=> 'expected_organize',
        		'tag_input_id'	=>	6,
                'order' => 8,
        	)
        );

        MissionSxtnAttribute::create(
        	array(
        		
        		'label'	=> '<strong>Yêu cầu đối với thời gian thực hiện</strong>',
        		'column'	=> 'claim_excecution_time',
        		'tag_input_id'	=>	6,
                'order' => 9,
        	)
        );

        MissionSxtnAttribute::create(
        	array(
        		
        		'label'	=> '<strong>Phương án huy động các nguồn lực của tổ chức dự kiến ứng dụng kết quả tạo ra: </strong> <i>(Khả năng huy động nhân lực, tài chính và cơ sở vật chất từ các nguồn khác nhau để thực hiện dự án)</i>',
        		'column'	=> 'plan_mobilizing_resource',
        		'tag_input_id'	=>	6,
                'order' => 10,
        	)
        );
        
        MissionSxtnAttribute::create(
        	array(
        		
        		'label'	=> '<strong>Dự kiến nhu cầu kinh phí</strong>',
        		'column'	=> 'expected_funding',
        		'tag_input_id'	=>	6,
                'order' => 11,
        	)
        );

        MissionSxtnAttribute::create(
            array(
                
                'label' => '<strong>Phiếu đánh giá của chuyên gia độc lập 01</strong>',
                'column'    => 'evaluation_form_01',
                'tag_input_id'  =>  5,
                'order' => 12,
            )
        );

        MissionSxtnAttribute::create(
            array(
                
                'label' => '<strong>Phiếu đánh giá của chuyên gia độc lập 02</strong>',
                'column'    => 'evaluation_form_02',
                'tag_input_id'  =>  5,
                'order' => 13,
            )
        );
    }
}
