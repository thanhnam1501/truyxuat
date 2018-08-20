<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMissionTopicAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mission_topic_attributes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mission_topic_id')->nullable()->comment('id hồ sơ - bảng mission_topics');
            $table->integer('tag_input_id')->nullable()->comment('id kiểu dữ liệu - bảng tag_inputs');
            $table->string('label')->nullable()->comment('tiêu đề cột');
            $table->string('column')->nullable()->comment('tên cột');
            $table->tinyInteger('status')->default(1)->comment('0: không hiển thị, 1: có hiển thị');
            $table->integer('order')->nullable()->comment('0: không hiển thị, 1: có hiển thị');
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
        Schema::dropIfExists('mission_topic_attributes');
    }
}
