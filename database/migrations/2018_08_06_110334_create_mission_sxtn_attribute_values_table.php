<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Eloquent\SoftDeletes;

class CreateMissionSxtnAttributeValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('mission_sxtn_attribute_values')) {
            Schema::create('mission_sxtn_attribute_values', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('mission_sxtn_attribute_id')->unsigned()->comment('id của bảng attribute');
                $table->string('value')->nullable()->comment('giá trị của trường');
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
        if (Schema::hasTable('mission_sxtn_attribute_values')) {
            Schema::dropIfExists('mission_sxtn_attribute_values');
        }
        
    }
}
