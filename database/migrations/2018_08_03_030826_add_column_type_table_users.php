<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnTypeTableUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {

            if (Schema::hasColumn('users','type')) {

                $table->dropColumn('type');
            }

            $table->tinyInteger('type')->default(1)->comment();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {

            if (Schema::hasColumn('users','type')) {

                $table->dropColumn('type');
            }
        });
    }
}
