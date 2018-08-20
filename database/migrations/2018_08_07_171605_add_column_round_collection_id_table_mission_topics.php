<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnRoundCollectionIdTableMissionTopics extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('mission_topics', function (Blueprint $table) {
        if (!Schema::hasColumn('mission_topics','round_collection_id')) {

            $table->integer('round_collection_id')->nullable()->comment('lấy id trong bảng round_collections');
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
        if (Schema::hasColumn('mission_topics','round_collection_id')) {

            $table->dropColumn('round_collection_id');
        }
      });
    }
}
