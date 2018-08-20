<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Eloquent\SoftDeletes;

class CreateMissionSxtnAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('mission_sxtn_attributes')) {
            Schema::create('mission_sxtn_attributes', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('mission_sxtn_id')->unsigned()->comment('id của bảng mission_sxtn')->nullable();
                $table->text('label')->comment('nhãn dán');
                $table->string('column', 255)->comment('Tên trường');
                $table->string('order', 255)->comment('kiểu sắp xếp')->nullable();
                $table->integer('tag_input_id')->unsigned()->comment('id của bảng tag input');
                $table->tinyInteger('status')->default(1)->comment('0: không hiển thị, 1: có hiển thị');
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
        if (Schema::hasTable('mission_sxtn_attributes')) {
            Schema::dropIfExists('mission_sxtn_attributes');
        }
        
    }
}
