<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEvaluationFormColumnToMissionSxtnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mission_sxtns', function (Blueprint $table) {
            if (!Schema::hasColumn('mission_sxtns', 'evaluation_form_01')) {
                $table->string('evaluation_form_01', 255)->nullable()->comment('Phiếu đánh giá của chuyên gia độc lập 01');
            }

            if (!Schema::hasColumn('mission_sxtns', 'evaluation_form_01')) {
                $table->string('evaluation_form_02', 255)->nullable()->comment('Phiếu đánh giá của chuyên gia độc lập 02');
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
            if (Schema::hasColumn('mission_sxtns', 'evaluation_form_01')) {
                $table->dropColumn('evaluation_form_01');
            }

            if (Schema::hasColumn('mission_sxtns', 'evaluation_form_02')) {
                $table->dropColumn('evaluation_form_02');
            }
        });
    }
}