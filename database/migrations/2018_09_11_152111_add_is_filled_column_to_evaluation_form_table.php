<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsFilledColumnToEvaluationFormTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('evaluation_form', function (Blueprint $table) {
            if (!Schema::hasColumn('evaluation_form', 'is_filled')) {
                $table->tinyInteger('is_filled')->nullable()->comment('Trạng thái hoàn thiện đánh giá hồ sơ. 0: chưa hoàn thiện, 1: đã hoàn thiện');
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
        Schema::table('evaluation_form', function (Blueprint $table) {
            if (Schema::hasColumn('evaluation_form', 'is_filled')) {
                $table->dropColumn('is_filled');
            }
        });
    }
}
