<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call(UsersTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(PermissionRolesTableSeeder::class);
        $this->call(ProfilesTableSeeder::class);
        $this->call(MissionScienceTechnologyAttributesTableSeeder::class);
        $this->call(MissionSxtnsTableSeeder::class);
        $this->call(MissionTopicAttributesTableSeeder::class);
        $this->call(GroupCouncilTableSeeder::class);
        $this->call(OptionsTableSeeder::class);
        $this->call(OptionValuesTableSeeder::class);
    }
}
