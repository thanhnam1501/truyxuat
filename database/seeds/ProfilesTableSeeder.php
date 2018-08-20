<?php

use Illuminate\Database\Seeder;
use App\Models\Profile;

class ProfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Profile::truncate();

        Profile::create(
            array(
                'name'=>'scientist',
                'email'=>'superadmin@gmail.com',
                'password'=>bcrypt('123456'),
                'status'=>1,
                'type'=>1
            )
        );
    }
}
