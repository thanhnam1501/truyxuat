<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteTableScientistsCompany extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('scientists_company', function (Blueprint $table) {
            if (Schema::hasTable('scientists_company')) {
              Schema::drop('scientists_company');
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
        Schema::table('scientists_company', function (Blueprint $table) {
            //
        });
    }
}
