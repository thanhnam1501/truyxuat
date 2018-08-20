<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnOtherSubmitHardCopyTableMissionTopics extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mission_topics', function (Blueprint $table) {
            if (!Schema::hasColumn('mission_topics', 'order_submit_hard_copy')) {
              $table->integer('order_submit_hard_copy')->default(0)->comment('So thu tu submit thu ban cung');
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
            if (Schema::hasColumn('mission_topics', 'order_submit_hard_copy')) {
                $table->dropColumn('order_submit_hard_copy');
            }
        });
    }
}
