<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnTableNameAndRecordIdToApplyLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('apply_logs', function (Blueprint $table) {
            if (!Schema::hasColumn('apply_logs', 'table_name')) {
                $table->string('table_name')->nullable();
            }

            if (!Schema::hasColumn('apply_logs', 'record_id')) {
                $table->integer('record_id')->nullable();
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
        Schema::table('apply_logs', function (Blueprint $table) {
            //
        });
    }
}
