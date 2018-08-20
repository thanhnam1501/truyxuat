<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteColumnIsReceiveTableMissionTopics extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mission_topics', function (Blueprint $table) {
            if (Schema::hasColumn('mission_topics', 'is_receive')) {
                $table->dropColumn('is_receive');
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
        Schema::table('mission_topics', function (Blueprint $table) {
            //
        });
    }
}
