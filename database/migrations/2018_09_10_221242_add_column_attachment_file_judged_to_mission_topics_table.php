<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnAttachmentFileJudgedToMissionTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mission_topics', function (Blueprint $table) {
            if (!Schema::hasColumn('mission_topics', 'attachment_file_judged')) {
                $table->string('attachment_file_judged', 255)->nullable()->comment('Tài liệu đính kèm khi hồ sơ được đưa vào hội đồng đánh giá');
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
            if (Schema::hasColumn('mission_topics', 'attachment_file_judged')) {
                $table->dropColumn('attachment_file_judged');
            }
        });
    }
}
