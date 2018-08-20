<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPerformColumnIsReceiveTableMissionTopics extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mission_topics', function (Blueprint $table) {
            if (!Schema::hasColumn('mission_topics', 'is_performed')) {
                $table->tinyInteger('is_performed')->default(0)->comment('Thực hiện - 0: chưa được thực hiện, 1: đã được thực hiện');
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
            if (Schema::hasColumn('mission_topics', 'is_performed')) {
                $table->dropColumn('is_performed');
            }
        });
    }
}
