<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserHandleFiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('user_handle_files')) {
            # code...
            Schema::create('user_handle_files', function (Blueprint $table) {
                $table->increments('id');
                $table->tinyInteger('user_id')->nullable();
                $table->tinyInteger('mission_id')->nullable();
                $table->tinyInteger('mission_table')->nullable();
                $table->tinyInteger('status')->comment('1: show, 0:hide')->default(1);
                $table->tinyInteger('is_handle')->comment('trang thai da duoc kiem tra hop le hay chua: 1-da kiem tra, 0-chua kiem tra')->default(0);
                $table->timestamps();
                $table->softDeletes();
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
        Schema::table('user_handle_files', function (Blueprint $table) {
            Schema:dropTable('user_handle_files');
        });
    }
}
