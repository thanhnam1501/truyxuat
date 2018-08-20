<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsfillsColumnToMissionSxtnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mission_sxtns', function (Blueprint $table) {
            if (!Schema::hasColumn('mission_sxtns', 'is_filled')) {
                $table->TinyInteger('is_filled')->default(0)->comment('trạng thái điền form, 0: chưa điền đầy đủ, 1: đã đầy đủ');
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
            if (Schema::hasColumn('mission_sxtns', 'is_filled')) {
                $table->dropColumn('is_filled');
            }
        });
    }
}
