<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\PermissionRole;
use App\Models\Permission;
use App\Models\RoleUser;

class PermissionRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('email', 'superadmin@gmail.com')->first();

        //update role and permissions for supper admin
        $role = Role::where('name', 'super-admin')->first();

        RoleUser::create([
        	'user_id' => $user->id,
        	'role_id' => $role->id,
        ]);

        $permissions = Permission::all();

        foreach ($permissions as $key => $permission) {
        	PermissionRole::create([
        		'role_id' => $role->id,
        		'permission_id' => $permission->id
        	]);
        }
    }
}
