<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMissionTopicFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mission_topic_files', function (Blueprint $table) {
              $table->increments('id');
              $table->integer('mission_topic_id');
              $table->integer('company_id');
              $table->string('name', 255)->comment('ten file');
              $table->string('link', 255)->comment('duong dan');
              $table->integer('size')->comment('don vi la Kb');
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
        Schema::dropIfExists('mission_topic_files');
    }
}
