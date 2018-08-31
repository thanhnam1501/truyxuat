<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTypeColumnToCouncilMissionScienceTechnologiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('council_mission_science_technologies', function (Blueprint $table) {
            if (!Schema::hasColumn('council_mission_science_technologies', 'type')) {
                $table->tinyInteger('type');
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
            if (Schema::hasColumn('council_mission_science_technologies', 'type')) {
                $table->dropColumn('type');
            }
        });
    }
}
