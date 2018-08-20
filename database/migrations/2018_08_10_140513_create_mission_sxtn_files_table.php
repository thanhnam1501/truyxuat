<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMissionSxtnFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('mission_files')) {
            Schema::create('mission_files', function (Blueprint $table) {
                $table->increments('id');
                $table->string('table_name', 100)->comment('Tên bảng');
                $table->tinyInteger('company_id')->comment('id người tạo');
                $table->tinyInteger('mission_id')->comment('id của nhiệm vụ');
                $table->tinyInteger('mission_attribute_id')->comment('id của cột');
                $table->string('path')->comment('đường dẫn tới ảnh');
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
        if (Schema::hasTable('mission_files')) {
            Schema::dropIfExists('mission_files');
        }
    }
}
