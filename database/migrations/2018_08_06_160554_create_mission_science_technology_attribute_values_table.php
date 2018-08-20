<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMissionScienceTechnologyAttributeValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mission_science_technology_attribute_values', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mission_science_technology_attribute_id')->nullable()->comment('lấy id trong bảng mission_science_technology_attributes');
            $table->text('value')->nullable();
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
        Schema::dropIfExists('mission_science_technology_attribute_values');
    }
}
