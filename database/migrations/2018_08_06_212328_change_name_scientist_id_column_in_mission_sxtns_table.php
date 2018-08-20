<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeNameScientistIdColumnInMissionSxtnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mission_sxtns', function (Blueprint $table) {
            if (Schema::hasColumn('mission_sxtns', 'scientis_id')) {
                $table->renameColumn('scientis_id', 'company_id');
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
            if (Schema::hasColumn('mission_sxtns', 'company_id')) {
                $table->renameColumn('company_id', 'scientis_id');
            }
        });
    }
}
