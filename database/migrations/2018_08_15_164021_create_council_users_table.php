<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouncilUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('council_users')) {
            Schema::create('council_users', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('council_id');
                $table->integer('user_id');
                $table->integer('position_council_id');
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
        if (Schema::hasTable('council_users')) {
            Schema::dropIfExists('council_users');
        }
    }
}
