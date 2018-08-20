<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnParentAttributeIdToMissionScienceTechnologyAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mission_science_technology_attributes', function (Blueprint $table) {
            if (!Schema::hasColumn('mission_science_technology_attributes', 'parent_attribute_id')) {
              $table->integer('parent_attribute_id')->nullable()->comment('id attribute la cha');
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
