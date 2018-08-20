<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeOrderTypeColumnInMissionSxtnAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('mission_sxtn_attributes', 'order')) {
            Schema::table('mission_sxtn_attributes', function (Blueprint $table) {
                $table->integer('order')->comment('thứ tự của cột')->unsigned()->unique()->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('mission_sxtn_attributes', 'order')) {
            Schema::table('mission_sxtn_attributes', function (Blueprint $table) {
                $table->string('order', 255)->comment('thứ tự của cột')->unsigned()->unique()->change();
            });
        }
    }
}
