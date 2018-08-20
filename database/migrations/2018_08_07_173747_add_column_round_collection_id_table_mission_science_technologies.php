<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnRoundCollectionIdTableMissionScienceTechnologies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mission_science_technologies', function (Blueprint $table) {
          if (!Schema::hasColumn('mission_science_technologies','is_filled')) {
              $table->tinyInteger('is_filled')->default(0)->comment('0: chưa nhập đủ, 1: đã nhập đủ');
          }

          if (!Schema::hasColumn('mission_science_technologies','round_collection_id')) {
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
        Schema::table('mission_science_technologies', function (Blueprint $table) {
            //
        });
    }
}
