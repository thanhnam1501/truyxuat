<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameColumnMissionTopicAttributeIdTableMissionTopicValues extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mission_topic_values', function (Blueprint $table) {
            if (Schema::hasColumn('mission_topic_values','mission_topic_attribute_id')) {
              $table->renameColumn('mission_topic_attribute_id', 'mission_topic_attribute_value_id');
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
        Schema::table('mission_topic_values', function (Blueprint $table) {
            //
        });
    }
}
