<?php

use Illuminate\Database\Seeder;
use App\Models\PositionCouncil;

class PositionCouncilsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PositionCouncil::truncate();

        PositionCouncil::create([
            'name'=>'Chủ tịch hội đồng',
        ]);

        PositionCouncil::create([
            'name'=>'Phó tịch hội đồng',
        ]);

        PositionCouncil::create([
            'name'=>'Uỷ viên phản biện',
        ]);

        PositionCouncil::create([
            'name'=>'Uỷ viên thường',
        ]);

    }
}
