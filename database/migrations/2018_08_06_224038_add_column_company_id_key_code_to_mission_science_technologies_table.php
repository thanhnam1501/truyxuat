<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnCompanyIdKeyCodeToMissionScienceTechnologiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mission_science_technologies', function (Blueprint $table) {
            if (!Schema::hasColumn('mission_science_technologies', 'company_id')) {
                $table->integer('company_id')->nullable()->comment('id người tạo phiếu');
            }

            if (!Schema::hasColumn('mission_science_technologies','key')) {
              $table->string('key',60)->nullable()->comment('số hồ sơ md5(id+company_id+now)');
            }
            if (!Schema::hasColumn('mission_science_technologies','code')) {
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
        Schema::table('mission_science_technologies', function (Blueprint $table) {
            if (Schema::hasColumn('mission_science_technologies','company_id')) {

                  Schema::dropColumn('company_id');
              }

              if (Schema::hasColumn('mission_science_technologies','key')) {

              Schema::dropColumn('key');
          }
          if (Schema::hasColumn('mission_science_technologies','code')) {

              Schema::dropColumn('code');
          }
        });
    }
}
