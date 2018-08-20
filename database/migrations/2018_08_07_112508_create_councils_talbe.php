<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouncilsTalbe extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('councils', function (Blueprint $table) {
           $table->increments('id');
           $table->string('name');
           $table->integer('round_collection_id')->unsigned()->comment('id của bảng round_collection_id');
           $table->integer('group_council_id')->unsigned()->comment('id của bảng group_councils');
           $table->tinyInteger('status')->default(1)->comment('');
           $table->timestamps();
           $table->softDeletes();
       });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('councils', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('round_collection_id')->unsigned()->comment('id của bảng round_collection_id');
            $table->integer('group_council_id')->unsigned()->comment('id của bảng group_councils');
            $table->tinyInteger('status')->default(1)->comment('1: active, 0: deactive');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
