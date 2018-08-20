<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUnperformedColumnIsReceiveTableMissionScienceTechnologies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mission_science_technologies', function (Blueprint $table) {
            if (!Schema::hasColumn('mission_science_technologies', 'is_unperformed')) {
                $table->tinyInteger('is_unperformed')->default(0)->comment('Thực hiện - 0: chưa được thực hiện, 1: Không được thực hiện');
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
            if (Schema::hasColumn('mission_science_technologies', 'is_unperformed')) {
                $table->dropColumn('is_unperformed');
            }
        });
    }
}
