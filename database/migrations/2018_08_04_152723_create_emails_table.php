<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emails', function (Blueprint $table) {
            $table->string('to', 250)->nullable()->comment('email nhận, có thể lưu nhiều email, nối với nhau dấu ","');
            $table->string('subject')->nullable()->comment('tiêu đề mail');
            $table->string('view')->nullable()->comment('view của Mail');
            $table->text('parameter')->nullable()->comment('mảng tham số truyền qua view');
            $table->integer('status')->nullable()->comment('
                0: gửi thành công,
                1: gửi lỗi, 
                2 chưa gửi
            ');
            $table->integer('type')->nullable()->comment('Loại email');
            $table->integer('num_submissions')->nullable()->comment('Số lần gửi thư');
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
        Schema::dropIfExists('emails');
    }
}
