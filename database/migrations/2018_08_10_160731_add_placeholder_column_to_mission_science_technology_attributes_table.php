<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPlaceholderColumnToMissionScienceTechnologyAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mission_science_technology_attributes', function (Blueprint $table) {
            if (!Schema::hasColumn('mission_science_technology_attributes', 'placeholder')) {
                $table->text('placeholder')->nullable();
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
        Schema::table('mission_science_technology_attributes', function (Blueprint $table) {
            //
        });
    }
}
