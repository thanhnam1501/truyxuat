<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeNameColumnCompanyIdToProfileIdMissionFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mission_files', function (Blueprint $table) {
            if (Schema::hasColumn('mission_files', 'company_id')) {
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
        Schema::table('mission_files', function (Blueprint $table) {
          if (Schema::hasColumn('mission_files', 'profile_id')) {
            $table->renameColumn('profile_id', 'company_id');
          }
        });
    }
}
