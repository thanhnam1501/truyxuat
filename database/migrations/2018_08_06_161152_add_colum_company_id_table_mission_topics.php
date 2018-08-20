<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumCompanyIdTableMissionTopics extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mission_topics', function (Blueprint $table) {
            if (!Schema::hasColumn('mission_topics','company_id')) {

                $table->integer('company_id')->nullable()->comment('id người tạo phiếu');
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
          if (Schema::hasColumn('mission_topics','company_id')) {

              Schema::dropColumn('company_id');
          }
        });
    }
}
