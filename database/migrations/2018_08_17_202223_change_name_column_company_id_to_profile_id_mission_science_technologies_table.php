<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeNameColumnCompanyIdToProfileIdMissionScienceTechnologiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mission_science_technologies', function (Blueprint $table) {
          if (Schema::hasColumn('mission_science_technologies', 'company_id')) {
            $table->renameColumn('company_id', 'profile_id');
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
        Schema::table('mission_science_technologies', function (Blueprint $table) {
          if (Schema::hasColumn('mission_science_technologies', 'profile_id')) {
            $table->renameColumn('profile_id', 'company_id');
          }
        });
    }
}
