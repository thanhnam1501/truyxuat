<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScientistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scientists', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->string('name');
            $table->string('avatar')->nullable();
            $table->boolean('gender')->default(1)->comment('1: male, 0: female');
            $table->date('birthday')->nullable();
            $table->string('mobile', 30)->nullable();
            $table->string('address')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1: active, 0: deactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scientists');
    }
}
