<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Eloquent\SoftDeletes;

class CreateMissionScienceTechnologyFiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if (!Schema::hasTable('mission_science_technology_files')) {
          Schema::create('mission_science_technology_files', function (Blueprint $table) {
              $table->increments('id');
              $table->integer('mission_science_technology_id');
              $table->integer('company_id');
              $table->string('name', 255)->comment('ten file');
              $table->string('link', 255)->comment('duong dan');
              $table->tinyInteger('size')->comment('don vi la Mb');
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
        //
    }
}
