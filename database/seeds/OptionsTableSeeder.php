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
    }
}
