<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('tax_code', 15)->comment('Ma so thue')->unique();
            $table->string('address')->nullable();
            $table->string('mobile_phone', 15)->nullable();
            $table->string('fax')->nullable();
            $table->string('account_number', 50)->nullable()->comment('So tai khoan ngan hang');
            $table->string('bank_name')->nullable()->comment('Ten ngan hang');
            $table->string('email_company')->nullable()->comment('Email don vi');
            $table->string('image')->nullable()->comment('Anh con dau');
            $table->string('representator')->nullable()->comment('Nguoi dai dien phap luat');
            $table->string('position_representator')->nullable()->comment('Chuc vu nguoi dai dien');
            $table->string('mobile_representator')->nullable()->comment('So dien thoai nguoi dai dien');
            $table->integer('status')->default(1)->comment('1: active, 0: deactive');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
}
