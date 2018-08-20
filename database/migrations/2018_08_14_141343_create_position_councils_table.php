<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePositionCouncilsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('position_councils')) {
            Schema::create('position_councils', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name', 255);
                $table->tinyInteger('status')->default(1);
                $table->text('description')->nullable();
                $table->SoftDeletes();
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
        if (Schema::hasTable('position_councils')) {
            Schema::dropIfExists('position_councils');
        }
        
    }
}
