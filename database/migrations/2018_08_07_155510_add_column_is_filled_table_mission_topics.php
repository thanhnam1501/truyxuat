<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnIsFilledTableMissionTopics extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mission_topics', function (Blueprint $table) {
            if (!Schema::hasColumn('mission_topics','is_filled')) {

                $table->tinyInteger('is_filled')->default(0)->comment('0: chưa nhập đủ, 1: đã nhập đủ');
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
          if (Schema::hasColumn('mission_topics','is_filled')) {

              $table->dropColumn('is_filled');
          }
        });
    }
}
