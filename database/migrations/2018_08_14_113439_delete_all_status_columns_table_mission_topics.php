<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteAllStatusColumnsTableMissionTopics extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mission_topics', function (Blueprint $table) {
            
            if (Schema::hasColumn('mission_topics', 'status')) {
                $table->dropColumn('status');
            }
            if (Schema::hasColumn('mission_topics', 'checked_status')) {
                $table->dropColumn('checked_status');
            }
            if (Schema::hasColumn('mission_topics', 'process_status')) {
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
        Schema::table('mission_topics', function (Blueprint $table) {
            //
        });
    }
}
