<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMissionScienceTechnologiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mission_science_technologies', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('status')->default(0)->comment('Trạng thái hồ sơ 0: mới tạo, 1: nộp bản mềm, 2: nộp bản cứng');
            $table->tinyInteger('checked_status')->default(0)->comment('Trạng thái duyệt hồ sơ 0: chưa giao cán bộ xử lý, 1: đã giao cán bộ xử lý, 2: hồ sơ được duyệt, 3: hồ sơ không được duyệt');
            $table->tinyInteger('process_status')->default(0)->comment('Trạng thái quá trình thực hiện 0: mới được duyệt, 1: đang thực hiện, 2: dừng thực hiện, 3: đã hoàn thành');
            $table->datetime('time_submit_ele_copy')->nullable()->comment('Thời gian nộp hồ sơ bản mềm');
            $table->datetime('time_submit_hard_copy')->nullable()->comment('Thời gian nộp hồ sơ bản cứng');
            $table->datetime('report_time_submit_ele')->nullable()->comment('Thời gian nộp báo cáo bản mềm');
            $table->datetime('report_time_submit_hard')->nullable()->comment('Thời gian nộp báo cáo bản cứng');
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
        Schema::dropIfExists('mission_science_technologies');
    }
}
