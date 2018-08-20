<?php

use Illuminate\Database\Seeder;
use App\Models\GroupCouncil;

class GroupCouncilTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	GroupCouncil::truncate();

    	GroupCouncil::create(
    		array(
    			'name'=>'Hội đồng xác định nhiệm vụ',
    			'status'=>1,
    		)
    	);


    	GroupCouncil::create(
    		array(
    			'name'=>'Hội đồng đánh giá thuyết minh',
    			'status'=>1,
    		)
    	);

    	GroupCouncil::create(
    		array(
    			'name'=>'Hội đồng đánh giá kinh phí',
    			'status'=>1,
    		)
    	);

    	GroupCouncil::create(
    		array(
    			'name'=>'Hội đồng nghiệm thu',
    			'status'=>1,
    		)
    	);
    }
}
