<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Eloquent\SoftDeletes;

class CreateMissionSxtnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('mission_sxtns')) {
            Schema::create('mission_sxtns', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('status')->default(0)->comment('0: mới khởi tạo, 1: nộp bản mềm, 2:nộp bản cứng');
                $table->integer('checked_status')->default(0)->comment('0: chưa giao, 1:đã giao, 2: được duyệt, 3: không được duyệt');
                $table->integer('process_status')->default(0)->comment('0: mới được duyệt, 1: đang thực hiện, 2: dừng thực hiện, 3: đã hoàn thành');
                $table->integer('report_status')->default(0)->comment('0: mới khởi tạo báo cáo bản mềm. 1: đã nộp báo cáo bản mềm, 2: đã nộp báo cáo bản cứng');
                $table->dateTime('time_submit_ele_copy')->nullable()->comment('Thời gian nộp bản mềm');
                $table->dateTime('time_submit_hard_copy')->nullable()->comment('Thời gian nộp bản cứng');
                $table->dateTime('report_time_submit_ele')->nullable()->comment('Thời gian nộp báo cáo bản mềm');
                $table->dateTime('report_time_submit_hard')->nullable()->comment('Thời gian nộp báo cáo bản cứng');
                $table->integer('scientis_id')->comment('id của người tạo bảng');
                $table->timestamps();
                $table->softDeletes();
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
        if (Schema::hasTable('mission_sxtns')) {
            Schema::dropIfExists('mission_sxtns');
        }
    }
}
