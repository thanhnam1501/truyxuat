<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteAllStatusColumnsTableMissionScienceTechnologies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mission_science_technologies', function (Blueprint $table) {
            if (Schema::hasColumn('mission_science_technologies', 'status')) {
                $table->dropColumn('status');
            }
            if (Schema::hasColumn('mission_science_technologies', 'checked_status')) {
                $table->dropColumn('checked_status');
            }
            if (Schema::hasColumn('mission_science_technologies', 'process_status')) {
                $table->dropColumn('process_status');
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
            //
        });
    }
}
