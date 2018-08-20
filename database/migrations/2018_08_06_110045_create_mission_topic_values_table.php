<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMissionTopicValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mission_topic_values', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mission_topic_id')->nullable()->comment('lấy id trong bảng mission_topics');
            $table->integer('mission_topic_attribute_id')->nullable()->comment('lấy id trong bảng mission_topic_attributes');
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
        Schema::dropIfExists('mission_topic_values');
    }
}
