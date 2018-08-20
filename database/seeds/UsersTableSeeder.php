<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        User::create(
            array(
                'name'=>'Super Admin',
                'email'=>'superadmin@gmail.com',
                'password'=>bcrypt('beallyoucanbe'),
                'status'=>1,
                'type'=>1
            )
        );


        User::create(
            array(
                'name'=>'Cán bộ xử lý hồ sơ',
                'email'=>'canbo@gmail.com',
                'password'=>bcrypt('beallyoucanbe'),
                'status'=>1,
                'type'=>0
            )
        );

        User::create(
            array(
                'name'=>'Chuyên viên (văn thư)',
                'email'=>'chuyenvien@gmail.com',
                'password'=>bcrypt('beallyoucanbe'),
                'status'=>1,
                'type'=>0
            )
        );


        User::create(
            array(
                'name'=>'Mẫn Văn Hậu',
                'email'=>'manhau.174@gmail.com',
                'password'=>bcrypt('123456'),
                'status'=>1,
                'type'=>0
            )
        );


        User::create(
            array(
                'name'=>'Đào Thanh Tùng',
                'email'=>'daothanhtung@gmail.com',
                'password'=>bcrypt('beallyoucanbe'),
                'status'=>1,
                'type'=>0
            )
        );

        User::create(
            array(
                'name'=>'Nguyễn Thành Nam',
                'email'=>'nguyenthanhnam@gmail.com',
                'password'=>bcrypt('beallyoucanbe'),
                'status'=>1,
                'type'=>0
            )
        );

        User::create(
            array(
                'name'=>'Nguyễn Tuấn Anh',
                'email'=>'nguyentuananh@gmail.com',
                'password'=>bcrypt('beallyoucanbe'),
                'status'=>1,
                'type'=>0
            )
        );
    }
}
