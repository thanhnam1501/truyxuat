<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteColumnFileInMissionSxtnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('mission_sxtns', function (Blueprint $table) {
            if (Schema::hasColumn('mission_sxtns', 'evaluation_form_01')) {
                $table->dropColumn('evaluation_form_01');
            } 
            if (Schema::hasColumn('mission_sxtns', 'evaluation_form_02')) {
                $table->dropColumn('evaluation_form_02');
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
            if (!Schema::hasColumn('mission_sxtns', 'evaluation_form_01')) {
                $table->string('evaluation_form_01')->nullable();
            }

            if (!Schema::hasColumn('mission_sxtns', 'evaluation_form_02')) {
                $table->string('evaluation_form_02')->nullable();
            }
        });
    }
}
