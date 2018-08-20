<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnKeyTableMissionTopics extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mission_topics', function (Blueprint $table) {
            if (!Schema::hasColumn('mission_topics','key')) {
              $table->string('key',60)->nullable()->comment('số hồ sơ md5(id+company_id+now)');
            }
            if (!Schema::hasColumn('mission_topics','code')) {
              $table->string('code')->nullable()->comment('Mã số hồ sơ sinh ra sau khi thu bản cứng');
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
          if (Schema::hasColumn('mission_topics','key')) {

              Schema::dropColumn('key');
          }
          if (Schema::hasColumn('mission_topics','code')) {

              Schema::dropColumn('code');
          }
        });
    }
}
