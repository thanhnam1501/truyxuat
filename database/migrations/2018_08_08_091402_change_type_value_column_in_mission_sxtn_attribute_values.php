<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeTypeValueColumnInMissionSxtnAttributeValues extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mission_sxtn_attribute_values', function (Blueprint $table) {
            if (Schema::hasColumn('mission_sxtn_attribute_values', 'value')) {
                $table->text('value')->nullbale()->change();
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
        Schema::table('mission_sxtn_attribute_values', function (Blueprint $table) {
            if (Schema::hasColumn('mission_sxtn_attribute_values', 'value')) {
                $table->string('value')->nullbale()->change();
            }
        });
    }
}
