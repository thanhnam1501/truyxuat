<?php

use Illuminate\Database\Seeder;
use App\Models\Option;

class OptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Option::truncate();

        Option::create([
        	'code'	=> 'USER-POS',
        	'name'	=> "Chức vụ",
        ]);

        Option::create([
            'code'  => 'GROUP-COUNCIL-FUNC',
            'name'  => "Chức năng của nhóm hội đồng",
        ]);

        // Option::create([
        //     'code'  => 'POSITION-COUNCIL',
        //     'name'  => "Vị trí trong hội đồng",
        // ]);
        // 
        Option::create([
            'code'  =>  'MISSION-TYPE',
            'name'  =>  'Phân loại nhiệm vụ',
        ]);
    }
}
