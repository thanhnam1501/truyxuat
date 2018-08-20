<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeNameAttributeIdColumnInMissionSxtnValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mission_sxtn_values', function (Blueprint $table) {
            if (Schema::hasColumn('mission_sxtn_values', 'mission_sxtn_attribute_id')) {
                $table->renameColumn('mission_sxtn_attribute_id', 'mission_sxtn_attribute_value_id');
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
        Schema::table('mission_sxtn_values', function (Blueprint $table) {
            if (Schema::hasColumn('mission_sxtn_values', 'mission_sxtn_attribute_value_id')) {
                $table->renameColumn('mission_sxtn_attribute_value_id', 'mission_sxtn_attribute_id');
            }
        });
    }
}
