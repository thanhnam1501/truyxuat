<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnTypeTableScientists extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('scientists', function (Blueprint $table) {

            if (Schema::hasColumn('scientists','type')) {

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
        Schema::table('scientists', function (Blueprint $table) {

            if (Schema::hasColumn('scientists','type')) {

                $table->dropColumn('type');
            }
        });
    }
}
