<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameColumnMissionScienceTechnologyAttributeIdTableMissionScienceTechnologyValues extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mission_science_technology_values', function (Blueprint $table) {
            if (Schema::hasColumn('mission_science_technology_values','mission_science_technology_attribute_id')) {
              $table->renameColumn('mission_science_technology_attribute_id', 'mission_science_technology_attribute_value_id');
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
        //
    }
}
