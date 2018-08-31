<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnMissionIdInCouncilMissionScienceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('council_mission_science_technologies', function (Blueprint $table) {
            if (Schema::hasColumn('council_mission_science_technologies', 'mission_science_technology_id')) {
                $table->renameColumn('mission_science_technology_id', 'mission_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('council_mission_science_technologies', function (Blueprint $table) {
            if (Schema::hasColumn('council_mission_science_technologies', 'mission_id')) {
                $table->renameColumn('mission_id', 'mission_science_technology_id');
            }
        });
    }
}
