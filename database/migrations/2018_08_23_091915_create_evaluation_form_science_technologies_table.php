<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvaluationFormScienceTechnologiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('evaluation_form')) {
            Schema::create('evaluation_form', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id');
                $table->integer('mission_id');
                $table->text('content'); //lưu json
                $table->string('table_name');
                $table->timestamps();
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
        if (Schema::hasTable('evaluation_form')) {
            Schema::dropIfExists('evaluation_form');
        }
    }
}
