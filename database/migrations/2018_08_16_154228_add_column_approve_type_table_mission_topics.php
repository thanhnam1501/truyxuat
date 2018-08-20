<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnApproveTypeTableMissionTopics extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mission_topics', function (Blueprint $table) {
            if (!Schema::hasColumn('mission_topics', 'approve_type')) {
                $table->tinyInteger('approve_type')->default(0)->comment('0: giao trực tiếp, 1: tuyển chọn');
            }            
            if (!Schema::hasColumn('mission_topics', 'is_unperformed_reason')) {
                $table->text('is_unperformed_reason')->nullable()->comment('Lý do không được phê duyệt thực hiện');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mission_topics', function (Blueprint $table) {
            if (Schema::hasColumn('mission_topics', 'approve_type')) {
                $table->dropColumn('approve_type');
            }            
            if (Schema::hasColumn('mission_topics', 'is_unperformed_reason')) {
                $table->dropColumn('is_unperformed_reason');
            }
        });
    }
}
