<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Eloquent\SoftDeletes;

class CreateMissionSxtnValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('mission_sxtn_values')) {
            Schema::create('mission_sxtn_values', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('mission_sxtn_id')->unsigned()->comment('id của bảng mission_sxtns');
                $table->integer('mission_sxtn_attribute_id')->unsigned()->comment('id của bảng attribute');
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
        if (Schema::hasTable('mission_sxtn_values')) {
            Schema::dropIfExists('mission_sxtn_values');
        }

    }
}
