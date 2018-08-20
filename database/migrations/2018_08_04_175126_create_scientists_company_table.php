<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScientistsCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scientists_company', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('scientist_id');
            $table->integer('company_id');
            $table->integer('status')->comment('1: active, 0: deactive')->default(1);
            $table->timestamps();
            $table->SoftDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scientists_company');
    }
}
