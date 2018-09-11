<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMissionTypeColumnToUserHandleFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_handle_files', function (Blueprint $table) {
            if (!Schema::hasColumn('user_handle_files', 'mission_type')) {
                $table->integer('mission_type')->nullable()->comment('Loại hồ sơ đối với KH và CN');
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
            if (Schema::hasColumn('user_handle_files', 'mission_type')) {
                $table->dropColumn('mission_type');
            }
        });
    }
}
