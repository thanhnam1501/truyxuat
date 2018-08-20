<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('permission_roles')) {
            Schema::create('permission_roles', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('permission_id');
                $table->integer('role_id');
                $table->timestamps();
            });   
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {   
        if (Schema::hasTable('permission_roles')) {
            Schema::dropIfExists('permission_roles');
        }
    }
}
