<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeNameColumnCompanyIdToProfileIdMissionSxtnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mission_sxtns', function (Blueprint $table) {
          if (Schema::hasColumn('mission_sxtns', 'company_id')) {
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
        Schema::table('mission_sxtns', function (Blueprint $table) {
          if (Schema::hasColumn('mission_sxtns', 'profile_id')) {
            $table->renameColumn('profile_id', 'company_id');
          }
        });
    }
}
