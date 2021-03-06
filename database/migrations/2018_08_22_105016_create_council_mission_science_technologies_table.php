<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouncilMissionScienceTechnologiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('council_mission_science_technologies')) {
            Schema::create('council_mission_science_technologies', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('council_id');
                $table->integer('mission_id');
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
        if (Schema::hasTable('council_mission_science_technologies')) {
            Schema::dropIfExists('council_mission_science_technologies');
        }
    }
}
