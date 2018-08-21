<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeTypeMissionTableUserHandleFileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_handle_files', function (Blueprint $table) {
            if (Schema::hasColumn('user_handle_files', 'mission_table')) {
                $table->string('mission_table')->nullable()->change();
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
        Schema::table('user_handle_files', function (Blueprint $table) {
            //
        });
    }
}
