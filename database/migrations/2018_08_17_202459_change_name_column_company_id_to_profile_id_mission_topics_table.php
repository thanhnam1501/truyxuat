<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeNameColumnCompanyIdToProfileIdMissionTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mission_topics', function (Blueprint $table) {
          if (Schema::hasColumn('mission_topics', 'company_id')) {
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
        Schema::table('mission_topics', function (Blueprint $table) {
          if (Schema::hasColumn('mission_topics', 'profile_id')) {
            $table->renameColumn('profile_id', 'company_id');
          }
        });
    }
}
