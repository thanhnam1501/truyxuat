<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRoundCollectionIdColumnToMissionSxtnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mission_sxtns', function (Blueprint $table) {
            if (!Schema::hasColumn('mission_sxtns', 'round_collection_id')) {
                $table->integer('round_collection_id');
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
            if (Schema::hasColumn('mission_sxtns', 'round_collection_id')) {
                $table->dropColumn('round_collection_id');
            }
        });
    }
}
